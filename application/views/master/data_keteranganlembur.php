<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-2 ml-4" data-toggle="modal" data-target="#addNewketeranganlembur"> <i class="fas fa-plus"></i> Tambah Data Keterangan Lembur</a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Keterangan Lembur</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php foreach ($keteranganlembur as $kl) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $kl['keterangan_lembur']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>master/editketeranganlembur/<?= $kl['id_keterangan_lembur']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>master/hapusketeranganlembur/<?= $kl['id_keterangan_lembur']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
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

<!-- Modal Add Jam Lembur -->
<div class="modal fade" id="addNewketeranganlembur" tabindex="-1" role="dialog" aria-labelledby="addNewketeranganlemburLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewketeranganlemburLabel">Tambah Data Jam Lembur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/keteranganlembur'); ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <input type="text" class="form-control" name="keterangan_lembur" maxlength="50" id="keterangan_lembur" placeholder="Keterangan Lembur">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah Data Jam Lembur</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Add Jam Lembur -->