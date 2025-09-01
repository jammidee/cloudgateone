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
 * CREATED DATE : August 31, 2025
 * ------------------------------------------------------------------------
 */

?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/configdb/system">Configdb</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </div>

    <div class="col-lg-12">
        <div class="card mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary mr-3 text-nowrap">Database</h6>
                </div>
            </div>

            <div class="text-center">
                <!-- Centered title and icon -->
                <img src="<?= base_url('assets/'); ?>img/config.svg" style="max-height: 90px">
                <h4 class="pt-3"><b>Configuration Database Module</b></h4>
            </div>
            
            <!-- Table of DB Actions -->
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <td style="width:200px;">
                                <a href="<?= base_url('configdb/initialize') ?>" class="btn btn-primary btn-block">Initialize DB</a>
                            </td>
                            <td>Creates the SQLite database file and initializes tables if not present.</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?= base_url('configdb/reset') ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure? This will erase all data!')">Reset DB</a>
                            </td>
                            <td>Resets the database by dropping and recreating tables (dangerous operation).</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?= base_url('configdb/backup') ?>" class="btn btn-success btn-block">Backup DB</a>
                            </td>
                            <td>Creates a backup copy of the current SQLite database file.</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?= base_url('configdb/optimize') ?>" class="btn btn-warning btn-block">Optimize DB</a>
                            </td>
                            <td>Runs `VACUUM` and `ANALYZE` on the SQLite database to optimize performance.</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="<?= base_url('configdb/create_lab_table') ?>" class="btn btn-warning btn-block">Create Lab Table</a>
                            </td>
                            <td>Runs a script to create the laboratory table in the database.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Put your customized page scripts
    });
</script>
