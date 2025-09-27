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

use Dompdf\Dompdf;
use Dompdf\Options;
use chillerlan\QRCode\{QRCode, QROptions};

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // isLogin();
        $uri = uri_string();
        isLoginRedirect($uri);

        $this->load->model('mainmodel');
        $this->load->model('usermodel');
        $this->load->model('emissionmodel');

    }

    public function index()
    {
        $data['title'] = 'User';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('user/index',         $data);
        $this->load->view('_layout/footer');

    }
    
    public function add()
    {

        $data['packages']   = $this->mainmodel->getAllPackages();
        $data['area']       = $this->mainmodel->getAllAreas();
        $data['staff']      = $this->mainmodel->getAllStaffs();

        $data['sites']  = $this->emissionmodel->getAllSites();

        $data['title'] = 'Add';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('user/add',           $data);
        $this->load->view('_layout/footer');

    }

    public function view($id = null)
    {
        if (!$id) {
            show_404();
        }

        $id = $this->uri->segment(3);
        $data['view_user']  = $this->usermodel->getUserByID($id);

        $data['title'] = 'User Details';

        // Load view
        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('user/userview', $data);
        $this->load->view('_layout/footer');
    }

    //Added by Jammi Dee 07/20/2025
    public function create()
    {
        $data = array();

        /* Uploading Profile Images */
        $imagePath = realpath(APPPATH . '../assets/images/');
        $photo = $_FILES['photo']['tmp_name'];
        if ($photo !== "") {
            $config['upload_path']      = $imagePath;
            $config['allowed_types']    = 'jpg|png|jpeg|gif';
            $config['file_name']        = date('Ymd_his_') . rand(100, 999) . rand(100, 999);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('photo')) {
                $uploadData = $this->upload->data();
                $data['photo'] = $uploadData['file_name'];

                $config['image_library']    = 'gd2';
                $config['source_image']     = $uploadData['full_path'];
                $config['new_image']        = $imagePath . '/crop';
                $config['quality']          = '100%';
                $config['maintain_ratio']   = FALSE;

                if ($uploadData['image_width'] > $uploadData['image_height']) {
                    $config['width']    = $uploadData['image_height'];
                    $config['height']   = $uploadData['image_height'];
                    $config['x_axis']   = (($uploadData['image_width'] / 2) - ($config['width'] / 2));
                } else {
                    $config['height']   = $uploadData['image_width'];
                    $config['width']    = $uploadData['image_width'];
                    $config['y_axis']   = (($uploadData['image_height'] / 2) - ($config['height'] / 2));
                }

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->crop();

                $config['source_image']     = $imagePath . '/crop/' . $uploadData['file_name'];
                $config['new_image']        = $imagePath . '/final';
                $config['width']            = 250;
                $config['height']           = 250;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $this->image_lib->resize();

                unlink($uploadData['full_path']);
            }
        }

        // Sanitize and gather input data
        $fields = [
            'name', 'mobile', 'package', 'area', 'staff', 'user_id',
            'password', 'join_date', 'role', 'status', 'location',
            'lat', 'lon', 'model', 'serial_no', 'number_of_ports',
            'wan_bandwidth', 'property_id', 'remarks', 'petc_code',
            'starttime', 'endtime'
        ];

        foreach ($fields as $field) {
            $value = $this->input->post($field);
            if (!empty($value)) {
                $data[$field] = $value;
            }
        }

        $data['email']  = $this->input->post('user_id');
        $data['pass']   = md5($this->input->post('password'));

        // Fields requiring special handling
        $data['amount'] = " ";
        $data['advance'] = " ";

        if (!empty($this->input->post('accpass'))) {
            $data['pass'] = md5($this->input->post('accpass'));
        }

        $data['search_quota'] = $this->input->post('search_quota') !== null
            ? $this->input->post('search_quota') : 100;

        $data['search_unli'] = $this->input->post('search_unli') ? 1 : 0;
        $data['time_unli']   = $this->input->post('time_unli') ? 1 : 0;

        //Log user creation
        log_action('create', 'Created new user');

        // Insert into database
        $insert_true = $this->db->insert('users', $data);
        if ($insert_true) {
            $this->session->set_flashdata('success', 'User Successfully Created');
            redirect('user/all?t=' . time(), 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Oops! Something went wrong');
            redirect('user/add?t=' . time(), 'refresh');
        }
    }


    public function all() {

        // Prepare QR data
        $qrlink = site_url('user/all/');
        $options = new QROptions(['outputType' => QRCode::OUTPUT_IMAGE_PNG, 'scale'  => 5, ]);
        // File path (make sure the folder exists and is writable)
        $filepath = FCPATH . 'assets/img/temp/qrcode.png';
        // Render directly to file
        (new QRCode($options))->render($qrlink, $filepath);
        // if you also want to embed in <img>, you can still read and encode it
        $data['qrcode'] = base64_encode(file_get_contents($filepath));
        
        $entityid = $this->session->userdata('user_entity') ?? '_NA_';
        $userid   = $this->session->userdata('user_id') ?? 0;

        $newDefaults = [
            // ✅ New company constants
            'company_name'      => esc(get_configdb($entityid, $userid, 'company_name', "Watercraft Venture Corporation")),
            'company_address'   => esc(get_configdb($entityid, $userid, 'company_address', "Lot A-7, (Bldg. 1031), Rizal Highway, Subic Bay Freeport Zone")),
            'company_contact'   => esc(get_configdb($entityid, $userid, 'company_contact', "Tel. Nos. (047) 252-1739, 252-1740   Fax No.: (047) 252-1738")),
            'company_email'     => esc(get_configdb($entityid, $userid, 'company_email', "watercraftventure@gmail.com")),
            'company_site'      => esc(get_configdb($entityid, $userid, 'company_site', "www.watercraftventure.com")),
        ];

        // Merge without overwriting existing keys
        $data = array_merge($newDefaults, $data ?? []);
        
        //Setup pagination
        $this->load->library('pagination');
        $limit = $this->input->get('limit') ?? 10;
        $data['limit'] = $limit;

        // Add this to links so limit persists
        $config['base_url'] = base_url('user/all') . '?limit=' . $limit;
        $config['page_query_string'] = TRUE;

        $config['base_url']     = base_url('user/all');
        $config['total_rows']   = $this->usermodel->count_users();
        $config['per_page']     = $limit;
        $config['uri_segment']  = 3;

        // Bootstrap-styled pagination
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['users'] = $this->usermodel->get_users($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        //$data['users']      = $this->usermodel->getAllUsers();

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

        $data['title'] = 'All User';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('user/allusers',      $data);
        $this->load->view('_layout/footer');

    }

    //Added 07/01/2025
    public function edit() {

        $id = $this->uri->segment(3);
        $data['edit_user']  = $this->usermodel->getUserByID($id);
        $data['packages']   = $this->mainmodel->getAllPackages();
        $data['area']       = $this->mainmodel->getAllAreas();
        $data['staff']      = $this->mainmodel->getAllStaffs();
        
        $data['sites']  = $this->emissionmodel->getAllSites();

        $data['title'] = 'Edit';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('user/edit',          $data);
        $this->load->view('_layout/footer');

    }


    public function update() {
        
        $id     = $this->input->post('id');
        $data   = array();

        /* Uploading Profile Images */
        $imagePath = realpath(APPPATH . '../assets/images/');
        $photo = $_FILES['photo']['tmp_name'];
        if ($photo !== "") {
            $config['upload_path']      = $imagePath;
            $config['allowed_types']    = 'jpg|png|jpeg|gif';
            $config['file_name']        = date('Ymd_his_') . rand(10, 99) . rand(10, 99) . rand(10, 99);
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('photo')) {
                $uploadData = $this->upload->data();
                $data['photo'] = $uploadData['file_name'];
            }

            $config['image_library']    = 'gd2';
            $config['source_image']     = $uploadData['full_path'];
            $config['new_image']        = $imagePath . '/crop';
            $config['quality']          = '100%';
            $config['maintain_ratio']   = FALSE;
            //Set cropping for y or x axis, depending on image orientation
            if ($uploadData['image_width'] > $uploadData['image_height']) {
                $config['width']    = $uploadData['image_height'];
                $config['height']   = $uploadData['image_height'];
                $config['x_axis']   = (($uploadData['image_width'] / 2) - ($config['width'] / 2));
            } else {
                $config['height']   = $uploadData['image_width'];
                $config['width']    = $uploadData['image_width'];
                $config['y_axis']   = (($uploadData['image_height'] / 2) - ($config['height'] / 2));
            }

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->crop();

            $config['source_image']     = $imagePath . '/crop/' . $uploadData['file_name'];
            $config['new_image']        = $imagePath . '/final';
            $config['maintain_ratio']   = FALSE;
            $config['width']            = 250;
            $config['height']           = 250;

            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();

            /* Deleting Uploaded Image After Croping and Resizing */
            /* Why Deleting because it's saving space */
            unlink($uploadData['full_path']);
        }

        if(!empty($this->input->post('name'))){
            $data['name'] = $this->input->post('name');
        }

        if(!empty($this->input->post('mobile'))){
            $data['mobile'] = $this->input->post('mobile');
        }

        if(!empty($this->input->post('package'))){
            $data['package'] = $this->input->post('package');
        }

        if(!empty($this->input->post('area'))){
            $data['area'] = $this->input->post('area');
        }

        if(!empty($this->input->post('area'))){
            $data['area'] = $this->input->post('area');
        }

        if(!empty($this->input->post('staff'))){
            $data['staff'] = $this->input->post('staff');
        }

        if(!empty($this->input->post('amount'))){
            $data['amount'] =  " ";
        }

        if(!empty($this->input->post('user_id'))){
            $data['user_id'] = $this->input->post('user_id');
        }

        if(!empty($this->input->post('password'))){
            $data['password'] = $this->input->post('password');
        }

        if(!empty($this->input->post('join_date'))){
            $data['join_date'] = $this->input->post('join_date');
        }

        if(!empty($this->input->post('advance'))){
            $data['advance'] = " ";
        }

        if(!empty($this->input->post('accpass'))){
            $data['pass'] = md5($this->input->post('accpass'));
        }

        if(!empty($this->input->post('role'))){
            $data['role'] = $this->input->post('role');
        }

        if(!empty($this->input->post('status'))){
            $data['status'] = $this->input->post('status');
        }

        if(!empty($this->input->post('location'))){
            $data['location'] = $this->input->post('location');
        }

        //Added by Jammi Dee 12/26/2024
        if (!empty($this->input->post('lat'))) {
            $data['lat'] = $this->input->post('lat');
        }
        if (!empty($this->input->post('lon'))) {
            $data['lon'] = $this->input->post('lon');
        }
        if (!empty($this->input->post('model'))) {
            $data['model'] = $this->input->post('model');
        }
        if (!empty($this->input->post('serial_no'))) {
            $data['serial_no'] = $this->input->post('serial_no');
        }
        if (!empty($this->input->post('number_of_ports'))) {
            $data['number_of_ports'] = $this->input->post('number_of_ports');
        }
        if (!empty($this->input->post('wan_bandwidth'))) {
            $data['wan_bandwidth'] = $this->input->post('wan_bandwidth');
        }
        if (!empty($this->input->post('property_id'))) {
            $data['property_id'] = $this->input->post('property_id');
        }
        if (!empty($this->input->post('remarks'))) {
            $data['remarks'] = $this->input->post('remarks');
        }

        // Added by Jammi Dee 01/13/2025
        // For PETC Specific functions
        if (!empty($this->input->post('petc_code'))) {
            $data['petc_code'] = $this->input->post('petc_code');
        }

        // echo $this->input->post('search_quota');
        // exit;

        if ($this->input->post('search_quota') !== null) { // Check if the input exists (even if it's 0)
            $data['search_quota'] = $this->input->post('search_quota'); // Assign the posted value
        } else {
            $data['search_quota'] = 100; // Default value if no input is provided
        }

        if (!empty($this->input->post('starttime'))) {
            $data['starttime'] = $this->input->post('starttime');
        }
        if (!empty($this->input->post('endtime'))) {
            $data['endtime'] = $this->input->post('endtime');
        }

        // echo $this->input->post('search_unli');
        // echo $this->input->post('time_unli');
        // exit;

        $data['search_unli']    = $this->input->post('search_unli') ? 1 : 0;
        $data['time_unli']      = $this->input->post('time_unli') ? 1 : 0;

        //Log profile update here
        log_action('update', 'Updated profile information');

        $this->db->where('id', $id);
        $update_true = $this->db->update('users', $data);
        if ($update_true) {
            $this->session->set_flashdata('success', 'User Successfully Updated');
            redirect('user/all?t=' . time(), 'refresh');
        } else {
            $this->session->set_flashdata('error', 'Opps! Something Wrong');
            redirect('user/all?t=' . time(), 'refresh');
        }

    }

    public function delete($id = null)
    {
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid user ID');
            redirect('user/all?t=' . time(), 'refresh');
        }

        // Get user data for logging and possible file removal
        $user = $this->db->get_where('users', ['id' => $id])->row();

        if (!$user) {
            $this->session->set_flashdata('error', 'User not found');
            redirect('user/all?t=' . time(), 'refresh');
        }

        // Remove profile images if they exist
        if (!empty($user->photo)) {
            $paths = [
                realpath(APPPATH . '../assets/images/') . '/' . $user->photo,
                realpath(APPPATH . '../assets/images/crop/') . '/' . $user->photo,
                realpath(APPPATH . '../assets/images/final/') . '/' . $user->photo,
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        }

        // Delete from DB
        $deleted = $this->db->delete('users', ['id' => $id]);

        if ($deleted) {
            log_action('delete', 'Deleted user with ID ' . $id);
            $this->session->set_flashdata('success', 'User Successfully Deleted');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user');
        }

        redirect('user/all?t=' . time(), 'refresh');
    }



}