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

    private function send_server_response($url, $api_token, $post_fields = null, $request_method = null)
    {
        $ch = curl_init();

        $data = json_encode($post_fields);

        curl_setopt ($ch, CURLOPT_URL, $url);
        if ($request_method == 'post') {
            curl_setopt ($ch, CURLOPT_POST, true);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == PUT
        if ($request_method == 'put') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == PATCH
        if ($request_method == 'patch') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == DELETE
        if ($request_method == 'delete') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
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

        if ($e = curl_error($ch)) {
            return $e;
        } else {
            return json_decode($response, true);
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

        $response = $this->send_server_response($url, $api_token, '', '');
        return $response;
    }



    /**
     * @param $url
     * @param $api_token
     * @param $post_fields => ['name' => 'your group name']
     * @return mixed
     * 
     * Create a new Contact Group
     */
    public function create_contact_group($url, $api_token, $post_fields)
    {
        $response = $this->send_server_response($url, $api_token, $post_fields, 'post');
        return $response;
    }



    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * View Contact Group
     */
    public function view_contact_group($url, $api_token)
    {
        $response = $this->send_server_response($url, $api_token, '', 'post');
        return $response;
    }



    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Update Contact Group
     */
    public function update_contact_group($url, $api_token, $post_fields)
    {
        $response = $this->send_server_response($url, $api_token, $post_fields, 'patch');
        return $response;
    }



    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * Delete Contact Group
     */
    public function delete_contact_group($url, $api_token)
    {
        $response = $this->send_server_response($url, $api_token, '', 'delete');
        return $response;
    }



    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * View all Contact Groups
     */
    public function all_contact_groups($url, $api_token)
    {
        $response = $this->send_server_response($url, $api_token, '', '');
        return $response;
    }


}