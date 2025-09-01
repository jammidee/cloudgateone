<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Lab Request</li>
        </ol>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <form method="POST" action="<?= site_url('laboratory/store'); ?>">

                    <!-- Hidden Metadata -->
                    <input type="hidden" name="entityid" value="_NA_">
                    <input type="hidden" name="appid" value="_NA_">
                    <input type="hidden" name="userid" value="<?= $this->session->userdata('user_id'); ?>">
                    <input type="hidden" name="vversion" value="">
                    <input type="hidden" name="pid" value="0">
                    <input type="hidden" name="sstatus" value="ACTIVE">

                    <!-- Patient & Doctor Details -->
                    <h5 class="mt-4 mb-3"><strong>Patient & Doctor Details</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" class="form-control" placeholder="Enter patient full name">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Patient Email</label>
                            <input type="email" name="patient_email" class="form-control" placeholder="Enter patient email address">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Patient Phone</label>
                            <input type="text" name="patient_phone" class="form-control" placeholder="Enter patient phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Patient Address</label>
                            <input type="text" name="patient_address" class="form-control" placeholder="Enter patient address">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Doctor Name</label>
                            <input type="text" name="doctor_name" class="form-control" placeholder="Enter doctor full name">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Doctor Email</label>
                            <input type="email" name="doctor_email" class="form-control" placeholder="Enter doctor email address">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Doctor Phone</label>
                            <input type="text" name="doctor_phone" class="form-control" placeholder="Enter doctor phone number">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Doctor Address</label>
                            <input type="text" name="doctor_address" class="form-control" placeholder="Enter doctor address">
                        </div>
                    </div>

                    <!-- Lab Request Details -->
                    <h5 class="mt-4 mb-3"><strong>Lab Request Details</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Category Name</label>
                            <input type="text" name="category_name" class="form-control" placeholder="Enter lab category (e.g., Hematology)">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category ID</label>
                            <input type="number" name="category_id" class="form-control" placeholder="Enter category ID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Report</label>
                        <textarea name="report" class="form-control" rows="3" placeholder="Enter lab report details"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Invoice ID</label>
                            <input type="number" name="invoice_id" class="form-control" placeholder="Enter invoice ID">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Hospital ID</label>
                            <input type="text" name="hospital_id" class="form-control" placeholder="Enter hospital ID">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Alloted Bed ID</label>
                            <input type="text" name="alloted_bed_id" class="form-control" placeholder="Enter allotted bed ID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bed Diagnostic ID</label>
                        <input type="text" name="bed_diagnostic_id" class="form-control" placeholder="Enter bed diagnostic ID">
                    </div>

                    <!-- Workflow / Status -->
                    <h5 class="mt-4 mb-3"><strong>Workflow / Status</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Lab Status</label>
                            <select name="lab_status" class="form-control">
                                <option value="queued" selected>Queued</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="error">Error</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Test Status</label>
                            <input type="text" name="test_status" class="form-control" placeholder="Enter test status">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Test Status Date</label>
                            <input type="datetime-local" name="test_status_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Delivery Status</label>
                            <input type="text" name="delivery_status" class="form-control" placeholder="Enter delivery status">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Delivery Status Date</label>
                            <input type="datetime-local" name="delivery_status_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Receiver Name</label>
                        <input type="text" name="receiver_name" class="form-control" placeholder="Enter receiver name">
                    </div>
                    <div class="form-group">
                        <label>Machine Status Message</label>
                        <input type="text" name="machine_status_message" class="form-control" placeholder="Enter machine status message or errors">
                    </div>

                    <!-- Assigned Resources -->
                    <h5 class="mt-4 mb-3"><strong>Assigned Resources</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Clinic ID</label>
                            <input type="text" name="assigned_clinic_id" class="form-control" placeholder="Enter clinic ID">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Machine ID</label>
                            <input type="text" name="assigned_machine_id" class="form-control" placeholder="Enter machine ID">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Technician ID</label>
                            <input type="text" name="assigned_technician_id" class="form-control" placeholder="Enter technician ID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Integration Ref ID</label>
                        <input type="text" name="integration_ref_id" class="form-control" placeholder="Enter integration reference ID">
                    </div>

                    <!-- Timeline -->
                    <h5 class="mt-4 mb-3"><strong>Timeline</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Request Received</label>
                            <input type="datetime-local" name="lab_request_received" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Start Time</label>
                            <input type="datetime-local" name="lab_start_time" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>End Time</label>
                            <input type="datetime-local" name="lab_end_time" class="form-control">
                        </div>
                    </div>

                    <!-- Signatories -->
                    <h5 class="mt-4 mb-3"><strong>Signatories</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Reported By</label>
                            <input type="text" name="reported_by" class="form-control" placeholder="Enter reporter name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Done By</label>
                            <input type="text" name="done_by" class="form-control" placeholder="Enter who performed the work">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Signed By</label>
                            <input type="text" name="signed_by" class="form-control" placeholder="Enter authorized signatory name">
                        </div>
                    </div>

                    <!-- Notes / Remarks -->
                    <h5 class="mt-4 mb-3"><strong>Notes / Remarks</strong></h5>
                    <div class="form-group">
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Additional notes or comments"></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary">Submit Lab Request</button>
                    <a href="<?= site_url('lab/all?t=') . time(); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid--->
