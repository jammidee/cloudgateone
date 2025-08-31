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

class Configdb extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->db_path = APPPATH . 'database/cgone.db';

        // Check user login session
        $uri = uri_string();
        isLoginRedirect($uri);

    }

    public function index() {
        $data['title'] = 'System Settings';

        // Load the layout with our calendar page
        $this->load->view('_layout/header',         $data);
        $this->load->view('_layout/sidebar',        $data);
        $this->load->view('_layout/topbar',         $data);
        $this->load->view('configdb/index',         $data); // Calendar page
        $this->load->view('_layout/footer');
    }

    public function system() {
        $data['title'] = 'System Settings';

        $entityid = $this->session->userdata('user_entity') ?? '_NA_';
        $userid   = $this->session->userdata('user_id') ?? 0;

        $newDefaults = [
            'maxusers'          => get_configdb($entityid, $userid, 'maxusers', "100"),
            'site_name'         => get_configdb($entityid, $userid, 'site_name', "My Cloudgate System"),
            'default_timezone'  => get_configdb($entityid, $userid, 'default_timezone', "UTC"),
            'theme'             => get_configdb($entityid, $userid, 'theme', "dark"),
            'session_timeout'   => get_configdb($entityid, $userid, 'session_timeout', "30"),
            'default_language'  => get_configdb($entityid, $userid, 'default_language', "en"),
            'support_email'     => get_configdb($entityid, $userid, 'support_email', "support@lalullacom"),
            'maintenance_mode'  => get_configdb($entityid, $userid, 'maintenance_mode', "0"),
            'currency_symbol'   => get_configdb($entityid, $userid, 'currency_symbol', "₱"),
            'records_per_page'  => get_configdb($entityid, $userid, 'records_per_page', "20"),

            // ✅ New company constants
            'company_name'      => get_configdb($entityid, $userid, 'company_name', "ClodGate Corporation"),
            'company_address'   => get_configdb($entityid, $userid, 'company_address', "Lot A-7, (Bldg. 3033), Rizal Highway, Makati Metro Manila"),
            'company_contact'   => get_configdb($entityid, $userid, 'company_contact', "Tel. Nos. (042) 253-1539, 253-1747   Fax No.: (042) 252-1338"),
            'company_email'     => get_configdb($entityid, $userid, 'company_email', "cgone@gmail.com"),
            'company_site'      => get_configdb($entityid, $userid, 'company_site', "www.cgone.com"),

        ];

        // Merge without overwriting existing keys
        $data = array_merge($newDefaults, $data ?? []);

        // Load the layout with our calendar page
        $this->load->view('_layout/header',         $data);
        $this->load->view('_layout/sidebar',        $data);
        $this->load->view('_layout/topbar',         $data);
        $this->load->view('configdb/system',        $data); // Calendar page
        $this->load->view('_layout/footer');
    }

    public function saveconfig() {
        $entityid = $this->session->userdata('user_entity') ?? '_NA_';
        $userid   = $this->session->userdata('user_id') ?? 0;

        // Collect POST values
        $configs = [
            'maxusers'         => ['value' => $this->input->post('maxusers'),        'type' => 'integer', 'desc' => 'Maximum number of users allowed'],
            'site_name'        => ['value' => $this->input->post('site_name'),       'type' => 'string',  'desc' => 'Application display name'],
            'default_timezone' => ['value' => $this->input->post('default_timezone'),'type' => 'string',  'desc' => 'Default system timezone'],
            'theme'            => ['value' => $this->input->post('theme'),           'type' => 'string',  'desc' => 'Default application theme'],
            'session_timeout'  => ['value' => $this->input->post('session_timeout'), 'type' => 'integer', 'desc' => 'Session timeout in minutes'],
            'default_language' => ['value' => $this->input->post('default_language'),'type' => 'string',  'desc' => 'Default system language'],
            'support_email'    => ['value' => $this->input->post('support_email'),   'type' => 'string',  'desc' => 'Support contact email address'],
            'maintenance_mode' => ['value' => $this->input->post('maintenance_mode'),'type' => 'boolean', 'desc' => 'Is application in maintenance mode?'],
            'currency_symbol'  => ['value' => $this->input->post('currency_symbol'), 'type' => 'string',  'desc' => 'Currency symbol used in the system'],
            'records_per_page' => ['value' => $this->input->post('records_per_page'),'type' => 'integer', 'desc' => 'Number of records shown per page'],

            // ✅ New company constants
            'company_name'     => ['value' => $this->input->post('company_name'),   'type' => 'string',  'desc' => 'Company legal name'],
            'company_address'  => ['value' => $this->input->post('company_address'),'type' => 'string',  'desc' => 'Company address'],
            'company_contact'  => ['value' => $this->input->post('company_contact'),'type' => 'string',  'desc' => 'Company contact numbers'],
            'company_email'    => ['value' => $this->input->post('company_email'),  'type' => 'string',  'desc' => 'Company email address'],
            'company_site'     => ['value' => $this->input->post('company_site'),   'type' => 'string',  'desc' => 'Company website'],

        ];

        // Save all configs
        foreach ($configs as $key => $config) {
            set_configdb($entityid, $userid, $key, $config['value'], $config['type'], $config['desc']);
        }

        //Update the logs
        log_action('update', 'Updated configuration DB information');

        // Flash success message
        $this->session->set_flashdata('success', 'System configuration saved successfully!');

        // Redirect back to system settings page
        redirect('configdb/system?t=' . time());
    }
    
    public function sqlitecfg() {
        $data['title'] = 'SQLite Configuration/Settings';

        // Load the layout with our calendar page
        $this->load->view('_layout/header',         $data);
        $this->load->view('_layout/sidebar',        $data);
        $this->load->view('_layout/topbar',         $data);
        $this->load->view('configdb/sqlitecfg',     $data); // Calendar page
        $this->load->view('_layout/footer');
    }
    
    // Initialize DB (create file + tables)
    public function initialize()
    {
        if (!file_exists($this->db_path)) {
            $db = new SQLite3($this->db_path);
        } else {
            $db = new SQLite3($this->db_path);
        }

        // Example: Create a simple table
        $sql = "CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT,
                    email TEXT,
                    created_at TEXT DEFAULT (datetime('now'))
                );";
        $db->exec($sql);

        $db->close();
        $this->session->set_flashdata('success', 'Database initialized successfully.');
        redirect('configdb/index');
    }
    
    // Reset DB (drop + recreate tables)
    public function reset()
    {
        if (file_exists($this->db_path)) {
            unlink($this->db_path); // delete file
        }
        $this->initialize(); // recreate
        $this->session->set_flashdata('success', 'Database reset successfully.');
        redirect('configdb/index');
    }
    
    // Backup DB
    public function backup()
    {
        if (file_exists($this->db_path)) {
            $backup_path = APPPATH . 'database/lab_backup_' . date('Ymd_His') . '.db';
            copy($this->db_path, $backup_path);
            $this->session->set_flashdata('success', 'Database backup created: ' . basename($backup_path));
        } else {
            $this->session->set_flashdata('error', 'Database file not found.');
        }
        redirect('configdb/index');
    }
    
    // Optimize DB
    public function optimize()
    {
        if (file_exists($this->db_path)) {
            $db = new SQLite3($this->db_path);
            $db->exec("VACUUM;");
            $db->exec("ANALYZE;");
            $db->close();
            $this->session->set_flashdata('success', 'Database optimized successfully.');
        } else {
            $this->session->set_flashdata('error', 'Database file not found.');
        }
        redirect('configdb/index');
    }
    



}