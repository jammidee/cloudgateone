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
 * CREATED DATE : June 28, 2025
 * ------------------------------------------------------------------------
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Mainmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Start User Functions
    // public function getTopUser() {
    //     $this->db->limit(10);
    //     $this->db->order_by('id', 'desc');
    //     $query = $this->db->get_where('users');
    //     return $query->result();
    // }

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

    public function getAllPackages() {
        $query = $this->db->get_where('package');
        return $query->result();
    }

    // public function getPackageByID($id) {
    //     $query = $this->db->get_where('package', array('packid' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         redirect('home', 'refresh');
    //     }
    // }

    public function getAllAreas() {
        $query = $this->db->get_where('area');
        return $query->result();
    }

    // public function getAreaByID($id) {
    //     $query = $this->db->get_where('area', array('id' => $id));
    //     return $query->result();
    // }

    //Added by jammi Dee 12/27/2024
    // public function getInvoiceByID($id) {
    //     $query = $this->db->get_where('invoice', array('invoiceID' => $id));
    //     return $query->result();
    // }

    public function getAllStaffs() {
        $query = $this->db->get_where('staff');
        return $query->result();
    }

    // public function getStaffByID($id) {
    //     $query = $this->db->get_where('staff', array('id' => $id));
    //     return $query->result();
    // }

    // public function getAllInvoices() {
    //     $this->db->order_by('invoiceID', 'desc');
    //     $query = $this->db->get_where('invoice');
    //     return $query->result();
    // }
    
    // // Modified by Jammi Dee 12/18/2024
    // public function getInvoicesByMonth() {
    //     $currentMonthStart = date('Y-m-01'); // First day of the current month
    //     $currentMonthEnd = date('Y-m-t');   // Last day of the current month

    //     $this->db->where('createdate >=', $currentMonthStart);
    //     $this->db->where('createdate <=', $currentMonthEnd);
    //     $this->db->order_by('invoiceID', 'desc');
    //     $query = $this->db->get('invoice');
    //     return $query->result();
    // }

    // // Modified by Jammi Dee 12/18/2024
    // public function getDueInvoices() {
    //     $this->db->order_by('invoiceID', 'desc');
    //     $query = $this->db->get_where('invoice');
    //     return $query->result();
    // }

    // Modified by Jammi Dee 12/18/2024, 01/07/2025
    // public function getDueInvoices($nodays) {
    //     $sql = "
    //         SELECT
    //             i.*,
    //             u.name AS customer_name,
    //             u.mobile AS customer_mobile,
    //             u.email AS customer_email
    //         FROM
    //             invoice i
    //         JOIN
    //             users u ON i.userid = u.id
    //         WHERE
    //             i.status = 'Unpaid'
    //             AND DATE(i.duedate) <= DATE(NOW() + INTERVAL " . (int)$nodays . " DAY)
    //         ORDER BY
    //             i.invoiceID DESC
    //     ";

    //     $query = $this->db->query($sql);
    //     return $query->result();
    // }



    // public function getAllInvoicsByUser($id) {
    //     $this->db->order_by('invoiceID', 'desc');
    //     $query = $this->db->get_where('invoice', array('userid' => $id));
    //     return $query->result();
    // }

    // public function getAllPayments() {
    //     $this->db->order_by('paymentid', 'desc');
    //     $query = $this->db->get_where('payments');
    //     return $query->result();
    // }

    // public function getAllPaymentsByInvoiceID() {
    //     $this->db->order_by('paymentid', 'desc');
    //     $query = $this->db->get_where('payments');
    //     return $query->result();
    // }

    // public function getPaymentsByMonth($month, $year) {
    //     $this->db->order_by('paymentid', 'desc');
    //     $this->db->where('month(saletime)', $month);
    //     $this->db->where('year(saletime)', $year);
    //     $query = $this->db->get_where('payments');
    //     return $query->result();
    // }

    // public function getPaymentsByMonthSite($siteId, $month, $year) {

    //     if( (int) $siteId == 0 ){
    //         //No Site Code
    //     } else {
    //         $this->db->where('saleid', $siteId);
    //     }

    //     $this->db->order_by('paymentid', 'desc');
    //     $this->db->where('month(saletime)', $month);
    //     $this->db->where('year(saletime)', $year);
    //     $query = $this->db->get_where('payments');
    //     return $query->result();
    // }

    // public function getPaymentsByYear($year) {
    //     $this->db->order_by('paymentid', 'desc');
    //     $this->db->where('year(saletime)', $year);
    //     $query = $this->db->get_where('payments');
    //     return $query->result();
    // }

    // public function getPaymentsByYearSite($siteId, $year) {

    //     if( (int) $siteId == 0 ){
    //         //No Site Code
    //     } else {
    //         $this->db->where('saleid', $siteId);
    //     }

    //     $this->db->order_by('paymentid', 'desc');
    //     $this->db->where('year(saletime)', $year);
    //     $query = $this->db->get_where('payments');
    //     return $query->result();
    // }


    // public function getPaymentsSumByMonth($month, $year) {
    //     $this->db->select_sum('amount');
    //     $this->db->from('payments');
    //     $this->db->where('month(saletime)', $month);
    //     $this->db->where('year(saletime)', $year);
    //     $sum = $this->db->get();
    //     if($sum->num_rows() > 0){
    //         $sum = $sum->result()[0];
    //         return round($sum->amount);
    //     }else{
    //         return 0;
    //     }
    // }

    // public function getAllBalances() {
    //     $this->db->order_by('id', 'desc');
    //     $query = $this->db->get_where('balance');
    //     return $query->result();
    // }

    // public function getBalancesByMonth($month, $year) {
    //     $this->db->order_by('id', 'desc');
    //     $this->db->where('month(date)', $month);
    //     $this->db->where('year(date)', $year);
    //     $query = $this->db->get_where('balance');
    //     return $query->result();
    // }

    // public function getBalancesByYear($year) {
    //     $this->db->order_by('id', 'desc');
    //     $this->db->where('year(date)', $year);
    //     $query = $this->db->get_where('balance');
    //     return $query->result();
    // }

    // public function getBalInSumByMonth($month, $year) {
    //     $this->db->select_sum('amount');
    //     $this->db->from('balance');
    //     $this->db->where('type', 'Income');
    //     $this->db->where('month(date)', $month);
    //     $this->db->where('year(date)', $year);
    //     $sum = $this->db->get();
    //     if($sum->num_rows() > 0){
    //         $sum = $sum->result()[0];
    //         return round($sum->amount);
    //     }else{
    //         return 0;
    //     }
    // }

    // public function getBalExSumByMonth($month, $year) {
    //     $this->db->select_sum('amount');
    //     $this->db->from('balance');
    //     $this->db->where('type', 'Expense');
    //     $this->db->where('month(date)', $month);
    //     $this->db->where('year(date)', $year);
    //     $sum = $this->db->get();
    //     if($sum->num_rows() > 0){
    //         $sum = $sum->result()[0];
    //         return round($sum->amount);
    //     }else{
    //         return 0;
    //     }
    // }


    // public function getBalanceByID($id) {
    //     $query = $this->db->get_where('balance', array('id' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         redirect('home', 'refresh');
    //     }
    // }


    public function getSettings() {
        $query = $this->db->get_where('settings', array('id' => 1));
        return $query->result();
    }
    
    // Added by Jammi Dee 12/17/2024
    public function getSettingsByID($id) {
        $query = $this->db->get_where('settings', array('id' => $id));
        return $query->result();
    }

    // Added by Jammi Dee 12/17/2024
    public function getAllSettings() {
        $query = $this->db->get_where('settings');
        return $query->result();
    }

    // public function getBillIDYear($userID, $selectedYear) {
    //     $this->db->order_by('month', 'asc');
    //     $query = $this->db->get_where('bills', array('userid' => $userID, 'year' => $selectedYear));
    //     return $query->result();
    // }

    // public function getInvoice($id) {
    //     $query = $this->db->get_where('invoice', array('invoiceID' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         redirect('home', 'refresh');
    //     }
    // }

    // public function getUserInvoice($id, $userID) {
    //     $query = $this->db->get_where('invoice', array('invoiceID' => $id, 'userid' => $userID));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         redirect('home', 'refresh');
    //     }
    // }

    // public function getInvoicesByUserID($id) {
    //     $query = $this->db->get_where('invoice', array('userid' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return false;
    //     }
    // }

    // public function getPaymenstsByInvoiceIDs($ids) {
    //     $this->db->where_in('invoiceid', $ids);
    //     $query = $this->db->get('payments');
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return 0;
    //     }
    // }

    //Added by Jammi Dee 03/24/2025
    // public function getPaymenstsBySite($site) {
    //     $this->db->where_in('saleid', $site);
    //     $query = $this->db->get('payments');
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return 0;
    //     }
    // }

    //Added by Jammi Dee 06/07/2025
    // public function getPaymenstsByDaterandAndSite($siteId, $daterange) {

    //     // Default to today
    //     $startdate  = date('Y-m-01');
    //     $enddate    = date('Y-m-t');

    //     // Determine the start and end date based on the selected date range
    //     switch ($daterange) {
    //         case 'tomorrow':
    //             $startdate = date('Y-m-d', strtotime('+1 day'));
    //             $enddate = date('Y-m-d', strtotime('+1 day'));
    //             break;

    //         case 'yesterday':
    //             $startdate = date('Y-m-d', strtotime('-1 day'));
    //             $enddate = date('Y-m-d', strtotime('-1 day'));
    //             break;

    //         case 'thisweek':
    //             $startdate = date('Y-m-d', strtotime('monday this week'));
    //             $enddate = date('Y-m-d', strtotime('sunday this week'));
    //             break;

    //         case 'nextweek':
    //             $startdate = date('Y-m-d', strtotime('monday next week'));
    //             $enddate = date('Y-m-d', strtotime('sunday next week'));
    //             break;

    //         case 'thismonth':
    //             $startdate = date('Y-m-01'); // First day of current month
    //             $enddate = date('Y-m-t');   // Last day of current month
    //             break;

    //         case 'nextmonth':
    //             $startdate = date('Y-m-01', strtotime('first day of next month'));
    //             $enddate = date('Y-m-t', strtotime('last day of next month'));
    //             break;

    //         case 'lastmonth':
    //             $startdate = date('Y-m-01', strtotime('first day of last month'));
    //             $enddate = date('Y-m-t', strtotime('last day of last month'));
    //             break;

    //         case 'last30days':
    //             $startdate = date('Y-m-d', strtotime('-30 days'));
    //             $enddate = date('Y-m-d');
    //             break;

    //         default:
    //             // If an invalid or empty value is given, default to "today"
    //             $daterange = 'today';
    //             break;
    //     }

    //     // Apply filters to the database query
    //     // $this->db->where("DATE_FORMAT(saletime, '%Y-%m-%d') >=", $startdate);
    //     // $this->db->where("DATE_FORMAT(saletime, '%Y-%m-%d') <=", $enddate);
    //     $this->db->where('saletime >=', $startdate . ' 00:00:00');
    //     $this->db->where('saletime <', date('Y-m-d', strtotime($enddate . ' +1 day')) . ' 00:00:00');

    //     if( (int) $siteId == 0 ){
    //         //No Site Code
    //     } else {
    //         $this->db->where('saleid', $siteId);
    //     }
    //     // $this->db->where_in('saleid', $siteId);

    //     $query = $this->db->get('payments');
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         return 0;
    //     }
    // }

    // public function getAllTickets() {
    //     $this->db->order_by('ticketID', 'desc');
    //     $query = $this->db->get_where('ticket');
    //     return $query->result();
    // }

    // public function getAllTicketsByUser() {
    //     $this->db->order_by('ticketID', 'desc');
    //     $userID = $this->session->userdata('user_id');
    //     $query = $this->db->get_where('ticket', array('userID' => $userID));
    //     return $query->result();
    // }

    // public function getTicketByID($id) {
    //     $query = $this->db->get_where('ticket', array('ticketID' => $id));
    //     if($query->num_rows() > 0){
    //         return $query->result();
    //     }else{
    //         redirect('ticket/all', 'refresh');
    //     }

    // }

    // public function getTicketCommentByID($id) {
    //     $query = $this->db->get_where('ticketcomment', array('ticketID' => $id));
    //     return $query->result();
    // }

    //==================
    // Router functions
    // JMD - 12/17/2024
    //==================
    // public function getAllRouters() {
    //     return $this->db->get('routers')->result();
    // }

    // public function getRouterByID($id) {
    //     return $this->db->get_where('routers', array('id' => $id))->row();
    // }

    // public function insertRouter($data) {
    //     return $this->db->insert('routers', $data);
    // }

    // public function updateRouter($id, $data) {
    //     $this->db->where('id', $id);
    //     return $this->db->update('routers', $data);
    // }

    // public function deleteRouter($id) {
    //     return $this->db->delete('routers', array('id' => $id));
    // }

    //==================
    // Device functions
    // JMD - 01/04/2024
    //==================

    // public function getAllDevices() {
    //     return $this->db->get('devices')->result();
    // }

    // public function getDeviceByID($id) {
    //     return $this->db->get_where('devices', array('id' => $id))->row();
    // }

    // public function insertDevice($data) {
    //     return $this->db->insert('devices', $data);
    // }

    // public function updateDevice($id, $data) {
    //     $this->db->where('id', $id);
    //     return $this->db->update('devices', $data);
    // }

    // public function deleteDevice($id) {
    //     return $this->db->delete('devices', array('id' => $id));
    // }



}
