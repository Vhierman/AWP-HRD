<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('history/tampilpendidikannonformal'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <!-- Menampilkan Pesan Kesalahan -->
            <?= $this->session->flashdata('message'); ?>

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

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">TAMPILKAN DATA</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('history/pendidikannonformal'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>