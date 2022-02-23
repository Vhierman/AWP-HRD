<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>
    <form action="<?= base_url('siswa/tambahsiswa'); ?>" method="POST">

        <div class="card">
            <h5 class="card-header">Form Tambah Siswa</h5>

            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <select name="sekolah_id" id="sekolah_id" class="form-control" required>
                            <option value="">Pilih Sekolah</option>
                            <?php foreach ($sekolah as $sk) : ?>
                                <option value="<?= $sk['id_sekolah']; ?>">
                                    <?= $sk['nama_sekolah']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('sekolah_id'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="penempatan_id" id="penempatan_id" class="form-control" required>
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
                        <input type="text" value="<?= set_value('tanggal_masuk_pkl'); ?>" id="tanggal_masuk_pkl" name="tanggal_masuk_pkl" readonly="readonly" placeholder="Tanggal Masuk PKL ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_masuk_pkl'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('tanggal_selesai_pkl'); ?>" id="tanggal_selesai_pkl" name="tanggal_selesai_pkl" readonly="readonly" placeholder="Tanggal Selesai PKL ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_selesai_pkl'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= set_value('nis_siswa'); ?>" id="nis_siswa" name="nis_siswa" placeholder="Masukan NIS Siswa">
                        <small class="form-text text-danger"><?php echo form_error('nis_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" onkeyup="huruf(this);" class="form-control" value="<?= set_value('nama_siswa'); ?>" id="nama_siswa" name="nama_siswa" placeholder="Masukan Nama Siswa">
                        <small class="form-text text-danger"><?php echo form_error('nama_siswa'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('tempat_lahir_siswa'); ?>" id="tempat_lahir_siswa" name="tempat_lahir_siswa" placeholder="Masukan Tempat Lahir">
                        <small class="form-text text-danger"><?php echo form_error('tempat_lahir_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('tanggal_lahir_siswa'); ?>" id="tanggal_lahir_siswa" name="tanggal_lahir_siswa" readonly="readonly" placeholder="Tanggal Lahir ( yyyy-mm-dd )">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_lahir_siswa'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <select name="jenis_kelamin_siswa" id="jenis_kelamin_siswa" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('jenis_kelamin_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <select name="agama_siswa" id="agama_siswa" class="form-control" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Kristen Katholik">Kristen Katholik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                        </select>
                        <small class="form-text text-danger"><?php echo form_error('agama_siswa'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" onkeyup="angka(this);" class="form-control" value="<?= set_value('nomor_handphone_siswa'); ?>" id="nomor_handphone_siswa" name="nomor_handphone_siswa" placeholder="Masukan Nomor Handphone">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone_siswa'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="<?= set_value('jurusan'); ?>" id="jurusan" name="jurusan" placeholder="Masukan Jurusan">
                        <small class="form-text text-danger"><?php echo form_error('jurusan'); ?></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">Alamat
                        <small id="emailHelp" class="form-text text-muted">--Diisi dengan ( Nama Jalan, Rt/Rw, Kelurahan, Kecamatan, Kabupaten/Kota, Kode POS )</small>
                    </label>

                    <div class="col-sm-6">
                        <textarea class="form-control" name="alamat_siswa" id="alamat_siswa"><?= set_value('alamat_siswa'); ?></textarea>
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