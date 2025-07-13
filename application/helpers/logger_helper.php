<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
 * CREATED DATE : July 09, 2025
 * ------------------------------------------------------------------------
 */

//  Usage:
 
//  log_action('login', 'User logged in successfully');
//  log_action(
//     'failed_login',
//     'Failed login attempt for email: ' . $email,
//     'WARNING',
//     true // suspicious if repeated
//  );
//  log_action('update', 'Updated profile information');
//  log_action('delete', 'Deleted item ID 123 from inventory module', 'WARNING');
 


function log_action($action_type, $action_details, $severity = 'INFO', $is_suspicious = false)
{
    $CI =& get_instance();
    $CI->load->database();
    $CI->load->library('session');

    $user_id = $CI->session->userdata('user_id') ?? null;
    $ip_address = $CI->input->ip_address();
    $user_agent = $CI->input->user_agent();

    $CI->db->insert('system_logs', [
        'user_id'       => $user_id,
        'action_type'   => $action_type,
        'action_details'=> $action_details,
        'ip_address'    => $ip_address,
        'user_agent'    => $user_agent,
        'severity'      => $severity,
        'is_suspicious' => $is_suspicious ? 1 : 0
    ]);
}
