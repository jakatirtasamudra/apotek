<h1 class="h3 mb-2 text-gray-800">
    Obat
</h1>
<p class="mb-4">
    Menampilkan keseluruhan data.
</p>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= url('/homeadmin'); ?>">Beranda</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= url('/homeadmin/stok'); ?>">Stok</a>
        </li>
    </ol>
</nav>

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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#__modal_tambah__">
            Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th></th>
                        <th>Nomor</th>
                        <th>Obat</th>
                        <th>Kategori</th>
                        <th>Expired</th>
                        <th>Jumlah</th>
                        <th>Harga Beli/Pcs</th>
                        <th>Harga Jual/Pcs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = '1'; 
                        foreach($datas as $rows) { 
                    ?>
                    <tr class="text-center">
                        <td>
                            <a href="#" class="btn btn-sm btn-danger __session_alert_data" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Hapus"
                                __slugs="Apakah Yakin Untuk Hapus Data <?= $rows->nama; ?> Ini ?"
                                __url="<?= url('/homeadmin/stok/hapus/'.$rows->id); ?>" __icon="warning" __text="Hapus"
                                __btn="danger">
                                <i class="fas fa-fw fa-trash"></i>
                            </a>
                        </td>
                        <td>
                            <?= $nomor++; ?>
                        </td>
                        <td>
                            <a href="<?= url('/homeadmin/stok/ubah/'.$rows->id); ?>">
                                <?= $rows->nama; ?>
                            </a>
                        </td>
                        <td>
                            <?= $rows->kategori; ?>
                        </td>
                        <td>
                            <?= $rows->exp; ?>
                        </td>
                        <td>
                            <?= $rows->jumlah; ?>
                        </td>
                        <td>
                            Rp. <?= $helpers->Uang($rows->beli); ?>
                        </td>
                        <td>
                            Rp. <?= $helpers->Uang($rows->jual); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="__modal_tambah__" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form name="frmInput" action="<?= url('/homeadmin/stok/simpan'); ?>" method="POST"
                enctype="multipart/form-data">
                <?= $csrf; ?>

                <input type="hidden" name="url" class="form-control" value="<?= url('/homeadmin/stok'); ?>" required
                    readonly>
                <input type="hidden" name="url_success" class="form-control" value="<?= url('/homeadmin/stok'); ?>"
                    required readonly>

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Informasi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Nama Obat
                                </label>
                                <input name="nama" class="form-control" type="text" autocomplete="off"
                                    placeholder="Nama Obat..." value="<?= $helpers->old('nama'); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Jumlah
                                </label>
                                <input name="jumlah" class="form-control" type="text" autocomplete="off"
                                    placeholder="Jumlah..." value="<?= $helpers->old('jumlah'); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Expired
                                </label>
                                <input name="exp" class="form-control" type="date" autocomplete="off"
                                    placeholder="Expired..."
                                    value="<?= htmlspecialchars($helpers->old('exp') ?: date('Y-m-d')); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Kategori
                                </label>
                                <select name="kategori" class="form-control" required="">
                                    <option value="" selected disabled>- Pilih -</option>
                                    <?php 
                                        foreach($kategoris as $kategori) { 
                                            echo "<option value='".$kategori->nama."'>".$kategori->nama."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Harga Beli/Pcs
                                </label>
                                <input name="beli" class="form-control" type="number" autocomplete="off"
                                    placeholder="Harga Beli/Pcs..." value="<?= $helpers->old('beli'); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Harga Jual/Pcs
                                </label>
                                <input name="jual" class="form-control" type="number" autocomplete="off"
                                    placeholder="Harga Jual/Pcs..." value="<?= $helpers->old('jual'); ?>" required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>