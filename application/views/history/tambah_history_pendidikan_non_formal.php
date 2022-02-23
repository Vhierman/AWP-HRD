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
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" readonly='readonly' value="<?= $pendidikannonformal['nik_karyawan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Karyawan</label>
                    <input type="text" class="form-control" value="<?= $pendidikannonformal['nama_karyawan'] ?>" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
                <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" value="<?= $pendidikannonformal['jabatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Penempatan</label>
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $pendidikannonformal['penempatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Nama Instansi Pendidikan</label>
                    <input type="text" class="form-control" name="nama_instansi_pendidikan_non_formal" value="<?= set_value('nama_instansi_pendidikan_non_formal'); ?>" id="nama_instansi_pendidikan_non_formal" placeholder="Nama Instansi Pendidikan Non Formal">
                    <small class="form-text text-danger"><?php echo form_error('nama_instansi_pendidikan_non_formal'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Tanggal Awal Pendidikan Pendidikan</label>
                    <input type="text" class="form-control" name="tanggal_awal_pendidikan_non_formal" value="<?= set_value('tanggal_awal_pendidikan_non_formal'); ?>" id="tanggal_awal_pendidikan_non_formal" placeholder="Awal Pendidikan Non Formal">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_awal_pendidikan_non_formal'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="label">Tanggal Akhir Pendidikan Pendidikan</label>
                    <input type="text" class="form-control" name="tanggal_akhir_pendidikan_non_formal" value="<?= set_value('tanggal_akhir_pendidikan_non_formal'); ?>" id="tanggal_akhir_pendidikan_non_formal" placeholder="Awal Pendidikan Non Formal">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_pendidikan_non_formal'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Lokasi Pendidikan Non Formal</label>
                    <input type="text" value="<?= set_value('lokasi_pendidikan_non_formal'); ?>" class="form-control" name="lokasi_pendidikan_non_formal"  id="lokasi_pendidikan_non_formal" placeholder="Lokasi Pendidikan">
                    <small class="form-text text-danger"><?php echo form_error('lokasi_pendidikan_non_formal'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="file" class="custom-file-input" id="dokumen_pendidikan_non_formal" name="dokumen_pendidikan_non_formal">
                    <label class="custom-file-label" id="dokumen_pendidikan_non_formal" for="dokumen_pendidikan_non_formal">Foto Dokumen ( Ijazah/Sertifikat ) Format .jpg</label>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">TAMBAH DATA PENDIDIKAN NON FORMAL</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/pendidikannonformal'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>