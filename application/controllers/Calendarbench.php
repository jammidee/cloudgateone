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
 * CREATED DATE : August 18, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Calendarbench extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Check user login session
        $uri = uri_string();
        isLoginRedirect($uri);

    }

    /**
     * ------------------------------------------------------------------------
     * Default method to load the map view page.
     * ------------------------------------------------------------------------
     */
    public function calview() {
        $data['title'] = 'Calendar Workbench';

        // Load the layout with our calendar page
        $this->load->view('_layout/header-cal',         $data);
        $this->load->view('_layout/sidebar',            $data);
        $this->load->view('_layout/topbar',             $data);
        $this->load->view('calendarbench/calview',      $data); // Calendar page
        $this->load->view('_layout/footer-cal');
    }

}