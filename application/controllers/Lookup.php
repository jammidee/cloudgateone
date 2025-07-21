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
 * CREATED DATE : July 02, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Lookup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $uri = uri_string();
        isLoginRedirect($uri);

        $this->load->model('mainmodel');
        $this->load->model('lookupmodel');

    }

   
    public function index()
    {
        $data['title'] = 'Lookup';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('lookup/index',       $data);
        $this->load->view('_layout/footer');

    }
    
    public function get($id) {
        $this->load->model('lookupmodel');

        $lookup = $this->lookupmodel->getLookupById($id);

        if ($lookup) {
            // Return as JSON
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($lookup));
        } else {
            show_404(); // or return an error JSON if you prefer
        }
    }

    public function all() {

        //Include keyid as passed parameter
        $data['pkeyid']     = $this->session->userdata('keyid');
        if( empty($data['pkeyid']) ){
            $data['pkeyid'] = (string) time();
        }
        //Get the current user Entity
        $data['entityid']   = $this->session->userdata('user_entity');

        //Added by Jammi Dee 07/02/2025
        $data['dtData']     = $this->lookupmodel->getAllLookup( $data['entityid'], $data['pkeyid'] );

        //Add list of keyids
        $arrKeyid           = ['COLOR', 'SIZE', 'BRAND', 'MATERIAL', 'CATEGORY'];
        $data['arrKeyid']   = $arrKeyid;

        $data['title']  = 'Lookup';

        $this->load->view('_layout/header',     $data);
        $this->load->view('_layout/sidebar',    $data);
        $this->load->view('_layout/topbar',     $data);
        $this->load->view('lookup/alllookup',   $data);
        $this->load->view('_layout/footer');

    }

    public function insert() {

        $data = array(
            'entityid'      => $this->session->userdata('user_entity'),
            'appid'         => $this->config->item('appid'),
            'userid'        => $this->session->userdata('user_id'),
            'keyid'         => $this->input->post('keyid'),
            'itemid'        => $this->input->post('itemid'),
            'description'   => $this->input->post('description'),
            'sstatus'       => $this->input->post('sstatus') ?? 'ACTIVE',
            //'vversion'      => $this->input->post('vversion') ?? 0,
            //'issync'        => $this->input->post('issync') ?? 0,
            'deleted'       => $this->input->post('deleted') ?? 0,
            //'createdate'    => date('Y-m-d'),
            //'createtime'    => date('H:i:s'),
        );

        if ($this->lookupmodel->createLookup($data)) {
            $this->session->set_flashdata('success', 'Lookup successfully added');
        } else {
            $this->session->set_flashdata('error', 'Oops! Something went wrong.');
        }
        redirect(base_url() . 'lookup/all?t=' . time() . '&keyid=' . $this->input->post('keyid') );

    }

    public function update() {

        // Sanitize inputs
        $id         = $this->input->post('id');
        $keyid      = $this->input->post('keyid');
        $itemid     = $this->input->post('itemid');
        $description = $this->input->post('description');

        // Optional: validate key fields
        if (empty($id) || empty($itemid)) {
            $this->session->set_flashdata('error', 'Missing required fields.');
            redirect(base_url("lookup/all?t=" . time() . "&keyid=" . urlencode($keyid)));
            return;
        }

        // Update data
        $data = [
            'itemid'      => $itemid,
            'description' => $description,
            'keyid'       => $keyid,
            'userid'      => $this->session->userdata('userid'), // optional auditing
        ];

        $updated = $this->lookupmodel->updateLookup($id, $data);

        if ($updated) {
            $this->session->set_flashdata('success', 'Lookup entry successfully updated.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update lookup entry.');
        }

        redirect(base_url("lookup/all?t=" . time() . "&keyid=" . urlencode($keyid)));
    }

    
    public function delete($id) {

        //Include keyid as passed parameter
        $pKeyid  = $this->input->get('keyid');
        if( empty($pKeyid) ){
            $pKeyid = (string) time();
        }

        if ($this->lookupmodel->deleteLookup($id)) {
            $this->session->set_flashdata('success', 'Item successfully delete.');
        } else {
            $this->session->set_flashdata('error', 'Oops! Something went wrong.');
        }
        redirect(base_url() . 'lookup/all?t=' . time() . '&keyid=' . $pKeyid );

    }


}