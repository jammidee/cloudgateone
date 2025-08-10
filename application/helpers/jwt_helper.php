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

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('generate_jwt')) {
    /**
     * Generate JWT. If $secret_key is null, uses config item 'jwt_secret'.
     * @param array $payload
     * @param string|null $secret_key
     * @param int $expiry seconds
     * @return string
     * @throws Exception if secret not configured
     */
    function generate_jwt(array $payload, $secret_key = null, $expiry = 3600) {
        $CI =& get_instance();
        if ($secret_key === null) {
            $secret_key = $CI->config->item('jwt_secret');
        }
        if (empty($secret_key)) {
            throw new Exception('JWT secret key not configured.');
        }

        $issuedAt = time();
        $expire   = $issuedAt + (int)$expiry;

        $token = [
            'iat'  => $issuedAt,
            'exp'  => $expire,
            'data' => $payload
        ];

        return JWT::encode($token, $secret_key, 'HS256');
    }
}

if (!function_exists('decode_jwt')) {
    /**
     * Decode JWT. If $secret_key is null, uses config item 'jwt_secret'.
     * @param string $jwt
     * @param string|null $secret_key
     * @param bool $return_full if true returns full decoded object as array (iat, exp, data)
     * @return array|false
     */
    function decode_jwt($jwt, $secret_key = null, $return_full = false) {
        $CI =& get_instance();
        if ($secret_key === null) {
            $secret_key = $CI->config->item('jwt_secret');
        }
        if (empty($secret_key)) {
            log_message('error', 'JWT secret key not configured.');
            return false;
        }

        try {
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            $decoded_arr = (array) $decoded;
            return $return_full ? $decoded_arr : (array)$decoded->data;
        } catch (Exception $e) {
            log_message('error', 'JWT decode error: ' . $e->getMessage());
            return false;
        }
    }
}