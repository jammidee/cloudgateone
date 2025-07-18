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
 * CREATED DATE : July 14, 2025
 * ------------------------------------------------------------------------
 */

use \Firebase\JWT\JWT;

if (!function_exists('generate_jwt')) {
    function generate_jwt($payload)
    {
        $key = 'your_secret_key'; // Put in config ideally
        $payload['iat'] = time();
        $payload['exp'] = time() + (60 * 60); // 1 hour expiry

        return JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('validate_jwt')) {
    function validate_jwt($token)
    {
        $key = 'your_secret_key';
        try {
            return JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
