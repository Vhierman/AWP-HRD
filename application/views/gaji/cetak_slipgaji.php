<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('gaji/cetakslipgaji'); ?>
    <div class="card">
        <h5 class="card-header"><?= $title; ?></h5>
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
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Jumlah Upah</b></label>
                    <input type="text" class="form-control" name="jumlah_upah" readonly="readonly" placeholder="Jumlah Upah">
                </div>
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Potongan JKN</b></label>
                    <input type="text" class="form-control" name="potongan_jkn" readonly='readonly' placeholder="Potongan JKN">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Potongan JHT</b></label>
                    <input type="text" class="form-control" placeholder="Potongan JHT" name="potongan_jht" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Potongan JP</b></label>
                    <input type="text" class="form-control" placeholder="Potongan JP" name="potongan_jp" readonly='readonly'>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Total Gaji</b></label>
                    <input type="text" class="form-control" placeholder="Total Gaji" name="total_gaji" readonly="readonly">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Periode Awal</b></label>
                    <input type="text" class="form-control" placeholder="Tanggal Mulai Laporan" id="tanggal_awal" name="tanggal_awal" readonly="readonly">
                </div>
                <div class="form-group col-md-6">
                    <label for="perusahaan_id" class="col-md-6 col-form-label"><b>Periode Akhir</b></label>
                    <input type="text" class="form-control" placeholder="Tanggal Akhir Laporan" id="tanggal_akhir" name="tanggal_akhir" readonly="readonly">
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" formtarget="_blank" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('gaji/slipgaji'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>