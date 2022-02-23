<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="" method="POST">
        <div class="card">
            <h5 class="card-header">Form <?= $title; ?></h5>
            <div class="card-body">
                <input type="hidden" class="form-control" name="id" onkeyup="angka(this);" readonly='readonly' value="<?= $karyawankeluar['id_karyawan_keluar'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" readonly='readonly' value="<?= $karyawankeluar['nik_karyawan_keluar'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nama Karyawan</label>
                        <input type="text" class="form-control" value="<?= $karyawankeluar['nama_karyawan_keluar'] ?>" name="nama_karyawan" maxlength="50" readonly='readonly'>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Perusahaan</label>
                        <input type="text" class="form-control" name="perusahaan" readonly="readonly" value="<?= $karyawankeluar['perusahaan_id'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" readonly='readonly' value="<?= $karyawankeluar['jabatan_id'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Penempatan</label>
                        <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $karyawankeluar['penempatan_id'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor NPWP</label>
                        <input type="text" class="form-control" name="nomor_npwp" readonly="readonly" value="<?= $karyawankeluar['nomor_npwp_karyawan_keluar'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Email Karyawan</label>
                        <input type="text" class="form-control" name="email_karyawan" readonly='readonly' value="<?= $karyawankeluar['email_karyawan_keluar'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor Handphone</label>
                        <input type="text" class="form-control" name="nomor_handphone" readonly="readonly" value="<?= $karyawankeluar['nomor_handphone_karyawan_keluar'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" readonly='readonly' value="<?= $karyawankeluar['tempat_lahir_karyawan_keluar'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Tanggal Lahir</label>
                        <input type="text" class="form-control" readonly="readonly" value="<?= $karyawankeluar['tanggal_lahir_karyawan_keluar'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" name="pendidikan_terakhir" readonly='readonly' value="<?= $karyawankeluar['pendidikan_terakhir_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('pendidikan_terakhir'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Jenis Kelamin</label>
                        <input type="text" class="form-control" name="jenis_kelamin" readonly="readonly"  value="<?= $karyawankeluar['jenis_kelamin_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Agama</label>
                        <input type="text" class="form-control" name="agama" readonly='readonly' value="<?= $karyawankeluar['agama_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Alamat</label>
                        <input type="text" class="form-control" name="alamat" readonly="readonly" value="<?= $karyawankeluar['alamat_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('alamat'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">RT</label>
                        <input type="text" class="form-control" name="rt" readonly='readonly' value="<?= $karyawankeluar['rt_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('rt'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">RW</label>
                        <input type="text" class="form-control" name="rw" readonly="readonly" value="<?= $karyawankeluar['rw_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('rw'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Kelurahan</label>
                        <input type="text" class="form-control" name="kelurahan" readonly='readonly' value="<?= $karyawankeluar['kelurahan_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('kelurahan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Kecamatan</label>
                        <input type="text" class="form-control" name="kecamatan" readonly="readonly" value="<?= $karyawankeluar['kecamatan_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('kecamatan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Kota</label>
                        <input type="text" class="form-control" name="kota" readonly='readonly' value="<?= $karyawankeluar['kota_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('kota'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Provinsi</label>
                        <input type="text" class="form-control" name="provinsi" readonly="readonly" value="<?= $karyawankeluar['provinsi_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('provinsi'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="input">Kode Pos</label>
                        <input type="text" class="form-control" name="kode_pos" readonly='readonly' value="<?= $karyawankeluar['kode_pos_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('kode_pos'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nomor JKN</label>
                        <input type="text" class="form-control" name="nomor_jkn" readonly='readonly' value="<?= $karyawankeluar['nomor_jkn_karyawan_keluar'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor JHT</label>
                        <input type="text" class="form-control" name="nomor_jht" readonly="readonly" value="<?= $karyawankeluar['nomor_jht_karyawan_keluar'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nomor JP</label>
                        <input type="text" class="form-control" name="nomor_jp" readonly='readonly' value="<?= $karyawankeluar['nomor_jp_karyawan_keluar'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor Rekening</label>
                        <input type="text" class="form-control" name="nomor_rekening" readonly="readonly" value="<?= $karyawankeluar['nomor_rekening_karyawan_keluar'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Tanggal Mulai Kerja</label>
                        <input type="text" class="form-control" readonly='readonly' value="<?= $karyawankeluar['tanggal_masuk_karyawan_keluar'] ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Status Kerja</label>
                        <input type="text" class="form-control" name="status_kerja" readonly="readonly" value="<?= $karyawankeluar['status_kerja_karyawan_keluar'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Tanggal Keluar</label>
                        <input type="text" class="form-control" id="tanggal_keluar_karyawan_keluar" name="tanggal_keluar_karyawan_keluar" readonly='readonly' value="<?= $karyawankeluar['tanggal_keluar_karyawan_keluar'] ?>">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_keluar_karyawan_keluar'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Keterangan Keluar</label>
                        <select name="keterangan_keluar" id="keterangan_keluar" class="form-control">
                            <?php foreach ($keterangan_keluar as $kk) : ?>

                                <?php if ($kk == $karyawankeluar['keterangan_keluar']) : ?>
                                    <option value="<?= $kk ?>" selected><?= $kk ?></option>
                                <?php else : ?>
                                    <option value="<?= $kk ?>"><?= $kk ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('keterangan_keluar'); ?></small>
                    </div>
                </div>



            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('KaryawanKeluar/karyawankeluar'); ?>">CANCEL</a>
        </div>
</div>
</form>
</div>