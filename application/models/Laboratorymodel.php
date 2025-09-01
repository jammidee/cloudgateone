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

class Laboratorymodel extends CI_Model {

    protected $table = 'lab';
    protected $localdb; // SQLite connection

    public function __construct() {
        parent::__construct();
        // Load SQLite connection defined in database.php as "localdb"
        $this->localdb = $this->load->database('localdb', TRUE);
    }

    // --------------------------------------------------------------------
    // Get all lab records with optional entity, filters, paging
    // --------------------------------------------------------------------
    public function getAll($entityid = null, $deleted = 0, $limit = null, $offset = null, $search = null, $date_from = null, $date_to = null) {
        $this->localdb->where('deleted', $deleted ?? 0);

        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }

        // 🔎 Date filter on created_at
        if (!empty($date_from) && !empty($date_to)) {
            $this->localdb->where('created_at >=', $date_from);
            $this->localdb->where('created_at <=', $date_to);
        }

        // 🔎 Search across patient, doctor, category, status
        if (!empty($search)) {
            $this->localdb->group_start();
            $this->localdb->like('patient_name', $search);
            $this->localdb->or_like('doctor_name', $search);
            $this->localdb->or_like('category_name', $search);
            $this->localdb->or_like('lab_status', $search);
            $this->localdb->or_like('remarks', $search);
            $this->localdb->group_end();
        }

        $this->localdb->order_by('created_at', 'desc');

        if (!is_null($limit) && !is_null($offset)) {
            $this->localdb->limit($limit, $offset);
        }

        $query = $this->localdb->get($this->table);
        return $query->result();
    }

    // --------------------------------------------------------------------
    // Count all records (with search and date filters)
    // --------------------------------------------------------------------
    public function countAll($entityid = null, $deleted = 0, $search = null, $date_from = null, $date_to = null) {
        $this->localdb->from($this->table);
        $this->localdb->where('deleted', $deleted ?? 0);

        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }

        if (!empty($date_from) && !empty($date_to)) {
            $this->localdb->where('created_at >=', $date_from);
            $this->localdb->where('created_at <=', $date_to);
        }

        if (!empty($search)) {
            $this->localdb->group_start();
            $this->localdb->like('patient_name', $search);
            $this->localdb->or_like('doctor_name', $search);
            $this->localdb->or_like('category_name', $search);
            $this->localdb->or_like('lab_status', $search);
            $this->localdb->or_like('remarks', $search);
            $this->localdb->group_end();
        }

        return $this->localdb->count_all_results();
    }

    // --------------------------------------------------------------------
    // Get single record by ID (with soft delete check)
    // --------------------------------------------------------------------
    public function getById($id, $entityid = null) {
        $this->localdb->where('id', $id);
        $this->localdb->where('deleted', 0);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }
        $query = $this->localdb->get($this->table);
        return $query->row();
    }

    // --------------------------------------------------------------------
    // Get single record by Tag ID
    // --------------------------------------------------------------------
    public function getByTagId($tag_id, $entityid = null) {
        $this->localdb->where('tag_id', $tag_id);
        $this->localdb->where('deleted', 0);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }
        $query = $this->localdb->get($this->table);
        return $query->row();
    }

    // --------------------------------------------------------------------
    // Get all lab records created by a specific user
    // --------------------------------------------------------------------
    public function getByUserId($userid, $entityid = null) {
        $this->localdb->where('userid', $userid);
        $this->localdb->where('deleted', 0);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }
        $this->localdb->order_by('created_at', 'desc');
        $query = $this->localdb->get($this->table);
        return $query->result();
    }

    // --------------------------------------------------------------------
    // Insert new lab record
    // --------------------------------------------------------------------
    public function insert($data) {
        $this->localdb->insert($this->table, $data);
        return $this->localdb->insert_id();
    }

    // --------------------------------------------------------------------
    // Update lab record
    // --------------------------------------------------------------------
    public function update($id, $data, $entityid = null) {
        $this->localdb->where('id', $id);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }
        return $this->localdb->update($this->table, $data);
    }

    // --------------------------------------------------------------------
    // Soft delete lab record
    // --------------------------------------------------------------------
    public function deleteSoft($id, $entityid = null) {
        $this->localdb->where('id', $id);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }
        return $this->localdb->update($this->table, ['deleted' => 1]);
    }

    // --------------------------------------------------------------------
    // Hard delete lab record
    // --------------------------------------------------------------------
    public function deleteHard($id, $entityid = null) {
        $this->localdb->where('id', $id);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }
        return $this->localdb->delete($this->table);
    }

    // --------------------------------------------------------------------
    // Search with DataTables (lab-specific)
    // --------------------------------------------------------------------
    public function search($search = '', $entityid = null, $limit = null, $offset = null) {
        $this->localdb->from($this->table);
        $this->localdb->where('deleted', 0);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }

        if (!empty($search)) {
            $this->localdb->group_start();
            $this->localdb->like('patient_name', $search);
            $this->localdb->or_like('doctor_name', $search);
            $this->localdb->or_like('category_name', $search);
            $this->localdb->or_like('lab_status', $search);
            $this->localdb->or_like('remarks', $search);
            $this->localdb->group_end();
        }

        $this->localdb->order_by('created_at', 'desc');

        if (!is_null($limit) && !is_null($offset)) {
            $this->localdb->limit($limit, $offset);
        }

        $query = $this->localdb->get();
        return $query->result();
    }

    // --------------------------------------------------------------------
    // Count search results (for DataTables)
    // --------------------------------------------------------------------
    public function countSearchResults($search = '', $entityid = null) {
        $this->localdb->from($this->table);
        $this->localdb->where('deleted', 0);
        if (!empty($entityid)) {
            $this->localdb->where('entityid', $entityid);
        }

        if (!empty($search)) {
            $this->localdb->group_start();
            $this->localdb->like('patient_name', $search);
            $this->localdb->or_like('doctor_name', $search);
            $this->localdb->or_like('category_name', $search);
            $this->localdb->or_like('lab_status', $search);
            $this->localdb->or_like('remarks', $search);
            $this->localdb->group_end();
        }

        return $this->localdb->count_all_results();
    }
}
