<?php
/**
 * Created by PhpStorm.
 * User: jackwalker
 * Date: 24/02/2018
 * Time: 14:46
 */

require_once (dirname($_SERVER['DOCUMENT_ROOT']).'/phpinclude/app/keys.php');


class APIService
{
    public static function callAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        $data_string = $data ? json_encode($data) : false;

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-AUTH-TOKEN: ' . API_KEY,
            'Content-Length: ' . strlen($data_string)
        ));

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }


    public function callAPI2($method, $url, $data = false)
    {
        $options = array(
            'http' => array(
                'header'  => ["Content-Type: application/x-www-form-urlencoded", "X-AUTH-TOKEN: ". API_KEY],
                'method'  => $method,
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { /* Handle error */ }

        return $result;
    }


}