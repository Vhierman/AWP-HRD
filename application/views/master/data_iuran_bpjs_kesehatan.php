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
                        <th scope="col">BPJSKS Beban Karyawan</th>
                        <th scope="col">BPJSKS Beban Perusahaan</th>
                        <th scope="col">Maksimal Iuran BPJSKS</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($bpjskesehatan as $row) : ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $row['potongan_bpjs_kesehatan_karyawan'] . "%"; ?></td>
                            <td><?= $row['potongan_bpjs_kesehatan_perusahaan'] . "%"; ?></td>
                            <td><?= "Rp." . format_angka($row['maksimal_iuran_bpjs_kesehatan']); ?></td>
                            <td>
                                <a href="<?= base_url(); ?>master/editbpjskesehatan/<?= $row['id_potongan_bpjs_kesehatan']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
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