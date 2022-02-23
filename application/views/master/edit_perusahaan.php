<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">

            <div class="card ">
                <h5 class="card-header">Edit Data Perusahaan</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $perusahaan['id'] ?>">

                        <div class="form-group">
                            <label for="NamaPerusahaan">Nama Perusahaan</label>
                            <input type="text" class="form-control" name="perusahaan" value="<?= $perusahaan['perusahaan'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('perusahaan'); ?></small>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Data Perusahaan</button>
                        <a href="<?= base_url('divisi/perusahaan'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>