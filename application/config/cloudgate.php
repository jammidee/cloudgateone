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
 * CREATED DATE : June 28, 2025
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

// Added by Jammi Dee 06/28/2025

$config['appid']                    = 'CGONE';
$config['appname']                  = 'CG Admin';
$config['appdesc']                  = 'Cloudgate Application Template';
$config['appprefix']                = 'FEA';
$config['appversion']               = '1.07.1972';
$config['appcopyright']             = 'Lalulla OPC';
$config['appentity']                = 'LALULLA';

$config['cg_version']               = '1.19.72';
$config['allowlogin']               = true;             // Allow user to login in the system
$config['autoreg']                  = false;             // Allow user to register themselves
$config['cg_landingpage']           = true;

//Business
$config['max_user_cap']             = 50;


//Mail Notification Settings
$config['mail_api_key']             = '111-ae6d6fbf53f804bbb7b753e58ed66970-xyz';
$config['mail_api_secret']          = '222-8cf78ed0415e57bf03ef953fa655fba2-xyz';
$config['mail_url']                 = 'https://api.mailjet.com/v3.1/send';
$config['mail_from']                = 'jammi_dee@yahoo.com';
$config['mail_app_name']            = 'Cloudgate One';

//Client Config
$config['parent_api_url']           = 'http://localhost:8340';
