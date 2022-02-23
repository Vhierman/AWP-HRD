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

            <!-- Jika Yang Login adalah Staff HRD Maka Button Tambah Dan Download Tampil -->
            <?php
            //Mengambil Session
            $role_id        = $this->session->userdata("role_id");
            //Jika Yang Login HRD, button tambah akan tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah Data Inventaris Laptop -->
                <a href="<?= base_url('inventaris/tambahinventarislaptop'); ?>" class="btn btn-primary mb-2 ml-4">
                    <i class="fas fa-plus"></i>
                    Tambah Data Inventaris Laptop
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
                        <th scope="col">Merk Laptop</th>
                        <th scope="col">Type Laptop</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($laptop as $lp) : ?>
                        <?php
                        $tanggal_penyerahan_laptop          = date('d-m-Y', strtotime($lp['tanggal_penyerahan_laptop']));
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $lp['nik_karyawan']; ?></td>
                            <td><?= $lp['nama_karyawan']; ?></td>
                            <td><?= $lp['merk_laptop']; ?></td>
                            <td><?= $lp['type_laptop']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>inventaris/lihatinventarislaptop/<?= $lp['id_inventaris_laptop']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>
                                <!-- Jika Yang Login adalah HRD Maka Button Akan Tampil Semua -->
                                <?php if ($role_id == 11 || $role_id == 11) : ?>
                                    <a href="<?= base_url(); ?>inventaris/editinventarislaptop/<?= $lp['id_inventaris_laptop']; ?>" class="btn btn-sm btn-success  "><i class="fas fa-pen"></i> Edit</a>
                                    <a href="<?= base_url(); ?>inventaris/hapusinventarislaptop/<?= $lp['id_inventaris_laptop']; ?>" class="btn btn-sm btn-danger  " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
                                    <!-- Jika Yang Login adalah Bukan HRD Maka Button EDIT Dan Hapus Tidak Akan Tampil Semua -->
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