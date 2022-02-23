<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('inventaris/tambahinventarismobil'); ?>
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
                    <input type="text" value="<?= set_value('merk_mobil'); ?>" class="form-control" name="merk_mobil" maxlength="20" id="merk_mobil" placeholder="Merk Mobil">
                    <small class="form-text text-danger"><?php echo form_error('merk_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('type_mobil'); ?>" class="form-control" name="type_mobil" maxlength="20" id="type_mobil" placeholder="Type Mobil">
                    <small class="form-text text-danger"><?php echo form_error('type_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('nomor_polisi'); ?>" class="form-control" name="nomor_polisi" maxlength="10" id="nomor_polisi" placeholder="Nomor Polisi">
                    <small class="form-text text-danger"><?php echo form_error('nomor_polisi'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('warna_mobil'); ?>" class="form-control" name="warna_mobil" maxlength="20" id="warna_mobil" placeholder="Warna Mobil">
                    <small class="form-text text-danger"><?php echo form_error('warna_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('nomor_rangka_mobil'); ?>" class="form-control" name="nomor_rangka_mobil" maxlength="50" id="nomor_rangka_mobil" placeholder="Nomor Rangka Mobil">
                    <small class="form-text text-danger"><?php echo form_error('nomor_rangka_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('nomor_mesin_mobil'); ?>" class="form-control" name="nomor_mesin_mobil" maxlength="50" id="nomor_mesin_mobil" placeholder="Nomor Mesin Mobil">
                    <small class="form-text text-danger"><?php echo form_error('nomor_mesin_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tahun_pembuatan_mobil'); ?>" class="form-control" name="tahun_pembuatan_mobil" maxlength="4" id="tahun_pembuatan_mobil" placeholder="Tahun Pembuatan Mobil">
                    <small class="form-text text-danger"><?php echo form_error('tahun_pembuatan_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_akhir_pajak_mobil'); ?>" class="form-control" name="tanggal_akhir_pajak_mobil" readonly="readonly" id="tanggal_akhir_pajak_mobil" placeholder="Tanggal Akhir Pajak Mobil ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_pajak_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_akhir_plat_mobil'); ?>" class="form-control" name="tanggal_akhir_plat_mobil" readonly="readonly" id="tanggal_akhir_plat_mobil" placeholder="Tanggal Akhir Plat Mobil">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_plat_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_penyerahan_mobil'); ?>" class="form-control" name="tanggal_penyerahan_mobil" readonly="readonly" id="tanggal_penyerahan_mobil" placeholder="Tanggal Penyerahan Mobil ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_penyerahan_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_stnk_mobil" name="foto_stnk_mobil">
                    <label class="custom-file-label" id="foto_stnk_mobil" for="foto_stnk_mobil">Foto STNK Mobil</label>
                </div>
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_mobil" name="foto_mobil">
                    <label class="custom-file-label" id="foto_mobil" for="foto_mobil">Foto Mobil</label>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('inventaris/inventarismobil'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>