<?php

namespace Robust\Settings\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Robust\Settings\Model\CoreSetting;
use Robust\Menus\Resources\CoreSetting as CoreSettingResource;


/**
 * Class SettingsApiController
 * @package Robust\Settings\Controllers\Admin
 */
class SettingsController extends Controller
{
    /**
     * @param \Robust\Settings\Model\CoreSetting $coreSetting
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(CoreSetting $coreSetting)
    {
        return CoreSettingResource::collection($coreSetting->all()->keyBy('type'));
    }

    /**
     * @param $type
     * @param \Robust\Settings\Model\CoreSetting $coreSetting
     * @return \Robust\Menus\Resources\CoreSetting
     */
    public function getByType($type, CoreSetting $coreSetting)
    {
        if($coreSetting->where('type',$type)->first()){
            return new CoreSettingResource($coreSetting->where('type', $type)->first());
        }
        return  response()->json('null');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $type
     * @param \Robust\Settings\Model\CoreSetting $coreSetting
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $type, CoreSetting $coreSetting)
    {
        // Json encode the settings data
        $setting = json_encode($request->all(), true);
        // Creates new field if exists, else updates the existing one
        $coreSetting->updateOrCreate(
            ['type' => $type],
            ['values' => $setting]
        );
        return response()->json(['message' => 'Success']);
    }
}


