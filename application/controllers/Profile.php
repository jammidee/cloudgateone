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
 * CREATED DATE : July 03, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // isLogin();
        isLoginRedirect();

        $this->load->model('mainmodel');
        $this->load->model('usermodel');

    }

    public function index() {

        $data['title'] = 'Profile';

        $id             = $this->session->userdata('user_id');
        $data['user']   = $this->usermodel->getUserById($id);

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('profile/index',      $data);
        $this->load->view('_layout/footer');

    }
    
    public function edit() {

        $data['title'] = 'Profile';

        $id             = $this->session->userdata('user_id');
        $data['user']   = $this->usermodel->getUserById($id)[0];
        
        // var_dump( $data['user'] );
        // exit;

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('profile/edit',       $data);
        $this->load->view('_layout/footer');

    }

    //Added 07/08/2025
    public function update() {
        $id = $this->session->userdata('user_id');
        
        $updateData = [];

        // Only add non-empty fields
        if ($this->input->post('name')) {
            $updateData['name'] = $this->input->post('name');
        }

        if ($this->input->post('email')) {
            $updateData['email'] = $this->input->post('email');
        }

        if ($this->input->post('mobile')) {
            $updateData['mobile'] = $this->input->post('mobile');
        }

        if ($this->input->post('location')) {
            $updateData['location'] = $this->input->post('location');
        }

        if ($this->input->post('area')) {
            $updateData['area'] = $this->input->post('area');
        }

        if ($this->input->post('package')) {
            $updateData['package'] = $this->input->post('package');
        }

        if ($this->input->post('remarks')) {
            $updateData['remarks'] = $this->input->post('remarks');
        }

        if ($this->input->post('password')) {
            $updateData['password'] = $this->input->post('password'); // You may hash this
        }

        /* Uploading Profile Images */
        $imagePath = realpath(APPPATH . '../assets/images/');
        $photo = $_FILES['photo']['tmp_name'];
        if ($photo !== "") {
            $config['upload_path'] = $imagePath;
            $config['allowed_types'] = 'jpg|png|jpeg|gif';
            $config['file_name'] = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('photo')) {
                $uploadData = $this->upload->data();
                $data['photo'] = $uploadData['file_name'];
            }

            $config['image_library'] = 'gd2';
            $config['source_image'] = $uploadData['full_path'];
            $config['new_image'] = $imagePath . '/crop';
            $config['quality'] = '100%';
            $config['maintain_ratio'] = FALSE;
            //Set cropping for y or x axis, depending on image orientation
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
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 250;
            $config['height'] = 250;

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            /* Deleting Uploaded Image After Croping and Resizing */
            /* Why Deleting because it's saving space */
            unlink($uploadData['full_path']);
        }
        /* Uploading Profile Images */

        if (!empty($updateData)) {
            $this->usermodel->updateUser($id, $updateData);
            $this->session->set_flashdata('success', 'Profile updated successfully.');
        } else {
            $this->session->set_flashdata('info', 'No changes made.');
        }

        redirect('profile/edit?t=' . time()  );
    }


}





