<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Edit Menu Management</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $user_menu['id'] ?>">

                        <div class="form-group">
                            <label for="NamaMenu">Nama Menu</label>
                            <input type="text" class="form-control" name="menu" value="<?= $user_menu['menu'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('menu'); ?></small>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Menu</button>
                        <a href="<?= base_url('menu'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>