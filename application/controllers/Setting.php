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
 * CREATED DATE : July 29, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $uri = uri_string();
        isLoginRedirect($uri);

        $this->load->model('settingmodel');
    }

    public function index() {
        $data['title']   = 'System Settings';
        $data['setting'] = $this->settingmodel->getSetting();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('setting/index',   $data);
        $this->load->view('_layout/footer');
    }

    public function all() {
        $data['title']   = 'System Settings';
        $data['settings'] = $this->settingmodel->getAll();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('setting/all',     $data);
        $this->load->view('_layout/footer');
    }

    public function view() {
        $data['title']   = 'System Settings';
        $data['settings'] = $this->settingmodel->getAll();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('setting/all',     $data);
        $this->load->view('_layout/footer');
    }

    public function edit($id) {
        $data['title']   = 'Edit System Settings';
        $data['setting'] = $this->settingmodel->getById($id);

        if (!$data['setting']) {
            show_404();
        }

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('setting/edit',    $data);
        $this->load->view('_layout/footer');
    }

    public function update($id) {
        $data = $this->input->post();

        $updateData = [
            'logo'          => $data['logo'],
            'favicon'       => $data['favicon'],
            'name'          => $data['name'],
            'slogan'        => $data['slogan'],
            'mobile'        => $data['mobile'],
            'email'         => $data['email'],
            'currency'      => $data['currency'],
            'paymentmethod' => $data['paymentmethod'],
            'paymentacc'    => $data['paymentacc'],
            'vat'           => $data['vat'],
            'smsapi'        => $data['smsapi'],
            'emailapi'      => $data['emailapi'],
            'smsonbills'    => $data['smsonbills'],
            'emailonbills'  => $data['emailonbills'],
            'mkipadd'       => $data['mkipadd'],
            'mkuser'        => $data['mkuser'],
            'mkpassword'    => $data['mkpassword'],
            'address'       => $data['address'],
            'city'          => $data['city'],
            'country'       => $data['country'],
            'zip'           => $data['zip'],
            'location'      => $data['location'],
            'copyright'     => $data['copyright'],
            'kenadekha'     => $data['kenadekha']
        ];

        $this->settingmodel->update($id, $updateData);
        redirect('setting/index?t=' . time());
    }

}
