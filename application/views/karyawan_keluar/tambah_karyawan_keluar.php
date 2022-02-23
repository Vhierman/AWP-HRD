<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="<?= base_url('KaryawanKeluar/tambahkaryawankeluar'); ?>" method="POST">
        <div class="card">
            <h5 class="card-header">Form <?= $title; ?></h5>
            <div class="card-body">

                <div class="alert alert-info" role="alert">
                    Silakan Masukan NIK Karyawan untuk mencari terlebih dahulu Nama Karyawan yang ingin diinputkan.
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" placeholder="Masukan NIK Karyawan">
                        <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nama Karyawan</label>
                        <input type="text" class="form-control" placeholder="Nama Karyawan" name="nama_karyawan" maxlength="50" readonly='readonly'>
                        <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Perusahaan</label>
                        <input type="text" class="form-control" name="perusahaan_id" readonly="readonly" placeholder="Perusahaan">
                        <input type="hidden" class="form-control" name="per" readonly="readonly" placeholder="Perusahaan">
                        <small class="form-text text-danger"><?php echo form_error('perusahaan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_id" readonly='readonly' placeholder="Jabatan">
                        <input type="hidden" class="form-control" name="jab" readonly="readonly" placeholder="Jabatan">
                        <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Penempatan</label>
                        <input type="text" class="form-control" name="penempatan_id" readonly='readonly' placeholder="Penempatan">
                        <input type="hidden" class="form-control" name="pen" readonly="readonly" placeholder="Penempatan">
                        <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor NPWP</label>
                        <input type="text" class="form-control" name="nomor_npwp" readonly="readonly" placeholder="Nomor NPWP">
                        <small class="form-text text-danger"><?php echo form_error('nomor_npwp'); ?></small>
                    </div>
                </div>

				<div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nomor Absen</label>
                        <input type="text" class="form-control" name="nomor_absen" readonly='readonly' placeholder="Penempatan">
                        <input type="hidden" class="form-control" name="nomor_absen" readonly="readonly" placeholder="Nomor Absen">
                        <small class="form-text text-danger"><?php echo form_error('nomor_absen'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Golongan Darah</label>
                        <input type="text" class="form-control" name="golongan_darah" readonly="readonly" placeholder="Golongan Darah">
                        <small class="form-text text-danger"><?php echo form_error('golongan_darah'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Email Karyawan</label>
                        <input type="text" class="form-control" name="email_karyawan" readonly='readonly' placeholder="Email Karyawan">
                        <small class="form-text text-danger"><?php echo form_error('email_karyawan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor Handphone</label>
                        <input type="text" class="form-control" name="nomor_handphone" readonly="readonly" placeholder="Nomor Handphone">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" readonly='readonly' placeholder="Tempat Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tempat_lahir'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Tanggal Lahir</label>
                        <input type="text" class="form-control" name="tanggal_lahir" readonly="readonly" placeholder="Tanggal Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lahir'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" name="pendidikan_terakhir" readonly='readonly' placeholder="Pendidikan Terakhir">
                        <small class="form-text text-danger"><?php echo form_error('pendidikan_terakhir'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Jenis Kelamin</label>
                        <input type="text" class="form-control" name="jenis_kelamin" readonly="readonly" placeholder="Jenis Kelamin">
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Agama</label>
                        <input type="text" class="form-control" name="agama" readonly='readonly' placeholder="Agama">
                        <small class="form-text text-danger"><?php echo form_error('agama'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Alamat</label>
                        <input type="text" class="form-control" name="alamat" readonly="readonly" placeholder="Alamat">
                        <small class="form-text text-danger"><?php echo form_error('alamat'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">RT</label>
                        <input type="text" class="form-control" name="rt" readonly='readonly' placeholder="RT">
                        <small class="form-text text-danger"><?php echo form_error('rt'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">RW</label>
                        <input type="text" class="form-control" name="rw" readonly="readonly" placeholder="RW">
                        <small class="form-text text-danger"><?php echo form_error('rw'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Kelurahan</label>
                        <input type="text" class="form-control" name="kelurahan" readonly='readonly' placeholder="Kelurahan">
                        <small class="form-text text-danger"><?php echo form_error('kelurahan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Kecamatan</label>
                        <input type="text" class="form-control" name="kecamatan" readonly="readonly" placeholder="Kecamatan">
                        <small class="form-text text-danger"><?php echo form_error('kecamatan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Kota</label>
                        <input type="text" class="form-control" name="kota" readonly='readonly' placeholder="Kota">
                        <small class="form-text text-danger"><?php echo form_error('kota'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Provinsi</label>
                        <input type="text" class="form-control" name="provinsi" readonly="readonly" placeholder="Provinsi">
                        <small class="form-text text-danger"><?php echo form_error('provinsi'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="input">Kode Pos</label>
                        <input type="text" class="form-control" name="kode_pos" readonly='readonly' placeholder="Kode Pos">
                        <small class="form-text text-danger"><?php echo form_error('kode_pos'); ?></small>
                    </div>
                </div>

				<div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nomor KK</label>
                        <input type="text" class="form-control" name="nomor_kartu_keluarga" readonly='readonly' placeholder="Nomor KK">
                        <small class="form-text text-danger"><?php echo form_error('nomor_kartu_keluarga'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Status Nikah</label>
                        <input type="text" class="form-control" name="status_nikah" readonly="readonly" placeholder="Status Nikah">
                        <small class="form-text text-danger"><?php echo form_error('status_nikah'); ?></small>
                    </div>
                </div>

				<div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nama Ayah</label>
                        <input type="text" class="form-control" name="nama_ayah" readonly='readonly' placeholder="Nama Ayah">
                        <small class="form-text text-danger"><?php echo form_error('nama_ayah'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nama Ibu</label>
                        <input type="text" class="form-control" name="nama_ibu" readonly="readonly" placeholder="Nama Ibu">
                        <small class="form-text text-danger"><?php echo form_error('nama_ibu'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nomor JKN</label>
                        <input type="text" class="form-control" name="nomor_jkn" readonly='readonly' placeholder="Nomor JKN">
                        <small class="form-text text-danger"><?php echo form_error('nomor_jkn'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor JHT</label>
                        <input type="text" class="form-control" name="nomor_jht" readonly="readonly" placeholder="Nomor JHT">
                        <small class="form-text text-danger"><?php echo form_error('nomor_jht'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Nomor JP</label>
                        <input type="text" class="form-control" name="nomor_jp" readonly='readonly' placeholder="Nomor JP">
                        <small class="form-text text-danger"><?php echo form_error('nomor_jp'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Nomor Rekening</label>
                        <input type="text" class="form-control" name="nomor_rekening" readonly="readonly" placeholder="Nomor Rekening">
                        <small class="form-text text-danger"><?php echo form_error('nomor_rekening'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Tanggal Mulai Kerja</label>
                        <input type="text" class="form-control" name="tanggal_mulai_kerja" readonly='readonly' placeholder="Tanggal Mulai Kerja">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_mulai_kerja'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Status Kerja</label>
                        <input type="text" class="form-control" name="status_kerja" readonly="readonly" placeholder="Status Kerja">
                        <small class="form-text text-danger"><?php echo form_error('status_kerja'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="input">Tanggal Keluar</label>
                        <input type="text" class="form-control" id="tanggal_keluar_karyawan_keluar" name="tanggal_keluar_karyawan_keluar" readonly='readonly' placeholder="Tanggal Keluar">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_keluar_karyawan_keluar'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="input">Keterangan Keluar</label>
                        <select name="keterangan_keluar" id="keterangan_keluar" class="form-control" required>
                            <option value="">Pilih Keterangan Keluar</option>
                            <option value="Berakhirnya Kontrak Kerja">Berakhirnya Kontrak Kerja</option>
                            <option value="Berakhirnya Masa Kerja">Berakhirnya Masa Kerja</option>
                            <option value="Pengunduran Diri">Pengunduran Diri</option>
                            <option value="Meninggal Dunia">Meninggal Dunia</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('keterangan_keluar'); ?></small>
                    </div>
                </div>



            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('karyawankeluar/karyawankeluar'); ?>">CANCEL</a>
        </div>
</div>
</form>
</div>
