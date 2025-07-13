<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -----------------------------------------------------
| PRODUCT NAME: ROUTER WHISPERER
| -----------------------------------------------------
| AUTHOR: JAMMI DEE
| -----------------------------------------------------
| EMAIL: jammi_dee@yahoo.com 01/10/2025
| -----------------------------------------------------
*/

class Emissionmodel extends CI_Model {
    
    private $emissionDb;

    public function __construct() {
        parent::__construct();

        // Load the 'emission' database group without overriding $this->db
        $this->emissionDb = $this->load->database('emission', TRUE);
    }

    private function getSelectedColumns() {
        // List all columns excluding blob fields
        // return [
        //     'RecordId', 'ENTITYID', 'APPID', 'USERID', 'IsCompanyOwned', 'LNAME', 'MNAME', 'FNAME', 
        //     'ORGANIZATION', 'CONTACTNO', 'EMAILADDR', 'PLATE_NO', 'MV_FILE_NO', 'CHASSIS_NO', 
        //     'ENGINE_NO', 'MV_TYPE', 'MV_TYPE_DESC', 'MAKE', 'MAKE_DESC', 'FUEL_TYPE', 'COLOR', 
        //     'CLASSIFICATION', 'CLASSIFICATION_DESC', 'VEHICLE_MODEL', 'VEHICLE_SERIES', 
        //     'DATE_FIRST_REG', 'CR_NO', 'OR_NO', 'OR_TYPE', 'CEC_NUMBER', 'PETC_ACCR_NO', 
        //     'DATETIME_TESTED', 'TEST_PURPOSE', 'PETC_NAME', 'PETC_RATE', 'TEST_AVE_D', 
        //     'TEST_CO', 'TEST_HC', 'RPM', 'PETC_RESULT', 'REGION_CODE', 'DISTRICT_CODE', 
        //     'OWNER_ADDRESS', 'BODY_TYPE', 'DIESEL_TYPE', 'GROSS_MV_WEIGHT', 'TESDA', 
        //     'REPRINT', 'RETEST', 'TRAN_ID', 'STATUSCODE', 'DOC_STATUS', 'DENR_RESULT', 
        //     'DATETIME_UPLOADED', 'AUTHENTICATION_NO', 'REMARKS', 'STRADSYSTEMSID', 'PETC_Code', 
        //     'LTOMONID', 'NO_OF_LANES', 'LANE_NO', 'HDD_ID', 'NIC_ID', 'WS_ID', 'TECHINICIAN', 
        //     'ENCODER', 'CATALYTIC', 'DATE_TESTED', 'TIME_TESTED', 'lto_expiry', 'dti_expiry', 
        //     'tesda_expiry', 'SSTATUS', 'VVERSION', 'ISSYNC', 'DELETED', 'CREATEDATE', 'CREATETIME'
        // ];
        
        return [
            'RecordId', 'IsCompanyOwned', 'LNAME', 'MNAME', 'FNAME', 
            'ORGANIZATION', 'PLATE_NO', 'MV_FILE_NO', 'CHASSIS_NO', 
            'ENGINE_NO', 'MV_TYPE', 'MV_TYPE_DESC', 'MAKE', 'MAKE_DESC', 'FUEL_TYPE', 'COLOR', 
            'CLASSIFICATION', 'CLASSIFICATION_DESC', 'VEHICLE_MODEL', 'VEHICLE_SERIES', 
            'DATE_FIRST_REG', 'CR_NO', 'OR_NO', 'OR_TYPE', 'CEC_NUMBER', 'PETC_ACCR_NO', 
            'DATETIME_TESTED', 'TEST_PURPOSE', 'PETC_NAME', 'TEST_AVE_D', 
            'TEST_CO', 'TEST_HC', 'RPM', 'PETC_RESULT', 'REGION_CODE', 'DISTRICT_CODE', 
            'OWNER_ADDRESS', 'BODY_TYPE', 'DIESEL_TYPE', 'GROSS_MV_WEIGHT', 'TESDA', 
            'REPRINT', 'RETEST', 'TRAN_ID', 'STATUSCODE', 'DOC_STATUS', 'DENR_RESULT', 
            'DATETIME_UPLOADED', 'AUTHENTICATION_NO', 'REMARKS', 'STRADSYSTEMSID', 'PETC_Code', 
            'LTOMONID', 'NO_OF_LANES', 'LANE_NO', 'HDD_ID', 'NIC_ID', 'WS_ID', 'TECHINICIAN', 
            'ENCODER', 'CATALYTIC', 'DATE_TESTED', 'TIME_TESTED', 'lto_expiry', 'dti_expiry', 
            'tesda_expiry'
        ];
    }

    public function getAllEmission() {
        $columns = $this->getSelectedColumns();
        $this->emissionDb->select($columns);
        return $this->emissionDb->get('emissionrecords')->result();
    }

    public function getEmissionByID($id) {
        $columns = $this->getSelectedColumns();
        $this->emissionDb->select($columns);
        return $this->emissionDb->get_where('emissionrecords', ['RecordId' => $id])->row();
    }

    // Added by Jammi Dee 01/16/2025
    public function getLatestRecordId() {
        // Query the table to fetch the latest RecordId
        $query = $this->emissionDb
                      ->select('RecordId')
                      ->order_by('RecordId', 'DESC')
                      ->limit(1)
                      ->get('emissionrecords');

        // Check if a result exists and return it
        if ($query->num_rows() > 0) {
            return $query->row()->RecordId;
        }

        // Return null if no records are found
        return null;
    }

    public function insertEmission($data) {
        $data['CREATEDATE'] = date('Y-m-d');
        $data['CREATETIME'] = date('H:i:s');
        return $this->emissionDb->insert('emissionrecords', $data);
    }

    public function updateEmission($id, $data) {
        $data['UPDATED_AT'] = date('Y-m-d H:i:s');
        return $this->emissionDb->where('RecordId', $id)->update('emissionrecords', $data);
    }

    public function deleteEmission($id) {
        return $this->emissionDb->delete('emissionrecords', ['RecordId' => $id]);
    }

    // Search for records by PLATE_NO, MV_FILE_NO, CHASSIS_NO, or ENGINE_NO
    public function searchEmission($searchTerm) {
        $columns = $this->getSelectedColumns();
        $this->emissionDb->select($columns);
        $this->emissionDb->from('emissionrecords');

        // Adding WHERE clause for search
        $this->emissionDb->group_start()
            ->like('PLATE_NO', $searchTerm)
            ->or_like('MV_FILE_NO', $searchTerm)
            ->or_like('CHASSIS_NO', $searchTerm)
            ->or_like('ENGINE_NO', $searchTerm)
        ->group_end();

        // Order by latest date and limit to 3 records
        $this->emissionDb->order_by('DATETIME_TESTED', 'DESC'); // Change 'DATETIME_TESTED' to your preferred timestamp column
        $this->emissionDb->limit(3);

        return $this->emissionDb->get()->result();
    }


    public function searchEmissionV2($searchTerm, $siteCode) {
        $columns = $this->getSelectedColumns();
        $this->emissionDb->select($columns);
        $this->emissionDb->from('emissionrecords');

        // Adding WHERE clause for search
        $this->emissionDb->group_start()
            ->like('PLATE_NO', $searchTerm)
            ->or_like('MV_FILE_NO', $searchTerm)
            ->or_like('CHASSIS_NO', $searchTerm)
            ->or_like('ENGINE_NO', $searchTerm)
        ->group_end();

        // Adding WHERE clause for site code
        if ($siteCode !== 'ALL') { // Exclude "ALL" to fetch records for all sites
            $this->emissionDb->like('PETC_CODE', $siteCode);
        }

        // Order by latest date and limit to 3 records
        $this->emissionDb->order_by('DATETIME_TESTED', 'DESC'); // Adjust column name as needed
        $this->emissionDb->limit(3);

        return $this->emissionDb->get()->result();
    }

    // Added by Jammi Dee 01/16/2025
    public function searchEmissionV3($startRecordId, $field, $searchTerm, $siteCode) {
        $columns = $this->getSelectedColumns();
        $this->emissionDb->select($columns);
        $this->emissionDb->from('emissionrecords');

        // Adding WHERE clause for RecordId to start the search
        $this->emissionDb->where('RecordId >', $startRecordId);

        // Adding WHERE clause for search terms
        $this->emissionDb->group_start()
            ->like($field, $searchTerm)
        ->group_end();

        // Adding WHERE clause for site code
        if ($siteCode !== 'ALL') { // Exclude "ALL" to fetch records for all sites
            $this->emissionDb->like('PETC_CODE', $siteCode);
        }

        // Order by latest date and limit to 3 records
        $this->emissionDb->order_by('DATETIME_TESTED', 'DESC'); // Adjust column name as needed
        $this->emissionDb->limit(3);

        return $this->emissionDb->get()->result();
    }


    //PETC_Site 01/10/2025
    public function getAllSites() {
        return $this->emissionDb->get('petc_site')->result();
    }
    
    //PETC_Site 01/10/2025
    public function getAllSitesBzIdNotNull() {
        return $this->emissionDb->where('BZ_ID IS NOT NULL')
                                ->where('BZ_ID !=', 'NA')
                                ->get('petc_site')
                                ->result();
    }
    
    public function getSiteByCode($siteCode) {
        return $this->emissionDb->get_where('petc_site', ['PETC_CODE' => $siteCode])->row();
    }
    

}
