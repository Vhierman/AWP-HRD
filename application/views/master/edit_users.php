<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="" method="POST">
        <div class="card">
            <h5 class="card-header">Form Edit Users</h5>
            <div class="card-body">

                <div class="alert alert-info" role="alert">
                    Yang Di EDIT Hanya Nama Users, Email, Dan Role, Jika yang salah NIK, maka Data Di Hapus Dan Di Input Ulang kedalam sistem.
                </div>

                <input type="hidden" class="form-control" name="id" readonly='readonly' value="<?= $users['id']; ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik" maxlength="16" readonly='readonly' value="<?= $users['nik']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('nik'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama Users</label>
                        <input type="text" class="form-control" name="name" maxlength="50" value="<?= $users['name']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('name'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email</label>
                        <input type="text" class="form-control" name="email" maxlength="100" value="<?= $users['email']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('email'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Role</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Pilih Role</option>
                            <?php foreach ($role as $jl) : ?>

                                <?php if ($jl['id'] == $users['role_id']) : ?>
                                    <option value="<?= $jl['id']; ?>" selected><?= $jl['role']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $jl['id']; ?>"><?= $jl['role']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('master/users'); ?>">CANCEL</a>
        </div>
</div>
</form>
</div>