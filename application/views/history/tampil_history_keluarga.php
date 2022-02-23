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

            <a href="<?= base_url('history/tambahkeluarga/'); ?><?= $this->input->post('nik_karyawan'); ?>" class="btn btn-primary mb-2 ml-4">
                <i class="fas fa-plus"></i>
                Tambah Data Keluarga
            </a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Hubungan Keluarga</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NIK</th>
                        <th scope="col">No BPJSKS</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php
                    foreach ($keluarga as $row) :
                        $tanggal_lahir_history_keluarga = IndonesiaTgl($row['tanggal_lahir_history_keluarga']);
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['hubungan_keluarga']; ?></td>
                            <td><?= $row['nama_history_keluarga']; ?></td>
                            <td><?= $row['nik_history_keluarga']; ?></td>
                            <td><?= $row['nomor_bpjs_kesehatan_history_keluarga']; ?></td>
                            <td><?= $tanggal_lahir_history_keluarga; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>assets/img/keluarga/<?= $row['file_history_keluarga']; ?>" target="_blank" class="btn btn-primary btn-sm "><i class="fas fa-search"></i> Lihat File</a>
                                <a href="<?= base_url(); ?>history/editkeluarga/<?= $row['id_history_keluarga']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>history/hapuskeluarga/<?= $row['id_history_keluarga']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
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