<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Wahyu Kamaludin">

    <title><?= $title ?></title>

    <link rel="canonical" href="<?= base_url() ?>" />
    <link rel="shortcut icon" href="<?= base_url("assets/img/favicon.ico") ?>">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- preload -->
    <link rel="preload" href="<?= base_url("assets/css/" . theme()->css . ".css") ?>" as="style">
    <link rel="preload" href="<?= base_url("assets/fonts/fa-solid-900.woff2") ?>" as="font" type="font/woff2" crossorigin>
    <script>
        var site_url = '<?= site_url() ?>';
    </script>

    <link href="<?= base_url("assets/css/" . theme()->css . ".css") ?>" rel="stylesheet">
</head>

<body data-theme="<?= theme()->theme ?>" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">

    <div class="col-sm-8 col-md-6 col-lg-4 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">

            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <div class="text-center mb-5">
                            <h1 class="h2"><?= aplikasi()->singkatan ?></h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                            <div class="text-center">
                                <img src="<?= base_url("assets/img/logo.png") ?>" alt="<?= aplikasi()->singkatan ?>" class="img-fluid rounded-circle" width="132" height="132">
                            </div>
                        </div>

                        <form class="authentication-form" id="f_login" autocomplete="off">
                            <div class="form-group">
                                <label class="form-control-label" for="username">Username</label>
                                <input class="form-control form-control-lg" type="text" name="username" id="username" placeholder="Masukkan Username" autofocus required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="password">Password</label>
                                <input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Masukkan Password" required>
                            </div>
                            <div class="form-group mb-4">
                                <div class="col-12">
                                    <div class="clearfix text-danger text-center mt-3 mb-3" id="alert">&nbsp;</div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button class="btn btn-primary btn-lg btn-block" type="submit" id="login">MASUK</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted"><a href="<?= base_url(); ?>" class="text-muted">&copy; <?= aplikasi()->singkatan ?> - 2020</a></p>
                </div> <!-- end col -->
            </div>

        </div>
    </div>

    <?php
    // load js by class name
    $file = 'assets/js/controller/' . $this->router->fetch_class() . '.js';
    if (file_exists($file)) echo '<script src="' . base_url($file) . '"></script>';
    ?>

</body>

</html>