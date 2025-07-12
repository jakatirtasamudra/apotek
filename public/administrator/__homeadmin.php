<?php @require_once __DIR__ . '/partials/__header.php'; ?>

<div id="wrapper">

    <?php @require_once __DIR__ . '/partials/__sidebar.php'; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <?php @require_once __DIR__ . '/partials/__navbar.php'; ?>

            <div class="container-fluid">

                <?php @require_once __DIR__ . '/modules/__content.php'; ?>

            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; <?= __Aplikasi()['Aplikasi'] . ' | ' . date('Y'); ?></span>
                </div>
            </div>
        </footer>
    </div>
</div>

<?php @require_once __DIR__ . '/partials/__footer.php'; ?>