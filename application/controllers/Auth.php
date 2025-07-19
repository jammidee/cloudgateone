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

            $this->load->view('_layout/auth-header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('_layout/auth-footers', $data);
        }
    }


    function checkinguser() {

        //$kenadekha['kenadekha'] = TRUE;

        //$this->session->set_userdata($kenadekha);

        $email          = $this->input->post('email');
        $password       = md5($this->input->post('password'));
        $selectedRouter = $this->input->post('router');

        //If selected is NONE, default it to 1.
        if( $selectedRouter == ''){
            $selectedRouter = 1;
        }

        // $data = $this->main->getRouterByID( $selectedRouter );

        $query = $this->db->get_where('users', array('email' => $email, 'pass' => $password));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $newdata = array(
                    'user_id'                   => $row->id,
                    'user_name'                 => $row->name,
                    'user_email'                => $row->email,
                    'user_role'                 => $row->role,
                    'user_entity'               => $this->config->item('appentity'),
                    'logged_in'                 => TRUE,
                );
            }

            $this->session->set_userdata($newdata);

            // Set Remember Me cookie (optional: encrypt or hash)
            $remember = $this->input->post('remember');
            if ($remember) {
                $cookie = array(
                    'name'   => 'remember_email',
                    'value'  => $email,
                    'expire' => 86400 * 30, // 30 days
                    'secure' => false
                );
                set_cookie($cookie);

                $cookie = array(
                    'name'   => 'remember_password',
                    'value'  => $password,
                    'expire' => 86400 * 30,
                    'secure' => false
                );
                set_cookie($cookie);
            } else {
                delete_cookie('remember_email');
                delete_cookie('remember_password');
            }

            //===============================
            // Added by Jammi Dee 01/22/2025
            // Log login
            //===============================
            try {

                $loguserid  = $this->session->userdata('user_id');
                $logemail   = $this->session->userdata('user_email');

                // writeToUserLogs(
                //     $loguserid,
                //     $logemail,
                //     'Logged into the system',
                //     'Success', // Success, Failed, Pending
                //     $_SERVER['REMOTE_ADDR'],
                //     $_SERVER['HTTP_USER_AGENT'],
                //     ['module' => 'authentication', 'details' => 'Login attempt']
                // );

                log_action('login', 'User logged in successfully');


            } catch (Exception $e) {

                // Handle the exception or log it
                error_log('Error writing to user logs: ' . $e->getMessage());
                var_dump($e);
                exit;

            }

            //Go to the redirect URL
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

        $this->session->set_flashdata('error', 'User Successfully Updated');
        redirect('welcome?t=' . time(), 'refresh');

    }

}
