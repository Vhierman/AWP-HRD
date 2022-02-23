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

            <!-- Mencari Tanggal Rekon Terakhir -->
            <?php
            $mulai_tanggal  = $this->input->post('mulai_tanggal', true);
            $sampai_tanggal = $this->input->post('sampai_tanggal', true);
            $query = $this->db->query("SELECT MAX(periode_awal_gaji_history) as periodeawalgajihistory from history_gaji");
            $hasil = $query->row();
            $coba = $hasil->periodeawalgajihistory;
            ?>

            <!-- JIka Data Pada Tanggal Tersebut Sudah Di Rekon -->
            <?php if ($mulai_tanggal == $coba) : ?>
                <a href="<?= base_url('gaji/canceldatarekonsiliasigaji/'); ?><?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" class="btn btn-danger mb-2 ml-4"><i class="fas fa-ban"></i> Cancel Semua Rekonsiliasi Data </a>
                <!-- JIka Data Pada Tanggal Tersebut Belum Pernah Di Rekon -->
            <?php else : ?>
                <a href="<?= base_url('gaji/prosesdatarekonsiliasigaji/'); ?><?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" class="btn btn-primary mb-2 ml-4"><i class="fas fa-check"></i> Proses Rekonsiliasi Data </a>
                <!-- Download Data Untuk DI Cek Terlebih Dahulu -->
                <a href="<?= base_url('gaji/downloadrekonsiliasigajiprimaexcell/'); ?><?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" class="btn btn-success mb-2 ml-4"><i class="fas fa-download"></i> Download Excell PT Prima Komponen Indonesia</a>
                <a href="<?= base_url('gaji/downloadrekonsiliasigajipetraexcell/'); ?><?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" class="btn btn-success mb-2 ml-4"><i class="fas fa-download"></i> Download Excell PT Petra Ariesca </a>
            <?php endif; ?>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Karyawan</th>
                        <th scope="col">Penempatan</th>
                        <!-- JIka Data Pada Tanggal Tersebut Sudah Di Rekon Maka Button Action Tampil -->
                        <?php if ($mulai_tanggal == $coba) : ?>
                            <th scope="col">Action</th>
                            <!-- JIka Data Pada Tanggal Tersebut Belum Di Rekon Maka Button Action Tidak Tampil -->
                        <?php else : ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1; ?>
                    <?php foreach ($rekon as $row) : ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $row['nama_karyawan']; ?></td>
                            <td><?= $row['penempatan']; ?></td>
                            <!-- JIka Data Pada Tanggal Tersebut Sudah Di Rekon Maka Button Action Tampil -->
                            <?php if ($mulai_tanggal == $coba) : ?>
                                <td>
                                    <a href="<?= base_url(); ?>gaji/editrekongaji/<?= $row['karyawan_id_master']; ?>/<?= $mulai_tanggal . '/' . $sampai_tanggal  ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                </td>
                                <!-- JIka Data Pada Tanggal Tersebut Belum Di Rekon Maka Button Action Tidak Tampil -->
                            <?php else : ?>
                            <?php endif; ?>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- /.container-fluid -->