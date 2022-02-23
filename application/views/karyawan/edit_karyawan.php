<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>
	<!-- Menampilkan Pesan Kesalahan -->
	<?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>
            <!-- Menampilkan Pesan Kesalahan -->
    <!-- Tab Tambah Data Karyawan -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="divisi-tab" data-toggle="tab" href="#divisi" role="tab" aria-controls="divisi" aria-selected="true">Divisi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="karyawan-tab" data-toggle="tab" href="#karyawan" role="tab" aria-controls="karyawan" aria-selected="false">Karyawan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="foto-tab" data-toggle="tab" href="#foto" role="tab" aria-controls="foto" aria-selected="false">Foto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="alamat-tab" data-toggle="tab" href="#alamat" role="tab" aria-controls="alamat" aria-selected="false">Alamat</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="gaji-tab" data-toggle="tab" href="#gaji" role="tab" aria-controls="gaji" aria-selected="false">Rekening</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false">Keluarga</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="bpjs-tab" data-toggle="tab" href="#bpjs" role="tab" aria-controls="bpjs" aria-selected="false">BPJS</a>
        </li>
    </ul>
    <!-- End Tab Tambah Data Karyawan -->

    <?= form_open_multipart(''); ?>

    <div class="tab-content" id="myTabContent">

        <!-- Tab Divisi -->
        <div class="tab-pane fade show active" id="divisi" role="tabpanel" aria-labelledby="divisi-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form Divisi</h5>
                <div class="card-body  border-bottom-success ">

                    <input type="hidden" value="<?= $joinkaryawanid['id_karyawan'] ?>" class="form-control" id="id" name="id" maxlength="16">

                    <div class="form-group row">
                        <label for="perusahaan_id" class="col-sm-3 col-form-label"><b>Nama Perusahaan</b></label>
                        <div class="col-sm-9">
                            <select name="perusahaan_id" id="perusahaan_id" class="form-control">
                                <option value="<?= set_value('perusahaan_id'); ?>">Pilih Perusahaan</option>
                                <?php foreach ($perusahaan as $pr) : ?>

                                    <?php if ($pr['id'] == $joinkaryawanid['perusahaan_id']) : ?>
                                        <option value="<?= $pr['id']; ?>" selected><?= $pr['perusahaan']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $pr['id']; ?>"><?= $pr['perusahaan']; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('perusahaan_id'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="penempatan_id" class="col-sm-3 col-form-label"><b>Nama Penempatan</b></label>
                        <div class="col-sm-9">
                            <select name="penempatan_id" id="penempatan_id" data-width="100%" data-live-search="true" class="bootstrap-select">
                                <option value="">Pilih Penempatan</option>
                                <?php foreach ($penempatan as $pn) : ?>

                                    <?php if ($pn['id'] == $joinkaryawanid['penempatan_id']) : ?>
                                        <option value="<?= $pn['id']; ?>" selected><?= $pn['penempatan']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $pn['id']; ?>"><?= $pn['penempatan']; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('penempatan_id'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jabatan_id" class="col-sm-3 col-form-label"><b>Nama Jabatan</b></label>
                        <div class="col-sm-9">
                            <select name="jabatan_id" id="jabatan_id" data-width="100%" data-live-search="true" class="bootstrap-select">
                                <option value="">Pilih Jabatan</option>
                                <?php foreach ($jabatan as $jb) : ?>

                                    <?php if ($jb['id'] == $joinkaryawanid['jabatan_id']) : ?>
                                        <option value="<?= $jb['id']; ?>" selected><?= $jb['jabatan']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $jb['id']; ?>"><?= $jb['jabatan']; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('jabatan_id'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jam_kerja_id" class="col-sm-3 col-form-label"><b>Jam Kerja</b></label>
                        <div class="col-sm-9">
                            <select name="jam_kerja_id" id="jam_kerja_id" class="form-control">
                                <option value="">Pilih Jam Kerja</option>
                                <?php foreach ($jamkerja as $jk) : ?>

                                    <?php if ($jk['id_jam_kerja'] == $joinkaryawanid['jam_kerja_id']) : ?>
                                        <option value="<?= $jk['id_jam_kerja']; ?>" selected><?= "( Jam Masuk " . $jk['jam_masuk'] . " ) " . " s/d ( Jam Pulang " . $jk['jam_pulang'] . " )"; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $jk['id_jam_kerja']; ?>"><?= "( Jam Masuk " . $jk['jam_masuk'] . " ) " . " s/d ( Jam Pulang " . $jk['jam_pulang'] . " )"; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('jam_kerja_id'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status_kerja" class="col-sm-3 col-form-label"><b>Status Kerja</b></label>
                        <div class="col-sm-9">
                            <select name="status_kerja" id="status_kerja" class="form-control">
                                <?php foreach ($status_kerja as $sk) : ?>

                                    <?php if ($sk == $joinkaryawanid['status_kerja']) : ?>
                                        <option value="<?= $sk ?>" selected><?= $sk ?></option>
                                    <?php else : ?>
                                        <option value="<?= $sk ?>"><?= $sk ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('status_kerja'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal_mulai_kerja" class="col-sm-3 col-form-label"><b>Tanggal Mulai Kerja</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['tanggal_mulai_kerja'] ?>" id="tanggal_mulai_kerja" name="tanggal_mulai_kerja" readonly="readonly" placeholder="Tanggal Masuk Kerja ( yyyy-mm-dd )">
                            <small class="form-text text-danger"><?php echo form_error('tanggal_mulai_kerja'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal_akhir_kerja" class="col-sm-3 col-form-label"><b>Tanggal Akhir Kerja</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['tanggal_akhir_kerja'] ?>" id="tanggal_akhir_kerja" name="tanggal_akhir_kerja" readonly="readonly" placeholder="Tanggal Akhir Kerja ( yyyy-mm-dd )">
                            <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_kerja'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Karyawan -->
        <div class="tab-pane fade" id="karyawan" role="tabpanel" aria-labelledby="karyawan-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form Karyawan</h5>
                <div class="card-body  border-bottom-success ">

                    <div class="form-group row">
                        <label for="nik_karyawan" class="col-sm-3 col-form-label"><b>NIK Karyawan</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nik_karyawan'] ?>" class="form-control" id="nik_karyawan" onkeyup="angka(this);" name="nik_karyawan" maxlength="16" placeholder="Masukan NIK KTP">
                            <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_karyawan" class="col-sm-3 col-form-label"><b>Nama Karyawan</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nama_karyawan'] ?>" class="form-control" id="nama_karyawan" onkeyup="huruf(this);" name="nama_karyawan" placeholder="Masukan Nama Karyawan">
                            <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email_karyawan" class="col-sm-3 col-form-label"><b>Email Karyawan</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['email_karyawan'] ?>" class="form-control" id="email_karyawan" name="email_karyawan" placeholder="Masukan Alamat Email">
                            <small class="form-text text-danger"><?php echo form_error('email_karyawan'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nomor_absen" class="col-sm-3 col-form-label"><b>Nomor Absen</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nomor_absen'] ?>" class="form-control" onkeyup="angka(this);" maxlength="4" id="nomor_absen" name="nomor_absen" placeholder="Masukan Nomor Absen">
                            <small class="form-text text-danger"><?php echo form_error('nomor_absen'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nomor_npwp" class="col-sm-3 col-form-label"><b>Nomor NPWP</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nomor_npwp'] ?>" class="form-control" onkeyup="angka(this);" maxlength="15" id="nomor_npwp" name="nomor_npwp" placeholder="Masukan Nomor NPWP">
                            <small class="form-text text-danger"><?php echo form_error('nomor_npwp'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tempat_lahir" class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['tempat_lahir'] ?>" class="form-control" id="tempat_lahir" maxlength="50" name="tempat_lahir" placeholder="Masukan Tempat Lahir">
                            <small class="form-text text-danger"><?php echo form_error('tempat_lahir'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal_lahir" class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['tanggal_lahir'] ?>" id="tanggal_lahir" name="tanggal_lahir" readonly="readonly" placeholder="Tanggal Lahir ( yyyy-mm-dd )">
                            <small class="form-text text-danger"><?php echo form_error('tanggal_lahir'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agama" class="col-sm-3 col-form-label"><b>Agama</b></label>
                        <div class="col-sm-9">
                            <select name="agama" id="agama" class="form-control">
                                <?php foreach ($agama as $ag) : ?>

                                    <?php if ($ag == $joinkaryawanid['agama']) : ?>
                                        <option value="<?= $ag ?>" selected><?= $ag ?></option>
                                    <?php else : ?>
                                        <option value="<?= $ag ?>"><?= $ag ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
                        <div class="col-sm-9">
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                <?php foreach ($jenis_kelamin as $jenkel) : ?>

                                    <?php if ($jenkel == $joinkaryawanid['jenis_kelamin']) : ?>
                                        <option value="<?= $jenkel ?>" selected><?= $jenkel ?></option>
                                    <?php else : ?>
                                        <option value="<?= $jenkel ?>"><?= $jenkel ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('jenis_kelamin'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pendidikan_terakhir" class="col-sm-3 col-form-label"><b>Pendidikan Terakhir</b></label>
                        <div class="col-sm-9">
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control">
                                <?php foreach ($pendidikan_terakhir as $pt) : ?>

                                    <?php if ($pt == $joinkaryawanid['pendidikan_terakhir']) : ?>
                                        <option value="<?= $pt ?>" selected><?= $pt ?></option>
                                    <?php else : ?>
                                        <option value="<?= $pt ?>"><?= $pt ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('pendidikan_terakhir'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nomor_handphone" class="col-sm-3 col-form-label"><b>Nomor Handphone</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nomor_handphone'] ?>" class="form-control" onkeyup="angka(this);" id="nomor_handphone" name="nomor_handphone" placeholder="Masukan Nomor Handphone">
                            <small class="form-text text-danger"><?php echo form_error('nomor_handphone'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="golongan_darah" class="col-sm-3 col-form-label"><b>Golongan Darah</b></label>
                        <div class="col-sm-9">
                            <select name="golongan_darah" id="golongan_darah" class="form-control">
                                <?php foreach ($golongan_darah as $gd) : ?>

                                    <?php if ($gd == $joinkaryawanid['golongan_darah']) : ?>
                                        <option value="<?= $gd ?>" selected><?= $gd ?></option>
                                    <?php else : ?>
                                        <option value="<?= $gd ?>"><?= $gd ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('golongan_darah'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Karyawan -->
        <div class="tab-pane fade" id="foto" role="tabpanel" aria-labelledby="foto-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form Foto</h5>
                <div class="card-body  border-bottom-success ">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/karyawan/') . $joinkaryawanid['foto_karyawan']; ?>" class="img-thumbnail">
                        </div>

                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/ktp/') . $joinkaryawanid['foto_ktp']; ?>" class="img-thumbnail">
                        </div>

                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/npwp/') . $joinkaryawanid['foto_npwp']; ?>" class="img-thumbnail">
                        </div>

                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/kk/') . $joinkaryawanid['foto_kk']; ?>" class="img-thumbnail">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_karyawan" name="foto_karyawan">
                                <label class="custom-file-label" id="foto_karyawan" for="foto_karyawan">Foto Karyawan</label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_ktp" name="foto_ktp">
                                <label class="custom-file-label" id="foto_ktp" for="foto_ktp">Foto KTP</label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_npwp" name="foto_npwp">
                                <label class="custom-file-label" id="foto_npwp" for="foto_npwp">Foto NPWP</label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_kk" name="foto_kk">
                                <label class="custom-file-label" id="foto_kk" for="foto_kk">Foto KK</label>
                            </div>
                        </div>
                    </div>
                    <span class="badge badge-danger">Kosongkan Saja Jika Foto Tidak Diganti</span>
                </div>
            </div>
        </div>


        <!-- Tab Alamat -->
        <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form Alamat</h5>
                <div class="card-body  border-bottom-success ">

                    <div class="form-group row">
                        <label for="alamat" class="col-sm-3 col-form-label"><b>Alamat</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['alamat'] ?>" class="form-control" id="alamat" name="alamat" placeholder="Masukan Nama Gedung / Jalan">
                            <small class="form-text text-danger"><?php echo form_error('alamat'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="rt" class="col-sm-3 col-form-label"><b>RT</b></label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $joinkaryawanid['rt'] ?>" onkeyup="angka(this);" class="form-control" id="rt" name="rt" placeholder="Masukan Nomor RT">
                            <small class="form-text text-danger"><?php echo form_error('rt'); ?></small>
                        </div>
                        <label for="rw" class="col-sm-3 col-form-label"><b>RW</b></label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $joinkaryawanid['rw'] ?>" onkeyup="angka(this);" class="form-control" id="rw" name="rw" placeholder="Masukan Nomor RW">
                            <small class="form-text text-danger"><?php echo form_error('rw'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="provinsi" class="col-sm-3 col-form-label"><b>Provinsi</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['provinsi'] ?>" class="form-control" id="provinsi" name="provinsi" placeholder="Masukan Nama Provinsi">
                            <small class="form-text text-danger"><?php echo form_error('provinsi'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kota" class="col-sm-3 col-form-label"><b>Kota</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['kota'] ?>" class="form-control" id="kota" name="kota" placeholder="Masukan Nama Kota">
                            <small class="form-text text-danger"><?php echo form_error('kota'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kecamatan" class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['kecamatan'] ?>" class="form-control" id="kecamatan" name="kecamatan" placeholder="Masukan Nama Kecamatan">
                            <small class="form-text text-danger"><?php echo form_error('kecamatan'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kelurahan" class="col-sm-3 col-form-label"><b>Kelurahan</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['kelurahan'] ?>" class="form-control" id="kecamatan" name="kelurahan" placeholder="Masukan Nama Kelurahan">
                            <small class="form-text text-danger"><?php echo form_error('kelurahan'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kode_pos" class="col-sm-3 col-form-label"><b>Kode Pos</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['kode_pos'] ?>" class="form-control" maxlength="5" id="kode_pos" name="kode_pos" placeholder="Masukan Nama Kode Pos">
                            <small class="form-text text-danger"><?php echo form_error('kode_pos'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Gaji -->
        <div class="tab-pane fade" id="gaji" role="tabpanel" aria-labelledby="gaji-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form Gaji</h5>
                <div class="card-body  border-bottom-success ">

                    <div class="form-group row">
                        <label for="nomor_rekening" class="col-sm-3 col-form-label"><b>Nomor Rekening</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nomor_rekening'] ?>" class="form-control" id="nomor_rekening" onkeyup="angka(this);" name="nomor_rekening" placeholder="Masukan Nomor Rekening">
                            <small class="form-text text-danger"><?php echo form_error('nomor_rekening'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Keluarga -->
        <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form Keluarga</h5>
                <div class="card-body  border-bottom-success ">

                    <div class="form-group row">
                        <label for="nomor_kartu_keluarga" class="col-sm-3 col-form-label"><b>Nomor Kartu Keluarga</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nomor_kartu_keluarga'] ?>" class="form-control" maxlength="16" id="nomor_kartu_keluarga" onkeyup="angka(this);" name="nomor_kartu_keluarga" placeholder="Masukan Nomor Kartu keluarga">
                            <small class="form-text text-danger"><?php echo form_error('nomor_kartu_keluarga'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status_nikah" class="col-sm-3 col-form-label"><b>Status Nikah</b></label>
                        <div class="col-sm-9">
                            <select name="status_nikah" id="status_nikah" class="form-control">
                                <?php foreach ($status_nikah as $sn) : ?>

                                    <?php if ($sn == $joinkaryawanid['status_nikah']) : ?>
                                        <option value="<?= $sn ?>" selected><?= $sn ?></option>
                                    <?php else : ?>
                                        <option value="<?= $sn ?>"><?= $sn ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-danger"><?php echo form_error('status_nikah'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_ayah" class="col-sm-3 col-form-label"><b>Nama Ayah</b></label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $joinkaryawanid['nama_ayah'] ?>" onkeyup="huruf(this);" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Masukan Nama Ayah">
                            <small class="form-text text-danger"><?php echo form_error('nama_ayah'); ?></small>
                        </div>
                        <label for="nama_ibu" class="col-sm-3 col-form-label"><b>Nama Ibu</b></label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $joinkaryawanid['nama_ibu'] ?>" onkeyup="huruf(this);" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Masukan Nama Ibu">
                            <small class="form-text text-danger"><?php echo form_error('nama_ibu'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab BPJS -->
        <div class="tab-pane fade" id="bpjs" role="tabpanel" aria-labelledby="bpjs-tab">
            <div class="card border-success">
                <h5 class="card-header text-white bg-success">Form BPJS</h5>
                <div class="card-body  border-bottom-success ">

                    <div class="form-group row">
                        <label for="nomor_jht" class="col-sm-3 col-form-label"><b>Nomor JHT</b></label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $joinkaryawanid['nomor_jht'] ?>" class="form-control" id="nomor_jht" name="nomor_jht" placeholder="Nomor JHT">
                            <small class="form-text text-danger"><?php echo form_error('nomor_jht'); ?></small>
                        </div>
                        <label for="nomor_jp" class="col-sm-3 col-form-label"><b>Nomor JP</b></label>
                        <div class="col-sm-3">
                            <input type="text" value="<?= $joinkaryawanid['nomor_jp'] ?>" class="form-control" id="nomor_jp" name="nomor_jp" placeholder="Nomor JP">
                            <small class="form-text text-danger"><?php echo form_error('nomor_jp'); ?></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nomor_jkn" class="col-sm-3 col-form-label"><b>Nomor BPJSKES Karyawan</b></label>
                        <div class="col-sm-9">
                            <input type="text" value="<?= $joinkaryawanid['nomor_jkn'] ?>" class="form-control" maxlength="13" id="nomor_jkn" onkeyup="angka(this);" name="nomor_jkn" placeholder="Masukan Nomor BPJSKES Jaminan Kesehatan Nasional">
                            <small class="form-text text-danger"><?php echo form_error('nomor_jkn'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Button Simpan Dan Cancel -->
        <button type="submit" name="edit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
        <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('karyawan/karyawan'); ?>">CANCEL</a>
    </div>
    </form>

</div>
<!-- /.container-fluid -->
