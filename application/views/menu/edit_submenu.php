<div class="container">
    <div class="row mt-3">
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Edit Sub Menu Management</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id" value="<?= $user_submenu['id'] ?>">

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Sub Menu</label>
                            <select class="form-control" id="menu_id" name="menu_id">
                                <?php foreach ($menu as $mn) : ?>

                                    <?php if ($mn['id'] == $user_submenu['menu_id']) : ?>
                                        <option value="<?= $mn['id']; ?>" selected><?= $mn['menu']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $mn['id']; ?>"><?= $mn['menu']; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="Title">Title</label>
                            <input type="text" class="form-control" name="title" value="<?= $user_submenu['title'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('title'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="URL">URL</label>
                            <input type="text" class="form-control" name="url" value="<?= $user_submenu['url'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('url'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="Icon">Icon</label>
                            <input type="text" class="form-control" name="icon" value="<?= $user_submenu['icon'] ?>">
                            <small class="form-text text-danger"><?php echo form_error('icon'); ?></small>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <?php if ($user_submenu['is_active'] == 1) : ?>
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                <?php else : ?>
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="0">
                                <?php endif; ?>
                                <label class="form-check-label" for="is_active">Active ?</label>
                            </div>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Sub Menu</button>
                        <a href="<?= base_url('menu/submenu'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>