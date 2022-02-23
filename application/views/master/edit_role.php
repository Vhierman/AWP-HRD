<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Edit Role</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $role['id'] ?>">

                        <div class="form-group">
                            <label for="NamaRole">Nama Role</label>
                            <input type="text" class="form-control" name="role" value="<?= $role['role'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('role'); ?></small>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Role</button>
                        <a href="<?= base_url('admin/role'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>