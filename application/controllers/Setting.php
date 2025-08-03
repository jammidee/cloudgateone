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
        $this->load->model('lookupmodel');

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

    public function add()
    {
        // Load any required data for the form
        // $data['sites'] = $this->emissionmodel->getAllSites(); // Example data if applicable

        // Set the title for the page
        $data['title'] = 'Add Setting';

        // Fetch countries from the lookup table where keyid = 'country'
        $data['countries']  = $this->lookupmodel->getAllLookup(null, 'country');
        $data['currencies'] = $this->lookupmodel->getAllLookup(null, 'currency');

        // Load views in correct order with data
        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('setting/add',        $data); // Make sure this file exists
        $this->load->view('_layout/footer');
    }

    public function store()
    {
        $data = [];

        // Upload path
        $imagePath = realpath(APPPATH . '../assets/images');

        // === Handle Logo Upload ===
        if (!empty($_FILES['logo']['name'])) {
            $config['upload_path']      = $imagePath;
            $config['allowed_types']    = 'jpg|png|jpeg|gif';
            $config['file_name']        = 'logo_' . time() . '_' . rand(100, 999);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $data['logo'] = $uploadData['file_name'];
            }
        }

        // === Handle Favicon Upload ===
        if (!empty($_FILES['favicon']['name'])) {
            $config['upload_path']      = $imagePath;
            $config['allowed_types']    = 'jpg|png|jpeg|gif|ico';
            $config['file_name']        = 'favicon_' . time() . '_' . rand(100, 999);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('favicon')) {
                $uploadData = $this->upload->data();
                $data['favicon'] = $uploadData['file_name'];
            }
        }

        // === Sanitize and collect form inputs ===
        $fields = ['name', 'slogan', 'email', 'mobile', 'city', 'country', 'currency', 'entityid'];
        foreach ($fields as $field) {
            $value = $this->input->post($field, TRUE); // TRUE for XSS filtering
            if (!empty($value)) {
                $data[$field] = $value;
            }
        }

        // Optional default values (based on schema defaults)
        $defaults = [
            'vat'           => 0,
            'paymentmethod' => '',
            'paymentacc'    => '',
            'smsapi'        => '',
            'emailapi'      => '',
            'smsonbills'    => 0,
            'emailonbills'  => 0,
            'mkipadd'       => '',
            'mkuser'        => '',
            'mkpassword'    => '',
            'address'       => '',
            'zip'           => '',
            'location'      => '',
            'copyright'     => '',
            'kenadekha'     => '',
            'entityid'      => '',
        ];

        foreach ($defaults as $key => $default) {
            $data[$key] = $this->input->post($key, TRUE) ?? $default;
        }

        // === Insert into settings table ===
        $inserted = $this->db->insert('settings', $data);

        if ($inserted) {
            $this->session->set_flashdata('success', 'Settings successfully saved.');
            redirect('setting/all?t=' . time(), 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Failed to save settings.');
            redirect('setting/add?t=' . time(), 'refresh');
        }
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

    public function view($id) {
        $data['title']   = 'System Settings';
        $data['view_setting'] = $this->settingmodel->getById($id);

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('setting/view',    $data);
        $this->load->view('_layout/footer');
    }

    public function edit($id) {
        $data['title']   = 'Edit System Settings';
        $data['setting'] = $this->settingmodel->getById($id);

        // Fetch countries from the lookup table where keyid = 'country'
        $data['countries']  = $this->lookupmodel->getAllLookup(null, 'country');
        $data['currencies'] = $this->lookupmodel->getAllLookup(null, 'currency');

        if (!$data['setting']) {
            show_404();
        }

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('setting/edit',    $data);
        $this->load->view('_layout/footer');
    }

    public function update($id)
    {
        $data = [];

        /* Uploading Logo and Favicon */
        $imagePath = realpath(APPPATH . '../assets/images/');
        $logo = $_FILES['logo']['tmp_name'] ?? '';
        $favicon = $_FILES['favicon']['tmp_name'] ?? '';

        // Handle Logo Upload
        if (!empty($logo)) {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['file_name'] = date('Ymd_His_') . rand(100000, 999999);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('logo')) {
                $uploadData = $this->upload->data();
                $data['logo'] = $uploadData['file_name'];

                // Crop and resize
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploadData['full_path'];
                $config['new_image'] = $imagePath . '/crop';
                $config['quality'] = '100%';
                $config['maintain_ratio'] = FALSE;

                if ($uploadData['image_width'] > $uploadData['image_height']) {
                    $config['width'] = $uploadData['image_height'];
                    $config['height'] = $uploadData['image_height'];
                    $config['x_axis'] = (($uploadData['image_width'] / 2) - ($config['width'] / 2));
                } else {
                    $config['height'] = $uploadData['image_width'];
                    $config['width'] = $uploadData['image_width'];
                    $config['y_axis'] = (($uploadData['image_height'] / 2) - ($config['height'] / 2));
                }

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();

                $config['source_image'] = $imagePath . '/crop/' . $uploadData['file_name'];
                $config['new_image'] = $imagePath . '/final';
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                // Delete raw uploaded image
                unlink($uploadData['full_path']);
            }
        }

        // Handle Favicon Upload
        if (!empty($favicon)) {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['file_name'] = date('Ymd_His_') . rand(100000, 999999);
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('favicon')) {
                $uploadData = $this->upload->data();
                $data['favicon'] = $uploadData['file_name'];

                // Crop and resize
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploadData['full_path'];
                $config['new_image'] = $imagePath . '/crop';
                $config['quality'] = '100%';
                $config['maintain_ratio'] = FALSE;

                if ($uploadData['image_width'] > $uploadData['image_height']) {
                    $config['width'] = $uploadData['image_height'];
                    $config['height'] = $uploadData['image_height'];
                    $config['x_axis'] = (($uploadData['image_width'] / 2) - ($config['width'] / 2));
                } else {
                    $config['height'] = $uploadData['image_width'];
                    $config['width'] = $uploadData['image_width'];
                    $config['y_axis'] = (($uploadData['image_height'] / 2) - ($config['height'] / 2));
                }

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();

                $config['source_image'] = $imagePath . '/crop/' . $uploadData['file_name'];
                $config['new_image'] = $imagePath . '/final';
                $config['width'] = 250;
                $config['height'] = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                unlink($uploadData['full_path']);
            }
        }

        // Collect the rest of the form fields
        $post = $this->input->post();
        $fields = [
            'entityid', 'name', 'slogan', 'mobile', 'email', 'currency',
            'paymentmethod', 'paymentacc', 'vat', 'smsapi', 'emailapi',
            'smsonbills', 'emailonbills', 'mkipadd', 'mkuser', 'mkpassword',
            'address', 'city', 'country', 'zip', 'location', 'copyright',
            'kenadekha', 'sstatus', 'pid', 'userid', 'deleted'
        ];

        foreach ($fields as $field) {
            $data[$field] = $post[$field] ?? '';
        }

        // Update the database
        $this->db->where('id', $id);
        $updated = $this->db->update('settings', $data);

        if ($updated) {
            $this->session->set_flashdata('success', 'Successfully Updated');
        } else {
            $this->session->set_flashdata('error', 'Oops! Something went wrong.');
        }

        redirect('setting/index?t=' . time());
    }

}
