<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>
    <form action="<?= base_url('magang/tambahmagang'); ?>" method="POST">

        <div class="card">
            <h5 class="card-header">Form Tambah Magang</h5>

            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Mulai</label>
                        <input type="text" value="<?= set_value('tanggal_masuk_magang'); ?>" id="tanggal_masuk_magang" name="tanggal_masuk_magang" readonly="readonly" placeholder="Tanggal Masuk ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_masuk_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Tanggal Selesai</label>
                        <input type="text" value="<?= set_value('tanggal_selesai_magang'); ?>" id="tanggal_selesai_magang" name="tanggal_selesai_magang" readonly="readonly" placeholder="Tanggal Selesai ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_selesai_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">NIK Magang</label>
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= set_value('nik_magang'); ?>" id="nik_magang" maxlength="16" name="nik_magang" placeholder="Masukan NIK KTP">
                        <small class="form-text text-danger"><?php echo form_error('nik_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nama</label>
                        <input type="text" onkeyup="huruf(this);" class="form-control" value="<?= set_value('nama_magang'); ?>" id="nama_magang" name="nama_magang" placeholder="Masukan Nama">
                        <small class="form-text text-danger"><?php echo form_error('nama_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="inputEmail4">Nomor Handphone</label>
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= set_value('nomor_handphone_magang'); ?>" id="nomor_handphone_magang" name="nomor_handphone_magang" placeholder="Masukan Nomor Handphone">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="selectpicker" data-width="100%" data-live-search="true" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatan as $row) : ?>
                                <option value="<?= $row['id']; ?>">
                                    <?= $row['jabatan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jabatan_id'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Penempatan</label>
                        <select name="penempatan_id" id="penempatan_id" class="selectpicker" data-width="100%" data-live-search="true" required>
                            <option value="">Pilih Penempatan</option>
                            <?php foreach ($penempatan as $pn) : ?>
                                <option value="<?= $pn['id']; ?>">
                                    <?= $pn['penempatan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('penempatan_id'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Tempat Lahir</label>
                        <input type="text" class="form-control" value="<?= set_value('tempat_lahir_magang'); ?>" id="tempat_lahir_magang" name="tempat_lahir_magang" placeholder="Masukan Tempat Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tempat_lahir_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Tanggal Lahir</label>
                        <input type="text" value="<?= set_value('tanggal_lahir_magang'); ?>" id="tanggal_lahir_magang" name="tanggal_lahir_magang" readonly="readonly" placeholder="Tanggal Lahir ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lahir_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Jenis Kelamin</label>
                        <select name="jenis_kelamin_magang" id="jenis_kelamin_magang" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                    <label for="inputEmail4">Agama</label>
                        <select name="agama_magang" id="agama_magang" class="form-control" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Kristen Katholik">Kristen Katholik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('agama_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                    <select name="pendidikan_terakhir_magang" id="pendidikan_terakhir_magang" class="form-control" required>
                            <option value="">Pilih Pendidikan Terakhir</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D1">D1</option>
                            <option value="D2">D2</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('pendidikan_terakhir_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('alamat_magang'); ?>" id="alamat_magang" name="alamat_magang" placeholder="Masukan Alamat">
                        <small class="form-text text-danger"><?php echo form_error('alamat_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('rt_magang'); ?>" id="rt_magang" name="rt_magang" placeholder="Masukan RT">
                        <small class="form-text text-danger"><?php echo form_error('rt_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('rw_magang'); ?>" id="rw_magang" name="rw_magang" placeholder="Masukan RW">
                        <small class="form-text text-danger"><?php echo form_error('rw_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('kelurahan_magang'); ?>" id="kelurahan_magang" name="kelurahan_magang" placeholder="Masukan Nama Kelurahan">
                        <small class="form-text text-danger"><?php echo form_error('kelurahan_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('kecamatan_magang'); ?>" id="kecamatan_magang" name="kecamatan_magang" placeholder="Masukan Nama Kecamatan">
                        <small class="form-text text-danger"><?php echo form_error('kecamatan_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('kota_magang'); ?>" id="kota_magang" name="kota_magang" placeholder="Masukan Nama Kota">
                        <small class="form-text text-danger"><?php echo form_error('kota_magang'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('provinsi_magang'); ?>" id="provinsi_magang" name="provinsi_magang" placeholder="Masukan Nama Provinsi">
                        <small class="form-text text-danger"><?php echo form_error('provinsi_magang'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" value="<?= set_value('kode_pos_magang'); ?>" id="kode_pos_magang" name="kode_pos_magang" placeholder="Masukan Kode POS">
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