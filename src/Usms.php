<?php

namespace UrhitechSMS;

class UrhitechSMSAPI 
{
    /**
     * @param $request_method
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Send Request to server and get sms status
     */
    private function send_server_response($url, $api_token, $request_method = null, $post_fields = null)
    {
        $ch = curl_init();

        $data = json_encode($post_fields);

        curl_setopt ($ch, CURLOPT_URL, $url);
        if ($request_method == 'post') {
            curl_setopt ($ch, CURLOPT_POST, true);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            "authorization: Bearer ".$api_token
        ]);

        // Allow cURL function to execute 20sec
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        // waiting 20 secs while waiting to connect
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

        $response = curl_exec( $ch );
        if ($e = curl_error( $ch )) {
            return $e;
        } else {
            return json_decode($response, true) ;
            curl_close($ch);
        }

    }


    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Send single SMS
     */
    public function send_sms($url, $api_token, $post_fields)
    {
        $response = $this->send_server_response($url, $api_token, 'post',  $post_fields);
        return $response;
    }



    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * View an SMS
     */
    public function view_sms($url, $api_token)
    {
        $response = $this->send_server_response($url, $api_token,'', '');
        return $response;
    }


    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * View profile
     */
    public function profile($url, $api_token)
    {
        $response = $this->send_server_response($url, $api_token, '', '');
        return $response;
    }


    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * View sms credit balance
     */
    public function check_balance($url, $api_token)
    {
        $response = $this->send_server_response($url, $api_token, '','');
        return $response;
    }
}