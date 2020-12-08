<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi Rekam Medis">
    <meta name="author" content="Wahyu Kamaludin">

    <title><?= $title ?></title>

    <link rel="canonical" href="<?= base_url() ?>" />
    <link rel="shortcut icon" href="<?= base_url("assets/img/favicon.ico") ?>">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- preload -->
    <link rel="preload" href="<?= base_url("assets/css/light.css") ?>" as="style">
    <script>
        var site_url = '<?= site_url() ?>';
    </script>

    <link href="<?= base_url("assets/css/light.css") ?>" rel="stylesheet">
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
    <div class="wrapper">

        <?= $_sidebar ?>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="d-none d-sm-inline-block ml-3">
                    <div class="input-group input-group-navbar">
                        <label class="h4 m-0"><?= $title ?></label>
                    </div>
                </div>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                                <img src="<?= base_url("assets/img/logo.png") ?>" class="avatar img-fluid rounded-circle mr-1" alt="<?= $this->session->nama_user; ?>" /> <span class="text-dark"><?= $this->session->nama_user; ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="pages-profile.html"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle mr-1" data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="pages-settings.html">Settings & Privacy</a>
                                <a class="dropdown-item" href="#">Help</a>
                                <a class="dropdown-item" href="<?= base_url("logout") ?>">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <!-- <h1 class="h3 mb-3"><?= $title ?></h1> -->

                    <?= $_content ?>

                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-left">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms of Service</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-6 text-right">
                            <p class="mb-0">
                                &copy; 2020 - <a href="index.html" class="text-muted">AppStack</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?= base_url("assets/js/app.js") ?>"></script>
    <?php
    // load js by class name
    $file = 'assets/js/controller/' . $this->router->fetch_class() . '.js';
    if (file_exists($file)) echo '<script src="' . base_url($file) . '"></script>';
    ?>

</body>

</html>