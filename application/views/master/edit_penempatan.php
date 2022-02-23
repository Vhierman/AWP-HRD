<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Edit Data Penempatan</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $penempatan['id'] ?>">

                        <div class="form-group">
                            <label for="NamaPenempatan">Nama Penempatan</label>
                            <input type="text" class="form-control" name="penempatan" value="<?= $penempatan['penempatan'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Data Penempatan</button>
                        <a href="<?= base_url('divisi/penempatan'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>