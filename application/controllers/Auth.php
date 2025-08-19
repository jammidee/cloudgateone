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
 * CREATED DATE : June 28, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->load->helper('cookie');
        // $this->load->model('main');

    }

    public function login()
    {
        // Redirect to dashboard if already logged in
        if (isLogged()) {

            redirect('dashboard?t=' . time(), 'refresh');

        } else {

            $data['title'] = 'Login';

            // Load saved email and password from cookies
            $data['remember_email']    = get_cookie('remember_email');
            $data['remember_password'] = get_cookie('remember_password');

            // Pass redirect URL to the view, if provided
            $url = $this->input->get('redirect');
            if (!empty($url)) {
                $data['redirect_url'] = urldecode($url); // decode just in case it's encoded
            }

            $this->load->view('_layout/auth-header-bgnd', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('_layout/auth-footers', $data);
        }
    }


    function checkinguser() {
        $email          = $this->input->post('email');
        $password       = md5($this->input->post('password'));
        $selectedRouter = $this->input->post('router');

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
                set_cookie('remember_email', $email, 86400 * 30);
                set_cookie('remember_password', $password, 86400 * 30);
            } else {
                delete_cookie('remember_email');
                delete_cookie('remember_password');
            }

            // Log login
            try {
                log_action('login', 'Superadmin logged in successfully');
            } catch (Exception $e) {
                error_log('Error writing to user logs: ' . $e->getMessage());
                var_dump($e);
                exit;
            }

            $redirect_url = $this->input->post('redirect');
            if (!empty($redirect_url)) {
                redirect($redirect_url . '?t=' . time(), 'refresh');
            } else {
                redirect('dashboard?t=' . time(), 'refresh');
            }

            return;
        }

        // Step 2: Check against database users
        $query = $this->db->get_where('users', array('email' => $email, 'pass' => $password));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $newdata = array(
                    'user_id'       => $row->id,
                    'user_name'     => $row->name,
                    'user_email'    => $row->email,
                    'user_role'     => $row->role,
                    'user_entity'   => $this->config->item('appentity'),
                    'logged_in'     => TRUE,
                );
            }

            $this->session->set_userdata($newdata);

            $remember = $this->input->post('remember');
            if ($remember) {
                set_cookie('remember_email', $email, 86400 * 30);
                set_cookie('remember_password', $password, 86400 * 30);
            } else {
                delete_cookie('remember_email');
                delete_cookie('remember_password');
            }

            try {
                log_action('login', 'User logged in successfully');
            } catch (Exception $e) {
                error_log('Error writing to user logs: ' . $e->getMessage());
                var_dump($e);
                exit;
            }

            $redirect_url = $this->input->post('redirect');
            if (!empty($redirect_url)) {
                redirect($redirect_url . '?t=' . time(), 'refresh');
            } else {
                redirect('dashboard?t=' . time(), 'refresh');
            }

        } else {
            redirect('welcome?t=' . time(), 'refresh');
        }
    }


    function logout() {

        //===============================
        // Added by Jammi Dee 06/29/2025
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

        $this->session->set_flashdata('success', 'User Successfully Updated');
        redirect('welcome?t=' . time(), 'refresh');

    }

    //Added by Jammi Dee 07/19/2025
    public function forgotpassword()
    {
        // Redirect to dashboard if already logged in
        if (isLogged()) {

            redirect('dashboard?t=' . time(), 'refresh');

        } else {

            $data['title'] = 'Forgot Password';

            $this->load->view('_layout/auth-header', $data);
            $this->load->view('auth/forgotpassword', $data);
            $this->load->view('_layout/auth-footers', $data);
        }
    }

    public function send_reset_link() {
        $this->load->helper(['url', 'string']); // For random_string
        $this->load->library('email');

        $email = $this->input->post('email', TRUE);

        // Check if user exists
        $user = $this->db->get_where('users', ['email' => $email])->row();
        if (!$user) {

            // Generate random password
            $new_password_plain = random_string('alnum', 8);
            $new_password_hashed = md5($new_password_plain); // Or use password_hash() if supported

            // Update user's password
            $this->db->where('email', $email)->update('users', ['password' => $new_password_hashed]);

            // Build reset URL (optional — for UX)
            $reset_url      = base_url("auth/resetpassword?email=" . urlencode($email));

            // Prepare Mailjet API call
            $api_key        = $this->config->item('mail_api_key');
            $api_secret     = $this->config->item('mail_api_secret');

            $payload = [
                'Messages' => [[
                    'From' => [
                        'Email' => $this->config->item('mail_from'),
                        'Name'  => $this->config->item('mail_app_name')
                    ],
                    'To' => [[
                        'Email' => $email,
                        'Name'  => $user->name ?? ''
                    ]],
                    'Subject' => "Password Reset Request",
                    'TextPart' => "You requested a password reset. Here is your new password: $new_password_plain\n\nClick to confirm reset: $reset_url",
                    'HTMLPart' => "<p>You requested a password reset.</p>
                                <p><strong>New Password:</strong> $new_password_plain</p>
                                <p><a href='$reset_url'>Click here to confirm the reset</a></p>"
                ]]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->config->item('mail_url'));
            curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //remove if cert already available

            $response = curl_exec($ch);
            // if ($response === false) {
            //     echo 'Curl error: ' . curl_error($ch);
            // } else {
            //     echo 'Response: ' . $response;
            // }
            // curl_close($ch);
            // exit();

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status == 200) {
                $this->session->set_flashdata('success', 'If the email exists, a reset link has been sent.');
            } else {
                $this->session->set_flashdata('error', 'Failed to send reset email. Please try again later.');
            }
            redirect('auth/login?t=' . time() );

        } else {

            $this->session->set_flashdata('error', 'If the email does not exists, reset link was not been sent.');
            redirect('auth/login?t=' . time() );
            return;
        }

    }


}


