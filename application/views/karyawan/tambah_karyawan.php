<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>

    <!-- Tab Tambah Data Karyawan -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="divisi-tab" data-toggle="tab" href="#divisi" role="tab" aria-controls="divisi" aria-selected="true">Divisi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="karyawan-tab" data-toggle="tab" href="#karyawan" role="tab" aria-controls="karyawan" aria-selected="false">Karyawan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="alamat-tab" data-toggle="tab" href="#alamat" role="tab" aria-controls="alamat" aria-selected="false">Alamat</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="gaji-tab" data-toggle="tab" href="#gaji" role="tab" aria-controls="gaji" aria-selected="false">Gaji</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false">Keluarga</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="bpjs-tab" data-toggle="tab" href="#bpjs" role="tab" aria-controls="bpjs" aria-selected="false">BPJS</a>
        </li>
    </ul>
    <!-- End Tab Tambah Data Karyawan -->

    <?= form_open_multipart('karyawan/tambahkaryawan'); ?>

    <div class="tab-content" id="myTabContent">

        <!-- Tab Divisi -->
        <div class="tab-pane fade show active" id="divisi" role="tabpanel" aria-labelledby="divisi-tab">
            <div class="card border-danger">
                <h5 class="card-header text-white bg-gradient-danger">Form Divisi</h5>
                <div class="card-body border-bottom-danger ">

                    <div class="form-group">
                        <select name="perusahaan_id" id="perusahaan_id" class="form-control" required>
                            <option value="<?= set_value('perusahaan_id'); ?>">Pilih Perusahaan</option>
                            <?php foreach ($perusahaan as $pr) : ?>
                                <option value="<?= $pr['id']; ?>">
                                    <?= $pr['perusahaan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('perusahaan_id'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="penempatan_id" id="penempatan_id" data-width="100%" data-live-search="true" class="bootstrap-select" required>
                            <option value="">Pilih Penempatan</option>
                            <?php foreach ($penempatan as $pn) : ?>
                                <option value="<?= $pn['id']; ?>">
                                    <?= $pn['penempatan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('penempatan_id'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="jabatan_id" id="jabatan_id" data-width="100%" data-live-search="true" class="bootstrap-select" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatan as $jb) : ?>
                                <option value="<?= $jb['id']; ?>">
                                    <?= $jb['jabatan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jabatan_id'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="jam_kerja_id" id="jam_kerja_id" class="form-control" required>
                            <option value="">Pilih Jam Kerja</option>
                            <?php foreach ($jamkerja as $jk) : ?>
                                <option value="<?= $jk['id_jam_kerja']; ?>">
                                    <?= "( Jam Masuk " . $jk['jam_masuk'] . " )" . " s/d ( Jam Pulang " . $jk['jam_pulang'] . " )"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('status_kerja'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="status_kerja" id="status_kerja" class="form-control" required>
                            <option value="">Pilih Status Kerja</option>
                            <option value="PKWT">PKWT</option>
                            <option value="PKWTT">PKWTT</option>
                            <option value="Outsourcing">Outsourcing</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('status_kerja'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('tanggal_mulai_kerja'); ?>" id="tanggal_mulai_kerja" name="tanggal_mulai_kerja" readonly="readonly" placeholder="Tanggal Masuk Kerja ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_mulai_kerja'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('tanggal_akhir_kerja'); ?>" id="tanggal_akhir_kerja" name="tanggal_akhir_kerja" readonly="readonly" placeholder="Tanggal Akhir Kerja ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_kerja'); ?></small>
                    </div>



                </div>
            </div>
        </div>

        <!-- Tab Karyawan -->
        <div class="tab-pane fade" id="karyawan" role="tabpanel" aria-labelledby="karyawan-tab">
            <div class="card border-danger">
                <h5 class="card-header text-white bg-gradient-danger">Form Karyawan</h5>
                <div class="card-body border-bottom-danger ">

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nik_karyawan'); ?>" class="form-control" id="nik_karyawan" onkeyup="angka(this);" id="nik_karyawan" name="nik_karyawan" maxlength="16" placeholder="Masukan NIK KTP">
                        <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nama_karyawan'); ?>" class="form-control" id="nama_karyawan" onkeyup="huruf(this);" name="nama_karyawan" placeholder="Masukan Nama Karyawan">
                        <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('email_karyawan'); ?>" class="form-control" id="email_karyawan" name="email_karyawan" placeholder="Masukan Alamat Email">
                        <small class="form-text text-danger"><?php echo form_error('email_karyawan'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nomor_absen'); ?>" class="form-control" onkeyup="angka(this);" maxlength="4" id="nomor_absen" name="nomor_absen" placeholder="Masukan Nomor Absen">
                        <small class="form-text text-danger"><?php echo form_error('nomor_absen'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nomor_npwp'); ?>" class="form-control" onkeyup="angka(this);" maxlength="15" id="nomor_npwp" name="nomor_npwp" placeholder="Masukan Nomor NPWP">
                        <small class="form-text text-danger"><?php echo form_error('nomor_npwp'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('tempat_lahir'); ?>" class="form-control" id="tempat_lahir" maxlength="50" name="tempat_lahir" placeholder="Masukan Tempat Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tempat_lahir'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('tanggal_lahir'); ?>" id="tanggal_lahir" name="tanggal_lahir" readonly="readonly" placeholder="Tanggal Lahir ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lahir'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Kristen Katholik">Kristen Katholik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control" required>
                            <option value="">Pilih Pendidikan Terakhir</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA / SMK">SMA / SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('pendidikan_terakhir'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nomor_handphone'); ?>" class="form-control" onkeyup="angka(this);" id="nomor_handphone" name="nomor_handphone" placeholder="Masukan Nomor Handphone">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="golongan_darah" id="golongan_darah" class="form-control" required>
                            <option value="">Pilih Golongan Darah</option>
                            <option value="AB">AB</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="O">O</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('golongan_darah'); ?></small>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Alamat -->
        <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
            <div class="card border-danger">
                <h5 class="card-header text-white bg-gradient-danger">Form Alamat</h5>
                <div class="card-body border-bottom-danger ">
					
					<?php
					/*
					API NEGARA
					<div class="form-group">
                        <select name="negara" id="negara" class="form-control" required>
                            <option value="">Pilih Negara</option>
                            <?php foreach ($negara as $key => $ng) : ?>
                                <option value="<?= $ng->name; ?>">
                                    <?= $ng->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
					</div>
					*/
					?>
					
                    <div class="form-group">
                        <input type="text" value="<?= set_value('alamat'); ?>" class="form-control" id="alamat" name="alamat" placeholder="Masukan Nama Gedung / Jalan">
                        <small class="form-text text-danger"><?php echo form_error('alamat'); ?></small>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" value="<?= set_value('rt'); ?>" class="form-control" name="rt" maxlength="3" onkeyup="angka(this);" id="rt" placeholder="RT">
                            <small class="form-text text-danger"><?php echo form_error('rt'); ?></small>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" value="<?= set_value('rw'); ?>" class="form-control" name="rw" maxlength="3" onkeyup="angka(this);" id="rw" placeholder="RW">
                            <small class="form-text text-danger"><?php echo form_error('rw'); ?></small>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('provinsi'); ?>" class="form-control" id="provinsi" name="provinsi" placeholder="Masukan Nama Provinsi">
                        <small class="form-text text-danger"><?php echo form_error('provinsi'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('kota'); ?>" class="form-control" id="kota" name="kota" placeholder="Masukan Nama Kota">
                        <small class="form-text text-danger"><?php echo form_error('kota'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('kecamatan'); ?>" class="form-control" id="kecamatan" name="kecamatan" placeholder="Masukan Nama Kecamatan">
                        <small class="form-text text-danger"><?php echo form_error('kecamatan'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('kelurahan'); ?>" class="form-control" id="kelurahan" name="kelurahan" placeholder="Masukan Nama Kelurahan">
                        <small class="form-text text-danger"><?php echo form_error('kelurahan'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('kode_pos'); ?>" class="form-control" id="kode_pos" name="kode_pos" maxlength="5" placeholder="Masukan Kode Pos">
                        <small class="form-text text-danger"><?php echo form_error('kode_pos'); ?></small>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Gaji -->
        <div class="tab-pane fade" id="gaji" role="tabpanel" aria-labelledby="gaji-tab">
            <div class="card border-danger">
                <h5 class="card-header text-white bg-gradient-danger">Form Gaji</h5>
                <div class="card-body border-bottom-danger ">

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nomor_rekening'); ?>" class="form-control" id="nomor_rekening" onkeyup="angka(this);" name="nomor_rekening" placeholder="Masukan Nomor Rekening">
                        <small class="form-text text-danger"><?php echo form_error('nomor_rekening'); ?></small>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?= set_value('gaji_pokok'); ?>" class="form-control" maxlength="8" id="gaji_pokok" onkeyup="angka(this);" name="gaji_pokok" placeholder="Masukan Gaji Pokok">
                        <small class="form-text text-danger"><?php echo form_error('gaji_pokok'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('uang_makan'); ?>" class="form-control" maxlength="8" id="uang_makan" onkeyup="angka(this);" name="uang_makan" placeholder="Masukan Uang Makan">
                        <small class="form-text text-danger"><?php echo form_error('uang_makan'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('uang_transport'); ?>" class="form-control" maxlength="8" id="uang_transport" onkeyup="angka(this);" name="uang_transport" placeholder="Masukan Uang Transport">
                        <small class="form-text text-danger"><?php echo form_error('uang_transport'); ?></small>
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('tunjangan_tugas'); ?>" class="form-control" maxlength="8" id="tunjangan_tugas" onkeyup="angka(this);" name="tunjangan_tugas" placeholder="Masukan Tunjangan Tugas">
                    </div>

                    <div class="form-group">
                        <input type="text" value="<?= set_value('tunjangan_pulsa'); ?>" class="form-control" maxlength="8" id="tunjangan_pulsa" onkeyup="angka(this);" name="tunjangan_pulsa" placeholder="Masukan Tunjangan Pulsa">
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Keluarga -->
        <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
            <div class="card border-danger">
                <h5 class="card-header text-white bg-gradient-danger">Form Keluarga</h5>
                <div class="card-body border-bottom-danger ">

                    <div class="form-group">
                        <input type="text" value="<?= set_value('nomor_kartu_keluarga'); ?>" class="form-control" maxlength="16" id="nomor_kartu_keluarga" onkeyup="angka(this);" name="nomor_kartu_keluarga" placeholder="Masukan Nomor Kartu keluarga">
                        <small class="form-text text-danger"><?php echo form_error('nomor_kartu_keluarga'); ?></small>
                    </div>

                    <div class="form-group">
                        <select name="status_nikah" id="statusnikah" class="form-control" required>
                            <option value="">Pilih Status Perkawinan</option>
                            <option value="Single">Single</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Duda">Duda</option>
                            <option value="Janda">Janda</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('status_nikah'); ?></small>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="text" value="<?= set_value('nama_ayah'); ?>" class="form-control" maxlength="50" id="nama_ayah" onkeyup="huruf(this);" name="nama_ayah" placeholder="Masukan Nama Ayah">
                            <small class="form-text text-danger"><?php echo form_error('nama_ayah'); ?></small>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" value="<?= set_value('nama_ibu'); ?>" class="form-control" maxlength="50" id="nama_ibu" onkeyup="huruf(this);" name="nama_ibu" placeholder="Masukan Nama Ibu">
                            <small class="form-text text-danger"><?php echo form_error('nama_ibu'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab BPJS -->
        <div class="tab-pane fade" id="bpjs" role="tabpanel" aria-labelledby="bpjs-tab">
            <div class="card border-danger">
                <h5 class="card-header text-white bg-gradient-danger">Form BPJS</h5>
                <div class="card-body border-bottom-danger ">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <input type="text" value="<?= set_value('nomor_jht'); ?>" class="form-control" maxlength="11" id="nomor_jht" name="nomor_jht" placeholder="Masukan Nomor BPJSTK Jaminan Hari Tua">
                            <small class="form-text text-danger"><?php echo form_error('nomor_jht'); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" value="<?= set_value('nomor_jp'); ?>" class="form-control" maxlength="11" id="nomor_jp" onkeyup="angka(this);" name="nomor_jp" placeholder="Masukan Nomor BPJSTK Jaminan Pensiun">
                            <small class="form-text text-danger"><?php echo form_error('nomor_jp'); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" value="<?= set_value('nomor_jkn'); ?>" class="form-control" maxlength="13" id="nomor_jkn" onkeyup="angka(this);" name="nomor_jkn" placeholder="Masukan Nomor BPJSKES Jaminan Kesehatan Nasional">
                            <small class="form-text text-danger"><?php echo form_error('nomor_jkn'); ?></small>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Button Simpan Dan Cancel -->
        <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
        <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('karyawan/karyawan'); ?>">CANCEL</a>
    </div>
    </form>

</div>
<!-- /.container-fluid -->
