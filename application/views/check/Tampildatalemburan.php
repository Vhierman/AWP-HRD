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

            <!-- Button Tambah Data Lembur -->
            <a href="" class="btn btn-sm btn-primary mb-3 ml-4" data-toggle="modal" data-target="#viewVerifikasiLembur">
                <i class="fas fa-check"></i>
                Verifikasi Data Lembur
            </a>

            <!-- Table Data Karyawan -->
            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Karyawan</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Tanggal Lembur</th>
                        <th scope="col">Keterangan Lembur</th>
                        <th scope="col">Status Lembur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php
                    foreach ($ceklembur as $lbr) :
                        $tanggallembur        = date('d-m-Y', strtotime($lbr['tanggal_lembur']));
                        if ($lbr['acc_supervisor'] == "" && $lbr['acc_manager'] == "" && $lbr['acc_hrd'] == "") {
                            $status = "Menunggu Verifikasi";
                        } elseif ($lbr['acc_supervisor'] != "" && $lbr['acc_manager'] == "" && $lbr['acc_hrd'] != "") {
                            $status = "Menunggu Verifikasi Manager";
                        } elseif ($lbr['acc_supervisor'] != "" && $lbr['acc_manager'] != "" && $lbr['acc_hrd'] == "") {
                            $status = "Menunggu Verifikasi HRD";
                        } elseif ($lbr['acc_supervisor'] == "" && $lbr['acc_manager'] != "" && $lbr['acc_hrd'] != "") {
                            $status = "Menunggu Verifikasi Supervisor";
                        } elseif ($lbr['acc_supervisor'] != "" && $lbr['acc_manager'] == "" && $lbr['acc_hrd'] == "") {
                            $status = "Menunggu Verifikasi Manager Dan HRD";
                        } elseif ($lbr['acc_supervisor'] == "" && $lbr['acc_manager'] != "" && $lbr['acc_hrd'] == "") {
                            $status = "Menunggu Verifikasi Supervisor Dan HRD";
                        } elseif ($lbr['acc_supervisor'] == "" && $lbr['acc_manager'] == "" && $lbr['acc_hrd'] != "") {
                            $status = "Menunggu Verifikasi Supervisor Dan Manager";
                        } else {
                            $status = "Verifikasi Selesai";
                        }
                    ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $lbr['nama_karyawan']; ?></td>
                            <td><?= $lbr['jabatan']; ?></td>
                            <td><?= $lbr['penempatan']; ?></td>
                            <td><?= $tanggallembur; ?></td>
                            <td><?= $lbr['keterangan_lembur']; ?></td>
                            <td><?= $status; ?></td>
                        </tr>

                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewVerifikasiLembur" tabindex="-1" role="dialog" aria-label="viewVerifikasiLemburLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewVerifikasiLemburLabel">Verifikasi Data Lembur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body border-bottom-danger">
                    <form action="<?= base_url('check/verifikasidatalemburan'); ?>" method="post">

                        <!-- Menyimpan Data Sementara Kedalam Variabel -->
                        <?php
                        $tanggalawal    = $this->input->post('tanggal_awal', true);
                        $tanggalakhir   = $this->input->post('tanggal_akhir', true);
                        $penempatanid   = $this->input->post('penempatan_id', true);
                        ?>

                        <input type="hidden" value="<?= $tanggalawal; ?>" name="tanggal_awal" class="form-control">
                        <input type="hidden" value="<?= $tanggalakhir; ?>" name="tanggal_akhir" class="form-control">
                        <input type="hidden" value="<?= $penempatanid; ?>" name="penempatan_id" class="form-control">
                        <!-- End Menyimpan Data Sementara Kedalam Variabel -->

                        <div class="form-group row">
                            <label for="nm_karyawan" class="col-sm-3 col-form-label"><b>Verifikasi Data Lembur</b></label>
                            <div class="col-sm-9">
                                <select class="selectpicker" name="verifikasi_lembur" data-width="100%" data-live-search="true" required>
                                    <option value="">Verifikasi Data</option>
                                    <option value="Verifikasi">Verifikasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Verifikasi Semua Data Lembur Yang Dipilih</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal -->


</div>