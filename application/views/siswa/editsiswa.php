<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <form action="" method="POST">

        <div class="card">
            <h5 class="card-header">Form Edit Siswa</h5>

            <div class="card-body">

                <input type="text" class="form-control" value="<?= $siswa['id_siswa']; ?>" id="id_siswa" name="id_siswa">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama Sekolah</label>
                        <select name="sekolah_id" id="sekolah_id" class="form-control">
                            <option value="">Pilih Sekolah</option>
                            <?php foreach ($sekolah as $skl) : ?>

                                <?php if ($skl['id_sekolah'] == $siswa['sekolah_id']) : ?>
                                    <option value="<?= $skl['id_sekolah']; ?>" selected><?= $skl['nama_sekolah']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $skl['id_sekolah']; ?>"><?= $skl['nama_sekolah']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('sekolah_id'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Penempatan</label>
                        <select name="penempatan_id" id="penempatan_id" class="form-control">
                            <option value="">Pilih Penempatan</option>
                            <?php foreach ($penempatan as $pn) : ?>

                                <?php if ($pn['id'] == $siswa['penempatan_id']) : ?>
                                    <option value="<?= $pn['id']; ?>" selected><?= $pn['penempatan']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $pn['id']; ?>"><?= $pn['penempatan']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('penempatan_id'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Mulai PKL</label>
                        <input type="text" value="<?= $siswa['tanggal_masuk_pkl']; ?>" id="tanggal_masuk_pkl" name="tanggal_masuk_pkl" readonly="readonly" placeholder="Tanggal Masuk PKL ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_masuk_pkl'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Selesai PKL</label>
                        <input type="text" value="<?= $siswa['tanggal_selesai_pkl']; ?>" id="tanggal_selesai_pkl" name="tanggal_selesai_pkl" readonly="readonly" placeholder="Tanggal Selesai PKL ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_selesai_pkl'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">NIS Siswa</label>
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= $siswa['nis_siswa']; ?>" id="nis_siswa" name="nis_siswa" placeholder="Masukan NIS Siswa">
                        <small class="form-text text-danger"><?php echo form_error('nis_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama Siswa</label>
                        <input type="text" onkeyup="huruf(this);" class="form-control" value="<?= $siswa['nama_siswa']; ?>" id="nama_siswa" name="nama_siswa" placeholder="Masukan Nama Siswa">
                        <small class="form-text text-danger"><?php echo form_error('nama_siswa'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tempat Lahir</label>
                        <input type="text" class="form-control" value="<?= $siswa['tempat_lahir_siswa']; ?>" id="tempat_lahir_siswa" name="tempat_lahir_siswa" placeholder="Masukan Tempat Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tempat_lahir_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Lahir</label>
                        <input type="text" value="<?= $siswa['tanggal_lahir_siswa']; ?>" id="tanggal_lahir_siswa" name="tanggal_lahir_siswa" readonly="readonly" placeholder="Tanggal Lahir ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lahir_siswa'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jenis Kelamin</label>
                        <select name="jenis_kelamin_siswa" id="jenis_kelamin_siswa" class="form-control">
                            <?php foreach ($jenis_kelamin_siswa as $jk) : ?>

                                <?php if ($jk == $siswa['jenis_kelamin_siswa']) : ?>
                                    <option value="<?= $jk ?>" selected><?= $jk ?></option>
                                <?php else : ?>
                                    <option value="<?= $jk ?>"><?= $jk ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Agama</label>
                        <select name="agama_siswa" id="agama_siswa" class="form-control">
                            <?php foreach ($agama_siswa as $ag) : ?>

                                <?php if ($ag == $siswa['agama_siswa']) : ?>
                                    <option value="<?= $ag ?>" selected><?= $ag ?></option>
                                <?php else : ?>
                                    <option value="<?= $ag ?>"><?= $ag ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('agama_siswa'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nomor Handphone</label>
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= $siswa['nomor_handphone_siswa']; ?>" id="nomor_handphone_siswa" name="nomor_handphone_siswa" placeholder="Masukan Nomor Handphone">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jurusan</label>
                        <input type="text" class="form-control" value="<?= $siswa['jurusan']; ?>" id="jurusan" name="jurusan" placeholder="Masukan Jurusan">
                        <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">Alamat
                        <small id="emailHelp" class="form-text text-muted">--Diisi dengan ( Nama Jalan, Rt/Rw, Kelurahan, Kecamatan, Kabupaten/Kota, Kode POS )</small>
                    </label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="alamat_siswa" id="alamat_siswa"><?= set_value('alamat_siswa'); ?><?= $siswa['alamat_siswa']; ?></textarea>
                        <small class="form-text text-danger"><?php echo form_error('alamat_siswa'); ?></small>
                    </div>
                </div>

                <!-- Button Simpan Dan Cancel -->
                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
                <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('siswa/siswa'); ?>">CANCEL</a>

            </div>
        </div>

    </form>
</div>