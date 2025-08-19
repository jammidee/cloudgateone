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
 * CREATED DATE : July 23, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('esc')) {
    function esc($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Get a variable value from configdb
 * Returns $default if not found
 */
if (!function_exists('get_configdb')) {
    function get_configdb($entityid, $userid, $key, $default = null) {
        $CI =& get_instance();
        $CI->load->model('Configdbmodel');
        return $CI->Configdbmodel->readVar($entityid, $userid, $key, $default);
    }
}

/**
 * Set a variable value into configdb
 * If entity + user + key exists → update, else → insert
 */
if (!function_exists('set_configdb')) {
    function set_configdb($entityid, $userid, $key, $value, $type = 'string', $description = null) {
        $CI =& get_instance();
        $CI->load->model('Configdbmodel');
        return $CI->Configdbmodel->writeVar($entityid, $userid, $key, $value, $type, $description);
    }
}

