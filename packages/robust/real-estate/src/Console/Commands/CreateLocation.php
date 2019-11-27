<?php

namespace Robust\RealEstate\Console\Commands;

use Illuminate\Console\Command;
use Robust\RealEstate\Helpers\LocationHelper;
use Robust\RealEstate\Models\MlsUser;
use Illuminate\Support\Str;

/**
 * Class CreateLocation
 * @package Robust\Mls\Console\Commands
 */
class CreateLocation extends Command
{
    /**
     * @var string
     */
    protected $signature = 'create:locations';

    /**
     * @var string
     */
    protected $description = 'Create or Updates the locations';

    /**
     * CreateLocation constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param LocationHelper $locationHelper
     */
    public function handle(LocationHelper $locationHelper)
    {
        $locations = [
            'area'=>'area',
            'city'=>'city',
            'county'=>'county',
            'elementarySchool'=>'elem_school',
            'grids'=>'grid',
            'highSchool' => 'high_school',
            'middleSchool'=>'middle_school',
            'schoolDistricts' => 'district',
            'zip' => 'zip',
            'subdivision'=> 'subdivision',
        ];
        foreach ($locations as $key => $attr)
        {
            $collections = $locationHelper->getCollection($attr);
            foreach ($collections as $collection)
            {
                $slug = Str::slug($collection,'-');
                $data = [
                    'active' => $locationHelper->getActiveCount($attr,$collection),
                    'sold' => $locationHelper->getSoldCount($attr,$collection),
                    'slug' => $slug,
                    'name' => $collection
                ];
                if($key === 'city'){
                    $data['state_short'] = 'glenn';
                }
                if($key === 'zips' || $key === 'subDivisions') {
                    $data['city_id'] = $locationHelper->getCityId($attr,$collection);
                    $data['county_id'] = $locationHelper->getCountyId($attr,$collection);
                    if($key === 'subDivisions'){
                        $data['zip_id'] = $locationHelper->getZipId($attr,$collection);
                    }
                }
                $locationHelper->updateorcreate($data,$key);
            }
        }
    }
}
