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
 


// function log_action($action_type, $action_details, $severity = 'INFO', $is_suspicious = false)
// {
//     $CI =& get_instance();
//     $CI->load->database();
//     $CI->load->library('session');

//     $user_id = $CI->session->userdata('user_id') ?? null;
//     $ip_address = $CI->input->ip_address();
//     $user_agent = $CI->input->user_agent();

//     $CI->db->insert('system_logs', [
//         'user_id'       => $user_id,
//         'action_type'   => $action_type,
//         'action_details'=> $action_details,
//         'ip_address'    => $ip_address,
//         'user_agent'    => $user_agent,
//         'severity'      => $severity,
//         'is_suspicious' => $is_suspicious ? 1 : 0
//     ]);
// }

function log_action($action_type, $action_details, $severity = 'INFO', $is_suspicious = false)
{
    $CI =& get_instance();
    $CI->load->database();
    $CI->load->library('session');

    $user_id   = $CI->session->userdata('user_id') ?? 0;
    $entity_id = $CI->session->userdata('user_entity') ?? '_NA_';
    $ip_address = $CI->input->ip_address();
    $user_agent = $CI->input->user_agent();

    $log_data = [
        'entityid'       => $entity_id,
        'user_id'        => $user_id,
        'action_type'    => $action_type,
        'action_details' => $action_details,
        'ip_address'     => $ip_address,
        'user_agent'     => $user_agent,
        'severity'       => $severity,
        'is_suspicious'  => $is_suspicious ? 1 : 0,
        'sstatus'        => 'ACTIVE',
        'pid'            => 0,
        'userid'         => $user_id,
        'deleted'        => 0
    ];

    $CI->db->insert('system_logs', $log_data);
}

// function log_action2file($action_type, $action_details, $severity = 'INFO', $is_suspicious = false)
// {
//     This function logs user/system actions into a FILE instead of the database.  
//     Each log entry is saved in JSON format for easy readability and parsing.  
//     A new log file is created daily under `application/logs/` with the name pattern:  
//     `actions-YYYY-MM-DD.log`
//
//     Parameters:
//         $action_type    : String  - Type of action being performed (e.g., 'LOGIN', 'DELETE', 'UPDATE').
//         $action_details : String  - Detailed description of the action (e.g., which record was updated).
//         $severity       : String  - Log level (default: 'INFO'). Can be 'INFO', 'WARNING', 'ERROR', etc.
//         $is_suspicious  : Boolean - Flag for marking suspicious activities (default: false).
//
//     Captured automatically from the session/environment:
//         - user_id       : ID of the logged-in user (0 if guest).
//         - entity_id     : The entity/organization ID if available (defaults to '_NA_').
//         - ip_address    : The client’s IP address.
//         - user_agent    : Browser/Client user agent string.
//
//     Behavior:
//         - Encodes all log data as JSON.
//         - Appends each log line to the appropriate daily log file.
//         - Uses file locking (LOCK_EX) to prevent simultaneous write collisions.
// }
// Added by Jammi Dee 08/31/2025
function log_action2file($action_type, $action_details, $severity = 'INFO', $is_suspicious = false)
{
    $CI =& get_instance();
    $CI->load->library('session');

    $user_id    = $CI->session->userdata('user_id') ?? 0;
    $entity_id  = $CI->session->userdata('user_entity') ?? '_NA_';
    $ip_address = $CI->input->ip_address();
    $user_agent = $CI->input->user_agent();

    $log_data = [
        'timestamp'      => date('Y-m-d H:i:s'),
        'entityid'       => $entity_id,
        'user_id'        => $user_id,
        'action_type'    => $action_type,
        'action_details' => $action_details,
        'ip_address'     => $ip_address,
        'user_agent'     => $user_agent,
        'severity'       => $severity,
        'is_suspicious'  => $is_suspicious ? 1 : 0
    ];

    // Encode as JSON so it's structured in the log file
    $log_line = json_encode($log_data) . PHP_EOL;

    // File path (daily rotating log file inside application/logs/)
    $log_file = APPPATH . 'logs/actions-' . date('Y-m-d') . '.log';

    // Append to file
    file_put_contents($log_file, $log_line, FILE_APPEND | LOCK_EX);
}