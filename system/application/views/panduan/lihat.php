<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if ($doc_panduan) : ?>
                    <iframe id="preview" src="<?= base_url($doc_panduan->file_path . $doc_panduan->file_name) ?>" class="rounded-md" width="100%" height="650px"></iframe>
                <?php else : ?>
                    <div class="list-group-item text-center p-3">
                        Belum ada panduan
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>