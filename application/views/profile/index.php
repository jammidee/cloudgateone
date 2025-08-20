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
 * CREATED DATE : July 06, 2025
 * ------------------------------------------------------------------------
 */

?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/profile/edit">Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </div>

    <div class="text-center">
        <!-- Centered title and icon -->
        <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3"><b>Profile Module</b></h4>
    </div>

    <!-- Left-aligned explanatory content -->
    <div class="px-4 pt-3">
        <p>
            The Profile page allows users to view and manage their personal information within the system.
            This includes details such as name, email, mobile number, location, and other user-specific settings relevant to their account.
        </p>

        <p>
            Keeping your profile up to date ensures smoother communication, accurate records, and a more personalized experience within the application.
            Users are encouraged to maintain current contact details and credentials to avoid issues with access, notifications, or services.
        </p>

        <p>
            Any changes made on this page will be saved to your account record and may be used by other modules or workflows within the system that rely on user-specific data.
        </p>

        <p>
            Use the <b>Update</b> button to save changes. Be sure to review your details carefully before submitting to ensure accuracy and completeness.
        </p>
    </div>



</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Put your customized page scripts

    });
</script>