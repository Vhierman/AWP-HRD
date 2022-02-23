<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart(''); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">
            <input type="text" class="form-control" name="id_inventaris_mobil" maxlength="11" onkeyup="angka(this);" value="<?= $lihat['id_inventaris_mobil'] ?>" readonly="readonly">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nik_karyawan">NIK Karyawan</label>
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" value="<?= $lihat['nik_karyawan'] ?>" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <label for="nama_karyawan">Nama Karyawan</label>
                    <input type="text" class="form-control" placeholder="Nama Karyawan" value="<?= $lihat['nama_karyawan'] ?>" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" value="<?= $lihat['jabatan'] ?>" name="jabatan" readonly="readonly" placeholder="Jabatan">
                </div>
                <div class="form-group col-md-6">
                    <label for="penempatan">Penempatan</label>
                    <input type="text" class="form-control" value="<?= $lihat['penempatan'] ?>" name="penempatan" readonly='readonly' placeholder="Penempatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="merk_mobil">Merk Mobil</label>
                    <input type="text" value="<?= $lihat['merk_mobil'] ?>" class="form-control" name="merk_mobil" maxlength="20" placeholder="Merk Mobil">
                    <small class="form-text text-danger"><?php echo form_error('merk_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="type_mobil">Type Mobil</label>
                    <input type="text" value="<?= $lihat['type_mobil'] ?>" class="form-control" name="type_mobil" maxlength="20" placeholder="Type Mobil">
                    <small class="form-text text-danger"><?php echo form_error('type_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nomor_polisi">Nomor Polisi</label>
                    <input type="text" value="<?= $lihat['nomor_polisi'] ?>" class="form-control" name="nomor_polisi" maxlength="10" placeholder="Nomor Polisi">
                    <small class="form-text text-danger"><?php echo form_error('nomor_polisi'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="warna_mobil">Warna Mobil</label>
                    <input type="text" value="<?= $lihat['warna_mobil'] ?>" class="form-control" name="warna_mobil" maxlength="20" placeholder="Warna Mobil">
                    <small class="form-text text-danger"><?php echo form_error('warna_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nomor_rangka_mobil">Nomor Rangka Mobil</label>
                    <input type="text" value="<?= $lihat['nomor_rangka_mobil'] ?>" class="form-control" name="nomor_rangka_mobil" maxlength="50" placeholder="Nomor Rangka Mobil">
                    <small class="form-text text-danger"><?php echo form_error('nomor_rangka_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="nomor_mesin_mobil">Nomor Mesin Mobil</label>
                    <input type="text" value="<?= $lihat['nomor_mesin_mobil'] ?>" class="form-control" name="nomor_mesin_mobil" maxlength="50" placeholder="Nomor Mesin Mobil">
                    <small class="form-text text-danger"><?php echo form_error('nomor_mesin_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tahun_pembuatan_mobil">Tahun Pembuatan Mobil</label>
                    <input type="text" value="<?= $lihat['tahun_pembuatan_mobil'] ?>" class="form-control" name="tahun_pembuatan_mobil" maxlength="4" placeholder="Tahun Pembuatan Mobil">
                    <small class="form-text text-danger"><?php echo form_error('tahun_pembuatan_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_akhir_pajak_mobil">Tanggal Akhir Pajak Mobil</label>
                    <input type="text" value="<?= $lihat['tanggal_akhir_pajak_mobil'] ?>" class="form-control" name="tanggal_akhir_pajak_mobil" readonly="readonly" placeholder="Tanggal Akhir Pajak Mobil ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_pajak_mobil'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tanggal_akhir_plat_mobil">Tanggal Akhir Plat Mobil</label>
                    <input type="text" value="<?= $lihat['tanggal_akhir_plat_mobil'] ?>" class="form-control" name="tanggal_akhir_plat_mobil" readonly="readonly" placeholder="Tanggal Akhir Plat Mobil">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_plat_mobil'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_penyerahan_mobil">Tanggal Penyerahan Mobil</label>
                    <input type="text" value="<?= $lihat['tanggal_penyerahan_mobil'] ?>" class="form-control" name="tanggal_penyerahan_mobil" readonly="readonly" placeholder="Tanggal Penyerahan Mobil ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_penyerahan_mobil'); ?></small>
                </div>
            </div>
            <span class="badge badge-danger">Kosongkan Saja Jika Foto Tidak Diganti</span>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_stnk_mobil" name="foto_stnk_mobil">
                    <label class="custom-file-label" id="foto_stnk_mobil" for="foto_stnk_mobil">Foto STNK Mobil</label>
                    <img src="<?= base_url('assets/img/inventaris/mobil/stnk/') . $lihat['foto_stnk_mobil']; ?>" class="img-thumbnail">
                </div>
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_mobil" name="foto_mobil">
                    <label class="custom-file-label" id="foto_mobil" for="foto_mobil">Foto Mobil</label>
                    <img src="<?= base_url('assets/img/inventaris/mobil/mobil/') . $lihat['foto_mobil']; ?>" class="img-thumbnail">
                </div>
            </div>



            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('inventaris/inventarismobil'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>