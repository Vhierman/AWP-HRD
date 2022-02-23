<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('gaji/tampil_rekap_gaji_prima_komponen_indonesia'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mulai_tanggal" class="col-md-6 col-form-label"><b>Mulai Tanggal</b></label>
                    <input type="text" class="form-control" id="mulai_tanggal" name="mulai_tanggal" maxlength="16" placeholder="Mulai Tanggal" readonly='readonly'>
                </div>
                <div class="form-group col-md-6">
                    <label for="sampai_tanggal" class="col-md-6 col-form-label"><b>Sampai Tanggal</b></label>
                    <input type="text" class="form-control" placeholder="Sampai Tanggal" name="sampai_tanggal" id="sampai_tanggal" maxlength="50" readonly='readonly'>
                </div>
            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">TAMPIL REKAP GAJI</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('gaji/rekap_gaji_prima_komponen_indonesia'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>