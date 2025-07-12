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
            <a href="<?= url('/homeadmin/penjualan'); ?>">Penjualan</a>
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
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Nomor Hp</th>
                        <th>Obat</th>
                        <th>Jumlah</th>
                        <th>harga</th>
                        <th>Total</th>
                        <th>Tgl Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
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
                    ?>
                    <tr class="text-center">
                        <td>
                            <?= $nomor++; ?>
                        </td>
                        <td>
                            <?= $rows->nama; ?>
                        </td>
                        <td>
                            <?= $rows->hp; ?>
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
                        <td>
                            <?php
                                if ($rows->bayar == '1') {
                                    echo $rows->tglbayar;
                                } else {
                                    echo '<span class="badge badge-danger">Belum Bayar</span>';
                                }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>