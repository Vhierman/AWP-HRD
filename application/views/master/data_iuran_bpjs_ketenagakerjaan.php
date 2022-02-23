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

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">JHT Beban Karyawan</th>
                        <th scope="col">JHT Beban Perusahaan</th>
                        <th scope="col">JP Beban Karyawan</th>
                        <th scope="col">JP Beban Perusahaan</th>
                        <th scope="col">JKK Beban Perusahaan</th>
                        <th scope="col">JKM Beban Perusahaan</th>
                        <th scope="col">Maksimal Iuran JP</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($bpjsketenagakerjaan as $row) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['potongan_jht_karyawan'] . "%"; ?></td>
                            <td><?= $row['potongan_jht_perusahaan'] . "%"; ?></td>
                            <td><?= $row['potongan_jp_karyawan'] . "%"; ?></td>
                            <td><?= $row['potongan_jp_perusahaan'] . "%"; ?></td>
                            <td><?= $row['potongan_jkk_perusahaan'] . "%"; ?></td>
                            <td><?= $row['potongan_jkm_perusahaan'] . "%"; ?></td>
                            <td><?= "Rp." . format_angka($row['maksimal_iuran_jp']); ?></td>
                            <td>
                                <a href="<?= base_url(); ?>master/editbpjsketenagakerjaan/<?= $row['id_potongan_bpjs_ketenagakerjaan']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
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