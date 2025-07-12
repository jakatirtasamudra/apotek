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
            <a href="<?= url('/homeadmin/keuangan'); ?>">Keuangan</a>
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
        <form name="frmInput" action="<?= url('/homeadmin/keuangan'); ?>" method="POST" enctype="multipart/form-data">
            <?= $csrf; ?>
            <div class="row mb-lg-4">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Tanggal Mulai
                        </label>
                        <input name="tgl1" class="form-control" type="date" autocomplete="off"
                            placeholder="Tanggal Mulai"
                            value="<?= htmlspecialchars($_POST['tgl1'] ?: date('Y-m-d')); ?>" required="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label>
                            Tanggal Selesai
                        </label>
                        <input name="tgl2" class="form-control" type="date" autocomplete="off"
                            placeholder="Tanggal Selesai"
                            value="<?= htmlspecialchars($_POST['tgl2'] ?: date('Y-m-d')); ?>" required="">
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>
        <?php //if (!$_POST['tgl1'] && !$_POST['tgl2']) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Obat</th>
                        <th>Jumlah</th>
                        <th>harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $penjualan = '0';
                        $nomor = '1';
                        foreach($datas as $rows) { 
                            $__obats__ = $query
                                ->table('tbl_obat')
                                ->select('id_obat AS id, kategori, nama_obat AS nama, jumlah_obat AS jumlah, exp_obat AS exp, beli_obat AS beli, jual_obat AS jual')
                                ->where('id_obat', '=', $rows->id_obat)
                                ->orderBy('id_obat', 'DESC')
                                ->first(); 
                            $totals = '0'; 
                            $totals += $rows->jumlah * $rows->harga;
                            $penjualan += $totals;
                    ?>
                    <tr class="text-center">
                        <td>
                            <?= $nomor++; ?>
                        </td>
                        <td>
                            <?= $__obats__->nama; ?>
                        </td>
                        <td>
                            <?= $rows->jumlah; ?>
                        </td>
                        <td>
                            Rp. <?= $helpers->Uang($rows->harga); ?>
                        </td>
                        <td>
                            Rp. <?= $helpers->Uang($totals); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th colspan="4">Total Penjualan</th>
                        <th>Rp. <?= $helpers->Uang($penjualan); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php //} ?>
    </div>
</div>