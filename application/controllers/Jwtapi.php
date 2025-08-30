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

/**
 * For the API to work, it requires:
 *
 * 	    # Special Notes for header
 *      SetEnvIfNoCase Authorization "^(.*)$" HTTP_AUTHORIZATION=$1
 *
 *      Place this in the apache server virtual host config
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

        // echo "Raw: " . $this->input->raw_input_stream;
        // $input = json_decode($this->input->raw_input_stream, true);
        // var_dump($input);
        // exit;

        // Read username/password from JSON body
        $username       = isset($input['username']) ? $input['username'] : null;
        $password       = isset($input['password']) ? $input['password'] : null; // Same hash style as DB

        // var_dump($username, $password );
        // exit;

        if (empty($username) || empty($password)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Username and password are required'
            ]);
            return;
        }

        // var_dump($username, $password);
        // exit;

        // Check database users
        $query = $this->db->get_where('users', [
            'email' => $username,
            'pass'  => $password
        ]);

        // echo $this->db->last_query();
        // var_dump($query->num_rows());
        // exit;

        if ($query->num_rows() > 0) {

            // var_dump($query->num_rows());
            // exit;

            $row = $query->row();

            // Payload for JWT
            $payload = [
                'id'     => $row->id,
                'name'   => $row->name,
                'email'  => $row->email,
                'role'   => $row->role
            ];

            // var_dump($payload);
            // exit;

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
    
    
    /**
     * -------------------------------
     * GENERIC QUERY API
     * -------------------------------
     * Expects JSON body:
     * {
     *   "table": "users",
     *   "filters": {"status": "active"},
     *   "sort": {"column": "id", "direction": "desc"},
     *   "limit": 10,
     *   "offset": 0
     * }
     */
    /**
     * -------------------------------
     * GENERIC QUERY API
     * -------------------------------
     * Expects JSON body:
     * {
     *   "table": "users",
     *   "filters": {"status": "active"},
     *   "sort": {"column": "id", "direction": "desc"},
     *   "limit": 10,
     *   "offset": 0
     * }
     */
    public function query()
    {
        // JWT Validation
        $auth_header = $this->input->get_request_header('Authorization');
        if (!$auth_header || strpos($auth_header, 'Bearer ') !== 0) {
            show_error('Unauthorized', 401);
        }

        $token   = substr($auth_header, 7);
        $decoded = decode_jwt($token);
        if (!$decoded) {
            show_error('Invalid or expired token', 401);
        }

        // Get request body
        $input = json_decode($this->input->raw_input_stream, true);

        $table   = isset($input['table']) ? $input['table'] : null;
        $filters = isset($input['filters']) ? $input['filters'] : [];
        $sort    = isset($input['sort']) ? $input['sort'] : [];
        $limit   = isset($input['limit']) ? intval($input['limit']) : null;
        $offset  = isset($input['offset']) ? intval($input['offset']) : null;
        $draw    = isset($input['draw']) ? intval($input['draw']) : 1;
        $search  = isset($input['search']) ? trim($input['search']) : '';

        if (empty($table)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Table name is required'
            ]);
            return;
        }

        // 🔹 Step 1: Get total count (no filters, no search)
        $total_count = $this->db->count_all($table);

        // 🔹 Step 2: Apply filters + search for filtered count
        $this->db->from($table);

        if (!empty($filters)) {
            foreach ($filters as $col => $val) {
                $this->db->where($col, $val);
            }
        }

        if (!empty($search)) {
            $this->db->group_start(); // ( ... )
            $fields = $this->db->list_fields($table);
            foreach ($fields as $i => $field) {
                if ($i === 0) {
                    $this->db->like($field, $search);
                } else {
                    $this->db->or_like($field, $search);
                }
            }
            $this->db->group_end(); // end ( ... )
        }

        $filtered_count = $this->db->count_all_results();

        // 🔹 Step 3: Fetch actual data with filters, search, sort, pagination
        $this->db->from($table);

        if (!empty($filters)) {
            foreach ($filters as $col => $val) {
                $this->db->where($col, $val);
            }
        }

        if (!empty($search)) {
            $this->db->group_start();
            $fields = $this->db->list_fields($table);
            foreach ($fields as $i => $field) {
                if ($i === 0) {
                    $this->db->like($field, $search);
                } else {
                    $this->db->or_like($field, $search);
                }
            }
            $this->db->group_end();
        }

        if (!empty($sort)) {
            $col = isset($sort['column']) ? $sort['column'] : 'id';
            $dir = isset($sort['direction']) ? $sort['direction'] : 'asc';
            $this->db->order_by($col, $dir);
        }

        if (!empty($limit)) {
            $this->db->limit($limit, $offset ?? 0);
        }

        $query  = $this->db->get();
        $result = $query->result();

        // 🔹 Step 4: Return DataTables compatible JSON
        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $total_count,
            'recordsFiltered' => $filtered_count,
            'data' => $result
        ]);
    }


}