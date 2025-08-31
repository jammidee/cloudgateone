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
        if ($string === null) {
            return '';
        }
        return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
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
 * Get a variable value from configdb
 * Returns $default if not found
 */
if (!function_exists('get_configdb_inc')) {
    function get_configdb_inc($entityid, $userid, $key, $default = null) {
        $CI =& get_instance();
        $CI->load->model('Configdbmodel');
        return $CI->Configdbmodel->readVarInc($entityid, $userid, $key, $default);
    }
}

/**
 * Get a variable value from configdb
 * Returns $default if not found
 */
if (!function_exists('get_configdb_inc')) {
    function get_configdb_inc($entityid, $userid, $key, $default = null) {
        $CI =& get_instance();
        $CI->load->model('Configdbmodel');
        return $CI->Configdbmodel->readVarInc($entityid, $userid, $key, $default);
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


/* -------------------------------------------------------------------------
   08/22/2025 - JMD
   Function: generate_unique_code
   Purpose:
     Creates a pseudo-random unique code based on current timestamp + random string.

   Parameters:
     $prefix (string) - Optional prefix to prepend before the generated code.

   Behavior:
     - If a prefix is provided, code format will be PREFIX-XXXXXXXX
     - If no prefix is provided, only the code is returned.
------------------------------------------------------------------------- */
if (!function_exists('generate_unique_code')) {
    function generate_unique_code($prefix = '') {
        /* Use current time in milliseconds for uniqueness */
        $timestamp = round(microtime(true) * 1000);

        /* Generate a random 4-character alphanumeric string */
        $random = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));

        /* Combine timestamp + random string and hash it */
        $raw = $timestamp . $random;
        $code = strtoupper(substr(md5($raw), 0, 8)); /* Take first 8 chars of MD5 hash */

        /* Return with or without prefix */
        return $prefix ? $prefix . '-' . $code : $code;
    }
}

/* -------------------------------------------------------------------------
   08/22/2025 - JMD
   Function: generate_verified_unique_code
   Purpose:
     Creates a unique code and verifies against database to ensure no duplicates exist.

   Parameters:
     $CI     - CodeIgniter instance to access DB
     $prefix (string) - Optional prefix for the code
     $table  (string) - Table name to check for uniqueness (default: 'customer_codes')
     $column (string) - Column name to check for uniqueness (default: 'customer_code')

   Behavior:
     - Attempts up to 3 times to generate a unique code
     - Returns the generated code if unique
     - Returns empty string '' if all attempts fail
------------------------------------------------------------------------- */
if (!function_exists('generate_verified_unique_code')) {
    function generate_verified_unique_code($CI, $prefix = '', $table = 'customer_codes', $column = 'customer_code') {
        $attempts = 0;

        /* Try up to 3 times to generate a unique code */
        while ($attempts < 3) {
            $code = generate_unique_code($prefix);

            /* Check if code already exists in given table/column */
            $exists = $CI->db->where($column, $code)->count_all_results($table);

            if ($exists == 0) {
                return $code; /* Unique code found */
            }

            $attempts++;
        }

        return ''; /* Return blank if uniqueness could not be guaranteed */
    }
}


