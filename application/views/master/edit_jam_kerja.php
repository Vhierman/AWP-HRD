<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">

            <div class="card ">
                <h5 class="card-header">Edit Data Jam Kerja</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id_jam_kerja" value="<?= $jamkerja['id_jam_kerja'] ?>">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="JamMasuk">Jam Masuk</label>
                                <input type="time" class="form-control" name="jam_masuk" value="<?= $jamkerja['jam_masuk'] ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="JamPulang">Jam Pulang</label>
                                <input type="time" class="form-control" name="jam_pulang" value="<?= $jamkerja['jam_pulang'] ?>">
                            </div>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Data Jam Lembur</button>
                        <a href="<?= base_url('master/jamkerja'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>