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
 * CREATED DATE : August 19, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Configdbmodel extends CI_Model {

    protected $table = 'configdb';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Read a variable by entity + user + key
     * Returns $default if not found
     */
    public function readVar($entityid, $userid, $key, $default = null) {

        $this->db->where('entityid', $entityid)
                ->where('var_key', $key)
                ->where('deleted', 0)
                ->where('status', 'active');

        // if (!is_null($userid)) {
        //     $this->db->where('userid', $userid);
        // }

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            return $query->row()->var_value;
        }
        return $default;
    }

    /**
     * Read a variable by entity + user + key
     * Increments it by 1, saves, and returns new value
     * Returns $default if not found
     */
    public function readVarInc($entityid, $userid, $key, $default = null) {
        
        $this->db->where('entityid', $entityid)
                ->where('var_key', $key)
                ->where('deleted', 0)
                ->where('status', 'active');

        // if (!is_null($userid)) {
        //     $this->db->where('userid', $userid);
        // }

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $newValue = (int)$row->var_value + 1;

            // update the table with incremented value
            $this->db->where('id', $row->id)
                    ->update($this->table, ['var_value' => $newValue]);

            return $newValue;
        }

        // If not found, initialize with default (if provided), otherwise start at 1
        $newValue = ($default !== null) ? $default : 1;

        $this->db->insert($this->table, [
            'entityid'  => $entityid,
            'userid'    => $userid,
            'var_key'   => $key,
            'var_value' => $newValue,
            'status'    => 'active',
            'deleted'   => 0
        ]);

        return $newValue;
    }

    
    /**
     * Write or update a variable (entity + user + key)
     */
    public function writeVar($entityid, $userid, $key, $value, $type = 'string', $description = null) {
        $data = [
            'var_value'   => $value,
            'var_type'    => $type,
            'description' => $description,
            'updated_at'  => date('Y-m-d H:i:s'),
            'updated_by'  => $userid
        ];

        $exists = $this->db->get_where($this->table, [
            'entityid' => $entityid,
            // 'userid'   => $userid,
            'var_key'  => $key
        ])->row();

        if ($exists) {
            // update existing
            $this->db->where('entityid', $entityid)
                    //  ->where('userid', $userid)
                     ->where('var_key', $key)
                     ->update($this->table, $data);
            return $this->db->affected_rows() > 0;
        } else {
            // create new
            $data['entityid']       = $entityid;
            $data['userid']         = $userid;
            $data['var_key']        = $key;
            $data['created_at']     = date('Y-m-d H:i:s');
            $data['created_by']     = $userid;
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }
    }


}