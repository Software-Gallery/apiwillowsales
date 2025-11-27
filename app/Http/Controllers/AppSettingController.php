<?php

namespace App\Http\Controllers;

use App\Models\app_setting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function index()
    {
        $setting = app_setting::first();
        return response()->json([
            'status' => 'Success',
            'message' => 'Data successfully retrieved',
            'statusCode' => 200,
            'data' => $setting
        ]);
    }
}
