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

class Mapboundariesmodel extends CI_Model {

    protected $table = 'map_boundaries';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all boundaries with optional filters, pagination, and DataTables integration
     */
    public function getAll($deleted = 0, $entityid = null, $limit = null, $offset = null, $search = null) {
        if (!is_null($deleted)) {
            $this->db->where('deleted', $deleted);
        }

        if (!is_null($entityid)) {
            $this->db->where('entityid', $entityid);
        } else {
            // Default: get entityid from session
            if ($this->session->userdata('user_entity')) {
                $this->db->where('entityid', $this->session->userdata('user_entity'));
            }
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('category', $search);
            $this->db->or_like('classification', $search);
            $this->db->group_end();
        }

        $this->db->order_by('name', 'asc');

        if (!is_null($limit)) {
            $this->db->limit($limit, $offset ?? 0);
        }

        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * Count boundaries for pagination or DataTables
     */
    public function countAll($deleted = 0, $entityid = null, $search = null) {
        if (!is_null($deleted)) {
            $this->db->where('deleted', $deleted);
        }

        if (!is_null($entityid)) {
            $this->db->where('entityid', $entityid);
        } else {
            if ($this->session->userdata('user_entity')) {
                $this->db->where('entityid', $this->session->userdata('user_entity'));
            }
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->or_like('category', $search);
            $this->db->or_like('classification', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results($this->table);
    }

    /**
     * Get boundary by primary key
     */
    public function getById($id) {
        $this->db->where('id', $id);
        $this->db->where('deleted', 0);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Get boundary by name
     */
    public function getByName($name, $entityid = null) {
        $this->db->where('name', $name);
        $this->db->where('deleted', 0);

        if (!is_null($entityid)) {
            $this->db->where('entityid', $entityid);
        } else {
            if ($this->session->userdata('user_entity')) {
                $this->db->where('entityid', $this->session->userdata('user_entity'));
            }
        }

        $query = $this->db->get($this->table);
        return $query->row();
    }

    /**
     * Insert a new boundary record
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update existing boundary record by ID
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Soft delete boundary (sets deleted = 1)
     */
    public function deleteSoft($id) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, ['deleted' => 1]);
    }

    /**
     * Hard delete boundary (permanently deletes from DB)
     */
    public function deleteHard($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}
