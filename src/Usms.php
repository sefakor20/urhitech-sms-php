<?php

namespace Urhitech;

class Usms
{
    static $curl_handle = NULL;
    /**
     * @param $request_method
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Send Request to server and get sms status
     */

    private function send_server_response($endpoint, $api_token, $post_fields = [], $sender_id, $recipient, $message, $request_method = null)
    {
        //Initialize the curl handle if it is not initialized yet
        if (!isset($this::$curl_handle)) {
            $this::$curl_handle = curl_init();
        }

        if (!empty($post_fields)) {
            $data = json_encode($post_fields);

        } else {
            $data = json_encode([
                'recipient' => $recipient,
                'sender_id' => $sender_id,
                'message' => $message,
            ]);
        }
        

        curl_setopt ($this::$curl_handle, CURLOPT_URL, $endpoint);
        if ($request_method == 'post') {
            curl_setopt ($this::$curl_handle, CURLOPT_POST, true);
            curl_setopt ($this::$curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == PUT
        if ($request_method == 'put') {
            curl_setopt($this::$curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($this::$curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == PATCH
        if ($request_method == 'patch') {
            curl_setopt($this::$curl_handle, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($this::$curl_handle, CURLOPT_POSTFIELDS, $data);
        }

        // request_method == DELETE
        if ($request_method == 'delete') {
            curl_setopt($this::$curl_handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        curl_setopt ($this::$curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($this::$curl_handle, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            "authorization: Bearer ".$api_token
        ]);

        // Allow cURL function to execute 20sec
        curl_setopt($this::$curl_handle, CURLOPT_TIMEOUT, 20);

        // waiting 20 secs while waiting to connect
        curl_setopt($this::$curl_handle, CURLOPT_CONNECTTIMEOUT, 20);

        if ($e = curl_error($this::$curl_handle)) {
            return $e;
        } else {
            return json_decode(curl_exec( $this::$curl_handle ), true);
            curl_close($this::$curl_handle);
        }

    }


    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Send single / group SMS
     */
    public function send_sms($endpoint, $api_token, $sender_id, $phones, $message)
    {
        $single_phone = $phones;
        $phones = explode(',', $phones);
        if (count($phones) > 1) {
            foreach ($phones as $phone) {
                $this->send_server_response($endpoint, $api_token, '', $sender_id, $phone, $message, 'post');
            }
        } else {
            // print_r($single_phone);exit();
            $this->send_server_response($endpoint, $api_token, $sender_id, $single_phone, $message, 'post');
        }
       
        return false;
    }




    /**
     * @param $endpoint
     * @param $api_token
     * @param $sender_id
     * @param $phone
     * @param $message
     * @return mixed
     *
     * Send single
     */
    public function sendSingle($endpoint, $api_token, $sender_id, $phone, $message)
    {
        $this->send_server_response($endpoint, $api_token, '',  $sender_id, $phone, $message, 'post');
    }



    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * View an SMS
     */
    public function view_sms($url, $api_token)
    {
        return $this->send_server_response($url, $api_token, '','', '', '', '', '');
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
        return $this->send_server_response($url, $api_token, '', '', '', '', '', '');
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

        return $this->send_server_response($url, $api_token, '', '', '', '', '');
    }



    /**
     * @param $url
     * @param $api_token
     * @param $post_fields => ['name' => 'your group name']
     * @return mixed
     * 
     * Create a new Contact Group
     */
    public function create_contact_group($endpoint, $api_token, $post_fields)
    {
        return $this->send_server_response($endpoint, $api_token, $post_fields, '', '', '', 'post');
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
        return $this->send_server_response($url, $api_token, '', '',  '', '', 'post');
    }



    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Update Contact Group
     */
    public function update_contact_group($endpoint, $api_token, $sender_id, $phones, $message)
    {
        return $this->send_server_response($endpoint, $api_token, '', $sender_id, $phones, $message, 'patch');
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
        return $this->send_server_response($url, $api_token, '', '', '',  '', 'delete');
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
        return $this->send_server_response($url, $api_token, '', '', '', '', '');
    }


    
    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Creates a new contact object
     */
    public function create_contact($endpoint, $api_token, $post_fields = [])
    {
        return $this->send_server_response($endpoint, $api_token, $post_fields, '', '', '', 'post');
    }


    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * Retrieves the information of an existing contact
     */
    public function view_contact($url, $api_token) 
    {
        return $this->send_server_response($url, $api_token, '', '', '', '', 'post');
    }



    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     * 
     * Update an existing contact.
     */
    public function update_contact($endpoint, $api_token, $post_fields = [])
    {
        return $this->send_server_response($endpoint, $api_token, $post_fields, '', '', '', 'patch');
    }



    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * Delete an existing contact
     */
    public function delete_contact($url, $api_token)
    {
        return $this->send_server_response($url, $api_token, '', '', '', '', 'delete');
    }



    /**
     * @param $url
     * @param $api_token
     * @return mixed
     * 
     * View all contacts in group
     */
    public function all_contacts_in_group($url, $api_token)
    {
        return $this->send_server_response($url, $api_token, '', '', 'post');
    }




    /**
     * @param $url
     * @param $api_token
     * @param $post_fields
     * @return mixed
     *
     * Confirm Inbound receipt
     */
    public function confirm_inbound($url, $api_token, $post_fields = []) 
    {
        return $this->send_server_response($url, $api_token, $post_fields, '', '', '', 'put');
    }

}