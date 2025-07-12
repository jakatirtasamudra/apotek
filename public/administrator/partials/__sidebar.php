<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= url('/homeadmin'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?= __Aplikasi()['Singkat']; ?> <sup>2</sup></div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="<?= url('/homeadmin'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Beranda</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Menu
    </div>
    <?php if ($auth->level == 'admin') { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAkun" aria-expanded="true"
            aria-controls="collapseAkun">
            <i class="fas fa-fw fa-cog"></i>
            <span>Akun</span>
        </a>
        <div id="collapseAkun" class="collapse <?= $__mod__['li_show_akun']; ?>" aria-labelledby="headingAkun"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $__mod__['li_active_pegawai']; ?>" href="<?= url('/homeadmin/akun') ?>">
                    Pegawai
                </a>
            </div>
        </div>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseObat" aria-expanded="true"
            aria-controls="collapseObat">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Obat</span>
        </a>
        <div id="collapseObat" class="collapse <?= $__mod__['li_show_obat']; ?>" aria-labelledby="headingObat"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $__mod__['li_active_kategori']; ?>"
                    href="<?= url('/homeadmin/kategori') ?>">
                    Kategori
                </a>
                <a class="collapse-item <?= $__mod__['li_active_diskon']; ?>"
                    href="<?= url('/homeadmin/diskon') ?>">
                    Diskon
                </a>
                <a class="collapse-item <?= $__mod__['li_active_stok']; ?>" href="<?= url('/homeadmin/stok') ?>">
                    Stok
                </a>
                <a class="collapse-item <?= $__mod__['li_active_penjualan']; ?>"
                    href="<?= url('/homeadmin/penjualan') ?>">
                    Penjualan
                </a>
                <hr>
                <a class="collapse-item <?= $__mod__['li_active_kas']; ?>"
                    href="<?= url('/homeadmin/kas') ?>">
                    Kas
                </a>
                <a class="collapse-item <?= $__mod__['li_active_keuangan']; ?>"
                    href="<?= url('/homeadmin/keuangan') ?>">
                    Keuangan
                </a>
            </div>
        </div>
    </li>
    <?php if ($auth->level == 'admin') { ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
            aria-expanded="true" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-users"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapseLaporan" class="collapse <?= $__mod__['li_show_transaksi']; ?>"
            aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $__mod__['li_active_konsumen']; ?>"
                    href="<?= url('/homeadmin/konsumen') ?>">
                    Konsumen
                </a>
            </div>
        </div>
    </li>
    <?php } ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMetode" aria-expanded="true"
            aria-controls="collapseMetode">
            <i class="fas fa-fw fa-check"></i>
            <span>Metode</span>
        </a>
        <div id="collapseMetode" class="collapse <?= $__mod__['li_show_metode']; ?>" aria-labelledby="headingMetode"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item <?= $__mod__['li_active_moora']; ?>" href="<?= url('/homeadmin/moora') ?>">
                    Moora
                </a>
                <a class="collapse-item <?= $__mod__['li_active_cf']; ?>" href="<?= url('/homeadmin/cf') ?>">
                    CF
                </a>
            </div>
        </div>
    </li>
</ul>