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

            <a href="<?= base_url('history/tambahpendidikanformal/'); ?><?= $this->input->post('nik_karyawan'); ?>" class="btn btn-primary mb-2 ml-4">
                <i class="fas fa-plus"></i>
                Tambah Data Pendidikan Formal
            </a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tingkat Pendidikan</th>
                        <th scope="col">Nama Instansi</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Tahun Lulus</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php
                    foreach ($pendidikanformal as $row) :
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['tingkat_pendidikan_formal']; ?></td>
                            <td><?= $row['nama_instansi_pendidikan']; ?></td>
                            <td><?= $row['jurusan']; ?></td>
                            <td><?= $row['tahun_lulus']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>assets/file/pendidikanformal/<?= $row['dokumen_pendidikan_formal']; ?>" target="_blank" class="btn btn-primary btn-sm "><i class="fas fa-search"></i> Lihat File</a>
                                <a href="<?= base_url(); ?>history/editpendidikanformal/<?= $row['id_history_pendidikan_formal']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>history/hapuspendidikanformal/<?= $row['id_history_pendidikan_formal']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
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