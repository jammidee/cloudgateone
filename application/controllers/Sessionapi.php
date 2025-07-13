<?php

/**
 * ------------------------------------------------------------------------
 * Copyright (C) 2025 Lalulla OPC. All rights reserved.
 *
 * Copyright (c) 2017 - Jammi Dee (Joel M. Damaso) <jammi_dee@yahoo.com>
 * This file is part of the Lalulla System.
 *
 * Lalulla System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * ------------------------------------------------------------------------
 * PRODUCT NAME : CloudGate PHP Framework
 * AUTHOR       : Jammi Dee (Joel M. Damaso)
 * LOCATION     : Manila, Philippines
 * EMAIL        : jammi_dee@yahoo.com
 * CREATED DATE : July 06, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Sessionapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //You may want to limit this API to only logged-in users
        if (!$this->session->userdata('logged_in')) {
            show_error('Unauthorized. No session found.', 401);
        }

        //Only allow AJAX Calls
        // if (!$this->input->is_ajax_request()) {
        //     show_error('No direct script access allowed', 403);
        // }

        //Whitelist IP Address
        // $allowed_ips = ['127.0.0.1', '::1'];
        // if (!in_array($this->input->ip_address(), $allowed_ips)) {
        //     show_error('Unauthorized IP address', 403);
        // }

    }

    public function get() {
        $sessionData = [
            'user_id'           => $this->session->userdata('user_id'),
            'user_email'        => $this->session->userdata('user_email'),
            'user_role'         => $this->session->userdata('user_role'),
            'user_name'         => $this->session->userdata('user_name'),
            'user_entity'       => $this->session->userdata('user_entity'),
            'logged_in'         => $this->session->userdata('logged_in'),
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'data' => $sessionData
            ]));
    }


    /**
     * Set session variables via POST request
     * Example call: POST /sessionapi/set
     * Body: { "key": "user_id", "value": "123" }
     */

    //  Usage:
    // fetch('/sessionapi/set', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    //     body: new URLSearchParams({
    //         key: 'user_id',
    //         value: '123'
    //     })
    // })
    // .then(res => res.json())
    // .then(data => console.log(data));

    public function set() {
        $key    = $this->input->post('key');
        $value  = $this->input->post('value');

        if (empty($key)) {
            return $this->_json_response(false, 'Missing session key');
        }

        $this->session->set_userdata($key, $value);
        return $this->_json_response(true, "Session variable '{$key}' set.");
    }


    /**
     * Set multiple session variables via associative array
     * POST: { "user_id": "123", "role": "Admin" }
     */

    // Usage:
    // fetch('/sessionapi/set_bulk', {
    //     method: 'POST',
    //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    //     body: new URLSearchParams({
    //         user_id: '123',
    //         role: 'Admin',
    //         location: 'Manila'
    //     })
    // })
    // .then(res => res.json())
    // .then(data => console.log(data));

    public function set_bulk() {
        $data = $this->input->post();

        // var_dump( $data );
        // exit;
        
        if (empty($data) || !is_array($data)) {
            return $this->_json_response(false, 'No session data provided.');
        }

        $this->session->set_userdata($data);
        return $this->_json_response(true, 'Session variables updated.', $data);
    }

    private function _json_response($success, $message, $extra = []) {
        $response = [
            'success' => $success,
            'message' => $message
        ];
        if (!empty($extra)) {
            $response['data'] = $extra;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }


}