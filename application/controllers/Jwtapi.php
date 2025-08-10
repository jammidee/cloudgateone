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
 * CREATED DATE : Aug. 10, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Jwtapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('jwt');
        $this->load->helper('url');
    }

    public function login()
    {
        $input = json_decode($this->input->raw_input_stream, true);

        // Read username/password from JSON body
        $email    = isset($input['username']) ? $input['username'] : null;
        $password = isset($input['password']) ? md5($input['password']) : null; // Same hash style as DB

        if (empty($email) || empty($password)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Email and password are required'
            ]);
            return;
        }

        // Check database users
        $query = $this->db->get_where('users', [
            'email' => $email,
            'pass'  => $password
        ]);

        if ($query->num_rows() > 0) {
            $row = $query->row();

            // Payload for JWT
            $payload = [
                'id'     => $row->id,
                'name'   => $row->name,
                'email'  => $row->email,
                'role'   => $row->role
            ];

            // Get secret from config
            $secret = $this->config->item('jwt_secret');

            // Generate token (1 hour expiry)
            $token = generate_jwt($payload, $secret, 3600);

            echo json_encode([
                'status' => 'success',
                'token'  => $token
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Invalid credentials'
            ]);
        }
    }


    public function secure_data()
    {
        $auth_header = $this->input->get_request_header('Authorization');

        if (!$auth_header || strpos($auth_header, 'Bearer ') !== 0) {
            show_error('Unauthorized', 401);
        }

        $token   = substr($auth_header, 7);
        $decoded = decode_jwt($token);

        if ($decoded) {
            echo json_encode([
                'status' => 'success',
                'data'   => $decoded
            ]);
        } else {
            show_error('Invalid or expired token', 401);
        }
    }
    
}