</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?= date('Y'); ?> - <b><?= $this->config->item('appcopyright'); ?></b> | Entity: <b><?= $this->session->userdata('user_entity'); ?></b> | Role: <b><?= $this->session->userdata('user_role'); ?></b></span>
            </span>
        </div>
    </div>
</footer>
<!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/jszip/jszip.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/pdfmake/vfs_fonts.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.print.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/buttons.html5.min.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/cg-admin.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/demo/chart-area-demo.js"></script>
<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/chart-pie-demo.js"></script>
<script src="<?= base_url('assets/'); ?>js/demo/chart-bar-demo.js"></script>

<!-- App-wide scripts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {

        //Logout button
        document.querySelectorAll('.logout-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const logoutUrl = this.getAttribute('data-href');

                Swal.fire({
                    title: 'Logout?',
                    text: 'You are about to be signed out.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Yes, logout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = logoutUrl;
                    }
                });
            });
        });
        
        //Display flash and clear message
        <?php if ($this->session->flashdata('success')): ?>
            let message = <?= json_encode($this->session->flashdata('success')); ?>;
            sessionStorage.setItem("flashdata", JSON.stringify({type: "success", message: message}));
        <?php elseif ($this->session->flashdata('error')): ?>
            let message = <?= json_encode($this->session->flashdata('error')); ?>;
            sessionStorage.setItem("flashdata", JSON.stringify({type: "error", message: message}));
        <?php elseif ($this->session->flashdata('warning')): ?>
            let message = <?= json_encode($this->session->flashdata('warning')); ?>;
            sessionStorage.setItem("flashdata", JSON.stringify({type: "warning", message: message}));
        <?php endif; ?>

        // Check and show alert if flashdata exists
        const data = sessionStorage.getItem("flashdata");
        if (data) {
            const flash = JSON.parse(data);
            Swal.fire({
                icon: flash.type,
                title: flash.type.charAt(0).toUpperCase() + flash.type.slice(1) + '!',
                text: flash.message,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            });
            sessionStorage.removeItem("flashdata"); // clear flashdata so it doesn't show again
        }




    });
</script>
<!-- App-wide scripts -->

</body>

</html>