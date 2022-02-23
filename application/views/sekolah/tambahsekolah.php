<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>
    <form action="<?= base_url('sekolah/tambahsekolah'); ?>" method="POST">

        <div class="card">
            <h5 class="card-header">Form Tambah Sekolah</h5>

            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <input type="text" value="<?= set_value('nama_sekolah'); ?>" class="form-control" name="nama_sekolah" maxlength="50" id="nama_sekolah" placeholder="Masukan Nama Sekolah">
                        <small class="form-text text-danger"><?php echo form_error('nama_sekolah'); ?></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-6 col-form-label">Alamat Sekolah
                        <small id="emailHelp" class="form-text text-muted">--Diisi dengan ( Nama Jalan, Rt/Rw, Kelurahan, Kecamatan, Kabupaten/Kota, Kode POS )</small>
                    </label>
                    <div class="col-sm-6">
                        <textarea class="form-control" name="alamat_sekolah" id="alamat_sekolah"><?= set_value('alamat_sekolah'); ?></textarea>
                        <small class="form-text text-danger"><?php echo form_error('alamat_sekolah'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('nomor_telepon_sekolah'); ?>" class="form-control" name="nomor_telepon_sekolah" onkeyup="angka(this);" maxlength="50" id="nomor_telepon_sekolah" placeholder="Masukan Nomor Telepon Sekolah">
                        <small class="form-text text-danger"><?php echo form_error('nomor_telepon_sekolah'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('email_sekolah'); ?>" class="form-control" placeholder="Masukan Email Sekolah" name="email_sekolah" id="email_sekolah" maxlength="50">
                        <small class="form-text text-danger"><?php echo form_error('email_sekolah'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" onkeyup="huruf(this);" value="<?= set_value('nama_guru_pembimbing'); ?>" class="form-control" name="nama_guru_pembimbing" maxlength="50" id="nama_guru_pembimbing" placeholder="Masukan Nama Guru Pembimbing">
                        <small class="form-text text-danger"><?php echo form_error('nama_guru_pembimbing'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" onkeyup="angka(this);" value="<?= set_value('nomor_handphone_guru_pembimbing'); ?>" class="form-control" placeholder="Masukan Nomor Handphone Guru Pembimbing" name="nomor_handphone_guru_pembimbing" id="nomor_handphone_guru_pembimbing" maxlength="50">
                        <small class="form-text text-danger"><?php echo form_error('nomor_handphone_guru_pembimbing'); ?></small>
                    </div>
                </div>

                <!-- Button Simpan Dan Cancel -->
                <button type="submit" class="btn btn-primary btn-sm btn-lg btn-block">SIMPAN</button>
                <a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('sekolah/sekolah'); ?>">CANCEL</a>
            </div>
        </div>

    </form>
</div>