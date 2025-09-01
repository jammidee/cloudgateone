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
 * CREATED DATE : August 31, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

use chillerlan\QRCode\{QRCode, QROptions};

class Laboratory extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $uri = uri_string();
        isClientLoginRedirect();

        $this->load->model('laboratorymodel', 'labmodel');
    }

    // --------------------------------------------------------------------
    // Index (landing page for labs)
    // --------------------------------------------------------------------
    public function index() {
        $data['title'] = 'Laboratory Records';
        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('laboratory/index',   $data);
        $this->load->view('_layout/footer');
    }

    // --------------------------------------------------------------------
    // Paginated list
    // --------------------------------------------------------------------
    public function all($offset = 0) {
        // QR Code for the listing page
        $qrlink = site_url('laboratory/all/');

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'scale'      => 5,
        ]);

        $filepath = FCPATH . 'assets/img/temp/qrcode.png';
        (new QRCode($options))->render($qrlink, $filepath);

        $data['qrcode'] = base64_encode(file_get_contents($filepath));

        $entityid = $this->session->userdata('user_entity');
        $limit    = 10;
        
        // var_dump( $this->session->userdata('user_id'), $this->session->userdata('user_entity') );
        // exit;

        $data['title'] = 'Laboratory Records';
        $data['labs']  = $this->labmodel->getAll($entityid, 0, $limit, $offset);
        $data['total_rows'] = $this->labmodel->countAll($entityid);

        // Pagination setup
        $this->load->library('pagination');
        $config['base_url']   = site_url('laboratory/all');
        $config['total_rows'] = $data['total_rows'];
        $config['per_page']   = $limit;
        $this->pagination->initialize($config);

        $this->load->view('_layout/client-header',      $data);
        $this->load->view('_layout/client-sidebar',     $data);
        $this->load->view('_layout/client-topbar',      $data);
        $this->load->view('laboratory/all', $data);
        $this->load->view('_layout/client-footer');
    }

    // --------------------------------------------------------------------
    // Datatables AJAX fetch
    // --------------------------------------------------------------------
    public function fetchAllAjax() {
        $entityid   = $this->input->post('entityid') ?? $this->session->userdata('user_entity');
        $search     = $this->input->post('search')['value'] ?? '';
        $limit      = $this->input->post('length') ?? 10;
        $offset     = $this->input->post('start') ?? 0;
        $date_from  = $this->input->post('date_from');
        $date_to    = $this->input->post('date_to');

        $data  = $this->labmodel->getAll($entityid, 0, $limit, $offset, $search, $date_from, $date_to);
        $total = $this->labmodel->countAll($entityid, 0, $search, $date_from, $date_to);

        echo json_encode([
            "draw"            => intval($this->input->post("draw")),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $data
        ]);
    }

    // --------------------------------------------------------------------
    // View a single lab record
    // --------------------------------------------------------------------
    public function view($id = null) {
        if (!$id) show_404();

        $entityid = $this->session->userdata('user_entity');
        $data['lab'] = $this->labmodel->getById($id, $entityid);
        $data['title'] = 'Lab Record Details';

        if (!$data['lab']) show_404();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('laboratory/view', $data);
        $this->load->view('_layout/footer');
    }

    // --------------------------------------------------------------------
    // Create form
    // --------------------------------------------------------------------
    public function create() {
    
        $data['title'] = 'New Laboratory Record';

        // Generate unique tag_id
        // $data['tag_id'] = generate_verified_unique_code($this, 'LAB', 'lab', 'tag_id');

        $this->load->view('_layout/client-header',  $data);
        $this->load->view('_layout/client-sidebar', $data);
        $this->load->view('_layout/client-topbar',  $data);
        $this->load->view('laboratory/create',      $data);
        $this->load->view('_layout/client-footer');
    }

    // --------------------------------------------------------------------
    // Store handler
    // --------------------------------------------------------------------
    public function store() {
        if ($this->input->post()) {
            // ---- Get metadata from session (fallback to hidden form fields if missing) ----
            $entityid = $this->session->userdata('user_entity') ?? $this->input->post('entityid') ?? '_NA_';
            $appid    = $this->session->userdata('user_appid')  ?? $this->input->post('appid') ?? '_NA_';
            $userid   = $this->session->userdata('user_id')     ?? $this->input->post('userid') ?? 0;

            // ---- Collect form data safely (null coalescing + trim) ----
            $data = [
                'entityid'              => $entityid,
                'appid'                 => $appid,
                'userid'                => $userid,
                'patient_name'          => trim($this->input->post('patient_name') ?? ''),
                'patient_email'         => trim($this->input->post('patient_email') ?? ''),
                'patient_phone'         => trim($this->input->post('patient_phone') ?? ''),
                'patient_address'       => trim($this->input->post('patient_address') ?? ''),
                'doctor_name'           => trim($this->input->post('doctor_name') ?? ''),
                'doctor_email'          => trim($this->input->post('doctor_email') ?? ''),
                'doctor_phone'          => trim($this->input->post('doctor_phone') ?? ''),
                'doctor_address'        => trim($this->input->post('doctor_address') ?? ''),
                'category_name'         => trim($this->input->post('category_name') ?? ''),
                'category_id'           => $this->input->post('category_id') ?? null,
                'report'                => trim($this->input->post('report') ?? ''),
                'invoice_id'            => $this->input->post('invoice_id') ?? null,
                'hospital_id'           => trim($this->input->post('hospital_id') ?? ''),
                'alloted_bed_id'        => trim($this->input->post('alloted_bed_id') ?? ''),
                'bed_diagnostic_id'     => trim($this->input->post('bed_diagnostic_id') ?? ''),
                'lab_status'            => $this->input->post('lab_status') ?? 'queued',
                'test_status'           => trim($this->input->post('test_status') ?? ''),
                'test_status_date'      => $this->input->post('test_status_date') ?? null,
                'delivery_status'       => trim($this->input->post('delivery_status') ?? ''),
                'delivery_status_date'  => $this->input->post('delivery_status_date') ?? null,
                'receiver_name'         => trim($this->input->post('receiver_name') ?? ''),
                'machine_status_message'=> trim($this->input->post('machine_status_message') ?? ''),
                'assigned_clinic_id'    => trim($this->input->post('assigned_clinic_id') ?? ''),
                'assigned_machine_id'   => trim($this->input->post('assigned_machine_id') ?? ''),
                'assigned_technician_id'=> trim($this->input->post('assigned_technician_id') ?? ''),
                'integration_ref_id'    => trim($this->input->post('integration_ref_id') ?? ''),
                'lab_request_received'  => $this->input->post('lab_request_received') ?? null,
                'lab_start_time'        => $this->input->post('lab_start_time') ?? null,
                'lab_end_time'          => $this->input->post('lab_end_time') ?? null,
                'reported_by'           => trim($this->input->post('reported_by') ?? ''),
                'done_by'               => trim($this->input->post('done_by') ?? ''),
                'signed_by'             => trim($this->input->post('signed_by') ?? ''),
                'remarks'               => trim($this->input->post('remarks') ?? ''),
                'tag_id'                => trim($this->input->post('tag_id') ?? ''),
                'vversion'              => trim($this->input->post('vversion') ?? ''), // hidden field
                'pid'                   => $this->input->post('pid') ?? 0,            // hidden field
                'sstatus'               => $this->input->post('sstatus') ?? 'ACTIVE', // hidden field
            ];

            // ---- Save to DB ----
            $this->labmodel->insert($data);

            // ---- Redirect with cache-busting timestamp ----
            redirect('laboratory/all?t=' . time());
        }
    }


    // --------------------------------------------------------------------
    // Edit form
    // --------------------------------------------------------------------
    public function edit($id) {
        $entityid = $this->session->userdata('user_entity');
        $data['title'] = 'Edit Laboratory Record';
        $data['lab']   = $this->labmodel->getById($id, $entityid);

        if (!$data['lab']) show_404();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('laboratory/edit', $data);
        $this->load->view('_layout/footer');
    }

    // --------------------------------------------------------------------
    // Update handler
    // --------------------------------------------------------------------
    public function update($id) {
        $entityid = $this->session->userdata('user_entity');
        $userid   = $this->session->userdata('user_id');

        $data = $this->input->post();

        $updateData = [
            'patient_name'  => $data['patient_name'],
            'doctor_name'   => $data['doctor_name'],
            'category_name' => $data['category_name'],
            'lab_status'    => $data['lab_status'],
            'remarks'       => $data['remarks'],
            'updated_at'    => date('Y-m-d H:i:s'),
            'update_by'     => $userid
        ];

        $this->labmodel->update($id, $updateData, $entityid);
        redirect('laboratory/all?t=' . time());
    }

    // --------------------------------------------------------------------
    // Soft delete
    // --------------------------------------------------------------------
    public function delete($id) {
        $entityid = $this->session->userdata('user_entity');
        $this->labmodel->deleteSoft($id, $entityid);
        redirect('laboratory/all?t=' . time());
    }

    // --------------------------------------------------------------------
    // Hard delete
    // --------------------------------------------------------------------
    public function deletehard($id) {
        $entityid = $this->session->userdata('user_entity');
        $lab = $this->labmodel->getById($id, $entityid);

        if (!$lab) show_404();

        $this->labmodel->deleteHard($id, $entityid);
        redirect('laboratory/all?t=' . time());
    }
}
