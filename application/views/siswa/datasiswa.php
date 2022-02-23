<!-- Function untuk view modal pada siswa -->
<script type="text/javascript">
    function viewdata($nis_siswa, $nama_siswa, $nama_sekolah, $penempatan, $tanggal_masuk_pkl, $tanggal_selesai_pkl, $tempat_lahir_siswa, $tanggal_lahir_siswa, $jenis_kelamin_siswa, $agama_siswa, $alamat_siswa, $nomor_handphone_siswa, $jurusan) {
        $("#nis_siswa").val($nis_siswa);
        $("#nama_siswa").val($nama_siswa);
        $("#nama_sekolah").val($nama_sekolah);
        $("#penempatan").val($penempatan);
        $("#tanggal_masuk_siswa").val($tanggal_masuk_pkl);
        $("#tanggal_selesai_siswa").val($tanggal_selesai_pkl);
        $("#tempat_lahir_siswa").val($tempat_lahir_siswa);
        $("#tanggal_lahir_siswa_pkl").val($tanggal_lahir_siswa);
        $("#jenis_kelamin_siswa").val($jenis_kelamin_siswa);
        $("#agama_siswa").val($agama_siswa);
        $("#alamat_siswa").val($alamat_siswa);
        $("#nomor_handphone_siswa").val($nomor_handphone_siswa);
        $("#jurusan").val($jurusan);
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
            //Mangambil Session
            $role_id        = $this->session->userdata("role_id");
            //Jika Yang Login adalah HRD Maka Button Tambah Tampil
            if ($role_id == 1 || $role_id == 11) : ?>
                <!-- Button Tambah -->
                <a href="<?= base_url('siswa/tambahsiswa'); ?>" class="btn btn-primary mb-2 ml-4"><i class="fas fa-plus"></i> Tambah Data Siswa</a>
                <!-- Jika Yang Login adalah Bukan HRD Maka Button Tambah Tidak Tampil -->
            <?php else : ?>
            <?php endif; ?>


            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NIS Siswa</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Penempatan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

                    ?>
                    <?php foreach ($siswa as $ssw) : ?>
                        <?php
                        $tanggal_masuk_pkl          = date('d-m-Y', strtotime($ssw['tanggal_masuk_pkl']));
                        $tanggal_selesai_pkl        = date('d-m-Y', strtotime($ssw['tanggal_selesai_pkl']));
                        $tanggal_lahir_siswa        = date('d-m-Y', strtotime($ssw['tanggal_lahir_siswa']));
                        ?>

                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $ssw['nis_siswa']; ?></td>
                            <td><?= $ssw['nama_siswa']; ?></td>
                            <td><?= $ssw['penempatan']; ?></td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewSiswa" onclick="viewdata(
                                                '<?= $ssw['nis_siswa']; ?>',
                                                '<?= $ssw['nama_siswa']; ?>',
                                                '<?= $ssw['nama_sekolah']; ?>',
                                                '<?= $ssw['penempatan']; ?>',
                                                '<?= $tanggal_masuk_pkl; ?>',
                                                '<?= $tanggal_selesai_pkl; ?>',
                                                '<?= $ssw['tempat_lahir_siswa']; ?>',
                                                '<?= $tanggal_lahir_siswa; ?>',
                                                '<?= $ssw['jenis_kelamin_siswa']; ?>',
                                                '<?= $ssw['agama_siswa']; ?>',
                                                '<?= $ssw['alamat_siswa']; ?>',
                                                '<?= $ssw['nomor_handphone_siswa']; ?>',
                                                '<?= $ssw['jurusan']; ?>'
                                                )">
                                    <i class="fas fa-eye"></i> View</a>
                                <!-- Jika yang login HRD, maka button edit, lihat, dan hapus akan tampil semua -->
                                <?php if ($role_id == 1 || $role_id == 11) : ?>
                                    <a href="<?= base_url(); ?>siswa/editsiswa/<?= $ssw['id_siswa']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                    <a href="<?= base_url(); ?>siswa/hapussiswa/<?= $ssw['id_siswa']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>
                                    <!-- Jika yang login Bukan HRD, maka button edit dan hapus Tidak akan tampil-->
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


<!-- Modal View Data Siswa Prakerin -->
<div class="modal fade" id="viewSiswa" tabindex="-1" role="dialog" aria-labelledby="viewSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSiswaLabel">View Data Siswa Prakerin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-danger">

                <div class="form-group row">
                    <label for="nis_siswa" class="col-sm-3 col-form-label"><b>NIS Siswa</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nis_siswa" id="nis_siswa">
                    </div>
                    <label for="nama_siswa" class="col-sm-3 col-form-label"><b>Nama Siswa</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nama_siswa" id="nama_siswa">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_sekolah" class="col-sm-3 col-form-label"><b>Nama Sekolah</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nama_sekolah" id="nama_sekolah">
                    </div>
                    <label for="penempatan" class="col-sm-3 col-form-label"><b>Penempatan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="penempatan" id="penempatan">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_masuk_pkl" class="col-sm-3 col-form-label"><b>Tanggal Masuk</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggal_masuk_pkl" id="tanggal_masuk_siswa">
                    </div>
                    <label for="tanggal_selesai_pkl" class="col-sm-3 col-form-label"><b>Tanggal Selesai</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggal_selesai_pkl" id="tanggal_selesai_siswa">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tempat_lahir_siswa" class="col-sm-3 col-form-label"><b>Tempat Lahir Siswa</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tempat_lahir_siswa" id="tempat_lahir_siswa">
                    </div>
                    <label for="tanggal_lahir_siswa" class="col-sm-3 col-form-label"><b>Tanggal Lahir Siswa</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="tanggal_lahir_siswa" id="tanggal_lahir_siswa_pkl">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_kelamin_siswa" class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="jenis_kelamin_siswa" id="jenis_kelamin_siswa">
                    </div>
                    <label for="agama_siswa" class="col-sm-3 col-form-label"><b>Agama</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="agama_siswa" id="agama_siswa">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nomor_handphone_siswa" class="col-sm-3 col-form-label"><b>Nomor Handphone</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="nomor_handphone_siswa" id="nomor_handphone_siswa">
                    </div>
                    <label for="jurusan" class="col-sm-3 col-form-label"><b>Jurusan</b></label>
                    <div class="col-sm-3">
                        <input type="text" readonly class="form-control-plaintext" name="jurusan" id="jurusan">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label"><b>Alamat Siswa</b></label>
                    <div class="col-sm-6">
                        <textarea style="resize:none;width:260px;height:90px;" readonly class="form-control-plaintext" id="alamat_siswa">
                            <?= set_value('$alamat_siswa'); ?>
                            </textarea>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- End of Modal -->