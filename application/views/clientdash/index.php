<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/clientdash/help">Client Dashboard Help</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </div>


    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <div class="d-flex align-items-center">

                    <i class="fas fa-users text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary mr-3">User List</h6>

                </div>

            </div>

            <br>
            <div class="text-center">
                <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
                <h4 class="pt-3">Save your <b>imagination</b> On Blank Canvas!</h4>
            </div>

            <div class="table-responsive p-3">

                <table id="usersTable" class="table table-sm align-items-center table-flush table-hover display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                        </tr>
                    </thead>
                </table>

            </div>


        </div>
    </div>

</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#usersTable').DataTable({
            processing: true,
            serverSide: true, // ✅ enable server-side
            ajax: {
                url: "http://localhost:8340/jwtapi/query",
                type: "POST",
                contentType: "application/json",
                headers: {
                    "Authorization": "Bearer <?= $this->session->userdata('jwt_token'); ?>"
                },
                data: function (d) {
                    let payload = {
                        table: "users",
                        select: ["user_id", "name", "mobile"],
                        filters: { entityid: "_NA_" },
                        sort: { column: "user_id", direction: "asc" },
                        offset: d.start,
                        limit: d.length,
                        draw: d.draw // 👈 send draw back to server
                    };

                    if (d.search && d.search.value) {
                        payload.search = d.search.value; // 👈 only add if not empty
                    }

                    return JSON.stringify(payload);
                },
                dataSrc: "data"
            },
            columns: [
                { data: "user_id" },
                { data: "name" },
                { data: "mobile" }
            ]
        });
    });
</script>
