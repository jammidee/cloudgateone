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
 * CREATED DATE : Aug. 28, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Clientdash extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        isClientLoginRedirect();
    }

    public function help()
    {
        $data['title'] = 'Dashboard Help';

        $this->load->view('_layout/client-header',      $data);
        $this->load->view('_layout/client-sidebar',     $data);
        $this->load->view('_layout/client-topbar',      $data);
        $this->load->view('clientdash/help',            $data);
        $this->load->view('_layout/client-footer');

    }

    public function index()
    {
        $data['title'] = 'Client Dashboard';

        //This is a test of a remote API call.
        $parent_api = $this->config->item('parent_api_url') ?? 'http://localhost:8340';
        $api_url    = $parent_api . "/jwtapi/query";

        // Token saved from login (in session)
        $token = $this->session->userdata('jwt_token');
        $data['token']  = $token;

        $this->load->view('_layout/client-header',      $data);
        $this->load->view('_layout/client-sidebar',     $data);
        $this->load->view('_layout/client-topbar',      $data);
        $this->load->view('clientdash/index',           $data);
        $this->load->view('_layout/client-footer');

    }
}
