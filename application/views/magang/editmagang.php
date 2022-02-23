<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <form action="" method="POST">

        <div class="card">
            <h5 class="card-header">Form Edit Magang</h5>

            <div class="card-body">

                <input type="hidden" class="form-control" value="<?= $magang['id_magang']; ?>" id="id_magang" name="id_magang">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">NIK Magang</label>
                        <input type="text" onkeyup="angka(this);" maxlength="16" class="form-control" value="<?= $magang['nik_magang']; ?>" id="nik_magang" name="nik_magang" placeholder="Masukan NIK KTP">
                        <small class="form-text text-danger"><?php echo form_error('nik_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama</label>
                        <input type="text" onkeyup="huruf(this);" class="form-control" value="<?= $magang['nama_magang']; ?>" id="nama_magang" name="nama_magang" placeholder="Masukan Nama">
                        <small class="form-text text-danger"><?php echo form_error('nama_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Nomor Handphone</label>
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= $magang['nomor_handphone_magang']; ?>" id="nomor_handphone_magang" name="nomor_handphone_magang" placeholder="Masukan Nomor Handphone">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="selectpicker" data-width="100%" data-live-search="true" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatan as $row) : ?>

                                <?php if ($row['id'] == $magang['jabatan_id']) : ?>
                                    <option value="<?= $row['id']; ?>" selected><?= $row['jabatan']; ?></option>
                                <?php else : ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['jabatan']; ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jabatan_id'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Penempatan</label>
                        <select name="penempatan_id" id="penempatan_id" class="selectpicker" data-width="100%" data-live-search="true" required>
                            <option value="">Pilih Penempatan</option>
                            <?php foreach ($penempatan as $pn) : ?>

                                <?php if ($pn['id'] == $magang['penempatan_id']) : ?>
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
                        <label for="inputEmail4">Tanggal Mulai</label>
                        <input type="text" value="<?= $magang['tanggal_masuk_magang']; ?>" id="tanggal_masuk_magang" name="tanggal_masuk_magang" readonly="readonly" placeholder="Tanggal Masuk ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_masuk_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Selesai</label>
                        <input type="text" value="<?= $magang['tanggal_selesai_magang']; ?>" id="tanggal_selesai_magang" name="tanggal_selesai_magang" readonly="readonly" placeholder="Tanggal Selesai ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_selesai_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tempat Lahir</label>
                        <input type="text" class="form-control" value="<?= $magang['tempat_lahir_magang']; ?>" id="tempat_lahir_magang" name="tempat_lahir_magang" placeholder="Masukan Tempat Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tempat_lahir_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Lahir</label>
                        <input type="text" value="<?= $magang['tanggal_lahir_magang']; ?>" id="tanggal_lahir_magang" name="tanggal_lahir_magang" readonly="readonly" placeholder="Tanggal Lahir ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lahir_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Jenis Kelamin</label>
                        <select name="jenis_kelamin_magang" id="jenis_kelamin_magang" class="form-control">
                            <?php foreach ($jenis_kelamin_magang as $jk) : ?>

                                <?php if ($jk == $magang['jenis_kelamin_magang']) : ?>
                                    <option value="<?= $jk ?>" selected><?= $jk ?></option>
                                <?php else : ?>
                                    <option value="<?= $jk ?>"><?= $jk ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Agama</label>
                        <select name="agama_magang" id="agama_magang" class="form-control">
                            <?php foreach ($agama_magang as $ag) : ?>

                                <?php if ($ag == $magang['agama_magang']) : ?>
                                    <option value="<?= $ag ?>" selected><?= $ag ?></option>
                                <?php else : ?>
                                    <option value="<?= $ag ?>"><?= $ag ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('agama_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir_magang" id="pendidikan_terakhir_magang" class="form-control">
                            <?php foreach ($pendidikan_terakhir_magang as $row) : ?>

                                <?php if ($row == $magang['pendidikan_terakhir_magang']) : ?>
                                    <option value="<?= $row ?>" selected><?= $row ?></option>
                                <?php else : ?>
                                    <option value="<?= $row ?>"><?= $row ?></option>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('pendidikan_terakhir_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Alamat</label>
                        <input type="text" class="form-control" value="<?= $magang['alamat_magang']; ?>" id="alamat_magang" name="alamat_magang"  placeholder="Alamat Tinggal">
                        <small class="form-text text-danger"><?php echo form_error('alamat_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">RT</label>
                            <input type="text" class="form-control" value="<?= $magang['rt_magang']; ?>" id="rt_magang" name="rt_magang"  placeholder="RT">
                            <small class="form-text text-danger"><?php echo form_error('rt_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">RW</label>
                            <input type="text" class="form-control" value="<?= $magang['rw_magang']; ?>" id="rw_magang" name="rw_magang"  placeholder="RW">
                            <small class="form-text text-danger"><?php echo form_error('rw_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Kelurahan</label>
                            <input type="text" class="form-control" value="<?= $magang['kelurahan_magang']; ?>" id="kelurahan_magang" name="kelurahan_magang"  placeholder="Kelurahan">
                            <small class="form-text text-danger"><?php echo form_error('kelurahan_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Kecamatan</label>
                            <input type="text" class="form-control" value="<?= $magang['kecamatan_magang']; ?>" id="kecamatan_magang" name="kecamatan_magang"  placeholder="Kecamatan">
                            <small class="form-text text-danger"><?php echo form_error('kecamatan_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Kota</label>
                            <input type="text" class="form-control" value="<?= $magang['kota_magang']; ?>" id="kota_magang" name="kota_magang"  placeholder="Kota">
                            <small class="form-text text-danger"><?php echo form_error('kota_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Provinsi</label>
                            <input type="text" class="form-control" value="<?= $magang['provinsi_magang']; ?>" id="provinsi_magang" name="provinsi_magang"  placeholder="Provinsi">
                            <small class="form-text text-danger"><?php echo form_error('provinsi_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">Kode POS</label>
                            <input type="text" class="form-control" value="<?= $magang['kode_pos_magang']; ?>" id="kode_pos_magang" name="kode_pos_magang"  placeholder="Kode POS">
                            <small class="form-text text-danger"><?php echo form_error('kode_pos_magang'); ?></small>
                    </div>
                </div>

                <!-- Button Simpan Dan Cancel -->
                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
                <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('magang/magang'); ?>">CANCEL</a>

            </div>
        </div>

    </form>
</div>