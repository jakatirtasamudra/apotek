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
            <a href="<?= url('/homeadmin/kategori'); ?>">Kategori</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= url('/homeadmin/kategori/ubah/'.$id); ?>">Ubah</a>
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
        <form name="frmInput" action="<?= url('/homeadmin/kategori/ubah/simpan'); ?>" method="POST"
            enctype="multipart/form-data">
            <?= $csrf; ?>

            <input type="hidden" name="url" class="form-control" value="<?= url('/homeadmin/kategori/ubah/'.$id); ?>"
                required readonly>
            <input type="hidden" name="url_success" class="form-control" value="<?= url('/homeadmin/kategori'); ?>"
                required readonly>
            <input type="hidden" name="id" class="form-control" value="<?= $id; ?>" required readonly>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Nama Kategori
                        </label>
                        <input name="nama" class="form-control" type="text" autocomplete="off"
                            placeholder="Nama Kategori..." value="<?= $datas->nama; ?>" required="">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <a href="<?= url('/homeadmin/kategori'); ?>" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-success">Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>