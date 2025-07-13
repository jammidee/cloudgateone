<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/user/index">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">All</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">User List</h6>

                <!-- Add Button -->
                <a href="<?= base_url('user/add'); ?>" class="btn btn-sm btn-primary" id="btnAddUser">
                    <i class="fas fa-plus mr-1"></i> Add User
                </a>


            </div>
            <div class="table-responsive p-3">

                <!-- <form method="get" class="form-inline mb-3">
                    <label class="mr-2">Show</label>
                    <select name="limit" class="form-control mr-2" onchange="this.form.submit()">
                        <option <!= $limit == 5 ? 'selected' : '' ?>>5</option>
                        <option <!= $limit == 10 ? 'selected' : '' ?>>10</option>
                        <option <!= $limit == 25 ? 'selected' : '' ?>>25</option>
                        <option <!= $limit == 50 ? 'selected' : '' ?>>50</option>
                    </select>
                    <span>entries</span>
                </form> -->

                <table class="table table-sm align-items-center table-flush table-hover display nowrap" id="dataTableHolder" style="width:100%" >
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 20%;">Position</th>
                            <th style="width: 15%;">UserID</th>
                            <th style="width: 15%;">Mobile</th>
                            <th style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>UserID</th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php $i = 0; foreach ($users as $row) { $i++; ?>
                            <tr>
                                <td class=" "><?php echo $row->id; ?></td>
                                <td class=" "><?php echo $row->name; ?></td>
                                <td class=" "><?php echo $row->role; ?></td>
                                <td class=" "><?php echo $row->user_id; ?></td>
                                <td class=" "><?php echo $row->mobile; ?></td>

                                <!-- Actions -->
                                <td>
                                    <a href="<?= base_url('/user/view/' . $row->id . '?t=' . time() ); ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('/user/edit/' . $row->id . '?t=' . time() ); ?>" class="btn btn-sm btn-primary ml-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('/user/delete/' . $row->id . '?t=' . time() ); ?>" class="btn btn-sm btn-danger ml-1" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                                <!-- Actions -->

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <!-- <div class="mt-3 text-right">
                    <!= $pagination_links; ?>
                </div> -->

            </div>
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


    });
</script>