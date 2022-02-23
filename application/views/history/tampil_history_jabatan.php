<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title . " " . $this->input->post('nama_karyawan'); ?></h1>

    <div class="row">
        <div class="col-lg">

            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('history/tambahjabatan/'); ?><?= $this->input->post('nik_karyawan'); ?>" class="btn btn-primary mb-2 ml-4">
                <i class="fas fa-plus"></i>
                Tambah Data Jabatan
            </a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Tanggal Mutasi</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php
                    foreach ($datajabatan as $row) :
                        $tanggal_mutasi = IndonesiaTgl($row['tanggal_mutasi']);
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['jabatan']; ?></td>
                            <td><?= $row['penempatan']; ?></td>
                            <td><?= $tanggal_mutasi; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>assets/img/jabatan/<?= $row['file_surat_mutasi']; ?>" target="_blank" class="btn btn-primary btn-sm "><i class="fas fa-search"></i> Lihat File</a>
                                <a href="<?= base_url(); ?>history/editjabatan/<?= $row['id_history_jabatan']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>history/hapusjabatan/<?= $row['id_history_jabatan']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
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