<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>
    <?= form_open_multipart('inventaris/tambahinventarislaptop'); ?>
    <div class="card">
        <h5 class="card-header">Form Tambah Data Inventaris Laptop</h5>
        <div class="card-body">

            <div class="alert alert-info" role="alert">
                Silakan Masukan NIK Karyawan untuk mencari terlebih dahulu Nama Karyawan yang ingin diinputkan.
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" placeholder="Masukan NIK Karyawan">
                    <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Nama Karyawan" name="nama_karyawan" maxlength="50" readonly='readonly'>
                    <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" placeholder="Jabatan">
                    <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' placeholder="Penempatan">
                    <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('merk_laptop'); ?>" class="form-control" name="merk_laptop" maxlength="20" id="merk_laptop" placeholder="Merk Laptop">
                    <small class="form-text text-danger"><?php echo form_error('merk_laptop'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('type_laptop'); ?>" class="form-control" name="type_laptop" maxlength="20" id="type_laptop" placeholder="Type Laptop">
                    <small class="form-text text-danger"><?php echo form_error('type_laptop'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('processor'); ?>" class="form-control" name="processor" maxlength="30" id="processor" placeholder="Processor">
                    <small class="form-text text-danger"><?php echo form_error('processor'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('ram'); ?>" class="form-control" name="ram" maxlength="5" id="ram" placeholder="RAM">
                    <small class="form-text text-danger"><?php echo form_error('ram'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('hardisk'); ?>" class="form-control" name="hardisk" maxlength="30" id="hardisk" placeholder="Hardisk">
                    <small class="form-text text-danger"><?php echo form_error('vga'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('vga'); ?>" class="form-control" name="vga" maxlength="30" id="vga" placeholder="VGA">
                    <small class="form-text text-danger"><?php echo form_error('vga'); ?></small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('sistem_operasi'); ?>" class="form-control" name="sistem_operasi" maxlength="30" id="sistem_operasi" placeholder="Sistem Operasi">
                    <small class="form-text text-danger"><?php echo form_error('sistem_operasi'); ?></small>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" value="<?= set_value('tanggal_penyerahan_laptop'); ?>" class="form-control" name="tanggal_penyerahan_laptop" readonly="readonly" id="tanggal_penyerahan_laptop" placeholder="Tanggal Penyerahan Laptop ( yyyy-mm-dd )">
                    <small class="form-text text-danger"><?php echo form_error('tanggal_penyerahan_laptop'); ?></small>
                </div>
            </div>


            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_laptop" name="foto_laptop">
                    <label class="custom-file-label" id="foto_laptop" for="foto_laptop">Foto Laptop</label>
                </div>
            </div>


            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('inventaris/inventarislaptop'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>