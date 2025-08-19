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
 * CREATED DATE : July 09, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

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

				$data['title'] = 'Landing Page';

				$this->load->view('site/_layout/auth-header', $data);
				$this->load->view('site/index', $data);
				$this->load->view('site/_layout/auth-footers', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

	}

	public function apitest()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'API Test Page';

				$this->load->view('site/_layout/auth-header', $data);
				$this->load->view('site/apitest', $data);
				$this->load->view('site/_layout/auth-footers', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

	}

    //Main non-logged page
	public function main()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'Main Page';

				$this->load->view('site/_layout/header', $data);
                $this->load->view('site/_layout/sidebar', $data);
                $this->load->view('site/_layout/topbar', $data);
				$this->load->view('site/main', $data);
				$this->load->view('site/_layout/auth-footers', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

    }
	
	//Added by Jammi Dee 0711/2025
	public function flyer()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'Flyer Page';

				$this->load->view('site/_layout/header', $data);
                $this->load->view('site/_layout/sidebar', $data);
                $this->load->view('site/_layout/topbar', $data);
				$this->load->view('site/flyer', $data);
				$this->load->view('site/_layout/auth-footers', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

    }

	//Added by Jammi Dee 07/11/2025
	public function fullflyer()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'Full Flyer Page';

				$this->load->view('site/_layout/auth-header', $data);
				$this->load->view('site/fullflyer', $data);
				$this->load->view('site/_layout/auth-footers', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

    }

	//Added by Jammi Dee 08/12/2025
	public function fullmap()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'Full Flyer Page';

				$this->load->view('site/_layout/header-map', $data);
				$this->load->view('site/fullmap', $data);
				$this->load->view('site/_layout/footer-map', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

    }

	//Added by Jammi Dee 08/14/2025
	public function fullcalendar()
	{

		$cg_landingpage = $this->config->item('cg_landingpage');

        if( $cg_landingpage == true){

			if( isLogged() ){

				redirect('dashboard?t=' . time() , 'refresh');

			} else {

				$data['title'] = 'Full Flyer Page';

				$this->load->view('site/_layout/header-cal', $data);
				$this->load->view('site/fullcalendar', $data);
				$this->load->view('site/_layout/footer-cal', $data);

			}


		} else {

			redirect('auth/login?t=' . time() , 'refresh');

		}

    }


}

