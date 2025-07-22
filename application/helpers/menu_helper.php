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

if (!function_exists('is_active_menu')) {
    function is_active_menu($controller, $method = null) {

        $CI =& get_instance();
        $current_controller = $CI->router->fetch_class();
        $current_method     = $CI->router->fetch_method();

        if ($method === null) {
            return ($controller === $current_controller) ? 'active' : '';
        }

        return ($controller === $current_controller && $method === $current_method) ? 'active' : '';

    }
}

if (!function_exists('is_active_menu_bg')) {
    function is_active_menu_bg($controller, $method = null, $styleOrClass = 'class')
    {
        $CI =& get_instance();
        $current_controller = $CI->router->fetch_class();
        $current_method     = $CI->router->fetch_method();

        $is_active = false;

        if ($method === null) {
            $is_active = ($controller === $current_controller);
        } else {
            $is_active = ($controller === $current_controller && $method === $current_method);
        }

        if (!$is_active) return '';

        if ($styleOrClass === 'style') {
            return 'style="background-color: #f0f0f0;"'; // customize background color
        }

        return 'class="bg-primary text-white"'; // Bootstrap 4/5 highlight class
    }
}


