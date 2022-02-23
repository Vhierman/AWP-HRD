<div class="container">
    <div class="row mt-3">
        <div class="col-md-12">

            <div class="card ">
                <h5 class="card-header">Edit Data Keterangan Lembur</h5>
                <div class="card-body">

                    <form action="" method="post">

                        <input type="hidden" name="id_keterangan_lembur" value="<?= $keteranganlembur['id_keterangan_lembur'] ?>">

                        <div class="form-group">
                            <label for="KeteranganLembur">Keterangan Lembur</label>
                            <input type="text" class="form-control" name="keterangan_lembur" value="<?= $keteranganlembur['keterangan_lembur'] ?>">
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save"></i> Edit Data Keterangan Lembur</button>
                        <a href="<?= base_url('master/keteranganlembur'); ?>" class="btn btn-danger"><i class="fas fa-ban"></i> Cancel</a>

                </div>
            </div>

            </form>
        </div>
    </div>
</div>