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
        <li class="breadcrumb-item">
            <a href="<?= url('/homeadmin/stok/ubah/'.$id); ?>">Ubah</a>
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
    <div class="card-body">
        <form name="frmInput" action="<?= url('/homeadmin/stok/ubah/simpan'); ?>" method="POST"
            enctype="multipart/form-data">
            <?= $csrf; ?>

            <input type="hidden" name="url" class="form-control" value="<?= url('/homeadmin/stok/ubah/'.$id); ?>"
                required readonly>
            <input type="hidden" name="url_success" class="form-control" value="<?= url('/homeadmin/stok'); ?>" required
                readonly>
            <input type="hidden" name="id" class="form-control" value="<?= $id; ?>" required readonly>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Nama Obat
                        </label>
                        <input name="nama" class="form-control" type="text" autocomplete="off"
                            placeholder="Nama Obat..." value="<?= $datas->nama; ?>" required="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Jumlah
                        </label>
                        <input name="jumlah" class="form-control" type="text" autocomplete="off" placeholder="Jumlah..."
                            value="<?= $datas->jumlah; ?>" required="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Expired
                        </label>
                        <input name="exp" class="form-control" type="date" autocomplete="off" placeholder="Expired..."
                            value="<?= htmlspecialchars($datas->exp) ?: date('Y-m-d'); ?>" required="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Kategori
                        </label>
                        <select name="kategori" class="form-control" required="">
                            <option value="<?= $datas->kategori; ?>" selected><?= $datas->kategori; ?></option>
                            <option value="" disabled>-- ### --</option>
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
                            placeholder="Harga Beli/Pcs..." value="<?= $datas->beli; ?>" required="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Harga Jual/Pcs
                        </label>
                        <input name="jual" class="form-control" type="number" autocomplete="off"
                            placeholder="Harga Jual/Pcs..." value="<?= $datas->jual; ?>" required="">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <a href="<?= url('/homeadmin/stok'); ?>" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>