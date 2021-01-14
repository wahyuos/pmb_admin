<div class="row">
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Informasi</h5>
                <h6 class="card-subtitle text-muted">Masukkan informasi atau pengumuman mengenai pendaftaran.</h6>
            </div>
            <div class="card-body">
                <form id="f_informasi" autocomplete="off">
                    <input type="hidden" name="id_informasi" id="id_informasi" value="">
                    <div class="form-group">
                        <label class="form-label" for="judul_informasi">Judul Informasi <span class="text-danger">*</span></label>
                        <input type="text" name="judul_informasi" id="judul_informasi" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="isi_informasi">Isi Informasi</label>
                        <div id="quill-toolbar">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                            </span>
                        </div>
                        <div id="isi_informasi"></div>
                        <input type="hidden" id="text_isi_informasi" name="isi_informasi">
                    </div>

                    <hr>
                    <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                    <button type="reset" class="btn btn-outline-secondary">RESET</button>
                    <a role="button" id="batal" onclick="location.reload()" class="btn btn-secondary waves-effect float-right" style="display: none;">BATAL</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Informasi</h5>
                <h6 class="card-subtitle text-muted">Informasi yang ada disini akan ditampilkan semua di halaman pendaftar.</h6>
            </div>
            <div class="card-body">
                <table id="dt-informasi" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (!window.Quill) {
            return $("#isi_informasi,#quill-toolbar").remove();
        }
        var quill = new Quill("#isi_informasi", {
            modules: {
                toolbar: "#quill-toolbar"
            },
            placeholder: "Type something",
            theme: "snow"
        });
        var text = document.getElementById('isi_informasi');
        text.onkeyup = function() {
            let text_info = $('.ql-editor').html();
            // let text_info = document.getElementsByClassName('ql-editor').innerHTML;
            let isi = document.getElementById('text_isi_informasi').value = text_info;
            return false;
        };
    });
</script>