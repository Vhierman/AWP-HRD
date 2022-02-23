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
            //Mengambil Data Session
            $role_id        = $this->session->userdata("role_id");
            //Jika yang login HRD Button Tambah Tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah Data Inventaris Mobil -->
                <a href="<?= base_url('inventaris/tambahinventarismobil'); ?>" class="btn btn-primary mb-2 ml-4">
                    <i class="fas fa-plus"></i>
                    Tambah Data Inventaris Mobil
                </a>
                <!-- Jika Yang Login adalah Bukan HRD Maka Button Tambah Tidak Tampil -->
            <?php else : ?>
            <?php endif; ?>

            <!-- Table Data Inventaris -->
            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIK Karyawan</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">Merk Mobil</th>
                        <th scope="col">Type Mobil</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($mobil as $mt) : ?>
                        <?php
                        $tanggal_penyerahan_mobil          = date('d-m-Y', strtotime($mt['tanggal_penyerahan_mobil']));
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $mt['nik_karyawan']; ?></td>
                            <td><?= $mt['nama_karyawan']; ?></td>
                            <td><?= $mt['merk_mobil']; ?></td>
                            <td><?= $mt['type_mobil']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>inventaris/lihatinventarismobil/<?= $mt['id_inventaris_mobil']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                                <!-- Jika yang login HRD, Maka Button akan tampil Semua -->
                                <?php if ($role_id == 1 || $role_id == 11) : ?>

                                    <a href="<?= base_url(); ?>inventaris/editinventarismobil/<?= $mt['id_inventaris_mobil']; ?>" class="btn btn-sm btn-success  "><i class="fas fa-pen"></i> Edit</a>
                                    <a href="<?= base_url(); ?>inventaris/hapusinventarismobil/<?= $mt['id_inventaris_mobil']; ?>" class="btn btn-sm btn-danger  " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
                                    <!-- Jika yang login Adalah bukan HRD, maka hanya button Lihat Yang Tampil-->
                                <?php else : ?>
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