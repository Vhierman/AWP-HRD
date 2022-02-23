<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="" method="POST">
        <div class="card">
            <h5 class="card-header">Form Edit BPJS Kesehatan</h5>
            <div class="card-body">

                <input type="hidden" class="form-control" name="id_potongan_bpjs_kesehatan" readonly='readonly' value="<?= $bpjskesehatan['id_potongan_bpjs_kesehatan']; ?>">

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Beban Karyawan (%)</label>
                        <input type="text" class="form-control" name="potongan_bpjs_kesehatan_karyawan" maxlength="2" value="<?= $bpjskesehatan['potongan_bpjs_kesehatan_karyawan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_bpjs_kesehatan_karyawan'); ?></small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Beban Perusahaan (%)</label>
                        <input type="text" class="form-control" name="potongan_bpjs_kesehatan_perusahaan" maxlength="2" value="<?= $bpjskesehatan['potongan_bpjs_kesehatan_perusahaan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_bpjs_kesehatan_perusahaan'); ?></small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Maksimal Iuran (Rp)</label>
                        <input type="text" class="form-control" name="maksimal_iuran_bpjs_kesehatan" maxlength="15" value="<?= $bpjskesehatan['maksimal_iuran_bpjs_kesehatan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('maksimal_iuran_bpjs_kesehatan'); ?></small>
                    </div>
                </div>

            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('master/bpjskesehatan'); ?>">CANCEL</a>
        </div>
</div>
</form>
</div>