<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('surat/cetakpkwt'); ?>
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
                    <input type="text" class="form-control" placeholder="Tanggal Masuk" name="tanggal_mulai_kerja" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Tanggal Akhir" name="tanggal_akhir_kerja" readonly='readonly'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <select name="masa" id="masa" class="form-control">
                        <option value="">Pilih Masa</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select name="lama" id="lama" class="form-control">
                        <option value="">Pilih Lama</option>
                        <option value="Bulan">Bulan</option>
                        <option value="Tahun">Tahun</option>
                    </select>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" formtarget="_blank" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('surat/pkwt'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>