<?php

namespace App\Http\Controllers\API;

use Hyn\Tenancy\Environment;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;


class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') { 
          //
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        
        $data = Voyager::model('Setting')->where('group', __('voyager::settings.group_site'))->get();

        $env = app(Environment::class);
        $fqdn = optional($env->hostname())->fqdn;

        return collect($data)->mapWithKeys(function ($item) use ($fqdn, $protocol) {
            // return [$item['key'] => $item['value']];
            switch ($item['type']) {
                case 'image':
                $return_value = empty($item['value']) ? $item['value'] : $protocol . $fqdn . '/storage/' . $item['value'];
                    break;
                case 'file':
                    if (empty($item['value'])) {
                        break;
                    }

                    $return_value = json_decode($item['value']);

                    foreach ($return_value as $key => $value) {
                        $return_value[$key]->download_link = empty( $value->download_link ) ? $value->download_link : $protocol . $fqdn . '/storage/' . $value->download_link;
                    }
                    
                    $return_value = json_encode($return_value);

                    break;
                default:
                    $return_value = $item['value'];
            }
            return [$item['key'] => $return_value];
        });
    }

}
