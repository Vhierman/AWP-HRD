<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <form action="" method="POST">
        <div class="card">
            <h5 class="card-header">Form Edit Absensi</h5>
            <div class="card-body">

                <div class="alert alert-info" role="alert">
                    Jika tidak ada yang di edit, maka kosongkan saja.
                </div>

                <input type="hidden" class="form-control" name="id_absen" readonly='readonly' value="<?= $absensi['id_absen']; ?>">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik_karyawan_absen" maxlength="16" readonly='readonly' value="<?= $absensi['nik_karyawan_absen']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('nik_karyawan_absen'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama Karyawan</label>
                        <input type="text" class="form-control" name="nama_karyawan" maxlength="50" readonly='readonly' value="<?= $absensi['nama_karyawan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" readonly="readonly" value="<?= $absensi['jabatan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Penempatan</label>
                        <input type="text" class="form-control" name="penempatan" readonly='readonly' value="<?= $absensi['penempatan']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Absen</label>
                        <input type="text" class="form-control" name="tanggal_absen" id="tanggal_absen" readonly="readonly" value="<?= $absensi['tanggal_absen']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_absen'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Selesai</label>
                        <input type="text" class="form-control" name="tanggal_selesai" id="tanggal_selesai" readonly='readonly' value="<?= $absensi['tanggal_selesai']; ?>">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_selesai'); ?></small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail4">Keterangan Absen</label>
                    <select name="keterangan_absen" id="keterangan_absen" class="form-control">
                        <?php foreach ($keterangan_absen as $ka) : ?>

                            <?php if ($ka == $absensi['keterangan_absen']) : ?>
                                <option value="<?= $ka ?>" selected><?= $ka ?></option>
                            <?php else : ?>
                                <option value="<?= $ka ?>"><?= $ka ?></option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('keterangan_absen'); ?></small>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Masukan Keterangan" id="keterangan" value="<?= $absensi['keterangan']; ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jenis Cuti</label>
                        <select name="jenis_cuti" id="jenis_cuti" class="form-control">
                            <?php foreach ($jenis_cuti as $jc) : ?>

                                <?php if ($jc == $absensi['jenis_cuti']) : ?>
                                    <option value="<?= $jc ?>" selected><?= $jc ?></option>
                                <?php else : ?>
                                    <option value="<?= $jc ?>"><?= $jc ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- Button Simpan Dan Cancel -->
                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
                <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('absensi/dataabsen'); ?>">CANCEL</a>
            </div>
        </div>
    </form>
</div>