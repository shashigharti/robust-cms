<?php

namespace App\Console\Commands;

use App\Helpers\DateTimeHelper;
use App\ListingFilters;
use App\Mail\UserAlert as UserAlertEmailService;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Robust\Landmarks\Model\Listings;
use Robust\Leads\Models\UserSearch;

/**
 * Class UserAlert
 * @package App\Console\Commands
 */
class UserAlert extends Command
{
    /**
     * @var string
     * Holds Current date & time
     */
    public $now;
    /**
     * @var \Robust\Landmarks\Model\Listings
     */
    public $listings;
    /**
     * @var \Robust\Leads\Models\UserSearch
     */
    public $userSearch;
    /**
     * @var \App\Helpers\DateTimeHelper
     */
    public $dateTimeHelper;
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'send:user-alerts';
    /**
     * The console command description.
     * @var string
     */
    protected $description = "Send Listing Alerts to users who have saved searches.";


    /**
     * UserAlert constructor.
     * @param \Robust\Leads\Models\UserSearch $userSearch
     * @param \App\Helpers\DateTimeHelper $dateTimeHelper
     * @param \Robust\Landmarks\Model\Listings $listings
     */
    public function __construct(UserSearch $userSearch, DateTimeHelper $dateTimeHelper, Listings $listings)
    {
        // Set current date and time
        $this->now = Carbon::now()->format('Y-m-d H:i:s');
        $this->userSearch = $userSearch;
        $this->dateTimeHelper = $dateTimeHelper;
        $this->listings = $listings;
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $userSearches = $this->getUserSearches();
        foreach ($userSearches as $searches) {
            foreach ($searches as $search) {
                $searchFilterArray = json_decode($search->content, true);
                $resultArr = $this->runSearch($searchFilterArray, $search);
                $listingsFromResults = $resultArr['results'];
                if (empty($listingsFromResults)) {
                    continue;
                } else {
                    if (count($listingsFromResults) > 0 && !empty($search->user) && empty($search->user->unsubscribe) && $this->isValidEmail($search)) {
                        $this->sendEmail($search, $listingsFromResults, $resultArr['counts']);
                    }
                }
            }

        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Robust\Leads\Models\UserSearch[]
     */
    private function getUserSearches()
    {
        // Get all searches
        $searches = $this->userSearch->with([
            'user' => function ($query) {
                $query->where('user_type', '!=', 'DISCARDED');
            }
        ])->whereHas('user')->where('reference_time', '<=', $this->now)->get();


        // Filter Searches to be dealt with currently
        $userSearches = $searches->filter(function ($value) {
            $diff = $this->dateTimeHelper->calcDifference($value->reference_time);
            if ($value->user->unsubscribed) {
                // Dont proceed if user has unsubscribed email list
                return false;
            } else {
                if (date('l') == $value->frequency) {
                    return true;
                } elseif ($value->frequency == 'Daily') {
                    return true;
                } elseif ($value->frequency == 'Biweekly' && $diff == 14) {
                    return true;
                } elseif ($value->frequency == 'Monthly' && $diff == 30) {
                    return true;
                }
            }
            return false;
        });
        return $userSearches->chunk(10);
    }

    /**
     * @param $search_filter_arr
     * @param $search
     * @return array
     */
    private function runSearch($search_filter_arr, $search)
    {
        $request = new Request();
        $request->merge($search_filter_arr);
        $builder = $this->listings->query();

        try {
            $filters = new ListingFilters($request);
            $base_queries = $filters->apply($builder)
                // to avoid rentals // applies in case if price filters are missing.
                ->where('system_price', '>=', 50000)
                // to avoid no pic
                ->where('picture_count', '>', 0)
                ->where('input_date', '>=', $search->reference_time)
                ->with('firstImage');

            $total_count = (clone($base_queries))
                ->count();

            $active_count = (clone($base_queries))
                ->where('status', '=', 'Active')
                ->count();

            $sold_count = (clone($base_queries))
                ->where('status', '=', 'Sold')
                ->count();

            $results = (clone($base_queries))
                ->where('status', 'Active')
                ->limit(5)
                ->get();

            return [
                'counts' => [
                    'active_count' => $active_count,
                    'sold_count' => $sold_count,
                    'total_count' => $total_count,
                ],
                'results' => $results,
            ];

        } catch (Exception $e) {
            // Exception during search
            return [
                'results' => [],
            ];
        }
    }

    /**
     * @param \Robust\Leads\Models\UserSearch $userSearch
     * @return bool
     */
    private function isValidEmail(UserSearch $userSearch)
    {
        return (bool)(!empty($userSearch->user->email) && filter_var($userSearch->user->email,
                FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    /**
     * @param \Robust\Leads\Models\UserSearch $userAlert
     * @param \Illuminate\Database\Eloquent\Collection $sampleFromResult
     * @param $counts
     */
    private function sendEmail(UserSearch $userAlert, Collection $sampleFromResult, $counts)
    {
        $leadObj = $userAlert->user;
        try {
            Mail::queue(new UserAlertEmailService($userAlert, $sampleFromResult, $leadObj, $counts));
            $userAlert->update([
                'reference_time' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            dd($e);
//            throw new EmailException($e, "User Search Email Alert Error");
        }
    }
}
