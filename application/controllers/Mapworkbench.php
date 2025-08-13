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
 * CREATED DATE : August 12, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Mapworkbench extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Check user login session
        $uri = uri_string();
        isLoginRedirect($uri);

        // Load models if needed in future expansion
        // $this->load->model('mapmodel');
    }

    /**
     * ------------------------------------------------------------------------
     * Default method to load the map view page.
     * ------------------------------------------------------------------------
     */
    public function mapview() {
        $data['title'] = 'Map Workbench';

        // Load the layout with our map page
        $this->load->view('_layout/header-map',  $data);
        $this->load->view('mapworkbench/mapview', $data); // Map page
        $this->load->view('_layout/footer-map');
    }
    
    /**
     * ------------------------------------------------------------------------
     * Default method to load the map view page.
     * ------------------------------------------------------------------------
     */
    public function mapviewv2() {
        $data['title'] = 'Map Workbench';

        // Load the layout with our map page
        $this->load->view('_layout/header-map',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('mapworkbench/mapviewv2', $data); // Map page
        $this->load->view('_layout/footer-map');
    }
    
}
