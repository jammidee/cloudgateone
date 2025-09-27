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
 * CREATED DATE : June 30, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Usermodel extends CI_Model {

    protected $table = 'users';
    
    public function __construct() {
        parent::__construct();
    }

    public function getAllUsers() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get_where('users');
        return $query->result();
    }

    public function getUser($id) {
        $query = $this->db->get_where('users', array('id' => $id));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home', 'refresh');
        }
    }

    public function getUserByID($id) {
        $query = $this->db->get_where('users', array('id' => $id));
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            redirect('home', 'refresh');
        }
    }

    public function count_users() {
        return $this->db->count_all('users');
    }

    public function get_users($limit, $start) {
        return $this->db->limit($limit, $start)->get('users')->result();
    }

    public function updateUser($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('users', $data); // returns TRUE on success, FALSE on failure
    }

    // public function getUserByPackageID($id) {
    //     $query = $this->db->get_where('users', array('package' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return false;
    //     }
    // }

    // public function getUserByAreaName($name) {
    //     $query = $this->db->get_where('users', array('area' => $name));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return false;
    //     }
    // }

    // //Added by Jammi Dee 01/03/2025
    // public function getUserByPppoeName($name) {
    //     $query = $this->db->get_where('users', array('pppoe_name' => $name));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return false;
    //     }
    // }


    // public function getUserByStaff($id) {
    //     $query = $this->db->get_where('users', array('staff' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return false;
    //     }
    // }

    // public function getUserDataByID($id) {
    //     $query = $this->db->get_where('users', array('id' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result()[0];
    //     }else{
    //         return false;
    //     }
    // }

    //Start Staff
    //Get Staff BY User ID
    // public function getStaff($id) {
    //     $query = $this->db->get_where('users', array('id' => $id));
    //     if($query->num_rows() > 0){
    //         $staff = $query->result()[0]->staff;
    //         $queryStaff = $this->db->get_where('staff', array('id' => $staff));
    //         if($queryStaff->num_rows() > 0){
    //             return $queryStaff->result()[0];
    //         }
    //     }else{
    //         return false;
    //     }

    // }

    public function getSettings() {
        $query = $this->db->get_where('settings', array('id' => 1));
        return $query->result();
    }

    public function getSettingsByID($id) {
        $query = $this->db->get_where('settings', array('id' => $id));
        return $query->result();
    }

    public function getAllSettings() {
        $query = $this->db->get_where('settings');
        return $query->result();
    }

    // Get all records with optional entity and paging
    public function getAll($entityid = null, $deleted = 0, $limit = null, $offset = null, $search = null, $date_from = null, $date_to = null) {
        $this->db->where('deleted', $deleted ?? 0);

        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }

        // 🔎 Date filter
        if (!empty($date_from) && !empty($date_to)) {
            $this->db->where('created_at >=', $date_from);
            $this->db->where('created_at <=', $date_to);
        }

        // 🔎 Search handling
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('fullname', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'desc');

        if (!is_null($limit) && !is_null($offset)) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Count all records with optional filters
    public function countAll($entityid = null, $deleted = 0, $search = null, $date_from = null, $date_to = null) {
        $this->db->from($this->table);
        $this->db->where('deleted', $deleted ?? 0);

        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }

        if (!empty($date_from) && !empty($date_to)) {
            $this->db->where('created_at >=', $date_from);
            $this->db->where('created_at <=', $date_to);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('fullname', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }

    // Get single record by ID (with soft delete check)
    public function getById($id, $entityid = null) {
        $this->db->where('id', $id);
        $this->db->where('deleted', 0);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // Get all users by role
    public function getByRole($role, $entityid = null) {
        $this->db->where('role', $role);
        $this->db->where('deleted', 0);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    // Insert a new user
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // Update an existing user
    public function update($id, $data, $entityid = null) {
        $this->db->where('id', $id);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }
        return $this->db->update($this->table, $data);
    }

    // Soft delete user
    public function deleteSoft($id, $entityid = null) {
        $this->db->where('id', $id);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }
        return $this->db->update($this->table, ['deleted' => 1]);
    }

    // Hard delete user
    public function deleteHard($id, $entityid = null) {
        $this->db->where('id', $id);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }
        return $this->db->delete($this->table);
    }

    // Search for DataTables
    public function search($search = '', $entityid = null, $limit = null, $offset = null) {
        $this->db->from($this->table);
        $this->db->where('deleted', 0);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('fullname', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'desc');

        if (!is_null($limit) && !is_null($offset)) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query->result();
    }

    // Count results for search
    public function countSearchResults($search = '', $entityid = null) {
        $this->db->from($this->table);
        $this->db->where('deleted', 0);
        if (!empty($entityid)) {
            $this->db->where('entityid', $entityid);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('username', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('fullname', $search);
            $this->db->or_like('status', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }


}
