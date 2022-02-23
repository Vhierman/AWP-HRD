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
                    <input type="hidden" class="form-control" name="id_history_jabatan" onkeyup="angka(this);" id="id_history_jabatan" readonly='readonly' value="<?= $datajabatan['id_history_jabatan'] ?>">
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" readonly='readonly' value="<?= $datajabatan['nik_karyawan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Nama Karyawan</label>
                    <input type="text" class="form-control" value="<?= $datajabatan['nama_karyawan'] ?>" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
                <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Jabatan</label>
                    <select name="jabatan_id_history_jabatan" id="jabatan_id_history_jabatan" class="selectpicker" data-width="100%" data-live-search="true" required>
                        <?php foreach ($jabatan as $row) : ?>

                            <?php if ($row['id'] == $datajabatan['jabatan_id_history_jabatan']) : ?>
                                <option value="<?= $row['id'] ?>" selected><?= $row['jabatan'] ?></option>
                            <?php else : ?>
                                <option value="<?= $row['id'] ?>"><?= $row['jabatan'] ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>
                    <small class="form-text text-danger"><?php echo form_error('jabatan_id'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="label">Penempatan</label>
                    <select name="penempatan_id_history_jabatan" id="penempatan_id_history_jabatan" class="selectpicker" data-width="100%" data-live-search="true" required>
                        <?php foreach ($penempatan as $row) : ?>

                            <?php if ($row['id'] == $datajabatan['penempatan_id_history_jabatan']) : ?>
                                <option value="<?= $row['id'] ?>" selected><?= $row['penempatan'] ?></option>
                            <?php else : ?>
                                <option value="<?= $row['id'] ?>"><?= $row['penempatan'] ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    </select>
                    <small class="form-text text-danger"><?php echo form_error('penempatan_id_history_jabatan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="label">Tanggal Mutasi</label>
                    <input type="text" class="form-control" name="tanggal_mutasi" value="<?= $datajabatan['tanggal_mutasi'] ?>" id="tanggal_mutasi" placeholder="YYYY-MM-DD">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_mutasi'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <input type="file" class="custom-file-input" id="file_surat_mutasi" name="file_surat_mutasi">
                    <label class="custom-file-label" id="file_surat_mutasi" for="file_surat_mutasi">Foto Dokumen ( Surat Mutasi Jabatan ) ( Jika File Tidak Dirubah Maka Kosongkan Saja ) Format .jpg</label>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">EDIT DATA JABATAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/jabatan'); ?>">CANCEL</a>

        </div>
    </div>
</div>