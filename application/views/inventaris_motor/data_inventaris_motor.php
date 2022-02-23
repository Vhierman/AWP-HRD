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
            //Jika Yang Login adalah HRD Maka Button Tambah Tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah Data Inventaris Motor -->
                <a href="<?= base_url('inventaris/tambahinventarismotor'); ?>" class="btn btn-primary mb-2 ml-4">
                    <i class="fas fa-plus"></i>
                    Tambah Data Inventaris Motor
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
                        <th scope="col">Merk Motor</th>
                        <th scope="col">Type Motor</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($motor as $mt) : ?>
                        <?php
                        $tanggal_penyerahan_motor          = date('d-m-Y', strtotime($mt['tanggal_penyerahan_motor']));
                        ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $mt['nik_karyawan']; ?></td>
                            <td><?= $mt['nama_karyawan']; ?></td>
                            <td><?= $mt['merk_motor']; ?></td>
                            <td><?= $mt['type_motor']; ?></td>
                            <td>
                                <a href="<?= base_url(); ?>inventaris/lihatinventarismotor/<?= $mt['id_inventaris_motor']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View</a>

                                <!-- Jika Yang Login adalah HRD Maka Button Akan Tampil Semua -->
                                <?php if ($role_id == 1 || $role_id == 11) : ?>
                                    <a href="<?= base_url(); ?>inventaris/editinventarismotor/<?= $mt['id_inventaris_motor']; ?>" class="btn btn-sm btn-success  "><i class="fas fa-pen"></i> Edit</a>
                                    <a href="<?= base_url(); ?>inventaris/hapusinventarismotor/<?= $mt['id_inventaris_motor']; ?>" class="btn btn-sm btn-danger  " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
                                    <!-- Jika Yang Login adalah Bukan HRD Maka Button Tidak Akan Tampil Semua -->
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