<?php
namespace Robust\Leads\Controllers\Admin;

use App\Http\Controllers\Controller;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Robust\Leads\Models\Lead;
use Robust\Leads\Models\LeadMetadata;
use Robust\Leads\Models\Status;
use Robust\Leads\Resources\Lead as LeadResource;
use Robust\Leads\Resources\LeadMetadata as LeadMetadataResource;
use Robust\Leads\Resources\Status as LeadStatusResource;

/**
 * Class CategoryController
 * @package Robust\Pages\Controllers\Admin
 */
class LeadsApiController extends Controller
{
    /**
     * @param \Robust\Leads\Models\Lead $lead
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAll(Lead $lead)
    {
        return LeadResource::collection($lead->paginate(10));
    }


    public function getLeadsByType($type, Lead $lead, Carbon $carbon)
    {
        $userArr = $lead->query();
        $userArr->with('metadata', 'agent');

        if ($type == 'unassigned') {
            $userArr->whereNull('agent_id');
        }
        else if ($type == 'assigned')
        {
            $userArr->where('agent_id', '!=', null);
        }
        else if ($type == 'archived')
        {
            $userArr->where('user_type', '=', 'archived');
        }
        else if ($type == 'discarded')
        {
            $userArr->where('user_type', '=', 'discarded');
        }
        else if ($type == 'unregistered')
        {
            $userArr->where('user_type', '=', 'unregistered');
        }
        else if ($type == 'new')
        {
            $userArr->where('leads.created_at', '>', DB::raw('NOW() - INTERVAL 48 HOUR'));
        }
        else if($type == 'all')
        {
            // no condition, get all the leads.
        }
        else
        {
            $userArr->where('user_type', '!=', 'unregistered');
            $userArr->where('user_type', '!=', 'archived');
            $userArr->where('user_type', '!=', 'discarded');
            $userArr->where('user_type', '!=', 'hidden');
        }
        $userArr = $userArr->paginate(30);

        foreach ($userArr as $userDetail) {
            $last_active_user = $userDetail->last_active;
            $userDetail['last_login'] = null;
            $dates_followup = [];

            // Check last_login parsed time
            if ($last_active_user != null) {
                $last_active = Carbon::parse($last_active_user);
//                $last_active_user = strtotime($last_active_user);
                $userDetail['last_login'] = $last_active->diffInMinutes($carbon->now()) < 5 ? 'Online' : $last_active;
            }

            // Get follow ups
            if (isset($userDetail->latestFollowUps) and !empty($userDetail->latestFollowUps)) {
                foreach ($userDetail->latestFollowUps as $single) {
                    if (count($dates_followup) < 2) {
                        $dates_followup[$single->id] = [
                            'date' => $single->date,
                            'note' => $single->note,
                            'type' => $single->type,
                            'agent_id' => $single->agent_id
                        ];
                    }
                }
            }
            $userDetail['latest_followup_dates'] = $dates_followup;
        }

        return LeadResource::collection($userArr);
    }

    /**
     * @param $id
     * @param \Robust\Leads\Models\Lead $lead
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getLeadsByAgent($id, Lead $lead)
    {
        $leadArr = $lead->query();

        if ($id == 0) {
            $leadArr->where('agent_id', '!=', null);
        } else {
            $leadArr->where('agent_id', $id);
        }

        return LeadResource::collection($leadArr->paginate(10));

    }

    /**
     * @param \Robust\Leads\Models\LeadMetadata $leadMetadata
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllMetadata(LeadMetadata $leadMetadata)
    {
        return LeadMetadataResource::collection($leadMetadata->paginate(10));
    }

    /**
     * @param $id
     * @param \Robust\Leads\Models\Lead $lead
     * @return \Robust\Leads\Resources\Lead
     */
    public function getLead(Lead $lead)
    {
        $lead->load('loginHistory',
            'agent',
            'searches',
            'reports',
            'emails',
            'metadata',
            'activityLog',
            'notes');

        // Calculate login status
        $logins_this_month = [];
        $logins_this_year = [];
        $logins_past_month = [];
        $logins_past_year = [];

        $login_time = $lead->loginHistory->reverse()->first();
        $last_login = null;
        if ($login_time != null) {
            $last_login = Carbon::parse($login_time->time_of_login)->diffForHumans();
            foreach ($lead->loginHistory as $key => $value) {
                if (Carbon::parse($value->time_of_login)->year == Carbon::now()->year && Carbon::parse($value->time_of_login)->month == Carbon::now()->month) {
                    array_push($logins_this_month, $value->time_of_login);
                }
                if (Carbon::parse($value->time_of_login)->year == Carbon::now()->year && Carbon::parse($value->time_of_login)->month == (Carbon::now()->month - 1)) {
                    array_push($logins_past_month, $value->time_of_login);
                }
                if (Carbon::parse($value->time_of_login)->year == Carbon::now()->year) {
                    array_push($logins_this_year, $value->time_of_login);
                }
                if (Carbon::parse($value->time_of_login)->year == (Carbon::now()->year - 1)) {
                    array_push($logins_past_year, $value->time_of_login);
                }
            }
        }
        if ($login_time == null) {
            $last_login = '0';
        }
        $lead['logins'] = [
            'last_login' => $last_login,
            'this_month' => count($logins_this_month),
            'this_year' => count($logins_this_year),
            'last_month' => count($logins_past_month),
            'last_year' => count($logins_past_year),
        ];

        return new LeadResource($lead);
    }

    /**
     * @param $id
     * @param \Robust\Leads\Models\LeadMetadata $leadMetadata
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getLeadMetadata($id, LeadMetadata $leadMetadata)
    {
        return LeadMetadataResource::collection($leadMetadata->where('lead_id', $id)->get());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Robust\Leads\Models\Lead $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Lead $lead)
    {
        try {
            $newLead = $request->all();
            $newLead['password'] = bcrypt($request->get('password'));
            $lead->create($newLead);
            return response()->json(['message' => 'Success']);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Failed to save!', 'error' => $e]);
        }
    }

    /**
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @param \Robust\Leads\Models\Lead $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request, Lead $lead)
    {
        try {
            $updatedLead = $request->all();
            if($request->has('password')) {
                $updatedLead['password'] = bcrypt($request->get('password'));
            }

            $lead->find($id)->update($updatedLead);
            return response()->json(['message' => 'Success']);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Failed to update!', 'error' => $e]);
        }
    }

    /**
     * @param \Robust\Leads\Models\Status $status
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllStatus(Status $status)
    {
        return LeadStatusResource::collection($status->all());
    }

    /**
     * @param $id
     * @param \Illuminate\Http\Request $request
     * @param \Robust\Leads\Models\Lead $leadModel
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLeadStatus($id, Request $request, Lead $leadModel)
    {
        $lead = $leadModel->find($id);
        $lead->status_id = $request->status_id;
        if ($lead->save()) {
            return response()->json(['message' => 'Successfully Updated.']);
        }
        return response()->json(['message' => 'Update Failed. Please try again later.']);
    }
}
