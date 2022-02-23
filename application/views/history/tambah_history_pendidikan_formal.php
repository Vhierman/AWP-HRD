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
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" readonly='readonly' value="<?= $pendidikanformal['nik_karyawan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Karyawan</label>
                    <input type="text" class="form-control" value="<?= $pendidikanformal['nama_karyawan'] ?>" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
                <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" value="<?= $pendidikanformal['jabatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Penempatan</label>
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $pendidikanformal['penempatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Tingkat Pendidikan</label>
                    <select name="tingkat_pendidikan_formal" id="tingkat_pendidikan_formal" class="form-control" required>
                        <option value="">Pilih Tingkat Pendidikan Formal</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA/SMK">SMA/SMK</option>
                        <option value="D1">D1</option>
                        <option value="D2">D2</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('tingkat_pendidikan_formal'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Instansi Pendidikan</label>
                    <input type="text" class="form-control" name="nama_instansi_pendidikan" value="<?= set_value('nama_instansi_pendidikan'); ?>" id="nama_instansi_pendidikan" placeholder="Nama Instansi Pendidikan Formal">
                    <small class="form-text text-danger"><?php echo form_error('nama_instansi_pendidikan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Jurusan</label>
                    <input type="text" class="form-control" name="jurusan" value="<?= set_value('jurusan'); ?>" id="jurusan" placeholder="Jurusan">
                    <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Tahun Lulus</label>
                    <input type="text" value="<?= set_value('tahun_lulus'); ?>" class="form-control" name="tahun_lulus" maxlength="4" onkeyup="angka(this);" id="tahun_lulus" placeholder="Tahun Lulus">
                    <small class="form-text text-danger"><?php echo form_error('tahun_lulus'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="dokumen_pendidikan_formal" name="dokumen_pendidikan_formal">
                    <label class="custom-file-label" id="dokumen_pendidikan_formal" for="dokumen_pendidikan_formal">Foto Dokumen ( Ijazah ) Format .jpg</label>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">TAMBAH DATA PENDIDIKAN FORMAL</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/pendidikanformal'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>