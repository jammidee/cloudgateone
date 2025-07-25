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

class Activitylog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // isLogin();
        $uri = uri_string();
        isLoginRedirect($uri);

        $this->load->model('mainmodel');
        $this->load->model('usermodel');
        $this->load->model('activitylogmodel');

    }

    public function index() {

        $data['title'] = 'Activity Log';

        $id             = $this->session->userdata('user_id');
        $data['user']   = $this->usermodel->getUserById($id);

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('activitylog/index',     $data);
        $this->load->view('_layout/footer');

    }

    public function all() {

       

        $data['logs']   = $this->activitylogmodel->getAllLogs(10,0);
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
        $data['logs'] = $this->activitylogmodel->getAllLogs($config['per_page'], $page);
        $data['pagination_links'] = $this->pagination->create_links();

        $data['title'] = 'Activity Log';
        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('activitylog/all',    $data);
        $this->load->view('_layout/footer');

    }

    //Server Side Processing for datatables
    public function fetchLogs()
    {
        $this->load->model('activitylogmodel');

        $draw   = $this->input->post('draw');
        $start  = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];

        $logsData           = $this->activitylogmodel->getPaginatedLogs($start, $length, $search);
        $totalRecords       = $this->activitylogmodel->countAllLogs();
        $filteredRecords    = $this->activitylogmodel->countFilteredLogs($search);

        $data = [];
        foreach ($logsData as $log) {
            $data[] = [
                $log->id,
                $log->user_id ?? '<i class="text-muted">Guest</i>',
                ucfirst($log->action_type),
                htmlentities($log->action_details),
                '<span class="badge ' .
                    ($log->severity === 'ERROR' ? 'badge-danger' :
                    ($log->severity === 'WARNING' ? 'badge-warning' : 'badge-success')) .
                    '">' . $log->severity . '</span>',
                $log->ip_address,
                wordwrap(htmlentities($log->user_agent), 30, "<br>"),
                date('Y-m-d H:i:s', strtotime($log->created_at)),
                $log->is_suspicious ? '<span class="text-danger">Yes</span>' : 'No'
            ];
        }

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    //For log rotation. CAll via URL
    public function rotateLogs() {

        $this->load->model('activitylogmodel');
        $this->activitylogmodel->rotateOldLogs();

        redirect('activitylog/all?t=' . time());

    }


}