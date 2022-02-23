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

            <!-- Mengambil Data Input -->
            <?php
            $mulaitanggal  = $this->input->post('mulai_tanggal', true);
            $sampaitanggal = $this->input->post('sampai_tanggal', true);
            ?>
            <!-- Mengambil Data Input -->

            <!-- Jika Yang Login adalah HRD Maka Button Tambah Tampil -->
            <?php
            //Mengambil Session
            $role_id        = $this->session->userdata("role_id");
            //Jika Yang Login adalah HRD Maka Button Tambah Tampil
            if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) : ?>
                <!-- Button Tambah Data Karyawan Keluar -->
                <a href="<?= base_url('laporan/downloadpdfkaryawankeluarprima/'); ?><?= $mulaitanggal . '/' . $sampaitanggal  ?>" target="_blank" class="btn btn-danger mb-2 ml-4">
                    <i class="fas fa-download"></i>
                    Download PDF ( PRIMA )
                </a>
                <a href="<?= base_url('laporan/downloadpdfkaryawankeluarpetra/'); ?><?= $mulaitanggal . '/' . $sampaitanggal  ?>" target="_blank" class="btn btn-danger mb-2 ml-4">
                    <i class="fas fa-download"></i>
                    Download PDF ( PETRA )
                </a>
                <a href="<?= base_url('laporan/downloadexcellkaryawankeluarprima/'); ?><?= $mulaitanggal . '/' . $sampaitanggal  ?>" target="_blank" class="btn btn-success mb-2 ml-4">
                    <i class="fas fa-download"></i>
                    Download Excell ( PRIMA )
                </a>
                <a href="<?= base_url('laporan/downloadexcellkaryawankeluarpetra/'); ?><?= $mulaitanggal . '/' . $sampaitanggal  ?>" target="_blank" class="btn btn-success mb-2 ml-4">
                    <i class="fas fa-download"></i>
                    Download Excell ( PETRA )
                </a>
                <!-- Jika Yang Login adalah Bukan HRD Maka Button Tambah Tidak Tampil -->
            <?php else : ?>
            <?php endif; ?>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">NIK Karyawan</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($tampillaporan as $row) : ?>
                        <?php
                        $tanggalmasukkaryawankeluar        = date('d-m-Y', strtotime($row['tanggal_masuk_karyawan_keluar']));
                        $tanggalkeluarkaryawankeluar        = date('d-m-Y', strtotime($row['tanggal_keluar_karyawan_keluar']));
                        ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['nama_karyawan_keluar']; ?></td>
                            <td><?= $row['nik_karyawan_keluar']; ?></td>
                            <td><?= $row['penempatan']; ?></td>
                            <td><?= $tanggalmasukkaryawankeluar; ?></td>
                            <td><?= $tanggalkeluarkaryawankeluar; ?></td>
                        </tr>


                        <?php $i++; ?>

                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- /.container-fluid -->