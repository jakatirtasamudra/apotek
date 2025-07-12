<h1 class="h3 mb-2 text-gray-800">
    Metode
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
            <a href="<?= url('/homeadmin/moora'); ?>">Moora</a>
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
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Kriteria</th>
                        <th>Bobot</th>
                        <th>Tipe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = '1'; 
                        foreach($kriteria as $kriteria_index => $kriteria_data) { 
                            $bobot += $kriteria_data['bobot'];
                    ?>
                    <tr class="text-center">
                        <td>
                            <?= $kriteria_index; ?>
                        </td>
                        <td>
                            <?= $kriteria_data['bobot']; ?>
                        </td>
                        <td>
                            <?= $kriteria_data['tipe']; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th>T O T A L</th>
                        <th><?= $bobot; ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <h5>NORMALISASI MATRIKS (MOORA)</h5>
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                        <th>C5</th>
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
                            <?= $rows['nama']; ?>
                        </td>
                        <td>
                            <?= $rows['c1']; ?>
                        </td>
                        <td>
                            <?= $rows['c2']; ?>
                        </td>
                        <td>
                            <?= $rows['c3']; ?>
                        </td>
                        <td>
                            <?= $rows['c4']; ?>
                        </td>
                        <td>
                            <?= $rows['c5']; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr>
            <h5>PANGKAT MATRIKS (MOORA)</h5>
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                        <th>C5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = '1'; 
                        foreach($datas as $rows) { 
                            $pangkat_c1 = $rows['c1'] ** 2;
                            $pangkat_c2 = $rows['c2'] ** 2;
                            $pangkat_c3 = $rows['c3'] ** 2;
                            $pangkat_c4 = $rows['c4'] ** 2;
                            $pangkat_c5 = $rows['c5'] ** 2;

                            $total_pangkat_c1 += $pangkat_c1;
                            $total_pangkat_c2 += $pangkat_c2;
                            $total_pangkat_c3 += $pangkat_c3;
                            $total_pangkat_c4 += $pangkat_c4;
                            $total_pangkat_c5 += $pangkat_c5;
                    ?>
                    <tr class="text-center">
                        <td>
                            <?= $nomor++; ?>
                        </td>
                        <td>
                            <?= $rows['nama']; ?>
                        </td>
                        <td>
                            <?= $pangkat_c1; ?>
                        </td>
                        <td>
                            <?= $pangkat_c2; ?>
                        </td>
                        <td>
                            <?= $pangkat_c3; ?>
                        </td>
                        <td>
                            <?= $pangkat_c4; ?>
                        </td>
                        <td>
                            <?= $pangkat_c5; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th colspan="2">T O T A L</th>
                        <th><?= $total_pangkat_c1; ?></th>
                        <th><?= $total_pangkat_c2; ?></th>
                        <th><?= $total_pangkat_c3; ?></th>
                        <th><?= $total_pangkat_c4; ?></th>
                        <th><?= $total_pangkat_c5; ?></th>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <h5>NORMALISASI X<sub>ij</sub> (MOORA)</h5>
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>C1</th>
                        <th>C2</th>
                        <th>C3</th>
                        <th>C4</th>
                        <th>C5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = 1; 
                        foreach($datas as $rows) {
                            $x1 = $rows['c1'] / sqrt($total_pangkat_c1);
                            $x2 = $rows['c2'] / sqrt($total_pangkat_c2);
                            $x3 = $rows['c3'] / sqrt($total_pangkat_c3);
                            $x4 = $rows['c4'] / sqrt($total_pangkat_c4);
                            $x5 = $rows['c5'] / sqrt($total_pangkat_c5);
                    ?>
                    <tr class="text-center">
                        <td><?= $nomor++; ?></td>
                        <td><?= $rows['nama']; ?></td>
                        <td><?= round($x1, 4); ?></td>
                        <td><?= round($x2, 4); ?></td>
                        <td><?= round($x3, 4); ?></td>
                        <td><?= round($x4, 4); ?></td>
                        <td><?= round($x5, 4); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <hr>
            <h5>Y<sub>ij</sub> = x<sub>ij</sub> × bobot | Y<sub>i</sub> = ∑ benefit − ∑ cost</h5>
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>y1 (COST)</th>
                        <th>y2 (BENEFIT)</th>
                        <th>y3 (BENEFIT)</th>
                        <th>y4 (BENEFIT)</th>
                        <th>y5 (BENEFIT)</th>
                        <th>Y<sub>i</sub></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor = 1; 
                        foreach($datas as $rows) {
                            // Normalisasi x_ij
                            $x1 = $rows['c1'] / sqrt($total_pangkat_c1); // COST
                            $x2 = $rows['c2'] / sqrt($total_pangkat_c2); // BENEFIT
                            $x3 = $rows['c3'] / sqrt($total_pangkat_c3); // BENEFIT
                            $x4 = $rows['c4'] / sqrt($total_pangkat_c4); // BENEFIT
                            $x5 = $rows['c5'] / sqrt($total_pangkat_c5); // BENEFIT

                            // Bobot sesuai kriteria
                            $bobot = [
                                1 => 0.2, // C1 - HARGA (COST)
                                2 => 0.2, // C2 - EFEKTIVITAS
                                3 => 0.2, // C3 - EFEK SAMPING RENDAH
                                4 => 0.2, // C4 - CEPAT REAKSI
                                5 => 0.1, // C5 - TERSEDIA DI APOTEK
                            ];

                            // Hitung y_ij = x_ij * bobot
                            $y1 = $x1 * $bobot[1];
                            $y2 = $x2 * $bobot[2];
                            $y3 = $x3 * $bobot[3];
                            $y4 = $x4 * $bobot[4];
                            $y5 = $x5 * $bobot[5];

                            // Hitung Y_i (Benefit - Cost)
                            $benefit = $y2 + $y3 + $y4 + $y5;
                            $cost    = $y1;
                            $Yi = $benefit - $cost;
                        ?>
                    <tr class="text-center">
                        <td><?= $nomor++; ?></td>
                        <td><?= $rows['nama']; ?></td>
                        <td><?= round($y1, 4); ?></td>
                        <td><?= round($y2, 4); ?></td>
                        <td><?= round($y3, 4); ?></td>
                        <td><?= round($y4, 4); ?></td>
                        <td><?= round($y5, 4); ?></td>
                        <td><strong><?= round($Yi, 4); ?></strong></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
                $hasil = [];
                $nomor = 1;

                foreach($datas as $rows) {
                    // Normalisasi x_ij
                    $x1 = $rows['c1'] / sqrt($total_pangkat_c1); // COST
                    $x2 = $rows['c2'] / sqrt($total_pangkat_c2); // BENEFIT
                    $x3 = $rows['c3'] / sqrt($total_pangkat_c3); // BENEFIT
                    $x4 = $rows['c4'] / sqrt($total_pangkat_c4); // BENEFIT
                    $x5 = $rows['c5'] / sqrt($total_pangkat_c5); // BENEFIT

                    // Bobot
                    $bobot = [1 => 0.2, 2 => 0.2, 3 => 0.2, 4 => 0.2, 5 => 0.1];

                    // y_ij
                    $y1 = $x1 * $bobot[1];
                    $y2 = $x2 * $bobot[2];
                    $y3 = $x3 * $bobot[3];
                    $y4 = $x4 * $bobot[4];
                    $y5 = $x5 * $bobot[5];

                    // benefit dan cost
                    $benefit = $y2 + $y3 + $y4 + $y5;
                    $cost = $y1;
                    $Yi = $benefit - $cost;

                    $hasil[] = [
                        'no' => $nomor++,
                        'nama' => $rows['nama'],
                        'y1' => $y1,
                        'y2' => $y2,
                        'y3' => $y3,
                        'y4' => $y4,
                        'y5' => $y5,
                        'benefit' => $benefit,
                        'cost' => $cost,
                        'Yi' => $Yi
                    ];
                }

                // Urutkan berdasarkan Yi DESC
                usort($hasil, fn($a, $b) => $b['Yi'] <=> $a['Yi']);

                // Tambahkan ranking
                foreach ($hasil as $i => &$h) {
                    $h['ranking'] = $i + 1;
                }
            ?>
            <h5>Perhitungan Y<sub>ij</sub> dan Ranking</h5>
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>y1 (COST)</th>
                        <th>y2 (BENEFIT)</th>
                        <th>y3 (BENEFIT)</th>
                        <th>y4 (BENEFIT)</th>
                        <th>y5 (BENEFIT)</th>
                        <th>∑ Benefit</th>
                        <th>∑ Cost</th>
                        <th>Y<sub>i</sub></th>
                        <th>Ranking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($hasil as $row): ?>
                    <tr class="text-center">
                        <td><?= $row['no']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= round($row['y1'], 4); ?></td>
                        <td><?= round($row['y2'], 4); ?></td>
                        <td><?= round($row['y3'], 4); ?></td>
                        <td><?= round($row['y4'], 4); ?></td>
                        <td><?= round($row['y5'], 4); ?></td>
                        <td><strong><?= round($row['benefit'], 4); ?></strong></td>
                        <td><strong><?= round($row['cost'], 4); ?></strong></td>
                        <td><strong><?= round($row['Yi'], 4); ?></strong></td>
                        <td><strong><?= $row['ranking']; ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>
            <h5>PERINGKAT AKHIR</h5>
            <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama</th>
                        <th>Y<sub>i</sub></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $peringkat = 1;
                        foreach($hasil as $row) {
                    ?>
                    <tr class="text-center">
                        <td><?= $peringkat++; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><strong><?= round($row['Yi'], 4); ?></strong></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>