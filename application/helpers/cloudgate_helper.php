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
 * CREATED DATE : June 28, 2025
 * ------------------------------------------------------------------------
 */

//=====================
// STATE CHECK
//=====================
// if (!function_exists('isLogin')) {
//     function isLogin() {
//         $ci = & get_instance(); //get main CodeIgniter object
//         $loggedIn = $ci->session->userdata('logged_in');
//         if (!$loggedIn) {

//             log_action(
//                 'unauthorized_access',
//                 'Unauthorized access attempt to secure page',
//                 'WARNING',
//                 true
//             );

//             return redirect('auth/login', 'refresh');

//         }
//     }
// }

if (!function_exists('isLogin')) {
    function isLogin() {
        $ci = & get_instance();
        $loggedIn = $ci->session->userdata('logged_in');

        if (!$loggedIn) {
            // Get caller info (controller and method)
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $caller = $backtrace[1] ?? null;

            $called_from = 'Unknown';
            if ($caller && isset($caller['class'], $caller['function'])) {
                $called_from = $caller['class'] . '::' . $caller['function'];
            }

            // Optional: also capture URI
            $uri = uri_string(); // e.g., 'admin/settings'

            log_action(
                'unauthorized_access',
                'Unauthorized access attempt to ' . $called_from . ' at URI: ' . $uri,
                'WARNING',
                true
            );

            return redirect('auth/login', 'refresh');
        }
    }
}

if (!function_exists('isLogged')) {
    function isLogged() {
        $ci = & get_instance(); //get main CodeIgniter object
        $loggedIn = $ci->session->userdata('logged_in');
        if ($loggedIn) {
            return true;
        }
    }
}

//============
// ROLE CHECK
//============

if (!function_exists('isManager')) {
    function isManager() {
        $ci = & get_instance();
        $userRole = $ci->session->userdata('user_role');
        if ($userRole !== "Manager") {
            return false;
        }else{
            return true;
        }
    }
}

if (!function_exists('isSupport')) {
    function isSupport() {
        $ci = & get_instance();
        $userRole = $ci->session->userdata('user_role');
        if ($userRole !== "Support") {
            return false;
        }else{
            return true;
        }
    }
}

if (!function_exists('isUser')) {
    function isUser() {
        $ci = & get_instance();
        $userRole = $ci->session->userdata('user_role');
        if ($userRole !== "User") {
            return false;
        }else{
            return true;
        }
    }
}

if (!function_exists('notAdmin')) {
    function notAdmin() {
        $ci = & get_instance(); //get main CodeIgniter object
        $userRole = $ci->session->userdata('user_role');
        if ($userRole !== "Admin") {
            return false;
        }else{
            return true;
        }
    }
}

//=============
// GROUP ROLES
//=============

//Technical Group roles
if (!function_exists('isTechGroup')) {
    function isTechGroup() {
        $ci = & get_instance(); // Get main CodeIgniter object
        $userRole = $ci->session->userdata('user_role');
        if ($userRole == "Admin") {
            return true;
        } elseif ($userRole == "Support") { // Fix: Use `elseif` or close `if` block
            return true;
        } else {
            return false;
        }
    }
}

//Management Group roles
if (!function_exists('isBizzGroup')) {
    function isBizzGroup() {
        $ci = & get_instance(); //get main CodeIgniter object
        $userRole = $ci->session->userdata('user_role');
        if ($userRole == "Admin") {
            return true;
        } if ($userRole == "Manager") {
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('roleBelongsTo')) {
    function roleBelongsTo($role, $group) {
        $ci =& get_instance();
        $roles = $ci->config->item('cg-roles');
        return isset($roles[$group]) && in_array($role, $roles[$group]);
    }
}


//===============
// GET USER INFO
//===============

if (!function_exists('getUsername')) {
    function getUsername() {
        $ci = & get_instance();
        $ci->load->database();
        $userID = $ci->session->userdata('user_id');
        $query = $ci->db->get_where('users', array('id' => $userID));
        if($query->num_rows() > 0){
            return $query->result()[0]->name;
        }else{
            return " ";
        }
    }
}