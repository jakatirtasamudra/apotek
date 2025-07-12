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
                    <tr>
                        <th></th>
                        <th>Nomor</th>
                        <th>Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $debet = '0'; 
                        $kredit = '0'; 
                        $no = 1; 
                        foreach ($data as $row) { 
                            $debet += $row->debet;
                            $kredit += $row->kredit;
                    ?>
                        <tr>
                            <td>
                                <a href="<?= url('/homeadmin/kas/'.$row->id) ?>" class="btn btn-sm btn-success">
                                    Ubah
                                </a>
                                <a href="#" class="btn btn-sm btn-danger __session_alert_data" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" title="Hapus"
                                    __slugs="Apakah Yakin Untuk Hapus Data <?= $rows->keterangan; ?> Ini ?"
                                    __url="<?= url('/homeadmin/kas/hapus/'.$row->id); ?>" __icon="warning" __text="Hapus"
                                    __btn="danger">
                                    Hapus
                                </a>
                            </td>
                            <td><?= $no++ ?></td>
                            <td><?= $row->keterangan ?></td>
                            <td><?= $row->debet ?></td>
                            <td><?= $row->kredit ?></td>
                            <td><?= $row->tgl ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th><?= $debet; ?></th>
                        <th><?= $kredit; ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="__modal_tambah__" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form name="frmInput" action="<?= url('/homeadmin/kas/simpan'); ?>" method="POST"
                enctype="multipart/form-data">
                <?= $csrf; ?>

                <input type="hidden" name="url" class="form-control" value="<?= url('/homeadmin/kas'); ?>" required
                    readonly>
                <input type="hidden" name="url_success" class="form-control" value="<?= url('/homeadmin/kas'); ?>"
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
                                    Keterangan
                                </label>
                                <input name="keterangan" class="form-control" type="text" autocomplete="off"
                                    placeholder="Keterangan..." value="<?= $helpers->old('keterangan'); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Tanggal
                                </label>
                                <input name="tanggal" class="form-control" type="date" autocomplete="off"
                                    placeholder="Tanggal..." value="<?= $helpers->old('tanggal'); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Nominal
                                </label>
                                <input name="nominal" class="form-control" type="number" autocomplete="off"
                                    placeholder="Nominal..." value="<?= $helpers->old('nominal'); ?>" required="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-3">
                                <label>
                                    Status
                                </label>
                                <select name="status" class="form-control" required="">
                                    <option selected disabled>--- Pilih ---</option>
                                    <?php 
                                        // foreach($status as $stat) {
                                        //     echo "<option value='".$stat."'>".$stat."</option>";
                                        // }
                                    ?>
                                    <!-- <option disabled>--- ### ---</option> -->
                                    <option value="debet">debet</option>
                                    <option value="kredit">kredit</option>
                                </select>
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