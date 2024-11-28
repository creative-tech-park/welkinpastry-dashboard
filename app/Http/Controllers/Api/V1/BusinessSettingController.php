<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Page;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use function App\Http\Helpers\getSetting;

class BusinessSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'bSettings' =>[
                'hero' => json_decode(getSetting('hero')),
                'profile' => json_decode(getSetting('profile')),
                'social' => json_decode(getSetting('social')),
                'counter' => json_decode(getSetting('counter')),
                'header' => json_decode(getSetting('header')),
                'footer' => json_decode(getSetting('footer')),
            ]
        ];

        return response()->json($settings);
    }

    public function updateSetting()
    {
        foreach (Request::all() as $type => $value){
            $business_settings = BusinessSetting::where('key', $type)->first();
            if($business_settings != null) {
                if ($value != null){
                    if ($type == 'timezone' && gettype($value) != 'array'){
                        $value = $business_settings->value;
                    }
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            } else{
                if ($value != null){
                    $business_settings = new BusinessSetting;
                    $business_settings->key = $type;
                    if(gettype($value) == 'array'){
                        $business_settings->value = json_encode($value);
                    }
                    else {
                        $business_settings->value = $value;
                    }
                    $business_settings->save();
                }
            }
        }

        return response()->json([
            'message' => 'Update Business Settings...'
        ]);
    }


    public function getAllSettings(): \Illuminate\Http\JsonResponse
    {
        $data = request()->all();
        $response = [];
        foreach (explode(',', $data['name']) as $item) {
            $response[$item] = json_decode(getSetting($item));
        }
        return response()->json($response);
    }


}
