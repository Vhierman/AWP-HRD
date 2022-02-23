<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="" method="POST">
        <div class="card">
            <h5 class="card-header">Form Edit Lembur</h5>
            <div class="card-body">

                <div class="alert alert-info" role="alert">
                    Yang Di EDIT Hanya Jam, Jenis, Dan Keterangan Lembur, Jika yang salah tanggal lembur, maka Data Di Hapus Dan Di Input Ulang.
                </div>

                <input type="hidden" class="form-control" name="id_slip_lembur" readonly='readonly' value="<?= $lembur['id_slip_lembur']; ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">NIK Karyawan</label>
                        <input type="text" class="form-control" name="karyawan_id" maxlength="16" readonly='readonly' value="<?= $lembur['karyawan_id']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('karyawan_id'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama Karyawan</label>
                        <input type="text" class="form-control" name="nama_karyawan" maxlength="50" readonly='readonly' value="<?= $lembur['nama_karyawan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" readonly="readonly" value="<?= $lembur['jabatan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Penempatan</label>
                        <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $lembur['penempatan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Lembur</label>
                        <input type="text" class="form-control" name="tanggal_lembur" readonly="readonly" value="<?= $lembur['tanggal_lembur']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lembur'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jam Lembur</label>
                        <select name="jam_lembur" id="jam_lembur" class="form-control">
                            <option value="">Pilih Jam Lembur</option>
                            <?php foreach ($jamlembur as $jl) : ?>

                                <?php if ($jl['id_jam_lembur'] == $lembur['jam_lembur_id']) : ?>
                                    <option value="<?= $jl['id_jam_lembur']; ?>" selected><?= 'Jam Masuk ' . $jl['jam_masuk'] . ' | Jam Istirahat ' . $jl['jam_istirahat'] . ' | Jam Pulang ' . $jl['jam_pulang']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $jl['id_jam_lembur']; ?>"><?= 'Jam Masuk ' . $jl['jam_masuk'] . ' | Jam Istirahat ' . $jl['jam_istirahat'] . ' | Jam Pulang ' . $jl['jam_pulang']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jenis Lembur</label>
                        <select name="jenis_lembur" id="jenis_lembur" class="form-control">
                            <?php foreach ($jenis_lembur as $jl) : ?>

                                <?php if ($jl == $lembur['jenis_lembur']) : ?>
                                    <option value="<?= $jl ?>" selected><?= $jl ?></option>
                                <?php else : ?>
                                    <option value="<?= $jl ?>"><?= $jl ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Keterangan Lembur</label>
                        <select name="keterangan_lembur" id="keterangan_lembur" class="form-control">
                            <option value="">Pilih Keterangan Lembur</option>
                            <?php foreach ($keteranganlembur as $kl) : ?>

                                <?php if ($kl['id_keterangan_lembur'] == $lembur['keterangan_lembur_id']) : ?>
                                    <option value="<?= $kl['id_keterangan_lembur']; ?>" selected><?= $kl['keterangan_lembur']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $kl['id_keterangan_lembur']; ?>"><?= $kl['keterangan_lembur']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>


                <!-- Button Simpan Dan Cancel -->
                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
                <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('lembur/datalembur'); ?>">CANCEL</a>
            </div>
        </div>
    </form>
</div>