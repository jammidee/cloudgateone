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
 * CREATED DATE : July 14, 2025
 * ------------------------------------------------------------------------
 */


/*
| A Small Plant.
| By Jammi Dee

| Seeds embedded
| Seems dead and get rid. Sleeps deep , beep!beep!
| In the moist deep peep
| Sun can up in fun
| Run see the seeds
| Look nook don't talk
| The seed is gone.

| Stop.

| Whats that's baby doing here
| Where is her mother?
| Do they care for him?
| Let's get the baby home
| Let's give her room
| To be cared of..

| No you're besides her mother
| You're stepping in their home

| She is a young baby plant
| Her mother is the narra tree,
| Their house is the earth.

*/

defined('BASEPATH') OR exit('No direct script access allowed');

$config['superadmins'] = array(
    array(
        'email'    => 'superadmin@cgone.com',
        'password' => md5('supersecret123') // hash using md5()
    ),
    array(
        'email'    => 'root@cgone.com',
        'password' => md5('toor')
    )
);

//Define group that can be accessed by roles.
$config['cg-roles'] = array(
    'super-group'       => array('Superadmin'),
    'admin-group'       => array('Superadmin', 'Admin'),
    'support-group'     => array('Superadmin', 'Admin','Support'),
    'business-group'    => array('Superadmin', 'Admin','Manager', 'User', 'Client'),
    'user-group'        => array('Superadmin', 'Admin','Support','Manager','Guest', 'Visitor'),
    'guest-group'       => array('Superadmin', 'Admin','Support','Manager','Guest', 'Visitor')
);

//Define menu that can be access by a group
$config['menu-access'] = array(

    //Top Menu controls
    'topmenu_manage'         => array('admin-group','support-group','business-group','user-group'),
    'topmenu_create'         => array('admin-group','support-group'),
    'topmenu_read'           => array('admin-group','support-group','business-group','user-group'),
    'topmenu_update'         => array('admin-group','support-group'),
    'topmenu_delete'         => array('admin-group','support-group'),

    //Lookup right controls
    'lookup_manage'         => array('admin-group','support-group','business-group','user-group'),
    'lookup_create'         => array('admin-group','support-group'),
    'lookup_read'           => array('admin-group','support-group','business-group','user-group'),
    'lookup_update'         => array('admin-group','support-group'),
    'lookup_delete'         => array('admin-group','support-group'),

    //User right controls
    'user_manage'           => array('super-group','admin-group'),
    'user_create'           => array('super-group','admin-group'),
    'user_read'             => array('super-group','admin-group'),
    'user_update'           => array('super-group','admin-group'),
    'user_delete'           => array('super-group','admin-group'),
    'user_report'           => array('super-group','admin-group'),

    //Setting right controls
    'setting_manage'        => array('super-group','admin-group'),
    'setting_create'        => array('super-group','admin-group'),
    'setting_read'          => array('super-group','admin-group'),
    'setting_update'        => array('super-group','admin-group'),
    'setting_delete'        => array('super-group','admin-group'),
    'setting_report'        => array('super-group','admin-group'),

    //Setting right controls
    'superadmin_manage'     => array('super-group'),
    'superadmin_create'     => array('super-group'),
    'superadmin_read'       => array('super-group'),
    'superadmin_update'     => array('super-group'),
    'superadmin_delete'     => array('super-group'),
    'superadmin_report'     => array('super-group'),

    'settings_manage'       => array('super-group','admin-group', 'support-group'),

    'support_dashboard'     => array('super-group','support-group'),
    'page_test'             => array('super-group','admin-group', 'support-group', 'business-group', 'user-group'),
);