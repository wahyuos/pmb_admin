<?php if ($this->session->level == 'mitra') : ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card illustration flex-fill">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row no-gutters w-100">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Hai, <?= explode(' ', $this->session->nama_user)[0] ?>!</h4>
                                <p class="mb-0"><?= aplikasi()->singkatan ?></p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-right">
                            <img src="<?= base_url('assets/img/customer-support.png') ?>" alt="Customer Support" class="img-fluid illustration-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-2"><?= ($total_pendaftar_by_user) ? $total_pendaftar_by_user : '0' ?></h3>
                            <p class="mb-2">Total Pendaftar</p>
                        </div>
                        <div class="d-inline-block ml-3">
                            <div class="stat">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card illustration flex-fill">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row no-gutters w-100">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Hai, <?= explode(' ', $this->session->nama_user)[0] ?>!</h4>
                                <p class="mb-0"><?= aplikasi()->singkatan ?></p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-right">
                            <img src="<?= base_url('assets/img/customer-support.png') ?>" alt="Customer Support" class="img-fluid illustration-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-2"><?= ($total_pendaftar) ? $total_pendaftar : '0' ?></h3>
                            <p class="mb-2">Total Pendaftar</p>
                            <div class="mb-0">
                                <span class="badge badge-soft-success mr-2"> <i class="mdi mdi-arrow-bottom-right"></i> +<?= ($total_daftar_hari_ini) ? $total_daftar_hari_ini : '0' ?> </span>
                                <span class="text-muted">pendaftar</span>
                            </div>
                        </div>
                        <div class="d-inline-block ml-3">
                            <div class="stat">
                                <i class="align-middle" data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-2"><?= ($total_pendaftar_pmdk) ? $total_pendaftar_pmdk : '0' ?></h3>
                            <p class="mb-0">Pendaftar PMDK</p>
                        </div>
                        <div class="d-inline-block ml-3">
                            <div class="stat">
                                <i class="align-middle" data-feather="file-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-2"><?= ($total_pendaftar_umum) ? $total_pendaftar_umum : '0' ?></h3>
                            <p class="mb-0">Pendaftar Umum</p>
                        </div>
                        <div class="d-inline-block ml-3">
                            <div class="stat">
                                <i class="align-middle" data-feather="globe"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pendaftaran Jalur PMDK</h5>
                </div>
                <div class="card-body d-flex w-100">
                    <div class="align-self-center chart chart-lg">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="chartjs-pmdk" style="display: block; width: 479px; height: 350px;" width="479" height="350" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pendaftaran Jalur Umum</h5>
                </div>
                <div class="card-body d-flex w-100">
                    <div class="align-self-center chart chart-lg">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="chartjs-umum" style="display: block; width: 479px; height: 350px;" width="479" height="350" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Peminat Program Studi</h5>
                </div>
                <div class="card-body d-flex">
                    <div class="align-self-center w-100">
                        <div class="py-3">
                            <div class="chart chart-xs">
                                <canvas id="chartjs-peminat-prodi"></canvas>
                            </div>
                        </div>

                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Program Studi</th>
                                    <th class="text-right">Peminat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($list_peminat_prodi as $prodi) :
                                ?>
                                    <tr>
                                        <td><i class="fas fa-square-full" style="color: <?= $prodi->warna ?>"></i> <?= $prodi->nama_prodi . ' (' . substr($prodi->jenis_prodi, 0, 3) . ')' ?></td>
                                        <td class="text-right"><strong><?= $prodi->jml ?></strong> pendaftar</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Referensi Masuk </h5>
                </div>
                <table class="table table-striped my-0">
                    <thead>
                        <tr>
                            <th>Referensi Masuk</th>
                            <th class="text-right">Jumlah Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($list_referensi_masuk as $referensi) :
                        ?>
                            <tr>
                                <td> <?= $referensi->jenis_masuk ?></td>
                                <td class="text-right"><strong><?= $referensi->jml ?></strong> pendaftar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Jenis Pendataran</h5>
                </div>
                <table class="table table-striped my-0">
                    <thead>
                        <tr>
                            <th>Jenis Daftar</th>
                            <th class="text-right">Jumlah Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rekap_pendaftar as $rekap) :
                            $level = ($rekap->level) ? $rekap->level : 'Mandiri';
                        ?>
                            <tr>
                                <td> <?= strtoupper($level) ?></td>
                                <td class="text-right"><strong><?= $rekap->jml ?></strong> pendaftar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Jenjang Sekolah </h5>
                </div>
                <table class="table table-striped my-0">
                    <thead>
                        <tr>
                            <th>Jenjang</th>
                            <th class="text-right">Jumlah Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rekap_jenjang_sekolah as $rekap) :
                        ?>
                            <tr>
                                <td> <?= $rekap->jenjang ?></td>
                                <td class="text-right"><strong><?= $rekap->jml ?></strong> pendaftar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Bar chart untuk jalur pmdk
        new Chart(document.getElementById("chartjs-pmdk"), {
            type: "bar",
            data: {
                labels: <?= $list_gelombang_pmdk ?>,
                datasets: [{
                    label: "Pendaftar",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: <?= $total_pendaftar_pmdk_by_gelombang ?>,
                    barPercentage: .325,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                cornerRadius: 10,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 10
                        },
                        stacked: true,
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        },
                        stacked: true,
                    }]
                }
            }
        });

        // Bar chart untuk jalur umum
        new Chart(document.getElementById("chartjs-umum"), {
            type: "bar",
            data: {
                labels: <?= $list_gelombang_umum ?>,
                datasets: [{
                    label: "Pendaftar",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: <?= $total_pendaftar_umum_by_gelombang ?>,
                    barPercentage: .325,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                cornerRadius: 10,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 10
                        },
                        stacked: true,
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        },
                        stacked: true,
                    }]
                }
            }
        });

        // Pie chart peminat prodi
        new Chart(document.getElementById("chartjs-peminat-prodi"), {
            type: "pie",
            data: {
                labels: <?= $list_program_studi ?>,
                datasets: [{
                    data: <?= $total_peminat_program_studi ?>,
                    backgroundColor: <?= $warna_program_studi ?>,
                    borderWidth: 5,
                    borderColor: window.theme.white
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: {
                    display: false
                }
            }
        });
    });
</script>