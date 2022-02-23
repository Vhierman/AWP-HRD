<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= form_open_multipart('gaji/updategajikaryawan'); ?>
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
            <!-- Menampilkan Pesan Kesalahan -->

            <div class="alert alert-info" role="alert">
                Silakan Pilih Penempatan Karyawan
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="penempatan" class="col-md-12 col-form-label"><b>Pilih Penempatan</b></label>
                    <select name="penempatan_id" id="penempatan_id" class="form-control">
                        <option value="" disabled="disabled">Pilih Penempatan</option>
                        <?php foreach ($penempatan as $pn) : ?>
                            <option value="<?= $pn['id']; ?>">
                                <?= $pn['penempatan']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SUBMIT</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('home'); ?>">CANCEL</a>

        </div>
    </div>
    </form>
</div>