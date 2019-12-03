<?php
namespace App\Console\Commands;

use Robust\RealEstate\Models\Listing;
use Illuminate\Console\Command;
use Robust\RealEstate\Models\ListingProperty;
use Robust\RealEstate\Models\ListingDetail;

/**
 * Class FixImages
 * @package App\Console\Commands
 */
class FixImagesCount extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'rws:fix-images-count';
    /**
     * The console command description.
     * @var string
     */
    protected $description = "Migrate Old Tables for Images to New Structure; This command will be removed";


    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {

       \DB::table('real_estate_listings')
           ->orderBy('input_date')
            ->chunk(1000,function ($listings){
                foreach($listings as $key => $listing){
                    $count = \DB::table('real_estate_listing_images')
                            ->where('listing_id',$listing->id)
                            ->count();
                    \DB::table('real_estate_listings')
                            ->where('id',$listing->id)
                            ->update(['picture_count' => $count]);
                    $this->info($count,$listing->id);
                }
            });


    }
}