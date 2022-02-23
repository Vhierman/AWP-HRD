<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col">
            <!-- Menampilkan Pesan Kesalahan -->
            <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-2 ml-4" data-toggle="modal" data-target="#addNewRole">
                <i class="fas fa-plus"></i>
                Add New Role
            </a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($role as $rl) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $rl['role']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>master/roleaccess/<?= $rl['id']; ?>" class="btn btn-warning btn-sm "><i class="fas fa-share-alt"></i> Access</a>
                                <a href="<?= base_url(); ?>master/edit_role/<?= $rl['id']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>master/hapus_role/<?= $rl['id']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah Anda yakin akan menghapus data tersebut'); "><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Add Menu -->
<div class="modal fade" id="addNewRole" tabindex="-1" role="dialog" aria-labelledby="addNewRoleLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewRoleLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/role'); ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Enter your Role Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times-circle"></i> Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Add Menu -->