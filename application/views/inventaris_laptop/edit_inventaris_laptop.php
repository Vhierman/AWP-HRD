<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart(''); ?>
    <div class="card">
        <h5 class="card-header"><?= $title; ?></h5>
        <div class="card-body">
            <input type="hidden" class="form-control" name="id_inventaris_laptop" readonly="readonly" value="<?= $lihat['id_inventaris_laptop']; ?>">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nik_karyawan">NIK Karyawan</label>
                    <input type="text" class="form-control" name="nik_karyawan" readonly="readonly" value="<?= $lihat['nik_karyawan']; ?>">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="nama_karyawan">Nama Karyawan</label>
                    <input type="text" class="form-control" readonly="readonly" name="nama_karyawan" value="<?= $lihat['nama_karyawan']; ?>">
                    <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" value="<?= $lihat['jabatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="penempatan">Penempatan</label>
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $lihat['penempatan'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="merk_laptop">Merk Laptop</label>
                    <input type="text" class="form-control" name="merk_laptop" maxlength="20" value="<?= $lihat['merk_laptop'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('merk_laptop'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="type_laptop">Type Laptop</label>
                    <input type="text" class="form-control" name="type_laptop" maxlength="20" value="<?= $lihat['type_laptop'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('type_laptop'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="processor">Processor</label>
                    <input type="text" class="form-control" name="processor" maxlength="30" value="<?= $lihat['processor'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('processor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="ram">RAM</label>
                    <input type="text" class="form-control" name="ram" maxlength="5" value="<?= $lihat['ram'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('ram'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="hardisk">Hardisk</label>
                    <input type="text" class="form-control" name="hardisk" maxlength="30" value="<?= $lihat['hardisk'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('vga'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="vga">VGA</label>
                    <input type="text" class="form-control" name="vga" maxlength="30" value="<?= $lihat['vga'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('vga'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="sistem_operasi">Sistem Operasi</label>
                    <input type="text" class="form-control" name="sistem_operasi" maxlength="30" value="<?= $lihat['sistem_operasi'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('sistem_operasi'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <label for="tanggal_penyerahan_laptop">Tanggal Penyerahan</label>
                    <input type="text" class="form-control" id="tanggal_penyerahan_laptop" name="tanggal_penyerahan_laptop" readonly="readonly" value="<?= $lihat['tanggal_penyerahan_laptop'] ?>">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_penyerahan_laptop'); ?></small>
                </div>
            </div>

            <span class="badge badge-danger">Kosongkan Saja Jika Foto Tidak Diganti</span>
            <div class="form-group row">
                <div class="col-sm-2">
                    <b>Foto Laptop</b>
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-5">
                            <img src="<?= base_url('assets/img/inventaris/laptop/') . $lihat['foto_laptop']; ?>" class="img-thumbnail">
                        </div>
                        <div class="col-sm-7">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="foto_laptop">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('inventaris/inventarislaptop'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>