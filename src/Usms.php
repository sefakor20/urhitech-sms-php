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
    private function send_server_response($request_method, $url, $api_token, $post_fields = null)
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
            "authorization: Bearer".$api_token
        ]);

        // Allow cURL function to execute 20sec
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        // waiting 20 secs while waiting to connect
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);

        $response = curl_exec( $ch );
        if ($e = curl_close( $ch )) {
            echo $e;
        } else {
            return json_encode($response, true) ;
        }

    }


    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Send SMS
     */
    public function send_sms($url, $api_token, $post_fields = null)
    {
        $response = $this->send_server_response('post', $url, $api_token, $post_fields);
        return $response;
    }
}