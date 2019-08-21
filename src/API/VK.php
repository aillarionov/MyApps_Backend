<?php

namespace Informer\API;

use Informer\Utils\Log;

use CURLFile;
use LoggedException;

class VK {

    private $token;
    private $v = '5.37';
    private $endpoint = 'https://api.vk.com/method/';
    private $lastChange;
    
    public function __construct($token) {
        $this->token = $token;
    }

    public function uploadFile($url, $path) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);

        if (class_exists('\CURLFile')) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('file1' => new CURLFile($path)));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, array('file1' => "@$path"));
        }

        $data = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($data, true);
    }

    public function request($method, array $params) {

        $data = $this->requestHTTP($method, $params);

        $json = json_decode($data, true);
        
        Log::write('INFO', 'vk', $method, array('params' => $params, 'data' => $data));

        if (!isset($json['response'])) {
            if (isset($json['error'])) {
                throw new VKException($json['error']);
            } else {
                throw new LoggedException($data);
            }
        }

        return $json['response'];
    }

    private function requestHTTP($method, array $params) {
        $params['v'] = $this->v;

        $ch = curl_init($this->endpoint . $method . '?access_token=' . $this->token);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $data = curl_exec($ch);

        curl_close($ch);

        return $data;
    }
}
