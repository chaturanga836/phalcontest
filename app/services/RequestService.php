<?php
namespace App\Service;
/**
 * Created by PhpStorm.
 * User: LAYOUTindex
 * Date: 02/12/2018
 * Time: 05:38 PM
 */
class RequestService
{

    /**
     * @var object
     */
    private $ch ;


    /**
     * @var string
     */
    public $base_url;

    /**
     * @var string
     */
    public $header_name;

    /**
     * @var string
     */
    public $header_val;


    /**
     * @var string
     */
    public $api_key;


    public function __construct()
    {
        $this->base_url     = 'https://api.nasa.gov/';
        //$this->header_name  = 'API KEY';
        //$this->header_val   = '3hVk85ZVP60SeT0B92FcCzDiOPoI3iBvzM5Td8KT';
        $this->api_key   = '3hVk85ZVP60SeT0B92FcCzDiOPoI3iBvzM5Td8KT';

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 100);

//        curl_setopt($this->ch, CURLOPT_HTTPHEADER, [
//                '{$this->header_name}: {$this->header_val}'
//            ]
//
//        );
    }

    /**
     * method is use to send get requests
     * @param string $route
     * @param array $param
     */

    public function get($route="",$param = [])
    {
        if (strpos($route, "?") == false) {
            $route .= '?';
        }

        $key_name = "api_key";
        $param[$key_name] =$this->api_key;
       // $url =  $this->base_url.$route .http_build_query($param, '', '&');
        $url =  $this->base_url.$route .http_build_query($param, '', '&');


        curl_setopt($this->ch, CURLOPT_URL,$url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

        return $this->sendRequest();
    }

    /**
     * method is use to send post requests
     *
     * @param string $route
     * @param array $param
     */
    public function post($route="", $param = [])
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->base_url.$route);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_POST, TRUE);

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($param));

        return $this->sendRequest();
    }


    /**method is use to execute curl reques and send response
     *
     * @return array
     */
    private function sendRequest()
    {
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_FAILONERROR, true);

        $tmp = curl_exec($this->ch);

        $error = curl_error($this->ch);

        $response_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        $response = json_decode($tmp, true);

        curl_close($this->ch);
        unset($this->ch);

        return [
            'response' => $response,
            'error'=>$error,
            'statu_code' =>$response_code
        ];

    }



}