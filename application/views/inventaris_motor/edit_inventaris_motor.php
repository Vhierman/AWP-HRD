<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart(''); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">
            <input type="text" class="form-control" name="id_inventaris_motor" maxlength="11" onkeyup="angka(this);" value="<?= $lihat['id_inventaris_motor'] ?>" readonly="readonly">
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
                    <label for="merk_motor">Merk Motor</label>
                    <input type="text" value="<?= $lihat['merk_motor'] ?>" class="form-control" name="merk_motor" maxlength="20" placeholder="Merk Motor">
                    <small class="form-text text-danger"><?php echo form_error('merk_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="type_motor">Type Motor</label>
                    <input type="text" value="<?= $lihat['type_motor'] ?>" class="form-control" name="type_motor" maxlength="20" placeholder="Type Motor">
                    <small class="form-text text-danger"><?php echo form_error('type_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nomor_polisi">Nomor Polisi</label>
                    <input type="text" value="<?= $lihat['nomor_polisi'] ?>" class="form-control" name="nomor_polisi" maxlength="10" placeholder="Nomor Polisi">
                    <small class="form-text text-danger"><?php echo form_error('nomor_polisi'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="warna_motor">Warna Motor</label>
                    <input type="text" value="<?= $lihat['warna_motor'] ?>" class="form-control" name="warna_motor" maxlength="20" placeholder="Warna Motor">
                    <small class="form-text text-danger"><?php echo form_error('warna_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nomor_rangka_motor">Nomor Rangka Motor</label>
                    <input type="text" value="<?= $lihat['nomor_rangka_motor'] ?>" class="form-control" name="nomor_rangka_motor" maxlength="50" placeholder="Nomor Rangka Motor">
                    <small class="form-text text-danger"><?php echo form_error('nomor_rangka_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="nomor_mesin_motor">Nomor Mesin Motor</label>
                    <input type="text" value="<?= $lihat['nomor_mesin_motor'] ?>" class="form-control" name="nomor_mesin_motor" maxlength="50" placeholder="Nomor Mesin Motor">
                    <small class="form-text text-danger"><?php echo form_error('nomor_mesin_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tahun_pembuatan_motor">Tahun Pembuatan Motor</label>
                    <input type="text" value="<?= $lihat['tahun_pembuatan_motor'] ?>" class="form-control" name="tahun_pembuatan_motor" maxlength="4" placeholder="Tahun Pembuatan Motor">
                    <small class="form-text text-danger"><?php echo form_error('tahun_pembuatan_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_akhir_pajak_motor">Tanggal Akhir Pajak Motor</label>
                    <input type="text" value="<?= $lihat['tanggal_akhir_pajak_motor'] ?>" class="form-control" name="tanggal_akhir_pajak_motor" readonly="readonly" placeholder="Tanggal Akhir Pajak Motor ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_pajak_motor'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tanggal_akhir_plat_motor">Tanggal Akhir Plat Motor</label>
                    <input type="text" value="<?= $lihat['tanggal_akhir_plat_motor'] ?>" class="form-control" name="tanggal_akhir_plat_motor" readonly="readonly" placeholder="Tanggal Akhir Plat Motor">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_akhir_plat_motor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_penyerahan_motor">Tanggal Penyerahan Motor</label>
                    <input type="text" value="<?= $lihat['tanggal_penyerahan_motor'] ?>" class="form-control" name="tanggal_penyerahan_motor" readonly="readonly" placeholder="Tanggal Penyerahan Motor ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_penyerahan_motor'); ?></small>
                </div>
            </div>
            <span class="badge badge-danger">Kosongkan Saja Jika Foto Tidak Diganti</span>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_stnk_motor" name="foto_stnk_motor">
                    <label class="custom-file-label" id="foto_stnk_motor" for="foto_stnk_motor">Foto STNK Motor</label>
                    <img src="<?= base_url('assets/img/inventaris/motor/stnk/') . $lihat['foto_stnk_motor']; ?>" class="img-thumbnail">
                </div>
                <div class="form-group col-md-6">
                    <input type="file" class="custom-file-input" id="foto_motor" name="foto_motor">
                    <label class="custom-file-label" id="foto_motor" for="foto_motor">Foto Motor</label>
                    <img src="<?= base_url('assets/img/inventaris/motor/motor/') . $lihat['foto_motor']; ?>" class="img-thumbnail">
                </div>
            </div>



            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('inventaris/inventarismotor'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>