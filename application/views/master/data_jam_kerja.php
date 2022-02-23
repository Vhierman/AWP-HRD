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

            <a href="" class="btn btn-primary mb-2 ml-4" data-toggle="modal" data-target="#addNewjamkerja"> <i class="fas fa-plus"></i> Tambah Data Jam Kerja</a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jam Masuk</th>
                        <th scope="col">Jam Pulang</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                                            $i = 1; ?>
                    <?php foreach ($jamkerja as $jl) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $jl['jam_masuk']; ?></td>
                            <td><?= $jl['jam_pulang']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>master/editjamkerja/<?= $jl['id_jam_kerja']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>master/hapusjamkerja/<?= $jl['id_jam_kerja']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
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

<!-- Modal Add Jam Kerja -->
<div class="modal fade" id="addNewjamkerja" tabindex="-1" role="dialog" aria-labelledby="addNewjamkerjaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewjamkerjaLabel">Tambah Data Jam Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/jamkerja'); ?>" method="post">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" placeholder="Jam Masuk">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="time" class="form-control" name="jam_pulang" id="jam_pulang" placeholder="Jam Pulang">
                        </div>
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