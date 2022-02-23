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
                <div class="form-group col-md-12">
                    <label for="label">Nama Karyawan</label>
                    <input type="hidden" readonly="readonly" class="form-control" id="id_history_kontrak" name="id_history_kontrak" value="<?= $kontrak['id_history_kontrak']; ?>" placeholder="ID">
                    <input type="hidden" readonly="readonly" class="form-control" id="nik_karyawan" name="nik_karyawan" value="<?= $kontrak['nik_karyawan']; ?>" placeholder="ID">
                    <input type="text" readonly="readonly" class="form-control" id="nama_karyawan" name="nama_karyawan" value="<?= $kontrak['nama_karyawan']; ?>" placeholder="Nama Karyawan">
                    <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Tanggal Awal Kontrak</label>
                    <input type="text" class="form-control" id="tanggal_awal_kontrak" name="tanggal_awal_kontrak" value="<?= $kontrak['tanggal_awal_kontrak']; ?>" placeholder="YYYY-MM-DD">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_awal_kontrak'); ?></small>

                </div>
                <div class="form-group col-md-6">
                    <label for="label">Tanggal Akhir Kontrak</label>
                    <input type="text" class="form-control" id="tanggal_akhir_kontrak" name="tanggal_akhir_kontrak" value="<?= $kontrak['tanggal_akhir_kontrak']; ?>" placeholder="YYYY-MM-DD">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_kontrak'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="label">Status Kontrak</label>
                    <select name="status_kontrak_kerja" id="status_kontrak_kerja" class="form-control">
                        <?php foreach ($status_kontrak_kerja as $row) : ?>

                            <?php if ($row == $kontrak['status_kontrak_kerja']) : ?>
                                <option value="<?= $row ?>" selected><?= $row ?></option>
                            <?php else : ?>
                                <option value="<?= $row ?>"><?= $row ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('status_kontrak_kerja'); ?></small>
                </div>

                <div class="form-group col-md-6">
                    <label for="label">Masa Kontrak</label>
                    <input type="text" readonly="readonly" class="form-control" id="masa_kontrak" name="masa_kontrak" value="<?= $kontrak['masa_kontrak']; ?>" placeholder="Masa Kontrak Kerja">
                </div>
            </div>

            <!-- Button Simpan Dan Cancel formtarget="_blank" -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">EDIT DATA KONTRAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/kontrak'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>