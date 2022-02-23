<!-- Function untuk view modal pada magang -->
<script type="text/javascript">
    function viewdata($penempatan, $tanggal_masuk_magang, $tanggal_selesai_magang, $nik_magang, $nama_magang, $tempat_lahir_magang, $tanggal_lahir_magang, $agama_magang, $jenis_kelamin_magang, $nomor_handphone_magang, $alamat_magang, $rt_magang, $rw_magang, $kelurahan_magang, $kecamatan_magang, $kota_magang, $provinsi_magang, $kode_pos_magang) {
        $("#penempatan").val($penempatan);
        $("#tanggal_masuk_program_magang").val($tanggal_masuk_magang);
        $("#tanggal_selesai_program_magang").val($tanggal_selesai_magang);
        $("#nik_magang").val($nik_magang);
        $("#nama_magang").val($nama_magang);
        $("#tempat_lahir_magang").val($tempat_lahir_magang);
        $("#tanggal_lahir_program_magang").val($tanggal_lahir_magang);
        $("#agama_magang").val($agama_magang);
        $("#jenis_kelamin_magang").val($jenis_kelamin_magang);
        $("#nomor_handphone_magang").val($nomor_handphone_magang);
        $("#alamat_magang").val($alamat_magang);
        $("#rt_magang").val($rt_magang);
        $("#rw_magang").val($rw_magang);
        $("#kelurahan_magang").val($kelurahan_magang);
        $("#kecamatan_magang").val($kecamatan_magang);
        $("#kota_magang").val($kota_magang);
        $("#provinsi_magang").val($provinsi_magang);
        $("#kode_pos_magang").val($kode_pos_magang);
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

            <?php
            //Mengambiol Session
            $role_id        = $this->session->userdata("role_id");
            //Jika Yang Login adalah HRD Maka Button Tambah Akan Tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah -->
                <a href="<?= base_url('magang/tambahmagang'); ?>" class="btn btn-primary mb-2 ml-4"><i class="fas fa-plus"></i> Tambah Data Magang</a>
                <!-- Button Download -->
                <a href="<?= base_url('magang/downloadmagang/'); ?>" class="btn btn-success mb-2 ml-4"><i class="fas fa-download"></i> Download Data Magang</a>

                <!-- Jika Yang Login adalah Accounting  Maka Button Tambah Tidak Tampil -->
                <?php elseif($role_id == 9 || $role_id == 10 || $role_id == 17 || $role_id == 18) : ?>
                <!-- Button Download -->
                <a href="<?= base_url('magang/downloadmagang/'); ?>" class="btn btn-success mb-2 ml-4"><i class="fas fa-download"></i> Download Data Magang</a>

                <!-- Jika Yang Login adalah Bukan HRD Maka Button Tambah Dan Download Tidak Tampil -->
            <?php else : ?>
            <?php endif; ?>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIK Magang</th>
                        <th scope="col">Nama Magang</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Tanggal Magang</th>
                        <th scope="col">Tanggal Selesai</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    ?>
                    <?php foreach ($magang as $mg) : ?>
                        <?php
                        $tanggal_masuk_magang        = date('d-m-Y', strtotime($mg['tanggal_masuk_magang']));
                        $tanggal_selesai_magang      = date('d-m-Y', strtotime($mg['tanggal_selesai_magang']));
                        $tanggal_lahir_magang        = date('d-m-Y', strtotime($mg['tanggal_lahir_magang']));
                        ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $mg['nik_magang']; ?></td>
                            <td><?= $mg['nama_magang']; ?></td>
                            <td><?= $mg['penempatan']; ?></td>
                            <td><?= $tanggal_masuk_magang; ?></td>
                            <td><?= $tanggal_selesai_magang; ?></td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewMagang" onclick="viewdata(
                                                '<?= $mg['penempatan']; ?>',
                                                '<?= $tanggal_masuk_magang; ?>',
                                                '<?= $tanggal_selesai_magang; ?>',
                                                '<?= $mg['nik_magang']; ?>',
                                                '<?= $mg['nama_magang']; ?>',
                                                '<?= $mg['tempat_lahir_magang']; ?>',
                                                '<?= $tanggal_lahir_magang; ?>',
                                                '<?= $mg['agama_magang']; ?>',
                                                '<?= $mg['jenis_kelamin_magang']; ?>',
                                                '<?= $mg['nomor_handphone_magang']; ?>',
                                                '<?= $mg['alamat_magang']; ?>',
                                                '<?= $mg['rt_magang']; ?>',
                                                '<?= $mg['rw_magang']; ?>',
                                                '<?= $mg['kelurahan_magang']; ?>',
                                                '<?= $mg['kecamatan_magang']; ?>',
                                                '<?= $mg['kota_magang']; ?>',
                                                '<?= $mg['provinsi_magang']; ?>',
                                                '<?= $mg['kode_pos_magang']; ?>'
                                                )">
                                    <i class="fas fa-eye"></i> View</a>
                                <!-- Jika yang login HRD Data Akan tampil Semua  -->
                                <?php if ($role_id == 1 || $role_id == 11) : ?>
                                    <a href="<?= base_url(); ?>magang/editmagang/<?= $mg['id_magang']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                    <a href="<?= base_url(); ?>magang/hapusmagang/<?= $mg['id_magang']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
                                    <a href="<?= base_url(); ?>magang/cetakpkwtmagang/<?= $mg['id_magang']; ?>" target="_blank" class="btn btn-info btn-sm "><i class="fas fa-print"></i> Cetak PKWT</a>
                                    <!-- Jika yang login Bukan HRD Data Button EDIT Dan Hapus Tidak Akan tampil Semua  -->
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

<!-- Modal View Magang -->
<div class="modal fade" id="viewMagang" tabindex="-1" role="dialog" aria-labelledby="viewMagangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMagangLabel">View Data Program Magang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-danger">

                <div class="form-group row">
                    <label for="nis_magang" class="col-sm-3 col-form-label"><b>NIK Magang</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nik_magang" id="nik_magang">
                    </div>
                    <label for="nama_magang" class="col-sm-3 col-form-label"><b>Nama Magang</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nama_magang" id="nama_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nomor_handphone_magang" class="col-sm-3 col-form-label"><b>Nomor Handphone</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_handphone_magang" id="nomor_handphone_magang">
                    </div>
                    <label for="penempatan" class="col-sm-3 col-form-label"><b>Penempatan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="penempatan" id="penempatan">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_masuk_magang" class="col-sm-3 col-form-label"><b>Tanggal Masuk</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggal_masuk_magang" id="tanggal_masuk_program_magang">
                    </div>
                    <label for="tanggal_selesai_magang" class="col-sm-3 col-form-label"><b>Tanggal Selesai</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggal_selesai_magang" id="tanggal_selesai_program_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tempat_lahir_magang" class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tempat_lahir_magang" id="tempat_lahir_magang">
                    </div>
                    <label for="tanggal_lahir_magang" class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggal_lahir_magang" id="tanggal_lahir_program_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_kelamin_magang" class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="jenis_kelamin_magang" id="jenis_kelamin_magang">
                    </div>
                    <label for="agama_magang" class="col-sm-3 col-form-label"><b>Agama</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="agama_magang" id="agama_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="agama_magang" class="col-sm-3 col-form-label"><b>Alamat</b></label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" name="alamat_magang" id="alamat_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="label" class="col-sm-3 col-form-label"><b>RT</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="rt_magang" id="rt_magang">
                    </div>
                    <label for="label" class="col-sm-3 col-form-label"><b>RW</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="rw_magang" id="rw_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="label" class="col-sm-3 col-form-label"><b>Kelurahan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="kelurahan_magang" id="kelurahan_magang">
                    </div>
                    <label for="label" class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="kecamatan_magang" id="kecamatan_magang">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="label" class="col-sm-3 col-form-label"><b>Kota</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="kota_magang" id="kota_magang">
                    </div>
                    <label for="label" class="col-sm-3 col-form-label"><b>Provinsi</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="provinsi_magang" id="provinsi_magang">
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- End of Modal View Magang -->
