<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('assets/img/logo/logo2.png') . '?v=' . time(); ?>" alt="Logo">
        </div>
        <div class="sidebar-brand-text mx-3"><?= $this->config->item('appname'); ?></div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>


    <!-- <!php if (roleBelongsTo($this->session->userdata('user_role'), 'admin-group')): ?> -->

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Main Menu
    </div>

    <?php if (roleBelongsTo($this->session->userdata('user_role'), 'support-group')): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('user/all'); ?>">
                <i class="fas fa-fw fa-user"></i>
                <span>Manage Users</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (roleBelongsTo($this->session->userdata('user_role'), 'support-group')): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('lookup/all'); ?>">
                <i class="fas fa-fw fa-table"></i>
                <span>Manage Lookup</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (roleBelongsTo($this->session->userdata('user_role'), 'user-group')): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('settings/edit'); ?>">
                <i class="fas fa-fw fa-table"></i>
                <span>Manage Settings</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if (roleBelongsTo($this->session->userdata('user_role'), 'user-group')): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('pagetest/all'); ?>">
                <i class="fab fa-fw fa-wpforms"></i>
                <span>Page Test</span>
            </a>
        </li>
    <?php endif; ?>
    
    <?php if (roleBelongsTo($this->session->userdata('user_role'), 'user-group')): ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('pagetest/all'); ?>">
                <i class="fab fa-fw fa-wpforms"></i>
                <span>Page Test</span>
            </a>
        </li>
    <?php endif; ?>

    <!-- <!php endif; ?> -->


    <!-- Sample Pages -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        AdminLTE Sample Pages
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true" aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>Bootstrap UI</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Bootstrap UI</h6>
                <a class="collapse-item" href="<?= base_url('element/alert'); ?>">Alerts</a>
                <a class="collapse-item" href="<?= base_url('element/button'); ?>">Buttons</a>
                <a class="collapse-item" href="<?= base_url('element/dropdown'); ?>">Dropdowns</a>
                <a class="collapse-item" href="<?= base_url('element/modal'); ?>">Modals</a>
                <a class="collapse-item" href="<?= base_url('element/popovers'); ?>">Popovers</a>
                <a class="collapse-item" href="<?= base_url('element/progressbar'); ?>">Progress Bars</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('element/form'); ?>">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Forms</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tables</h6>
                <a class="collapse-item" href="<?= base_url('element/simpletable'); ?>">Simple Tables</a>
                <a class="collapse-item" href="<?= base_url('element/datatable'); ?>">DataTables</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('element/uicolors'); ?>">
            <i class="fas fa-fw fa-palette"></i>
            <span>UI Colors</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Examples
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
            <i class="fas fa-fw fa-columns"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Example Pages</h6>
                <a class="collapse-item" href="<?= base_url('element/login'); ?>">Login</a>
                <a class="collapse-item" href="<?= base_url('element/register'); ?>">Register</a>
                <a class="collapse-item" href="<?= base_url('element/error_page'); ?>">404 Page</a>
                <a class="collapse-item" href="<?= base_url('element/blank'); ?>">Blank Page</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('element/charts'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-cgone">
        Version <?= $this->config->item('appversion'); ?>
    </div>
</ul>
<!-- Sidebar -->