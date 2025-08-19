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
 * CREATED DATE : June 29, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Pagetest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isLogin();

        $this->load->model('mainmodel');

    }

    public function index()
    {
        $data['title'] = 'Page';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('pagetest/index',     $data);
        $this->load->view('_layout/footer');

    }

    public function all() {

        $data['users']      = $this->mainmodel->getAllUsers();

        $maxUserCap = $this->config->item('max_user_cap');
        if ($maxUserCap === NULL) {
            die("Configuration item 'max_user_cap' is not defined.");
        }
        if( count($data['users']) < $maxUserCap ){
            $data['userMaxCap'] = false;
        } else {
            $data['userMaxCap'] = true;
            $this->session->set_flashdata('warning', 'Maximum user registered reached!');
        }

        $data['title'] = 'All Pages';

        // Write variable
        $entityid = $this->session->userdata('user_entity') ?? '_NA_';
        $userid   = $this->session->userdata('user_id') ?? 0;
        set_configdb($entityid, $userid, 'maxusers', $maxUserCap, 'integer', 'Maximum number of users allowed');
        
        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('pagetest/pagetest',  $data);
        $this->load->view('_layout/footer');

        $types = ['success', 'error', 'warning'];
        $randomType = $types[array_rand($types)];
        $this->session->set_flashdata($randomType, 'User Successfully Updated');

    }


}