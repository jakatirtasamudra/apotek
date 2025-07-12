<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= url('/logout'); ?>" method="POST" enctype="multipart/form-data">
                <?= $csrf; ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Informasi
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Aapkah kamu yakin untuk keluar dari aplikasi ?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Keluar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= assets(); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= assets(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= assets(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= assets(); ?>js/sb-admin-2.min.js"></script>
<script src="<?= assets(); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= assets(); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= assets(); ?>js/demo/datatables-demo.js"></script>

<script src="<?= assets(); ?>sweetalert/sweetalert.min.js"></script>
<script>
$(document).on('click', '.__session_alert_data', function(e) {
    e.preventDefault(); // Mencegah langsung redirect
    const __Slugs = $(this).attr('__slugs');
    const __Url = $(this).attr('__url');
    const __Icon = $(this).attr('__icon');
    const __Text = $(this).attr('__text');
    const __Btn = $(this).attr('__btn');

    swal({
        title: "Informasi",
        text: __Slugs,
        icon: __Icon,
        buttons: {
            confirm: {
                text: __Text,
                className: 'btn btn-' + __Btn + ' swal-button',
                style: 'display: block; margin: 0 auto;' // Tombol confirm rata tengah
            },
            cancel: {
                visible: true,
                text: "Batal",
                className: 'btn btn-warning swal-button',
                style: 'display: block; margin: 10px auto;' // Tombol batal rata tengah
            }
        },
        content: {
            element: 'div',
            attributes: {
                style: 'text-align: center;' // Menjadikan teks di dalam SweetAlert rata tengah
            }
        }
    }).then((Conf) => {
        if (Conf) {
            window.location.replace(__Url);
        } else {
            swal("Batal " + __Text + " Data!", {
                buttons: {
                    confirm: {
                        text: "Oke",
                        className: 'btn btn-success swal-button',
                        style: 'display: block; margin: 0 auto;' // Tombol rata tengah
                    }
                },
                content: {
                    element: 'div',
                    attributes: {
                        style: 'text-align: center;' // Menjadikan teks rata tengah di swal kedua
                    }
                }
            });
        }
    });
});
</script>

<?php if(isset($_SESSION['__Toast'])): ?>
<div class="position-fixed top-0 right-0 p-3" style="z-index: 9999; top: 1rem; right: 1rem;">
    <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
        <div class="toast-header">
            <img src="<?= __Aplikasi()['Logo']; ?>" class="rounded mr-2" alt="..." width="10%">
            <strong class="mr-auto text-primary">Informasi</strong>
            <small><?= date('d-m-Y, H:i') ?></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?= htmlspecialchars($_SESSION['__Toast']) ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#liveToast').toast('show');
});
</script>
<?php unset($_SESSION['__Toast']); ?>
<?php endif; ?>

</body>

</html>