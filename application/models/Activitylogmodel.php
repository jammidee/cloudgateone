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
 * CREATED DATE : July 23, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Activitylogmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // GET all logs
    public function getAllLogs($limit = null, $offset = null) {
        $this->db->order_by('created_at', 'desc');
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('system_logs')->result();
    }

    // GET single log by ID
    public function getLogById($id) {
        return $this->db->get_where('system_logs', array('id' => $id))->row();
    }

    // INSERT new log
    public function insertLog($data) {
        $this->db->insert('system_logs', $data);
        return $this->db->insert_id();
    }

    // DELETE log permanently
    public function deleteLog($id) {
        $this->db->where('id', $id);
        return $this->db->delete('system_logs');
    }

    // COUNT total logs (with optional filters)
    public function countLogs($filters = []) {
        if (!empty($filters)) {
            $this->db->where($filters);
        }
        return $this->db->count_all_results('system_logs');
    }

    // GET logs with filters (severity, action_type, date range, etc.)
    public function getFilteredLogs($filters = [], $limit = null, $offset = null) {
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if ($key === 'date_from') {
                    $this->db->where('created_at >=', $value);
                } elseif ($key === 'date_to') {
                    $this->db->where('created_at <=', $value);
                } else {
                    $this->db->where($key, $value);
                }
            }
        }
        $this->db->order_by('created_at', 'desc');
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('system_logs')->result();
    }

    // LOG a system activity (helper)
    public function logActivity($action_type, $action_details, $severity = 'INFO', $is_suspicious = false, $user_id = null) {
        $data = [
            'user_id'       => $user_id,
            'action_type'   => $action_type,
            'action_details'=> $action_details,
            'ip_address'    => $this->input->ip_address(),
            'user_agent'    => $this->input->user_agent(),
            'severity'      => $severity,
            'is_suspicious' => $is_suspicious ? 1 : 0
        ];
        return $this->insertLog($data);
    }

    //Server Side Processing 07/24/2025
    public function getPaginatedLogs($start, $length, $search = '')
    {
        $this->db->select('*')
                 ->from('system_logs');

        if (!empty($search)) {
            $this->db->group_start()
                ->like('user_id', $search)
                ->or_like('action_type', $search)
                ->or_like('action_details', $search)
                ->or_like('ip_address', $search)
                ->or_like('user_agent', $search)
                ->or_like('severity', $search)
                ->group_end();
        }

        $this->db->order_by('created_at', 'desc');
        $this->db->limit($length, $start);

        return $this->db->get()->result();
    }

    public function countAllLogs()
    {
        return $this->db->count_all('system_logs');
    }

    public function countFilteredLogs($search = '')
    {
        $this->db->from('system_logs');

        if (!empty($search)) {
            $this->db->group_start()
                ->like('user_id', $search)
                ->or_like('action_type', $search)
                ->or_like('action_details', $search)
                ->or_like('ip_address', $search)
                ->or_like('user_agent', $search)
                ->or_like('severity', $search)
                ->group_end();
        }

        return $this->db->count_all_results();
    }

    public function rotateOldLogs() {
        // Optionally insert to archive table here first
        $this->db->where('created_at <', date('Y-m-d H:i:s', strtotime('-90 days')));
        $this->db->delete('system_logs');
    }

}
