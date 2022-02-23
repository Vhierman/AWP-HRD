<!-- Function untuk view modal pada magang -->
<script type="text/javascript">
    function viewdata($nama_karyawan, $jabatan, $penempatan, $tanggallembur, $jam_masuk, $jam_istirahat, $jam_pulang, $input_oleh, $acc_supervisor, $acc_manager, $acc_hrd) {
        $("#nama_karyawan").val($nama_karyawan);
        $("#jabatan").val($jabatan);
        $("#penempatan").val($penempatan);
        $("#tanggallembur").val($tanggallembur);
        $("#jam_masuk").val($jam_masuk);
        $("#jam_istirahat").val($jam_istirahat);
        $("#jam_pulang").val($jam_pulang);
        $("#input_oleh").val($input_oleh);
        $("#acc_supervisor").val($acc_supervisor);
        $("#acc_manager").val($acc_manager);
        $("#acc_hrd").val($acc_hrd);
    }
</script>

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
            $role = $this->session->userdata("role_id");
            //Jika yang login adalah leader, atau staff HRD maka form tambah akan tampil
            if ($role == 8 || $role == 1 || $role == 11) :
            ?>
                <!-- Button Tambah Data Lembur -->
                <a href="" class="btn btn-sm btn-primary mb-3 ml-4" data-toggle="modal" data-target="#viewTambahLembur">
                    <i class="fas fa-plus"></i>
                    Tambah Data Lembur
                </a>
                <!-- Jika tidak, maka form tambah tidak akan tampil -->
            <?php else : ?>
            <?php endif; ?>

            <!-- Table Data Lembur -->
            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Karyawan</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Tanggal Lembur</th>
                        <th scope="col">Keterangan Lembur</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php foreach ($lembur as $lbr) :
                        $tanggallembur        = date('d-m-Y', strtotime($lbr['tanggal_lembur']));
                    ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $lbr['nama_karyawan']; ?></td>
                            <td><?= $lbr['jabatan']; ?></td>
                            <td><?= $lbr['penempatan']; ?></td>
                            <td><?= $tanggallembur; ?></td>
                            <td><?= $lbr['keterangan_lembur']; ?></td>
                            <?php

                            if ($role == 8 || $role == 1 || $role == 11) :
                            ?>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#viewLembur" class="btn btn-sm btn-primary" title="Lihat" onclick="viewdata(
                                                '<?= $lbr['nama_karyawan']; ?>',
                                                '<?= $lbr['jabatan']; ?>',
                                                '<?= $lbr['penempatan']; ?>',
                                                '<?= $tanggallembur; ?>',
                                                '<?= $lbr['jam_masuk']; ?>',
                                                '<?= $lbr['jam_istirahat']; ?>',
                                                '<?= $lbr['jam_pulang']; ?>',
                                                '<?= $lbr['input_oleh']; ?>',
                                                '<?= $lbr['acc_supervisor']; ?>',
                                                '<?= $lbr['acc_manager']; ?>',
                                                '<?= $lbr['acc_hrd']; ?>'
                                                
                                                )"><i class="fas fa-search"></i></a>
                                    <a href="<?= base_url(); ?>lembur/editlembur/<?= $lbr['id_slip_lembur']; ?>" class="btn btn-sm btn-success" title="Edit"><i class="fas fa-pen"></i></a>
                                    <a href="<?= base_url(); ?>lembur/hapuslembur/<?= $lbr['id_slip_lembur']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini'); " title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            <?php else : ?>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#viewLembur" class="btn btn-sm btn-primary" title="Lihat" onclick="viewdata(
                                                '<?= $lbr['nama_karyawan']; ?>',
                                                '<?= $lbr['jabatan']; ?>',
                                                '<?= $lbr['penempatan']; ?>',
                                                '<?= $tanggallembur; ?>',
                                                '<?= $lbr['jam_masuk']; ?>',
                                                '<?= $lbr['jam_istirahat']; ?>',
                                                '<?= $lbr['jam_pulang']; ?>',
                                                '<?= $lbr['input_oleh']; ?>',
                                                '<?= $lbr['acc_supervisor']; ?>',
                                                '<?= $lbr['acc_manager']; ?>',
                                                '<?= $lbr['acc_hrd']; ?>'
                                                
                                                )"><i class="fas fa-search"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Data Lembur-->
    <div class="modal fade" id="viewTambahLembur" tabindex="-1" role="dialog" aria-label="viewTambahLemburLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTambahLemburLabel">Tambah Data Lembur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body border-bottom-danger">
                    <form action="<?= base_url('lembur/datalembur'); ?>" method="post">

                        <div class="form-group row">
                            <label for="tanggal_lembur" class="col-sm-3 col-form-label"><b>Tanggal Lembur</b></label>
                            <div class="col-sm-9">
                                <input type="text" name="tanggal_lembur" id="tanggal_lembur" class="form-control" placeholder="Tanggal Lembur ( yyyy-mm-dd )" readonly="readonly" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jenis_lembur" class="col-sm-3 col-form-label"><b>Jenis Lembur</b></label>
                            <div class="col-sm-9">
                                <select class="selectpicker" name="jenis_lembur" data-width="100%" data-live-search="true" required>
                                    <option value="">Pilih Jenis Hari Lembur</option>
                                    <option value="Libur">Libur</option>
                                    <option value="Biasa">Biasa</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nik_karyawan" class="col-sm-3 col-form-label"><b>Nama Karyawan</b></label>
                            <div class="col-sm-9">
                                <select class="bootstrap-select" name="nik_karyawan[]" data-width="100%" data-live-search="true" multiple required>
                                    <?php foreach ($karyawan as $row) : ?>
                                        <option value="<?= $row['nik_karyawan']; ?>"><?= $row['nama_karyawan'] . "[ " . $row['jabatan'] . " ]" . " [ " . $row['penempatan'] . " ]"; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nm_karyawan" class="col-sm-3 col-form-label"><b>Jam Lembur</b></label>
                            <div class="col-sm-9">
                                <select class="selectpicker" name="jam_lembur" data-width="100%" data-live-search="true" required>
                                    <option value="">Pilih Jam</option>
                                    <?php foreach ($jamlembur as $row) : ?>
                                        <option value="<?= $row['id_jam_lembur']; ?>">Jam Masuk <?= $row['jam_masuk'] . " | Jam Istirahat " . $row['jam_istirahat'] . " | Jam Pulang " . "" . $row['jam_pulang'] . ""; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nm_karyawan" class="col-sm-3 col-form-label"><b>Keterangan Lembur</b></label>
                            <div class="col-sm-9">
                                <select class="selectpicker" name="keterangan_lembur" data-width="100%" data-live-search="true" required>
                                    <option value="">Pilih Keterangan</option>
                                    <?php foreach ($keteranganlembur as $row) : ?>
                                        <option value="<?= $row['id_keterangan_lembur']; ?>"><?= $row['keterangan_lembur']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tambah Data Lembur</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- End of Modal -->

    <!-- Modal View Magang -->
    <div class="modal fade" id="viewLembur" tabindex="-1" role="dialog" aria-labelledby="viewLemburLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewLemburLabel">View Data Lembur Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body border-bottom-danger">

                    <div class="form-group row">
                        <label for="nama_karyawan" class="col-sm-3 col-form-label"><b>Nama Karyawan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="nama_karyawan" id="nama_karyawan">
                        </div>
                        <label for="tanggallembur" class="col-sm-3 col-form-label"><b>Tanggal Lembur</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="tanggallembur" id="tanggallembur">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jabatan" class="col-sm-3 col-form-label"><b>Jabatan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="jabatan" id="jabatan">
                        </div>
                        <label for="penempatan" class="col-sm-3 col-form-label"><b>Penempatan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="penempatan" id="penempatan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jam_masuk" class="col-sm-2 col-form-label"><b>Jam Masuk</b></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control-plaintext" name="jam_masuk" id="jam_masuk">
                        </div>
                        <label for="jam_istirahat" class="col-sm-2 col-form-label"><b>Jam Istirahat</b></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control-plaintext" name="jam_istirahat" id="jam_istirahat">
                        </div>
                        <label for="jam_pulang" class="col-sm-2 col-form-label"><b>Jam Pulang</b></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control-plaintext" name="jam_pulang" id="jam_pulang">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input_oleh" class="col-sm-3 col-form-label"><b>Input Oleh</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="input_oleh" id="input_oleh">
                        </div>
                        <label for="acc_supervisor" class="col-sm-3 col-form-label"><b>Acc Supervisor</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="acc_supervisor" id="acc_supervisor">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="acc_manager" class="col-sm-3 col-form-label"><b>Acc Manager</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="acc_manager" id="acc_manager">
                        </div>
                        <label for="acc_hrd" class="col-sm-3 col-form-label"><b>Acc HRD</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" name="acc_hrd" id="acc_hrd">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End of Modal View Magang -->