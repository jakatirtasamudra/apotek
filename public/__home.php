<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        <?= __Aplikasi()['Aplikasi']; ?>
    </title>

    <link rel="shortcut icon" href="<?= __Aplikasi()['Logo']; ?>">
    <link href="<?= assets(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?= assets(); ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">
        <ul class="navbar-nav">
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Pesan Obat</span>
                                <img class="img-profile rounded-circle" src="<?= __Aplikasi()['Logo']; ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= url('/login') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Login
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <?php if (isset($pembeli) && $pembeli == TRUE) { ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h4 mb-0 text-gray-800">
                            Selamat Memilih Obat,
                            <strong><?= $_SESSION['beli']['nama']; ?>!</strong>
                        </h1>
                    </div>
                    <hr>
                    <h5>Daftar Belanja</h5>
                    <div id="list-belanja" style="max-height:500px; overflow-y:auto;"></div>
                    <br>
                    <button class="btn btn-success btn-block __btnBayar">Bayar</button>
                    <hr>
                    <div class="form-group">
                        <select class="form-control" id="filter-kategori">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategori_list as $kategori) { ?>
                            <option value="<?= $kategori->kategori; ?>"><?= $kategori->kategori; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row" style="max-height:1000px; overflow-y:auto;" id="dataObat"></div>
                </div>
                <?php } else { ?>
                <div class="container">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($errors = $helpers->error()): ?>
                                    <?php foreach ((array) $errors as $error): ?>
                                    <div class="alert alert-danger text-center" role="alert">
                                        <?= htmlspecialchars($error) ?>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if ($errors = $helpers->allerror()) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                            <li><?= htmlspecialchars($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <?php } ?>

                                    <center>
                                        <small class="mb-lg-2 text-center">
                                            Silahkan Masukkan Nomor Handphone Aktif <br> dan Nama Lengkap
                                        </small>
                                    </center>
                                    <br>
                                    <form action="<?= url('/beli'); ?>" method="POST" enctype="multipart/form-data">
                                        <?= $csrf; ?>
                                        <div class="form-group">
                                            <input type="text" name="hp" class="form-control form-control-user"
                                                placeholder="Nomor Handphone Aktif..." required="" autofocus
                                                autocomplete="off" value="<?= $helpers->old('hp'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="nama" class="form-control form-control-user"
                                                placeholder="Nama Lengkap Anda..." required="" autocomplete="off"
                                                value="<?= $helpers->old('nama'); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Pesan Obat
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-3"></div>
                        </div>
                    </div>
                </div>
                <br>
                <?php } ?>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="<?= assets(); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= assets(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= assets(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= assets(); ?>js/sb-admin-2.min.js"></script>
    <script src="<?= assets(); ?>sweetalert/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
        $(document).on('click', '.__btnBayar', function(e) {
            e.preventDefault();

            swal({
                title: "Informasi",
                text: "Apakah Anda yakin ingin menyelesaikan pembayaran?",
                icon: "warning",
                buttons: {
                    confirm: {
                        text: 'Konfirmasi Pembayaran',
                        className: 'btn btn-success swal-button',
                        style: 'display: block; margin: 0 auto;'
                    },
                    cancel: {
                        visible: true,
                        text: "Batal",
                        className: 'btn btn-warning swal-button',
                        style: 'display: block; margin: 10px auto;'
                    }
                }
            }).then((Conf) => {
                if (Conf) {
                    $.ajax({
                        url: "<?= __Base_Url() . 'public/__home_bayar.php'; ?>",
                        method: "POST",
                        data: {
                            aksi: 'bayar',
                            hp: '<?= $pembeli->hp; ?>'
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.status === 'success') {
                                swal("Berhasil!", "Pembayaran berhasil disimpan.",
                                        "success")
                                    .then(() => {
                                        window.location.href =
                                            "<?= url('/'); ?>";
                                    });
                            } else {
                                swal("Gagal", "Terjadi kesalahan saat menyimpan.",
                                    "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                            swal("Error", "Gagal terhubung ke server.", "error");
                        }
                    });
                } else {
                    swal("Batal", "Pembayaran dibatalkan.", "info");
                }
            });
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hp = '<?= $pembeli->hp; ?>';

        // Fungsi untuk memuat daftar belanja dari AJAX
        function loadBelanja() {
            $.ajax({
                url: "<?= __Base_Url() . 'public/__home_beli.php'; ?>",
                type: "POST",
                data: {
                    hp: hp,
                    load_data: '1',
                },
                success: function(res) {
                    loadBelanja();
                    $('#list-belanja').html(res);

                    $('.jumlah-beli').val(0);
                    try {
                        // Ubah string HTML menjadi DOM agar bisa diakses
                        const tempDom = $('<div>').html(res);
                        const dataJson = tempDom.find('#data-transaksi-json').val() || '[]';
                        const data = JSON.parse(dataJson);

                        data.forEach(item => {
                            // Update jumlah beli di input
                            $('#jumlah_' + item.id_obat).val(item.jumlah);

                            // Update stok sisa yang ditampilkan
                            const stokEl = $('#stok_' + item.id_obat);
                            const stokAsli = parseInt(stokEl.data('stok')) || 0;
                            const stokSisa = stokAsli - item.jumlah;
                            stokEl.text(`(Stok ${stokSisa})`);
                        });
                    } catch (e) {
                        console.warn('Gagal memuat data transaksi:', e);
                    }
                },
                error: function(err) {
                    console.error('Gagal load data belanja:', err);
                }
            });
        }

        // Panggil pertama kali saat halaman dimuat
        loadBelanja();

        // Event tombol + dan -
        $(document).on('click', '.btn-plus, .btn-minus', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const harga = $(this).data('harga');
            const stok = $(this).data('stok') ?? 9999;
            const input = $('#jumlah_' + id);
            let jumlah = parseInt(input.val());

            if ($(this).hasClass('btn-plus') && jumlah < stok) jumlah++;
            if ($(this).hasClass('btn-minus') && jumlah > 0) jumlah--;

            input.val(jumlah);

            $.ajax({
                url: "<?= __Base_Url() . 'public/__home_beli.php'; ?>",
                type: "POST",
                data: {
                    hp: hp,
                    id_obat: id,
                    jumlah: jumlah,
                    harga: harga
                },
                success: function(res) {
                    loadBelanja();
                    $('#list-belanja').html(res);

                    $('.jumlah-beli').val(0);
                    try {
                        const data = JSON.parse($(res).filter('#data-transaksi-json')
                            .val() || '[]');
                        data.forEach(item => {
                            $('#jumlah_' + item.id_obat).val(item.jumlah);

                            const stokEl = $('#stok_' + item.id_obat);
                            const stokAsli = parseInt(stokEl.data('stok')) || 0;
                            const stokSisa = stokAsli - item.jumlah;
                            stokEl.text(`(Stok ${stokSisa})`);
                        });
                    } catch (e) {
                        console.warn('Gagal memuat data transaksi');
                    }
                }
            });
        });

        $(document).ready(function() {
            // Load data obat awal
            loadObat();
            // Filter kategori
            $('#filter-kategori').on('change', function() {
                const kategori = $(this).val();
                loadObat(kategori);
            });

            function loadObat(kategori = '') {
                $.ajax({
                    url: "<?= __Base_Url() . 'public/__home_filter.php'; ?>",
                    type: 'POST',
                    data: {
                        kategori_id: kategori
                    },
                    success: function(res) {
                        loadBelanja();
                        $('#dataObat').html(res);
                    },
                    error: function() {
                        $('#dataObat').html(
                            '<div class="col-12"><div class="alert alert-danger">Gagal memuat data.</div></div>'
                        );
                    }
                });
            }
        });
    });
    </script>

</body>

</html>