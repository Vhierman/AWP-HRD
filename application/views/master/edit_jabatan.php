<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Edit Data Jabatan</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $jabatan['id'] ?>">

                        <div class="form-group">
                            <label for="NamaJabatan">Nama Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" value="<?= $jabatan['jabatan'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Data Jabatan</button>
                        <a href="<?= base_url('divisi/jabatan'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>