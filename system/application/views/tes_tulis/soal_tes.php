<div class="row">
    <div class="col-12 col-xl-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Form Soal Tes</h5>
                <h6 class="card-subtitle text-muted">Kelola data soal tes tulis</h6>
            </div>
            <div class="card-body">
                <form id="f_soal" autocomplete="off">
                    <input type="hidden" name="id_soal" id="id_soal" value="">
                    <div class="form-group">
                        <div id="quill-toolbar">
                            <span class="ql-formats">
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
                        <div id="pertanyaan"></div>
                        <input type="hidden" id="text_pertanyaan" name="pertanyaan">
                        <!-- <textarea type="text" name="pertanyaan" id="pertanyaan" class="form-control" rows="4" required autofocus placeholder="Masukkan soal disini"></textarea> -->
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="opsi_a" id="opsi_a" class="form-control" required placeholder="Jawaban untuk opsi A"></textarea>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="opsi_b" id="opsi_b" class="form-control" required placeholder="Jawaban untuk opsi B"></textarea>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="opsi_c" id="opsi_c" class="form-control" required placeholder="Jawaban untuk opsi C"></textarea>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="opsi_d" id="opsi_d" class="form-control" required placeholder="Jawaban untuk opsi D"></textarea>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="opsi_e" id="opsi_e" class="form-control" required placeholder="Jawaban untuk opsi E"></textarea>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="jawaban" id="jawaban" required>
                            <option selected disabled value="">Pilih Kunci Jawaban</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>

                    <hr>
                    <button type="submit" id="submit" class="btn btn-primary">SIMPAN</button>
                    <button type="reset" class="btn btn-outline-secondary">RESET</button>
                    <a role="button" id="batal" onclick="location.reload()" class="btn btn-secondary waves-effect float-right" style="display: none;">BATAL</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Soal Tes</h5>
            </div>
            <div class="card-body">
                <table id="dt-soal" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Soal</th>
                            <th>Jawaban</th>
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
            return $("#pertanyaan,#quill-toolbar").remove();
        }
        var quill = new Quill("#pertanyaan", {
            modules: {
                toolbar: "#quill-toolbar"
            },
            placeholder: "Type something",
            theme: "snow"
        });
        var text = document.getElementById('pertanyaan');
        text.onkeyup = function() {
            let text_info = $('.ql-editor').html();
            let isi = document.getElementById('text_pertanyaan').value = text_info;
            return false;
        };
    });
</script>