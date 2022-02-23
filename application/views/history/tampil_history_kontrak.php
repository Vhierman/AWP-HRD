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

            <a href="<?= base_url('history/tambahdetailkontrak/'); ?><?= $this->input->post('nik_karyawan'); ?>" class="btn btn-primary mb-2 ml-4">
                <i class="fas fa-plus"></i>
                Tambah Data History Kontrak
            </a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">Awal Kontrak</th>
                        <th scope="col">Akhir Kontrak</th>
                        <th scope="col">Masa Kontrak</th>
                        <th scope="col">Status Kontrak</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php 
                    foreach ($kontrak as $row) : 
                        $tanggal_awal_kontrak = IndonesiaTgl($row['tanggal_awal_kontrak']);
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['nama_karyawan']; ?></td>
                            <td><?= $tanggal_awal_kontrak; ?></td>
                            <td><?= $row['tanggal_akhir_kontrak']; ?></td>
                            <td><?= $row['masa_kontrak']; ?></td>
                            <td><?= $row['status_kontrak_kerja']; ?></td>
                            <td>
								<a href="<?= base_url(); ?>history/cetakpkwtt/<?= $row['id_history_kontrak']; ?>" target="_blank" class="btn btn-primary btn-sm "><i class="fas fa-pen"></i> Cetak</a>
                                <a href="<?= base_url(); ?>history/editkontrak/<?= $row['id_history_kontrak']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>history/hapuskontrak/<?= $row['id_history_kontrak']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
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
