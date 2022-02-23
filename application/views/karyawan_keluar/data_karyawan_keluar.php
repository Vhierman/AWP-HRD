<!-- Function untuk view modal pada Karyawan Keluar -->
<script type="text/javascript">
    function viewdata($nik_karyawan_keluar, $nama_karyawan_keluar, $jabatan, $penempatan, $nomor_npwp_karyawan_keluar, $nomor_handphone_karyawan_keluar, $email_karyawan_keluar, $tempat_lahir_karyawan_keluar, $tanggallahirkaryawankeluar, $nomor_jkn_karyawan_keluar, $nomor_jht_karyawan_keluar, $nomor_jp_karyawan_keluar, $nomor_rekening_karyawan_keluar, $tanggalmasukkaryawankeluar, $tanggalkeluarkaryawankeluar, $status_kerja_karyawan_keluar, $keterangan_keluar) {
        $("#nik_karyawan_keluar").val($nik_karyawan_keluar);
        $("#nama_karyawan_keluar").val($nama_karyawan_keluar);
        $("#jabatan").val($jabatan);
        $("#penempatan").val($penempatan);
        $("#nomor_npwp_karyawan_keluar").val($nomor_npwp_karyawan_keluar);
        $("#nomor_handphone_karyawan_keluar").val($nomor_handphone_karyawan_keluar);
        $("#email_karyawan_keluar").val($email_karyawan_keluar);
        $("#tempat_lahir_karyawan_keluar").val($tempat_lahir_karyawan_keluar);
        $("#tanggallahirkaryawankeluar").val($tanggallahirkaryawankeluar);
        $("#nomor_jkn_karyawan_keluar").val($nomor_jkn_karyawan_keluar);
        $("#nomor_jht_karyawan_keluar").val($nomor_jht_karyawan_keluar);
        $("#nomor_jp_karyawan_keluar").val($nomor_jp_karyawan_keluar);
        $("#nomor_rekening_karyawan_keluar").val($nomor_rekening_karyawan_keluar);
        $("#tanggalmasukkaryawankeluar").val($tanggalmasukkaryawankeluar);
        $("#tanggalkeluarkaryawankeluar").val($tanggalkeluarkaryawankeluar);
        $("#status_kerja_karyawan_keluar").val($status_kerja_karyawan_keluar);
        $("#keterangan_keluar").val($keterangan_keluar);
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

            <!-- Jika Yang Login adalah HRD Maka Button Tambah Tampil -->
            <?php
            //Mengambil Session
            $role_id        = $this->session->userdata("role_id");
            //Jika Yang Login adalah HRD Maka Button Tambah Tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah Data Karyawan Keluar -->
                <a href="<?= base_url('KaryawanKeluar/tambahkaryawankeluar'); ?>" class="btn btn-primary mb-2 ml-4">
                    <i class="fas fa-plus"></i>
                    Tambah Data Karyawan Keluar
                </a>
                <!-- Jika Yang Login adalah Bukan HRD Maka Button Tambah Tidak Tampil -->
            <?php else : ?>
            <?php endif; ?>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Karyawan Keluar</th>
                        <th scope="col">NIK Karyawan Keluar</th>
                        <th scope="col">No BPJS Kesehatan</th>
                        <th scope="col">No Rekening</th>
                        <th scope="col">Tanggal Keluar</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($datakeluar as $kk) : ?>
                        <?php
                        $tanggallahirkaryawankeluar         = date('d-m-Y', strtotime($kk['tanggal_lahir_karyawan_keluar']));
                        $tanggalmasukkaryawankeluar        = date('d-m-Y', strtotime($kk['tanggal_masuk_karyawan_keluar']));
                        $tanggalkeluarkaryawankeluar        = date('d-m-Y', strtotime($kk['tanggal_keluar_karyawan_keluar']));
                        ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $kk['nama_karyawan_keluar']; ?></td>
                            <td><?= $kk['nik_karyawan_keluar']; ?></td>
                            <td><?= $kk['nomor_jkn_karyawan_keluar']; ?></td>
                            <td><?= $kk['nomor_rekening_karyawan_keluar']; ?></td>
                            <td><?= $tanggalkeluarkaryawankeluar; ?></td>
                            <td><?= $kk['penempatan']; ?></td>
                            <td><?= $kk['status_kerja_karyawan_keluar']; ?></td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewKaryawanKeluar" onclick="viewdata(
                        '<?= $kk['nik_karyawan_keluar']; ?>',
                        '<?= $kk['nama_karyawan_keluar']; ?>',
                        '<?= $kk['jabatan']; ?>',
                        '<?= $kk['penempatan']; ?>',
                        '<?= $kk['nomor_npwp_karyawan_keluar']; ?>',
                        '<?= $kk['nomor_handphone_karyawan_keluar']; ?>',
                        '<?= $kk['email_karyawan_keluar']; ?>',
                        '<?= $kk['tempat_lahir_karyawan_keluar']; ?>',
                        '<?= $tanggallahirkaryawankeluar; ?>',
                        '<?= $kk['nomor_jkn_karyawan_keluar']; ?>',
                        '<?= $kk['nomor_jht_karyawan_keluar']; ?>',
                        '<?= $kk['nomor_jp_karyawan_keluar']; ?>',
                        '<?= $kk['nomor_rekening_karyawan_keluar']; ?>',
                        '<?= $tanggalmasukkaryawankeluar; ?>',
                        '<?= $tanggalkeluarkaryawankeluar; ?>',
                        '<?= $kk['status_kerja_karyawan_keluar']; ?>',
                        '<?= $kk['keterangan_keluar']; ?>'
                        )">
                                    <i class="fas fa-eye"></i>View</a>

                                <!-- Jika Yang Login adalah HRD Maka Button EDIT Dan Hapus Akan Tampil Semua -->
                                <?php if ($role_id == 1 || $role_id == 11) : ?>
                                    <a href="<?= base_url(); ?>KaryawanKeluar/editkaryawankeluar/<?= $kk['id_karyawan_keluar']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                    <a href="<?= base_url(); ?>KaryawanKeluar/hapuskaryawankeluar/<?= $kk['id_karyawan_keluar']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
                                    <!-- Jika Yang Login adalah Bukan HRD Maka Data Tidak Akan Tampil Semua -->
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

<!-- Modal View Karyawan Keluar -->
<div class="modal fade" id="viewKaryawanKeluar" tabindex="-1" role="dialog" aria-labelledby="viewKaryawanKeluarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewKaryawanKeluarLabel">View Data Karyawan Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-danger">

                <div class="form-group row">
                    <label for="nik_karyawan_keluar" class="col-sm-3 col-form-label"><b>NIK Karyawan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nik_karyawan_keluar" id="nik_karyawan_keluar">
                    </div>
                    <label for="nama_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nama Karyawan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nama_karyawan_keluar" id="nama_karyawan_keluar">
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
                    <label for="nomor_npwp_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nomor NPWP</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_npwp_karyawan_keluar" id="nomor_npwp_karyawan_keluar">
                    </div>
                    <label for="nomor_handphone_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nomor Handphone</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_handphone_karyawan_keluar" id="nomor_handphone_karyawan_keluar">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email_karyawan_keluar" class="col-sm-3 col-form-label"><b>Alamat Email</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="email_karyawan_keluar" id="email_karyawan_keluar">
                    </div>
                    <label for="tempat_lahir_karyawan_keluar" class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tempat_lahir_karyawan_keluar" id="tempat_lahir_karyawan_keluar">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggallahirkaryawankeluar" class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggallahirkaryawankeluar" id="tanggallahirkaryawankeluar">
                    </div>
                    <label for="nomor_jkn_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nomor JKN</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_jkn_karyawan_keluar" id="nomor_jkn_karyawan_keluar">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nomor_jht_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nomor JHT</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_jht_karyawan_keluar" id="nomor_jht_karyawan_keluar">
                    </div>
                    <label for="nomor_jp_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nomor JP</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_jp_karyawan_keluar" id="nomor_jp_karyawan_keluar">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nomor_rekening_karyawan_keluar" class="col-sm-3 col-form-label"><b>Nomor Rekening</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_rekening_karyawan_keluar" id="nomor_rekening_karyawan_keluar">
                    </div>
                    <label for="status_kerja_karyawan_keluar" class="col-sm-3 col-form-label"><b>Status Kerja</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="status_kerja_karyawan_keluar" id="status_kerja_karyawan_keluar">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggalmasukkaryawankeluar" class="col-sm-3 col-form-label"><b>Tanggal Masuk</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggalmasukkaryawankeluar" id="tanggalmasukkaryawankeluar">
                    </div>
                    <label for="tanggalkeluarkaryawankeluar" class="col-sm-3 col-form-label"><b>Tanggal Keluar</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggalkeluarkaryawankeluar" id="tanggalkeluarkaryawankeluar">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="keterangan_keluar" class="col-sm-3 col-form-label"><b>Keterangan Keluar</b></label>
                    <div class="col-sm-5">
                        <input type="text" readonly class="form-control-plaintext" name="keterangan_keluar" id="keterangan_keluar">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End of Modal -->
