<div class="row  d-flex justify-content-center">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-center">Atur Tahun Akademik</h5>
            </div>
            <div class="card-body">
                <select name="tahun" id="tahun" onchange="ganti_ta()" class="form-control form-control-lg mb-3">
                    <option disabled selected>Pilih tahun akademik</option>
                    <?php
                    $thn_skr = date('Y');
                    for ($x = $thn_skr + 1; $x >= 2019; $x--) {
                        $selected = ($x == $ta->tahun) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $x; ?>" <?= $selected; ?>><?php echo $x . '/' . ($x + 1); ?></option>
                    <?php
                    }
                    ?>
                </select>

                <div class="alert alert-primary" role="alert">
                    <div class="alert-message">
                        <h4 class="alert-heading">Penting!</h4>
                        <p>Pada saat proses pendaftaran, pastikan tahun akademik yang aktif sesuai dengan tahun saat ini. Hal ini bermaksud agar proses pendaftaran berjalan sesuai tahun akademik yang sedang berjalan.</p>
                        <hr>
                        <p class="mb-0">Demi menjaga keamanan proses pendaftaran, sebaiknya <strong>tidak boleh</strong> mengganti tahun akademik selama proses pendaftaran berlangsung.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>