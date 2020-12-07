<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Profile Details</h5>
            </div>
            <div class="card-body text-center">
                <img src="<?= base_url('assets/img/avatar.jpg') ?>" alt="Stacie Hall" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                <h5 class="card-title mb-0">Stacie Hall</h5>
                <div class="text-muted mb-2">Lead Developer</div>

                <div>
                    <a class="btn btn-primary btn-sm" href="#"><span data-feather="edit-2"></span> Edit</a>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <h5 class="h6 card-title">Persyaratan</h5>
                <ul class="list-unstyled mb-0">
                    <li class="mb-1">
                        <span data-feather="check" class="feather-sm mr-1"></span> Kartu Keluarga
                        <a class="small float-right">
                            <span data-feather="edit-2" class="feather-sm"></span>
                        </a>
                    </li>
                    <hr class="m-1">
                    <li class="mb-1">
                        <span data-feather="check" class="feather-sm mr-1"></span> Ijazah/SKL
                        <a class="small float-right">
                            <span data-feather="edit-2" class="feather-sm"></span>
                        </a>
                    </li>
                    <hr class="m-1">
                    <li class="mb-1">
                        <span data-feather="check" class="feather-sm mr-1"></span> Pas Foto
                        <a class="small float-right">
                            <span data-feather="edit-2" class="feather-sm"></span>
                        </a>
                    </li>
                    <hr class="m-1">
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-body h-100">
                <!-- Biodata -->
                <div class="mb-2 border-bottom">
                    <h5 class="card-title mb-3">Biodata</h5>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nm_pd">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nm_pd" name="nm_pd" required autofocus>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nik">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                        <input type="text" onfocus="(this.type='number')" class="form-control" id="nik" name="nik" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tmpt_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="text" onfocus="(this.type='date')" min="<?= date('Y-m-d', strtotime('-50 years', strtotime(date('Y-m-d')))) ?>" max="<?= date('Y-m-d', strtotime('-16 years', strtotime(date('Y-m-d')))) ?>" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_agama">Agama <span class="text-danger">*</span></label>
                        <select class="form-control" name="id_agama" id="id_agama" required>
                            <option selected disabled>Silahkan pilih</option>
                            <?php if ($agama) :
                                foreach ($agama as $list) : ?>
                                    <option value="<?= $list->id_agama ?>"><?= $list->nm_agama ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="jk">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="form-group border p-1 pl-2 m-0 rounded">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="l" name="jk" value="L" class="custom-control-input" required>
                                <label class="custom-control-label" for="l">Laki-laki </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="p" name="jk" value="P" class="custom-control-input" required>
                                <label class="custom-control-label" for="p">Perempuan </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>