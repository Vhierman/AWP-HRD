<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('laporan/cetaklaporanmagang'); ?>
    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <div class="alert alert-info" role="alert">
                Silakan Pilih Penempatan Program Magang
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="penempatan" class="col-md-12 col-form-label"><b>Pilih Penempatan</b></label>
                    <select name="penempatan" id="penempatan" class="form-control">
                        <option value="">Pilih Penempatan</option>
                        <?php foreach ($penempatan as $pn) : ?>
                            <option value="<?= $pn['id']; ?>">
                                <?= $pn['penempatan']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" formtarget="_blank" class="btn btn-primary btn-sm btn-lg btn-block">CETAK</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('laporan/magang'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>