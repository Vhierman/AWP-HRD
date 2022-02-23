<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('inventaris/tambahinventarismotor'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <div class="alert alert-info" role="alert">
                Silakan Masukan NIK Karyawan untuk mencari terlebih dahulu Nama Karyawan yang ingin diinputkan.
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" placeholder="Masukan NIK Karyawan">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Nama Karyawan" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" placeholder="Jabatan">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' placeholder="Penempatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('merk_motor'); ?>" class="form-control" name="merk_motor" maxlength="20" id="merk_motor" placeholder="Merk Motor">
                    <small class="form-text text-danger"><?php echo form_error('merk_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('type_motor'); ?>" class="form-control" name="type_motor" maxlength="20" id="type_motor" placeholder="Type Motor">
                    <small class="form-text text-danger"><?php echo form_error('type_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('nomor_polisi'); ?>" class="form-control" name="nomor_polisi" maxlength="10" id="nomor_polisi" placeholder="Nomor Polisi">
                    <small class="form-text text-danger"><?php echo form_error('nomor_polisi'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('warna_motor'); ?>" class="form-control" name="warna_motor" maxlength="20" id="warna_motor" placeholder="Warna Motor">
                    <small class="form-text text-danger"><?php echo form_error('warna_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('nomor_rangka_motor'); ?>" class="form-control" name="nomor_rangka_motor" maxlength="50" id="nomor_rangka_motor" placeholder="Nomor Rangka Motor">
                    <small class="form-text text-danger"><?php echo form_error('nomor_rangka_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('nomor_mesin_motor'); ?>" class="form-control" name="nomor_mesin_motor" maxlength="50" id="nomor_mesin_motor" placeholder="Nomor Mesin Motor">
                    <small class="form-text text-danger"><?php echo form_error('nomor_mesin_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tahun_pembuatan_motor'); ?>" class="form-control" name="tahun_pembuatan_motor" maxlength="4" id="tahun_pembuatan_motor" placeholder="Tahun Pembuatan Motor">
                    <small class="form-text text-danger"><?php echo form_error('tahun_pembuatan_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_akhir_pajak_motor'); ?>" class="form-control" name="tanggal_akhir_pajak_motor" readonly="readonly" id="tanggal_akhir_pajak_motor" placeholder="Tanggal Akhir Pajak Motor ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_pajak_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_akhir_plat_motor'); ?>" class="form-control" name="tanggal_akhir_plat_motor" readonly="readonly" id="tanggal_akhir_plat_motor" placeholder="Tanggal Akhir Plat Motor">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_plat_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_penyerahan_motor'); ?>" class="form-control" name="tanggal_penyerahan_motor" readonly="readonly" id="tanggal_penyerahan_motor" placeholder="Tanggal Penyerahan Motor ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_penyerahan_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_stnk_motor" name="foto_stnk_motor">
                    <label class="custom-file-label" id="foto_stnk_motor" for="foto_stnk_motor">Foto STNK Motor</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_motor" name="foto_motor">
                    <label class="custom-file-label" id="foto_motor" for="foto_motor">Foto Motor</label>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('inventaris/inventarismotor'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>