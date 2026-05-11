<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function mainSlider()
    {
        $mainslider = Banner::where('category_id', 1)->where('status', 1)->select('image', 'link')->get();

        return response()->json([
            'status' => true,
            'data' => $mainslider,
            'messsage' => 'Main slider data fetch successfully!'
        ]);
    }
    public function socialMedia()
    {
        $social_media = SocialMedia::where('status', 1)->select('name', 'icon', 'color', 'link')->get();

        return response()->json([
            'status' => true,
            'data' => $social_media,
            'messsage' => 'Social media data fetch successfully!'
        ]);
    }
}
