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
            <!-- Menampilkan Pesan Kesalahan -->

            <?php
            //Mengambil Session
            $role_id        = $this->session->userdata("role_id");
            //Jika Yang Login adalah HRD Maka Button Tambah Dan Download Tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah Data Karyawan -->
                <a href="<?= base_url('karyawan/tambahkaryawan'); ?>" class="btn btn-primary mb-2 ml-4">
                    <i class="fas fa-plus"></i>
                    Tambah Data Karyawan
                </a>
                <!-- Button Download Data Karyawan -->
                <a href="<?= base_url('karyawan/downloaddatakaryawan'); ?>" class="btn btn-success mb-2 ml-4">
                    <i class="fas fa-download"></i>
                    Download Data Karyawan
                </a>
                <!-- Jika Yang Login adalah Accounting -->
            <?php
                //Mengambil Session
                $role_id        = $this->session->userdata("role_id");
            elseif ($role_id == 17 || $role_id == 18 || $role_id == 9 || $role_id == 10) : ?>
                <!-- Button Download Data Karyawan -->
                <a href="<?= base_url('karyawan/downloaddatakaryawan'); ?>" class="btn btn-success mb-2 ml-4">
                    <i class="fas fa-download"></i>
                    Download Data Karyawan
                </a>
                <!-- Jika Yang Login adalah Bukan HRD Maka Button Tambah Dan Download Tidak Tampil -->
            <?php else : ?>
            <?php endif; ?>

            <!-- Table Data Karyawan -->
            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">NIK Karyawan</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Status Kontrak</th>
                        <th scope="col">Tanggal Kerja</th>
                        <th scope="col">Tanggal Akhir</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($joinkaryawan as $pm) :
                        $tanggalmulaikerja         = date('d-m-Y', strtotime($pm['tanggal_mulai_kerja']));
                        $tanggallahir               = date('d-m-Y', strtotime($pm['tanggal_lahir']));
                        if ($pm['status_kerja'] != 'PKWT') {
                            $tanggalakhirkerja         = $pm['status_kerja'];
                        } else {
                            $tanggalakhirkerja         = date('d-m-Y', strtotime($pm['tanggal_akhir_kerja']));
                        }
                    ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $pm['nama_karyawan']; ?></td>
                            <td><?= $pm['nik_karyawan']; ?></td>
                            <td><?= $pm['penempatan']; ?></td>
                            <td><?= $pm['status_kerja']; ?></td>
                            <td><?= $tanggalmulaikerja; ?></td>
                            <td><?= $tanggalakhirkerja; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>karyawan/lihatkaryawan/<?= $pm['id_karyawan']; ?>" class="btn btn-sm btn-primary" title="Lihat"><i class="fas fa-eye"></i></a>

                                <!-- Jika yang login HRD, Maka Button EDIT, Lihat, Dan Hapus Akan Tampil Semua-->
                                <?php if ($role_id == 1 || $role_id == 11) : ?>
                                    <a href="<?= base_url(); ?>karyawan/resumekaryawan/<?= $pm['nik_karyawan']; ?>" class="btn btn-sm btn-info" title="Resume" target="_blank"><i class="fas fa-address-card"></i></a>
                                    <a href="<?= base_url(); ?>karyawan/editkaryawan/<?= $pm['id_karyawan']; ?>" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-pen"></i></a>
                                    <a href="<?= base_url(); ?>karyawan/hapuskaryawan/<?= $pm['id_karyawan']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i></a>
                                    <!-- Jika yang login Manager HRD Dan Supervisor, Maka Button  Resume Yang Tampil-->
                                <?php
                                    //Mengambil Session
                                    $role_id        = $this->session->userdata("role_id");
                                elseif ($role_id == 9 || $role_id == 10 || $role_id == 17 || $role_id == 18) :
                                ?>
                                    <a href="<?= base_url(); ?>karyawan/resumekaryawan/<?= $pm['nik_karyawan']; ?>" class="btn btn-sm btn-info" title="Resume" target="_blank"><i class="fas fa-address-card"></i></a>

                                <?php
                                //Jika Yang Login Bukan HRD,dan Accounting Maka Button Lihat Doank yang tampil
                                else : ?>
                                <?php endif; ?>
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