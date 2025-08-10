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
 * CREATED DATE : August 10, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Mapmarker extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $uri = uri_string();
        isLoginRedirect($uri);

        $this->load->model('mapmarkermodel');
        $this->load->library('pagination'); // For paging
    }

    /**
     * Index page - loads the main marker map module
     */
    public function index() {
        $data['title'] = 'Map Markers';
        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapmarker/index', $data);
        $this->load->view('_layout/footer');
    }

    /**
     * Paginated listing page
     */
    public function all() {
        $data['title'] = 'Map Markers';

        $entityid = $this->session->userdata('user_entity');
        $search   = $this->input->get('search');
        $page     = $this->input->get('page') ?? 1;
        $perPage  = 10;
        $offset   = ($page - 1) * $perPage;

        $totalRows = $this->mapmarkermodel->countAll(0, $search);

        $config['base_url']   = site_url('mapmarker/all');
        $config['total_rows'] = $totalRows;
        $config['per_page']   = $perPage;
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $data['markers'] = $this->mapmarkermodel->getAll(0, $perPage, $offset, $search);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapmarker/all',   $data);
        $this->load->view('_layout/footer');
    }

    /**
     * DataTables Ajax Fetch
     */
    public function fetchAllAjax() {
        $search   = $this->input->post('search')['value'] ?? '';
        $limit    = $this->input->post('length') ?? 10;
        $offset   = $this->input->post('start') ?? 0;

        $data  = $this->mapmarkermodel->getAll(0, $limit, $offset, $search);
        $total = $this->mapmarkermodel->countAll(0, $search);

        echo json_encode([
            "draw" => intval($this->input->post("draw")),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ]);
    }

    /**
     * View Marker Details
     */
    public function view($id = null) {
        if (!$id) {
            show_404();
        }

        $data['marker'] = $this->mapmarkermodel->getById($id);
        $data['title']  = 'Marker Details';

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapmarker/view',  $data);
        $this->load->view('_layout/footer');
    }

    /**
     * Create Marker Form
     */
    public function create() {
        $data['title'] = 'Add New Marker';

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapmarker/create',$data);
        $this->load->view('_layout/footer');
    }

    /**
     * Store Marker
     */
    public function store() {
        if ($this->input->post()) {
            $entityid = $this->session->userdata('user_entity');

            $data = [
                'name'           => $this->input->post('name'),
                'description'    => $this->input->post('description'),
                'latitude'       => $this->input->post('latitude'),
                'longitude'      => $this->input->post('longitude'),
                'category'       => $this->input->post('category'),
                'subcateg'       => $this->input->post('subcateg'),
                'objtype'        => $this->input->post('objtype'),
                'classification' => $this->input->post('classification'),
                'type'           => $this->input->post('type'),
                'entityid'       => $entityid,
                'created_by'     => $this->session->userdata('user_id') ?? 0
            ];

            $this->mapmarkermodel->insert($data);
            redirect('mapmarker/all?t=' . time());
        }
    }

    /**
     * Edit Marker Form
     */
    public function edit($id) {
        $data['title']  = 'Edit Marker';
        $data['marker'] = $this->mapmarkermodel->getById($id);

        if (!$data['marker']) {
            show_404();
        }

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapmarker/edit',  $data);
        $this->load->view('_layout/footer');
    }

    /**
     * Update Marker
     */
    public function update($id) {
        $entityid = $this->session->userdata('user_entity');

        $data = $this->input->post();

        $updateData = [
            'name'           => $data['name'],
            'description'    => $data['description'],
            'latitude'       => $data['latitude'],
            'longitude'      => $data['longitude'],
            'category'       => $data['category'],
            'subcateg'       => $data['subcateg'],
            'objtype'        => $data['objtype'],
            'classification' => $data['classification'],
            'type'           => $data['type'],
            'entityid'       => $entityid,
            'updated_at'     => date('Y-m-d H:i:s'),
            'updated_by'     => $this->session->userdata('user_id') ?? 0
        ];

        $this->mapmarkermodel->update($id, $updateData);
        redirect('mapmarker/all?t=' . time());
    }

    /**
     * Soft Delete Marker
     */
    public function delete($id) {
        $this->mapmarkermodel->deleteSoft($id);
        redirect('mapmarker/all?t=' . time());
    }

    /**
     * Hard Delete Marker
     */
    public function deletehard($id) {
        $marker = $this->mapmarkermodel->getById($id);

        if (!$marker) {
            show_404();
        }

        $this->mapmarkermodel->deleteHard($id);
        redirect('mapmarker/all?t=' . time());
    }
}
