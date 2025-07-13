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

//Added by Jammi Dee 07/14/2025
if (!function_exists('canAccessMenu')) {
    function canAccessMenu($menuId, $userRole)
    {
        $CI =& get_instance();
        $menuAccess = $CI->config->item('menu-access');
        $roleGroups = $CI->config->item('cg-roles');

        if (!is_string($menuId) || !isset($menuAccess[$menuId])) {
            return false;
        }

        $groups = (array) $menuAccess[$menuId]; // force to array

        foreach ($groups as $group) {
            if (isset($roleGroups[$group]) && in_array($userRole, $roleGroups[$group])) {
                return true;
            }
        }

        return false;
    }
}
