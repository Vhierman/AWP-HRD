<!-- Begin Page Content -->
<div class="container-fluid">

    <?php
    $mulai_tanggal  = $this->input->post('mulai_tanggal', true);
    $sampai_tanggal = $this->input->post('sampai_tanggal', true);
    ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?> Periode <?= IndonesiaTgl($mulai_tanggal); ?> Sampai <?= IndonesiaTgl($sampai_tanggal); ?></h1>

    <div class="row">
        <div class="col-lg">
            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>
            
            
            <!-- Download Data Untuk DI Cek Terlebih Dahulu -->
            <a href="<?= base_url('gaji/downloadrekapgajiprimaexcell/'); ?><?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" target="_blank" class="btn btn-success mb-2 ml-4"><i class="fas fa-download"></i> Download Rekap Gaji Format Excell</a>
            <a href="<?= base_url('gaji/downloadrekapgajiprimapdf/'); ?><?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" target="_blank" class="btn btn-danger mb-2 ml-4"><i class="fas fa-download"></i> Download Rekap Gaji Format PDF </a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Jumlah Upah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1; ?>
                    <?php foreach ($rekap as $row) : ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $row['nama_karyawan']; ?></td>
                            <td><?= $row['penempatan']; ?></td>
                            <td><?= "Rp. ".format_angka($row['jumlah_upah_history']).",-"; ?></td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- /.container-fluid -->