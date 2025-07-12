<h1 class="h3 mb-2 text-gray-800">
    Kas
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
            <a href="<?= url('/homeadmin/kas'); ?>">Kas</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= url('/homeadmin/kas/'.$id); ?>">Ubah</a>
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
        <a href="<?= url('/homeadmin/kas') ?>" class="btn btn-danger">
            Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <form action="<?= url('/homeadmin/kas/ubahsimpan') ?>" method="POST" enctype="multipart/form-data">
                    <?= $csrf ?>
                    <input type="hidden" name="id" value="<?= $id ?>" required readonly>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Keterangan
                                </label>
                                <input name="keterangan" class="form-control" type="text" autocomplete="off"
                                    placeholder="Keterangan..." value="<?= $data->keterangan; ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Tanggal
                                </label>
                                <input name="tanggal" class="form-control" type="date" autocomplete="off"
                                    placeholder="Tanggal..." value="<?= $data->tgl; ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Nominal
                                </label>
                                <input name="nominal" class="form-control" type="number" autocomplete="off"
                                    placeholder="Nominal..." value="<?= $data->nominal; ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Status
                                </label>
                                <select name="status" class="form-control" required="">
                                    <?php
                                        if (isset($data->debet) && $data->debet == TRUE) {
                                            echo "<option value='debet'>debet</option>";
                                        } else {
                                            echo "<option value='kredit'>kredit</option>";
                                        }
                                    ?>
                                    <option disabled>--- ### ---</option>
                                    <option value="debet">debet</option>
                                    <option value="kredit">kredit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-success btn-sm btn-block">
                                Ubah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
