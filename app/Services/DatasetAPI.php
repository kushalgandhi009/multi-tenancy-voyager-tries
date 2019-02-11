<?php

namespace App\Services;

use GuzzleHttp\Client as Client;
use GuzzleHttp\RequestOptions;
use \Hyn\Tenancy\Environment;

class DatasetAPI
{
    protected $_client = NULL;
    
    
    public function __construct()
    {
        $urlApi = env('API_URL_DATASET', '');
       
        $this->_client = new Client(['base_uri' => $urlApi, 'verify' => false]);
    }


    /**
     * datasetInit
     * 
     * @param string $clientId
     * @param string $filename
     * @return array
     */
    public function datasetInit($clientId, $filename)
    {
        return $this->_client->request('POST', 'dataset/init/', [
            RequestOptions::JSON => [
                'client_id'     => $clientId,
                'site_owner_id' => app(Environment::class)->hostname()->fqdn,
                'filename'      => $filename,
            ]
        ]);
    }

    public function datasetStatus($datasetId)
    {
        return $this->_client->request('GET', 'dataset/status/'.$datasetId);
    }

}