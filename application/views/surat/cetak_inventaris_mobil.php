<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('surat/cetakinventarismobil'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <div class="alert alert-info" role="alert">
                Silakan Masukan NIK Karyawan untuk mencari terlebih dahulu Nama Karyawan yang ingin diinputkan.
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>NIK Karyawan</b></label>
                    <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" placeholder="Masukan NIK Karyawan">
                </div>
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Nama Karyawan</b></label>
                    <input type="text" class="form-control" placeholder="Nama Karyawan" name="nama_karyawan" maxlength="50" readonly='readonly'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Jabatan</b></label>
                    <input type="text" class="form-control" name="jabatan" readonly="readonly" placeholder="Jabatan">
                </div>
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Penempatan</b></label>
                    <input type="text" class="form-control" name="penempatan" readonly='readonly' placeholder="Penempatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Merk Mobil</b></label>
                    <input type="text" class="form-control" placeholder="Merk Mobil" name="merk_mobil" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Type Mobil</b></label>
                    <input type="text" class="form-control" placeholder="Type Mobil" name="type_mobil" readonly='readonly'>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" formtarget="_blank" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('surat/inventarismobil'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>