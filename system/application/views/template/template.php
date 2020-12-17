<!DOCTYPE html>
<html lang="en" translate="no">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=5, width=device-width, shrink-to-fit=no">
    <meta name="description" content="PMB STIKes Muhammadiyah Ciamis.">
    <meta name="author" content="Wahyu Kamaludin">
    <meta name="google" value="notranslate">

    <title><?= $title ?></title>

    <link rel="canonical" href="<?= current_url() ?>" />
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
                            <a class="nav-icon d-inline-block d-sm-none">
                                <i class="align-middle" data-feather="user"></i>
                            </a>

                            <a class="nav-link d-none d-sm-inline-block">
                                <img src="<?= base_url("assets/img/logo.png") ?>" class="avatar img-fluid rounded-circle mr-1" width="100" height="100" alt="<?= $this->session->nama_user; ?>" /> <span class="text-dark"><?= $this->session->nama_user; ?></span>
                            </a>
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
                            <?= aplikasi()->kampus ?>
                        </div>
                        <div class="col-6 text-right">
                            <p class="mb-0">
                                &copy; 2020 - <a href="index.html" class="text-muted"><?= aplikasi()->singkatan . ' ' . aplikasi()->versi ?></a>
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

    <script>
        async function ubah_theme(theme, css) {
            let data = {
                'theme': theme,
                'css': css
            };
            const options = {
                method: 'POST',
                headers: {
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            };
            try {
                const response = await fetch(site_url + 'theme/ubah', options);
                const json = await response.json();
                // console.log(json);
                if (json.status) {
                    // reload
                    location.reload();
                } else {
                    // tampil notif
                    notif(json.message, json.type);
                }
            } catch (error) {
                console.log(error);
                // tampil notif
                notif(error, 'error');
            }
        }

        // fungsi untuk notifikasi
        function notif(pesan, tipe) {
            const message = pesan;
            const type = tipe;
            const duration = 5000;
            const ripple = true;
            const dismissible = true;
            const positionX = 'center';
            const positionY = 'top';
            window.notyf.open({
                type,
                message,
                duration,
                ripple,
                dismissible,
                position: {
                    x: positionX,
                    y: positionY
                }
            });
        }
    </script>

</body>

</html>