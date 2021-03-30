<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Info BRIVA</h5>
            </div>
            <div class="card-body">
                <?php if ($info_briva) : ?>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">URL API <span class="float-right"> : </span></label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $info_briva->urlApi ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Kode Institusi <span class="float-right"> : </span></label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $info_briva->kodeInstitusi ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Kode BRIVA <span class="float-right"> : </span></label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $info_briva->kodebriva ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-form-label col-sm-4">Jumlah Bayar <span class="float-right"> : </span></label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0">Rp <?= number_format($info_briva->biayaDaftar, 0, ',', '.') ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label col-sm-4">Keterangan <span class="float-right"> : </span></label>
                        <div class="col-sm-8 col-form-label">
                            <p class="text-dark m-0"><?= $info_briva->ketBayar ?></p>
                        </div>
                    </div>
                    <button class="btn btn-block btn-primary" onclick="edit(`<?= $info_briva->kodebriva ?>`)">EDIT</button>
                <?php else : ?>
                    Belum ada info BRIVA
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card" id="card_form" style="display: none;">
            <div class="card-header">
                <h5 class="card-title">Atur Briva</h5>
            </div>
            <div class="card-body">
                <form id="f_briva" autocomplete="off">
                    <div class="form-group">
                        <label class="form-label" for="urlApi">URL API <span class="text-danger">*</span></label>
                        <input type="text" name="urlApi" id="urlApi" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kodeInstitusi">Kode Institusi <span class="text-danger">*</span></label>
                        <input type="text" name="kodeInstitusi" id="kodeInstitusi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kodebriva">Kode BRIVA <span class="text-danger">*</span></label>
                        <input type="text" name="kodebriva" id="kodebriva" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="biayaDaftar">Biaya Pendaftaran <span class="text-danger">*</span></label>
                        <input type="text" name="biayaDaftar" id="biayaDaftar" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="ketBayar">Keterangan <span class="text-danger">*</span></label>
                        <input type="text" name="ketBayar" id="ketBayar" class="form-control" required>
                    </div>

                    <hr>
                    <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                    <button type="reset" class="btn btn-outline-secondary">RESET</button>
                    <a role="button" id="batal" onclick="location.reload()" class="btn btn-secondary waves-effect float-right" style="display: none;">BATAL</a>
                </form>
            </div>
        </div>
    </div>
</div>