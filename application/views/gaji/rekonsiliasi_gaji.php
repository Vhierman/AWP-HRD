<!-- Begin Page Content -->
<div class="container-fluid">

            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

    <!-- Page Heading -->
    <?= form_open_multipart('gaji/tampilrekonsiliasigaji'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

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

            <!-- Button Tampil Dan Cancel -->
            <button type="submit"  class="btn btn-primary btn-sm btn-lg btn-block">TAMPILKAN DATA</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('gaji/rekonsiliasigaji'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>