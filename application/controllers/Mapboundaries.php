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

class Mapboundaries extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $uri = uri_string();
        isLoginRedirect($uri);

        $this->load->model('mapboundariesmodel');
        $this->load->library('pagination');
    }

    public function index() {
        $data['title'] = 'Map Boundaries';
        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapboundaries/index', $data);
        $this->load->view('_layout/footer');
    }

    public function all() {
        $data['title'] = 'Map Boundaries';

        $entityid = $this->session->userdata('user_entity');
        $search   = $this->input->get('search');
        $page     = $this->input->get('page') ?? 1;
        $perPage  = 10;
        $offset   = ($page - 1) * $perPage;

        $totalRows = $this->mapboundariesmodel->countAll(0, $entityid, $search);

        $config['base_url']   = site_url('mapboundaries/all');
        $config['total_rows'] = $totalRows;
        $config['per_page']   = $perPage;
        $config['reuse_query_string'] = true;

        $this->pagination->initialize($config);

        $data['boundaries']  = $this->mapboundariesmodel->getAll(0, $entityid, $perPage, $offset, $search);
        $data['pagination']  = $this->pagination->create_links();

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapboundaries/all', $data);
        $this->load->view('_layout/footer');
    }

    public function fetchAllAjax() {
        $entityid = $this->input->post('entityid') ?? $this->session->userdata('user_entity');
        $search   = $this->input->post('search')['value'] ?? '';
        $limit    = $this->input->post('length') ?? 10;
        $offset   = $this->input->post('start') ?? 0;

        $data  = $this->mapboundariesmodel->getAll(0, $entityid, $limit, $offset, $search);
        $total = $this->mapboundariesmodel->countAll(0, $entityid, $search);

        echo json_encode([
            "draw"            => intval($this->input->post("draw")),
            "recordsTotal"    => $total,
            "recordsFiltered" => $total,
            "data"            => $data
        ]);
    }

    public function view($id = null) {
        if (!$id) {
            show_404();
        }

        $data['boundary'] = $this->mapboundariesmodel->getById($id);
        $data['title']    = 'Boundary Details';

        if (!$data['boundary']) {
            show_404();
        }

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapboundaries/view', $data);
        $this->load->view('_layout/footer');
    }

    public function create() {
        $data['title'] = 'Add New Boundary';

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapboundaries/create', $data);
        $this->load->view('_layout/footer');
    }

    public function store() {
        if ($this->input->post()) {
            $entityid = $this->session->userdata('user_entity');

            $data = [
                'name'           => $this->input->post('name'),
                'description'    => $this->input->post('description'),
                'category'       => $this->input->post('category'),
                'classification' => $this->input->post('classification'),
                'type'           => $this->input->post('type'),
                'coordinates'    => $this->input->post('coordinates'),
                'entityid'       => $entityid,
                'created_by'     => $this->session->userdata('user_id') ?? 0
            ];

            $this->mapboundariesmodel->insert($data);
            redirect('mapboundaries/all?t=' . time());
        }
    }

    public function edit($id) {
        $data['title']    = 'Edit Boundary';
        $data['boundary'] = $this->mapboundariesmodel->getById($id);

        if (!$data['boundary']) {
            show_404();
        }

        $this->load->view('_layout/header',  $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar',  $data);
        $this->load->view('mapboundaries/edit', $data);
        $this->load->view('_layout/footer');
    }

    public function update($id) {
        $entityid = $this->session->userdata('user_entity');

        $post = $this->input->post();

        $updateData = [
            'name'           => $post['name'],
            'description'    => $post['description'],
            'category'       => $post['category'],
            'classification' => $post['classification'],
            'type'           => $post['type'],
            'coordinates'    => $post['coordinates'],
            'entityid'       => $entityid,
            'updated_at'     => date('Y-m-d H:i:s'),
            'updated_by'     => $this->session->userdata('user_id') ?? 0
        ];

        $this->mapboundariesmodel->update($id, $updateData);
        redirect('mapboundaries/all?t=' . time());
    }

    public function delete($id) {
        $this->mapboundariesmodel->deleteSoft($id);
        redirect('mapboundaries/all?t=' . time());
    }

    public function deletehard($id) {
        $boundary = $this->mapboundariesmodel->getById($id);

        if (!$boundary) {
            show_404();
        }

        $this->mapboundariesmodel->deleteHard($id);
        redirect('mapboundaries/all?t=' . time());
    }
}
