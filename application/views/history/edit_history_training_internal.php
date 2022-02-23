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
                    <input type="hidden" class="form-control" name="id_history_training_internal" onkeyup="angka(this);" id="id_history_training_internal" readonly='readonly' value="<?= $datatraininginternal['id_history_training_internal'] ?>">
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" readonly='readonly' value="<?= $datatraininginternal['nik_karyawan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Karyawan</label>
                    <input type="text" class="form-control" name="nama_karyawan" id="nama_karyawan" readonly='readonly' value="<?= $datatraininginternal['nama_karyawan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Tanggal Training Internal</label>
                    <input type="text" class="form-control" id="tanggal_training_internal" name="tanggal_training_internal" value="<?= $datatraininginternal['tanggal_training_internal'] ?>" placeholder="YYYY-MM-DD">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_training_internal'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Jam Training Internal</label>
                    <input type="time" class="form-control" id="jam_training_internal" name="jam_training_internal" value="<?= $datatraininginternal['jam_training_internal'] ?>" placeholder="YYYY-MM-DD">
                    <small class="form-text text-danger"><?php echo form_error('jam_training_internal'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Lokasi Training Internal</label>
                    <input type="text" class="form-control" id="lokasi_training_internal" name="lokasi_training_internal" value="<?= $datatraininginternal['lokasi_training_internal'] ?>" placeholder="Lokasi Training Internal">
                    <small class="form-text text-danger"><?php echo form_error('lokasi_training_internal'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Materi Training Internal</label>
                    <input type="text" class="form-control" id="materi_training_internal" name="materi_training_internal" value="<?= $datatraininginternal['materi_training_internal'] ?>" placeholder="Materi Training Internal">
                    <small class="form-text text-danger"><?php echo form_error('materi_training_internal'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Penilaian Sebelum Training Internal</label>
                    <input type="text" class="form-control" id="penilaian_sebelum_training_internal" name="penilaian_sebelum_training_internal" value="<?= $datatraininginternal['penilaian_sebelum_training_internal'] ?>" placeholder="Penilaian Sebelum Training Internal">
                    <small class="form-text text-danger"><?php echo form_error('penilaian_sebelum_training_internal'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Penilaian Sesudah Training Internal</label>
                    <input type="text" class="form-control" id="penilaian_sesudah_training_internal" name="penilaian_sesudah_training_internal" value="<?= $datatraininginternal['penilaian_sesudah_training_internal'] ?>" placeholder="Materi Training Internal">
                    <small class="form-text text-danger"><?php echo form_error('penilaian_sesudah_training_internal'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="label">Trainer Training Internal</label>
                    <input type="text" class="form-control" id="trainer_training_internal" name="trainer_training_internal" value="<?= $datatraininginternal['trainer_training_internal'] ?>" placeholder="Trainer Training Internal">
                    <small class="form-text text-danger"><?php echo form_error('trainer_training_internal'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="file" class="custom-file-input" id="dokumen_materi_training_internal" name="dokumen_materi_training_internal">
                    <label class="custom-file-label" id="dokumen_materi_training_internal" for="dokumen_materi_training_internal">File Dokumen ( Materi Training Internal ) ( Jika File Tidak Dirubah Maka Kosongkan Saja ) </label>
                </div>
            </div>


            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">EDIT DATA TRAINING INTERNAL</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/traininginternal'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>