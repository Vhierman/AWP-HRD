<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>
    <form action="<?= base_url('absensi/tambahabsensi'); ?>" method="POST">
        <div class="card">
            <h5 class="card-header">Form Tambah Absensi</h5>
            <div class="card-body">

                <div class="alert alert-info" role="alert">
                    Silakan Masukan NIK Karyawan untuk mencari terlebih dahulu Nama Karyawan yang ingin diinputkan.
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" id="nik_karyawan" placeholder="Masukan NIK Karyawan">
                        <small class="form-text text-danger"><?php echo form_error('nik_karyawan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" placeholder="Nama Karyawan" name="nama_karyawan" maxlength="50" readonly='readonly'>
                        <small class="form-text text-danger"><?php echo form_error('nama_karyawan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="jabatan" readonly="readonly" placeholder="Jabatan">
                        <small class="form-text text-danger"><?php echo form_error('jabatan'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="penempatan" readonly='readonly' placeholder="Penempatan">
                        <small class="form-text text-danger"><?php echo form_error('penempatan'); ?></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('tanggal_absen'); ?>" class="form-control" name="tanggal_absen" id="tanggal_absen" readonly="readonly" placeholder="Tanggal Absen">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_absen'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('tanggal_selesai'); ?>" class="form-control" name="tanggal_selesai" id="tanggal_selesai" readonly='readonly' placeholder="Tanggal Selesai">
                        <small class="form-text text-danger"><?php echo form_error('tanggal_selesai'); ?></small>
                    </div>
                </div>

                <div class="form-group">
                    <select name="keterangan_absen" id="keterangan_absen" class="form-control" required>
                        <option value="">Keterangan Absen</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Ijin">Ijin</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Alpa">Alpa</option>
                        <option value="Telat">Telat</option>
                    </select>
                    <small class="form-text text-danger"><?php echo form_error('keterangan_absen'); ?></small>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" value="<?= set_value('keterangan'); ?>" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">
                        <small class="form-text text-danger"><?php echo form_error('keterangan'); ?></small>
                    </div>

                    <div class="form-group col-md-6">
                        <select name="jenis_cuti" id="jenis_cuti" class="form-control">
                            <option value="">Jenis Cuti</option>
                            <option value="Tahunan">Tahunan</option>
                            <option value="Khusus">Khusus</option>
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