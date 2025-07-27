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

defined('BASEPATH') OR exit('No direct script access allowed');

class Lookupmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // GET all lookup records
    public function getAllLookup($entityid = null, $keyid = null, $deleted = 0) {
        if ($entityid !== null) {
            $this->db->where('entityid', $entityid);
        }
        if ($keyid !== null) {
            $this->db->where('keyid', $keyid);
        }
        $this->db->where('deleted', $deleted ?? 0);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('lookup');
        return $query->result();
    }

    // GET one by ID
    public function getLookupById($id) {
        $query = $this->db->get_where('lookup', array('id' => $id, 'deleted' => 0));
        return $query->row(); // return one row
    }

    // INSERT new record
    public function createLookup($data) {
        $this->db->insert('lookup', $data);
        return $this->db->insert_id(); // return newly inserted ID
    }

    // UPDATE existing record
    public function updateLookup($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lookup', $data);
    }

    // SOFT DELETE record (set `deleted` to 1)
    public function deleteLookup($id) {
        $this->db->where('id', $id);
        return $this->db->update('lookup', array('deleted' => 1));
    }

    // COUNT lookups (optionally filtered)
    public function countLookup($entityid = null, $keyid = null) {
        if ($entityid !== null) {
            $this->db->where('entityid', $entityid);
        }
        if ($keyid !== null) {
            $this->db->where('keyid', $keyid);
        }
        $this->db->where('deleted', 0);
        return $this->db->count_all_results('lookup');
    }

    // GET lookups with pagination
    public function getLookupPaginated($limit, $start, $entityid = null, $keyid = null) {
        if ($entityid !== null) {
            $this->db->where('entityid', $entityid);
        }
        if ($keyid !== null) {
            $this->db->where('keyid', $keyid);
        }
        $this->db->where('deleted', 0);
        $this->db->order_by('id', 'desc');
        return $this->db->get('lookup', $limit, $start)->result();
    }

}
