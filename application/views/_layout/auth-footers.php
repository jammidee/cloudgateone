<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/cg-admin.js"></script>

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