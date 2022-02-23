<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg">

            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>
            <!-- Menampilkan Pesan Kesalahan -->

            <!-- Button Tambah Data Lembur -->
            <form action="<?= base_url('check/tampildatalemburan'); ?>" method="post">
                <div class="col-sm-12">
                    <div class="card mb-2">
                        <div class="card-header">
                            Pilih Data Yang Akan Ditampilkan
                        </div>

                        <div class="form-group row ml-3 mt-5">
                            <div class="col-sm-11">
                                <select name="penempatan_id" id="penempatan_id" class="form-control">
                                    <option value="">Pilih Penempatan</option>
                                    <?php foreach ($penempatan as $pn) : ?>
                                        <option value="<?= $pn['id']; ?>">
                                            <?= $pn['penempatan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mt-4 ml-3">
                            <label for="tanggal_lembur" class="col-sm-2 col-form-label"><b>Dari Tanggal</b></label>
                            <div class="col-sm-3">
                                <input type="text" name="tanggal_awal" id="tanggal_mulai" class="form-control" placeholder="Dari Tanggal ( yyyy-mm-dd )" readonly="readonly" required>
                            </div>
                            <label for="tanggal_lembur" class="col-sm-3 col-form-label"><b>Sampai Tanggal</b></label>
                            <div class="col-sm-3">
                                <input type="text" name="tanggal_akhir" id="tanggal_selesai" class="form-control" placeholder="Sampai Tanggal ( yyyy-mm-dd )" readonly="readonly" required>
                            </div>
                        </div>

                        <div class="form-group row ml-3">
                            <div class="col-sm-11">
                                <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fas fa-search"></i> Search </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>

</div>