<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('laporan/cetaklaporanabsensi'); ?>
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
                    <input type="text" class="form-control" placeholder="Tanggal Mulai Laporan" id="tanggal_mulai_laporan_absen" name="tanggal_mulai_laporan_absen" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" placeholder="Tanggal Selesai Laporan" id="tanggal_selesai_laporan_absen" name="tanggal_selesai_laporan_absen" readonly='readonly'>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" formtarget="_blank" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('laporan/absensikaryawan'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>