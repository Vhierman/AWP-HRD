<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="<?= base_url('CetakLembur/optioncetak'); ?>" method="post">
        <div class="card">
            <h5 class="card-header">Form <?= $title; ?></h5>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="slip" class="col-md-12 col-form-label"><b>Pilih Slip Lembur</b></label>
                        <select name="slip" id="slip" class="form-control">
                            <option value="">Pilih Jenis Slip</option>
                            <option value="Kecil">Kecil</option>
                            <option value="Besar">Besar</option>
                        </select>
                    </div>
                </div>

                <!-- Button Simpan Dan Cancel -->
                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
                <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('cetaklembur/sliplembur'); ?>">CANCEL</a>

            </div>
    </form>
</div>
</form>
</div>