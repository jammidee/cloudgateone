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

        $this->load->driver('cache', ['adapter' => 'file']);

    }

    //Added by Jammi Dee 08/30/2025
    public function index()
    {
        // Redirect to dashboard if already logged in
        if (isLogged()) {

            redirect('dashboard?t=' . time(), 'refresh');

        } else {

            $data['title'] = 'Client Login Module Help';

            $this->load->view('_layout/authclient-header-bgnd', $data);
            $this->load->view('authclient/help', $data);
            $this->load->view('_layout/authclient-footers', $data);
        }
    }

    public function login()
    {
        // Redirect to dashboard if already logged in
        if (isLogged()) {

            redirect('clientdash?t=' . time(), 'refresh');

        } else {

            $cachedData = $this->cache->get('user_creds');
            if ($cachedData !== FALSE) {

                $this->session->set_userdata($cachedData);
                
                try {
                    log_action('login', 'User logged in successfully using cache credentials');
                } catch (Exception $e) {
                    error_log('Error writing to user logs: ' . $e->getMessage());
                    var_dump($e);
                    exit;
                }
                
                redirect('clientdash?t=' . time(), 'refresh');

            } else {

                //If no cache credentials, normal login
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
    }

    //Added by Jammi Dee 08/28/2025
    function checkinguser() {
        $username           = $this->input->post('username');
        $password           = md5($this->input->post('password'));
        $selectedRouter     = $this->input->post('router');

        // var_dump($password);
        // exit;

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username or password is missing!');
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
            if ($admin['email'] === $username && $admin['password'] === $password) {
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

            //Remove any cache credentials, if any, for superadmins
            $this->cache->delete('user_creds');

            // Set Remember Me cookie (optional)
            $remember = $this->input->post('remember');
            if ($remember) {
                set_cookie('client_remember_email', $username, 86400 * 30);
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

        // Step 3: Check against database users via API
        
        // $api_url        = "http://localhost:8340/jwtapi/login";
        $parent_api     = $this->config->item('parent_api_url') ?? 'http://localhost:8340';
        $api_url        = $parent_api . "/jwtapi/login";
        
        $postData = array(
            'username' => $username,
            'password' => $password
        );

        $postdata = json_encode($postData);
        // var_dump($postdata);
        // exit;

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postdata)
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        // var_dump($response);
        // exit;

        if (!$response) {

            $this->session->set_flashdata('error', 'Master Server connection error.');
            redirect('authclient/login?t=' . time(), 'refresh');
            return;

        }

        $result = json_decode($response, true);

        // var_dump($result);
        // exit;

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
                'user_email'  => $decoded->data->user_email ?? null,
                'user_role'   => $decoded->data->user_role ?? null,
                'user_entity' => $decoded->data->entity ?? $this->config->item('appentity'),
                'logged_in'   => TRUE,
                'jwt_token'   => $jwt_token
            ];

            $this->session->set_userdata($userData);

            //Write the current logged user to cache
            $this->cache->save('user_creds', $userData, 0); //forever

            // ---- 3. Remember me cookies ----
            $remember = $this->input->post('remember');
            if ($remember) {
                set_cookie('client_remember_email', $username, 86400 * 30);
                set_cookie('client_remember_password', $password, 86400 * 30);
            } else {
                delete_cookie('client_remember_email');
                delete_cookie('client_remember_password');
            }

            log_action2file('login', 'Remote User logged in successfully');

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

    function logout() {

        //===============================
        // Added by Jammi Dee 08/30/2025
        // Log login
        //===============================
        try {

            log_action('logout', 'User logged out');

            $loguserid  = $this->session->userdata('user_id');
            $logemail   = $this->session->userdata('user_email');

            // writeToUserLogs(
            //     $loguserid,
            //     $logemail,
            //     'Logged out of the system',
            //     'Success', // Success, Failed, Pending
            //     $_SERVER['REMOTE_ADDR'],
            //     $_SERVER['HTTP_USER_AGENT'],
            //     ['module' => 'authentication', 'details' => 'Login attempt']
            // );

        } catch (Exception $e) {

            // Handle the exception or log it
            error_log('Error writing to user logs: ' . $e->getMessage());
            var_dump($e);
            exit;
        }

        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('logged_in', FALSE);

        //On logout, remove cache data
        $this->cache->delete('user_creds');

        $this->session->set_flashdata('success', 'User Successfully Updated');
        redirect('welcome?t=' . time(), 'refresh');

    }

    //Added by Jammi Dee 08/30/2025
    public function help()
    {
        // Redirect to dashboard if already logged in
        if (isLogged()) {

            redirect('dashboard?t=' . time(), 'refresh');

        } else {

            $data['title'] = 'Client Login Module Help';

            $this->load->view('_layout/authclient-header-bgnd', $data);
            $this->load->view('authclient/help', $data);
            $this->load->view('_layout/authclient-footers', $data);
        }
    }


}