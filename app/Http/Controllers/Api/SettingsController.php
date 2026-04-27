<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings()
    {
        $settings = GeneralSetting::where('status', 1)->select('name', 'white_logo', 'dark_logo', 'favicon', 'copyright', 'description', 'wp_number', 'messenger')->first();

        if (!$settings) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Settings not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $settings,
            'message' => 'Settings fetched successfully'
        ], 200);
    }

    public function contact_info()
    {
        $contactInfo = Contact::select('hotline','hotmail','phone','email','address','map_link')->first();

        if(!$contactInfo){
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Contact info not found'
            ],404);
        }
        return response()->json([
            'success' => true,
            'data' => $contactInfo,
            'message' => 'Contact info fetch successfully'
        ],200);
    }
}
