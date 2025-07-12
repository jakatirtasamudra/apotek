<h1 class="h3 mb-2 text-gray-800">
    Transaksi
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
            <a href="<?= url('/homeadmin/konsumen'); ?>">Konsumen</a>
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
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = '1'; 
                        foreach($datas as $rows) { 
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
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>