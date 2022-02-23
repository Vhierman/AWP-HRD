<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">

            <div class="card ">
                <h5 class="card-header">Edit Data Jam Lembur</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id_jam_lembur" value="<?= $jamlembur['id_jam_lembur'] ?>">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="JamMasuk">Jam Masuk</label>
                                <input type="text" class="form-control" name="jam_masuk" value="<?= $jamlembur['jam_masuk'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="JamIstirahat">Jam Istirahat</label>
                                <input type="text" class="form-control" name="jam_istirahat" value="<?= $jamlembur['jam_istirahat'] ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="JamPulang">Jam Pulang</label>
                                <input type="text" class="form-control" name="jam_pulang" value="<?= $jamlembur['jam_pulang'] ?>">
                            </div>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Data Jam Lembur</button>
                        <a href="<?= base_url('master/jamlembur'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>