<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Lab Request</li>
        </ol>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="container-fluid">
                <form method="POST" action="<?= site_url('laboratory/update/' . $lab->id); ?>">

                    <!-- Hidden Metadata -->
                    <input type="hidden" name="entityid" value="<?= $lab->entityid ?? '_NA_'; ?>">
                    <input type="hidden" name="appid" value="<?= $lab->appid ?? '_NA_'; ?>">
                    <input type="hidden" name="userid" value="<?= $lab->userid ?? $this->session->userdata('user_id'); ?>">
                    <input type="hidden" name="vversion" value="<?= $lab->vversion ?? ''; ?>">
                    <input type="hidden" name="pid" value="<?= $lab->pid ?? 0; ?>">
                    <input type="hidden" name="sstatus" value="<?= $lab->sstatus ?? 'ACTIVE'; ?>">

                    <!-- Patient & Doctor Details -->
                    <h5 class="mt-4 mb-3"><strong>Patient & Doctor Details</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" class="form-control" value="<?= $lab->patient_name ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Patient Email</label>
                            <input type="email" name="patient_email" class="form-control" value="<?= $lab->patient_email ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Patient Phone</label>
                            <input type="text" name="patient_phone" class="form-control" value="<?= $lab->patient_phone ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Patient Address</label>
                            <input type="text" name="patient_address" class="form-control" value="<?= $lab->patient_address ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Doctor Name</label>
                            <input type="text" name="doctor_name" class="form-control" value="<?= $lab->doctor_name ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Doctor Email</label>
                            <input type="email" name="doctor_email" class="form-control" value="<?= $lab->doctor_email ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Doctor Phone</label>
                            <input type="text" name="doctor_phone" class="form-control" value="<?= $lab->doctor_phone ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Doctor Address</label>
                            <input type="text" name="doctor_address" class="form-control" value="<?= $lab->doctor_address ?? ''; ?>">
                        </div>
                    </div>

                    <!-- Lab Request Details -->
                    <h5 class="mt-4 mb-3"><strong>Lab Request Details</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Category Name</label>
                            <input type="text" name="category_name" class="form-control" value="<?= $lab->category_name ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category ID</label>
                            <input type="number" name="category_id" class="form-control" value="<?= $lab->category_id ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Report</label>
                        <textarea name="report" class="form-control" rows="3"><?= $lab->report ?? ''; ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Invoice ID</label>
                            <input type="number" name="invoice_id" class="form-control" value="<?= $lab->invoice_id ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Hospital ID</label>
                            <input type="text" name="hospital_id" class="form-control" value="<?= $lab->hospital_id ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Alloted Bed ID</label>
                            <input type="text" name="alloted_bed_id" class="form-control" value="<?= $lab->alloted_bed_id ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Bed Diagnostic ID</label>
                        <input type="text" name="bed_diagnostic_id" class="form-control" value="<?= $lab->bed_diagnostic_id ?? ''; ?>">
                    </div>

                    <!-- Workflow / Status -->
                    <h5 class="mt-4 mb-3"><strong>Workflow / Status</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Lab Status</label>
                            <select name="lab_status" class="form-control">
                                <option value="queued" <?= ($lab->lab_status == 'queued') ? 'selected' : ''; ?>>Queued</option>
                                <option value="in_progress" <?= ($lab->lab_status == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="completed" <?= ($lab->lab_status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                <option value="error" <?= ($lab->lab_status == 'error') ? 'selected' : ''; ?>>Error</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Test Status</label>
                            <input type="text" name="test_status" class="form-control" value="<?= $lab->test_status ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Test Status Date</label>
                            <input type="datetime-local" name="test_status_date" class="form-control" value="<?= isset($lab->test_status_date) ? date('Y-m-d\TH:i', strtotime($lab->test_status_date)) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Delivery Status</label>
                            <input type="text" name="delivery_status" class="form-control" value="<?= $lab->delivery_status ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Delivery Status Date</label>
                            <input type="datetime-local" name="delivery_status_date" class="form-control" value="<?= isset($lab->delivery_status_date) ? date('Y-m-d\TH:i', strtotime($lab->delivery_status_date)) : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Receiver Name</label>
                        <input type="text" name="receiver_name" class="form-control" value="<?= $lab->receiver_name ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Machine Status Message</label>
                        <input type="text" name="machine_status_message" class="form-control" value="<?= $lab->machine_status_message ?? ''; ?>">
                    </div>

                    <!-- Assigned Resources -->
                    <h5 class="mt-4 mb-3"><strong>Assigned Resources</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Clinic ID</label>
                            <input type="text" name="assigned_clinic_id" class="form-control" value="<?= $lab->assigned_clinic_id ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Machine ID</label>
                            <input type="text" name="assigned_machine_id" class="form-control" value="<?= $lab->assigned_machine_id ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Technician ID</label>
                            <input type="text" name="assigned_technician_id" class="form-control" value="<?= $lab->assigned_technician_id ?? ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Integration Ref ID</label>
                        <input type="text" name="integration_ref_id" class="form-control" value="<?= $lab->integration_ref_id ?? ''; ?>">
                    </div>

                    <!-- Timeline -->
                    <h5 class="mt-4 mb-3"><strong>Timeline</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Request Received</label>
                            <input type="datetime-local" name="lab_request_received" class="form-control" value="<?= isset($lab->lab_request_received) ? date('Y-m-d\TH:i', strtotime($lab->lab_request_received)) : ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Start Time</label>
                            <input type="datetime-local" name="lab_start_time" class="form-control" value="<?= isset($lab->lab_start_time) ? date('Y-m-d\TH:i', strtotime($lab->lab_start_time)) : ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>End Time</label>
                            <input type="datetime-local" name="lab_end_time" class="form-control" value="<?= isset($lab->lab_end_time) ? date('Y-m-d\TH:i', strtotime($lab->lab_end_time)) : ''; ?>">
                        </div>
                    </div>

                    <!-- Signatories -->
                    <h5 class="mt-4 mb-3"><strong>Signatories</strong></h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Reported By</label>
                            <input type="text" name="reported_by" class="form-control" value="<?= $lab->reported_by ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Done By</label>
                            <input type="text" name="done_by" class="form-control" value="<?= $lab->done_by ?? ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Signed By</label>
                            <input type="text" name="signed_by" class="form-control" value="<?= $lab->signed_by ?? ''; ?>">
                        </div>
                    </div>

                    <!-- Notes / Remarks -->
                    <h5 class="mt-4 mb-3"><strong>Notes / Remarks</strong></h5>
                    <div class="form-group">
                        <textarea name="remarks" class="form-control" rows="3"><?= $lab->remarks ?? ''; ?></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary">Update Lab Request</button>
                    <a href="<?= site_url('laboratory/all?t=') . time(); ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!---Container Fluid--->
