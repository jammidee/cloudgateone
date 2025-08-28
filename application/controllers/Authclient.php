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
 * CREATED DATE : August 28, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Authclient extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->load->database();
        $this->load->helper(['cookie', 'url']);
        $this->load->library('session');
        $this->jwt_secret = $this->config->item('jwt_secret') ?? 'SuperSecretKey123';

    }

    public function login()
    {
        // Redirect to dashboard if already logged in
        if (isLogged()) {

            redirect('clientdash?t=' . time(), 'refresh');

        } else {

            $data['title'] = 'Login';

            // Load saved email and password from cookies
            $data['client_remember_email']    = get_cookie('client_remember_email');
            $data['client_remember_password'] = get_cookie('client_remember_password');

            // Pass redirect URL to the view, if provided
            $url = $this->input->get('redirect');
            if (!empty($url)) {
                $data['redirect_url'] = urldecode($url); // decode just in case it's encoded
            }

            $this->load->view('_layout/authclient-header-bgnd', $data);
            $this->load->view('authclient/login', $data);
            $this->load->view('_layout/auth-footers', $data);
        }
    }

    //Added by Jammi Dee 08/28/2025
    function checkinguser() {
        $email          = $this->input->post('email');
        $password       = md5($this->input->post('password'));
        $selectedRouter = $this->input->post('router');

        if (empty($email) || empty($password)) {
            $this->session->set_flashdata('error', 'Login name or password is missing!');
            redirect('authclient/login?t=' . time(), 'refresh');
            return;
        }

        if ($selectedRouter == '') {
            $selectedRouter = 1;
        }

        // Step 1: Check against predefined superadmins
        $superadmins = $this->config->item('superadmins');
        $matchedSuperadmin = null;

        foreach ($superadmins as $admin) {
            if ($admin['email'] === $email && $admin['password'] === $password) {
                $matchedSuperadmin = $admin;
                break;
            }
        }

        if ($matchedSuperadmin) {
            // Hardcoded superadmin login
            $newdata = array(
                'user_id'       => 0,
                'user_name'     => 'Superadmin',
                'user_email'    => $matchedSuperadmin['email'],
                'user_role'     => 'Superadmin',
                'user_entity'   => $this->config->item('appentity'),
                'user_appid'    => $this->config->item('appid'),
                'logged_in'     => TRUE,
            );

            $this->session->set_userdata($newdata);

            // Set Remember Me cookie (optional)
            $remember = $this->input->post('remember');
            if ($remember) {
                set_cookie('client_remember_email', $email, 86400 * 30);
                set_cookie('client_remember_password', $password, 86400 * 30);
            } else {
                delete_cookie('client_remember_email');
                delete_cookie('client_remember_password');
            }

            // Log login
            try {
                log_action('login', 'Client Superadmin logged in successfully');
            } catch (Exception $e) {
                error_log('Error writing to user logs: ' . $e->getMessage());
                var_dump($e);
                exit;
            }

            $redirect_url = $this->input->post('redirect');
            if (!empty($redirect_url)) {
                redirect($redirect_url . '?t=' . time(), 'refresh');
            } else {
                redirect('clientdash?t=' . time(), 'refresh');
            }

            return;
        }

        // Step 2: Check for cache account and use if available
        
        // Step 3: Check against database users via API
        
        $api_url = "http://localhost:8340/jwtapi/login";
        $postData = [
            'username' => $email,
            'password' => $password
        ];

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {

            $this->session->set_flashdata('error', 'Master Server connection error.');
            redirect('authclient/login?t=' . time(), 'refresh');
            return;

        }

        $result = json_decode($response, true);

        //Token check
        if (!isset($result['token'])) {

            $this->session->set_flashdata('error', 'No token received.');
            redirect('authclient/login?t=' . time(), 'refresh');
            return;

        }

        $jwt_token = $result['token'];

        // ---- 3a. Decode JWT ----
        try {
            $secret = $this->config->item('jwt_secret') ?? 'SuperSecretKey123'; // must match issuer
            $decoded = JWT::decode($jwt_token, new Key($secret, 'HS256'));

            // Extract user data from token
            $userData = [
                'user_id'     => $decoded->data->user_id ?? null,
                'user_name'   => $decoded->data->user_name ?? null,
                'user_email'  => $decoded->data->user_email ?? $email,
                'user_role'   => $decoded->data->user_role ?? null,
                'user_entity' => $decoded->data->entity ?? $this->config->item('appentity'),
                'logged_in'   => TRUE,
                'jwt_token'   => $jwt_token
            ];

            $this->session->set_userdata($userData);

            // ---- 3. Remember me cookies ----
            $remember = $this->input->post('remember');
            if ($remember) {
                set_cookie('client_remember_email', $email, 86400 * 30);
                set_cookie('client_remember_password', $password, 86400 * 30);
            } else {
                delete_cookie('client_remember_email');
                delete_cookie('client_remember_password');
            }

            log_action('login', 'Remote User logged in successfully');

            // ---- 4. Redirect ----
            if (!empty($redirect_url)) {
                redirect($redirect_url . '?t=' . time(), 'refresh');
            } else {
                redirect('clientdash?t=' . time(), 'refresh');
            }

        } catch (Exception $e) {
            error_log('JWT decode failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'No token received.');
            redirect('authclient/login?t=' . time(), 'refresh');
        }

    }


}