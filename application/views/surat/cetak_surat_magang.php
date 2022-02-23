<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('surat/cetaksuratmagang'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="nik_karyawan_magang" maxlength="16" onkeyup="angka(this);" id="nik_karyawan_magang" placeholder="Masukan NIK Karyawan Magang">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" onkeyup="huruf(this);" placeholder="Nama Karyawan" name="nama_karyawan" maxlength="50">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="jabatan" placeholder="Jabatan">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="penempatan" placeholder="Penempatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="tempat_lahir" placeholder="Tempat Lahir">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" readonly='readonly' placeholder="Tanggal Lahir" readonly="readonly">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Pendidikan Terakhir" name="pendidikan_terakhir">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Jenis Kelamin" name="jenis_kelamin">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Agama" name="agama">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Alamat" name="alamat">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="RT" name="rt">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="RW" name="rw">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Kelurahan" name="kelurahan">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Kecamatan" name="kecamatan">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Kota" name="kota">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Provinsi" name="provinsi">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Tanggal Akhir Magang" id="tanggal_akhir_magang" name="tanggal_akhir_magang" readonly='readonly'>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Tanggal Cetak Surat" id="tanggal_cetak_surat" name="tanggal_cetak_surat" readonly='readonly'>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" formtarget="_blank" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('surat/suratmagang'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>