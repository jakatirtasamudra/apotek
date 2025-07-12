<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        <?= __Aplikasi()['Aplikasi']; ?>
    </title>

    <link rel="shortcut icon" href="<?= __Aplikasi()['Logo']; ?>">
    <!-- Custom fonts for this template-->
    <link href="<?= assets(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= assets(); ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <center>
                                <img src="<?= __Aplikasi()['Logo']; ?>" alt="" width="30%" class="img-fluid rounded">
                            </center>
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">
                                    Selamat Datang!
                                </h1>
                            </div>

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

                            <form class="user" action="<?= url('/login/proses'); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?= $csrf; ?>
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user"
                                        placeholder="Username Anda..." required="" autofocus autocomplete="off"
                                        value="<?= $helpers->old('username'); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user"
                                        placeholder="Password Anda..." required="" autocomplete="off" id="password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">
                                            Tampilkan Password
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <a href="<?= url('/'); ?>" class="btn btn-danger btn-user btn-block">
                                    Kembali
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= assets(); ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= assets(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= assets(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= assets(); ?>js/sb-admin-2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#customCheck').on('change', function() {
            const passwordInput = $('#password');
            if (this.checked) {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });
    });
    </script>


</body>

</html>