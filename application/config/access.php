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

//Define group that can be accessed by roles.
$config['cg-roles'] = array(
    'admin-group'       => array('Admin'),
    'support-group'     => array('Admin','Support'),
    'business-group'    => array('Admin','Manager', 'User', 'Client'),
    'user-group'        => array('Admin','Support','Manager','Guest', 'Visitor'),
    'guest-group'       => array('Admin','Support','Manager','Guest', 'Visitor')
);

//Define menu that can be access by a group
$config['menu-access'] = array(
    
    //Lookup right controls
    'lookup_manage'         => array('admin-group','support-group','business-group','user-group'),
    'lookup_create'         => array('admin-group','support-group'),
    'lookup_read'           => array('admin-group','support-group','business-group','user-group'),
    'lookup_update'         => array('admin-group','support-group'),
    'lookup_delete'         => array('admin-group','support-group'),

    //User right controls
    'user_manage'           => array('admin-group'),
    'user_create'           => array('admin-group'),
    'user_read'             => array('admin-group'),
    'user_update'           => array('admin-group'),
    'user_delete'           => array('admin-group'),

    'settings_manage'       => array('admin-group', 'support-group'),

    'support_dashboard'     => array('support-group'),
    'page_test'             => array('admin-group', 'support-group', 'business-group', 'user-group'),
);