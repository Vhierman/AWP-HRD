<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart(''); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <!-- Menampilkan Pesan Kesalahan -->
            <?= $this->session->flashdata('message'); ?>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">NIK Karyawan</label>
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" readonly='readonly' value="<?= $keluarga['nik_karyawan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Karyawan</label>
                    <input type="text" class="form-control" value="<?= $keluarga['nama_karyawan'] ?>" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
                <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" value="<?= $keluarga['jabatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Penempatan</label>
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $keluarga['penempatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" id="hubungan_keluarga" class="form-control" required>
                        <option value="">Pilih Hubungan Keluarga</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('hubungan_keluarga'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">NIK</label>
                    <input type="text" class="form-control" name="nik_history_keluarga" maxlength="16" value="<?= set_value('nik_history_keluarga'); ?>" onkeyup="angka(this);" id="nik_history_keluarga" placeholder="NIK">
                    <small class="form-text text-danger"><?php echo form_error('nik_history_keluarga'); ?></small>
                </div>
            </div>

            <div class="form-row">
            <div class="form-group col-md-6">
                    <label for="label">No BPJS Kesehatan</label>
                    <input type="text" class="form-control" name="nomor_bpjs_kesehatan_history_keluarga" maxlength="13" onkeyup="angka(this);" value="<?= set_value('nomor_bpjs_kesehatan_history_keluarga'); ?>" id="nomor_bpjs_kesehatan_history_keluarga" placeholder="NO BPJS Kesehatan">
                    <small class="form-text text-danger"><?php echo form_error('nomor_bpjs_kesehatan_history_keluarga'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Lengkap</label>
                    <input type="text" value="<?= set_value('nama_history_keluarga'); ?>" class="form-control" name="nama_history_keluarga" maxlength="50" onkeyup="huruf(this);" id="nama_history_keluarga" placeholder="Nama Lengkap">
                    <small class="form-text text-danger"><?php echo form_error('nama_history_keluarga'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Jenis Kelamin</label>
                    <select name="jenis_kelamin_history_keluarga" id="jenis_kelamin_history_keluarga" class="form-control" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('jenis_kelamin_history_keluarga'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Tempat Lahir</label>
                    <input type="text" value="<?= set_value('tempat_lahir_history_keluarga'); ?>" class="form-control" name="tempat_lahir_history_keluarga" maxlength="50" id="tempat_lahir_history_keluarga" placeholder="Tempat Lahir">
                    <small class="form-text text-danger"><?php echo form_error('tempat_lahir_history_keluarga'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Tanggal Lahir</label>
                    <input type="text" value="<?= set_value('tanggal_lahir_history_keluarga'); ?>" class="form-control" name="tanggal_lahir_history_keluarga" maxlength="50" id="tanggal_lahir_history_keluarga" placeholder="Tanggal Lahir">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_lahir_history_keluarga'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Golongan Darah</label>
                    <select name="golongan_darah_history_keluarga" id="golongan_darah_history_keluarga" class="form-control" required>
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('golongan_darah_history_keluarga'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="file_history_keluarga" name="file_history_keluarga">
                    <label class="custom-file-label" id="file_history_keluarga" for="file_history_keluarga">Foto Dokumen ( KTP/Akta Anak ) Format .jpg</label>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel formtarget="_blank" -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">TAMBAH DATA KELUARGA</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/keluarga'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>
