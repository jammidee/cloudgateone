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

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {

        parent::__construct();

    }

	public function index()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'Welcome';

				$this->load->view('_layout/auth-header', $data);
				$this->load->view('welcome/index');
				$this->load->view('_layout/auth-footers', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

	}

}
