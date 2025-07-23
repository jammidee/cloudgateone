<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/lookup/index">Lookup</a></li>
            <li class="breadcrumb-item active" aria-current="page">All</li>
        </ol>
    </div>


    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div class="d-flex align-items-center">

                    <i class="fas fa-list text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary mr-3 text-nowrap">Lookup List</h6>

                    <!-- keyid Dropdown -->
                    <select id="keyidFilter" class="form-control form-control-sm">
                        <option value="">-- Select Key ID --</option>
                        <?php foreach ($arrKeyid as $key): ?>
                            <option value="<?= $key ?>" <?= ($pkeyid == $key) ? 'selected' : '' ?>>
                                <?= $key ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Add Button -->
                <?php if (canAccessMenu('lookup_create', $this->session->userdata('user_role'))): ?>
                    <button class="btn btn-sm btn-primary" id="btnAddLookup">
                        <i class="fas fa-plus mr-1"></i>
                    </button>
                <?php endif; ?>

            </div>


            <div class="table-responsive p-3">

                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableHolder" style="width:100%" >
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 15%;">ID</th>
                            <th style="width: 20%;">ItemID</th>
                            <th style="width: 50%;">Description</th>
                            <th style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>ItemID</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php $i = 0; foreach ($dtData as $row) { $i++; ?>
                            <tr>
                                <td class=" "><?php echo $row->id; ?></td>
                                <td class=" "><?php echo $row->itemid; ?></td>
                                <td class=" "><?php echo $row->description; ?></td>
                                <!-- Actions -->
                                <td>
                                    <!-- <a href="<!= base_url('/lookup/view/' . $row->id . '?t=' . time() ); ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a> -->
                                    <?php if (canAccessMenu('lookup_update', $this->session->userdata('user_role'))): ?>
                                        <a href="#" class="btn btn-sm btn-primary ml-1 btn-edit" data-id="<?= $row->id ?>"  data-toggle="modal" data-target="#editLookupModal" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (canAccessMenu('lookup_delete', $this->session->userdata('user_role'))): ?>
                                        <a href="<?= base_url('/lookup/delete/' . $row->id . '?t=' . time() . '&keyid=' . $row->keyid); ?>" class="btn btn-sm btn-danger ml-1 btn-delete" data-id="<?= $row->id ?>" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php endif; ?>


                                </td>
                                <!-- Actions -->

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Add Lookup Modal -->
    <div class="modal fade" id="addLookupModal" tabindex="-1" role="dialog" aria-labelledby="addLookupModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form action="/lookup/insert" method="post"> <!-- adjust URL as needed -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLookupModalLabel">
                            <i class="fas fa-plus-circle mr-2 text-primary"></i> Add Lookup Entry
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Example form fields -->
                        <input type="hidden" name="keyid" id="keyid">

                        <div class="form-group">
                            <label for="itemid">Item ID</label>
                            <input type="text" name="itemid" id="itemid" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                        </div>
                        <!-- Add more fields as needed -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Edit Lookup Modal -->
    <div class="modal fade" id="editLookupModal" tabindex="-1" role="dialog" aria-labelledby="editLookupModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <form action="/lookup/update" method="post">
                <input type="hidden" name="id" id="edit-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLookupModalLabel">
                            <i class="fas fa-edit mr-2 text-primary"></i> Edit Lookup Entry
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Example fields -->
                        <input type="hidden" name="keyid" id="edit-keyid">

                        <div class="form-group">
                            <label for="edit-itemid">Item ID</label>
                            <input type="text" name="itemid" id="edit-itemid" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-description">Description</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>




</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Check if jQuery is loaded
        if (typeof jQuery === "undefined") {
            console.error("jQuery is not loaded. DataTables requires jQuery.");
            return;
        }

        // Initialize DataTable if target table exists
        if ($('#dataTableHolder').length) {
            $('#dataTableHolder').DataTable({
                responsive: true, // ✅ enables responsive layout
                order: [],        // no initial ordering
                columnDefs: [{
                    targets: 'nosort',
                    orderable: false
                }]
            });
        } else {
            console.warn("#dataTableHolder table not found.");
        }

        //Add button event
        $('#btnAddLookup').on('click', function () {
            const selectedKeyId = $('#keyidFilter').val();

            if (!selectedKeyId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Key ID Required',
                    text: 'Please select a Key ID before adding a new lookup item.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            // Populate hidden keyid field in modal
            $('#keyid').val(selectedKeyId);

            // If selected, open the modal
            $('#addLookupModal').modal('show');
        });

        //Add change event of keyid filter
        const keyidFilter = document.getElementById("keyidFilter");
        keyidFilter.addEventListener("change", function () {
            const selectedValue = this.value;

            // Step 1: Call the session API to store keyid in session
            fetch('/sessionapi/set_bulk', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ keyid: selectedValue })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success === true) {
                    window.location.href = "/lookup/all?t=" + Date.now();
                } else {
                    alert("Failed to set session keyid. " + JSON.stringify(result));
                }
            })
            .catch(error => {
                console.error("Session API error:", error);
                alert("Error occurred while setting session.");
            });

            // Call your function or logic here
            //window.location.href = "/lookup/all?t=" + Date.now() + "&keyid=" + encodeURIComponent(selectedValue);

        });

        //Added click on delete button
        // document.querySelectorAll(".btn-delete").forEach(function (button) {
        //     button.addEventListener("click", function (e) {
        //         e.preventDefault(); // Stop default redirect

        //         const url = this.getAttribute("href");

        //         Swal.fire({
        //             title: 'Are you sure?',
        //             text: "This action cannot be undone.",
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#d33',
        //             cancelButtonColor: '#6c757d',
        //             confirmButtonText: 'Yes, delete it!'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 window.location.href = url;
        //             }
        //         });
        //     });
        // });

        // Added click on delete button with SweetAlert
        document.querySelectorAll(".btn-delete").forEach(function (button) {
            button.addEventListener("click", function (e) {
                e.preventDefault(); // Prevent default anchor behavior

                const url = this.getAttribute("href");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    heightAuto: false, // Fix layout issue on mobile
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary ml-2'
                    },
                    buttonsStyling: false // Let Bootstrap handle button styles
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

        document.querySelectorAll(".btn-edit").forEach(button => {
            button.addEventListener("click", function () {
                const id = this.dataset.id;

                // Use AJAX to get the data
                fetch(`/lookup/get/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("edit-id").value = data.id;
                        document.getElementById("edit-keyid").value = data.keyid;
                        document.getElementById("edit-itemid").value = data.itemid;
                        document.getElementById("edit-description").value = data.description;
                    })
                    .catch(error => {
                        console.error("Failed to load data for editing", error);
                    });
            });
        });



    });
</script>