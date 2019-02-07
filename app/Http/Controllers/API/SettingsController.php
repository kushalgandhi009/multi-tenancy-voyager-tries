<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SettingRequest;
use App\Http\Controllers\Controller;
use TCG\Voyager\Facades\Voyager;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Voyager::model('Setting')->where('group', __('voyager::settings.group_site'))->get();
        
        return collect($data)->mapWithKeys(function ($item) {
            return [$item['key'] => $item['value']];
        });
    }

}
