<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/lookup/all">Lookup</a></li>
            <li class="breadcrumb-item active" aria-current="page">Index</li>
        </ol>
    </div>

    <div class="text-center">
        <!-- Centered title and icon -->
        <img src="<?= base_url('assets/'); ?>img/think.svg" style="max-height: 90px">
        <h4 class="pt-3"><b>Lookup Module</b></h4>
    </div>

    <!-- Left-aligned explanatory content -->
    <div class="px-4 pt-3">
        <p>
            The Lookup Module serves as a centralized configuration tool for managing reference or master data across the application.
            It provides a flexible and dynamic way to store commonly used lists or values that are needed by other modules, such as dropdown selections, category options, or configuration items.
        </p>
        
        <p>
            Instead of hardcoding static values or duplicating data across modules, this system allows administrators to define and maintain them in one place. 
            This ensures consistency, minimizes data maintenance overhead, and improves the adaptability of the application to changes in business requirements.
        </p>

        <p>
            Each lookup item is organized under a <b>Key ID</b>, which groups related values together (e.g., types of statuses, classifications, codes, etc.).
            Selecting a Key ID from the filter dropdown will display all lookup entries associated with that category.
        </p>

        <p>
            Use the <b>Add</b> button to register a new entry under a specific Key ID. These entries can then be consumed by forms, workflows, validations, or business logic within other modules, enabling a more modular and scalable system.
        </p>
    </div>


</div>
<!---Container Fluid-->

<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Put your customized page scripts

    });
</script>