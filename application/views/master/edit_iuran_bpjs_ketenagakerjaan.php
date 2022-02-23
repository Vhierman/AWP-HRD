<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="" method="POST">
        <div class="card">
            <h5 class="card-header">Form Edit BPJS Ketenagakerjaan</h5>
            <div class="card-body">

                <input type="hidden" class="form-control" name="id_potongan_bpjs_ketenagakerjaan" readonly='readonly' value="<?= $bpjsketenagakerjaan['id_potongan_bpjs_ketenagakerjaan']; ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">JHT Beban Karyawan (%)</label>
                        <input type="text" class="form-control" name="potongan_jht_karyawan" maxlength="5" value="<?= $bpjsketenagakerjaan['potongan_jht_karyawan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_jht_karyawan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">JHT Beban Perusahaan (%)</label>
                        <input type="text" class="form-control" name="potongan_jht_perusahaan" maxlength="5" value="<?= $bpjsketenagakerjaan['potongan_jht_perusahaan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_jht_perusahaan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">JP Beban Karyawan (%)</label>
                        <input type="text" class="form-control" name="potongan_jp_karyawan" maxlength="5" value="<?= $bpjsketenagakerjaan['potongan_jp_karyawan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_jp_karyawan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">JP Beban Perusahaan (%)</label>
                        <input type="text" class="form-control" name="potongan_jp_perusahaan" maxlength="5" value="<?= $bpjsketenagakerjaan['potongan_jp_perusahaan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_jp_perusahaan'); ?></small>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">JKK Beban Perusahaan (%)</label>
                        <input type="text" class="form-control" name="potongan_jkk_perusahaan" maxlength="5" value="<?= $bpjsketenagakerjaan['potongan_jkk_perusahaan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_jkk_perusahaan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">JKM Beban Perusahaan (%)</label>
                        <input type="text" class="form-control" name="potongan_jkm_perusahaan" maxlength="5" value="<?= $bpjsketenagakerjaan['potongan_jkm_perusahaan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('potongan_jkm_perusahaan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Maksimal Iuran JP (Rp.)</label>
                        <input type="text" class="form-control" name="maksimal_iuran_jp" maxlength="15" value="<?= $bpjsketenagakerjaan['maksimal_iuran_jp']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('maksimal_iuran_jp'); ?></small>
                    </div>
                </div>

            </div>

            <!-- Button Simpan Dan Cancel -->
            <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
            <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('master/bpjsketenagakerjaan'); ?>">CANCEL</a>
        </div>
</div>
</form>
</div>