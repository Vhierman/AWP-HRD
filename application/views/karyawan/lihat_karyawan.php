<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>

    <!-- Tab Lihat Data Karyawan -->

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="foto-tab" data-toggle="tab" href="#foto" role="tab" aria-controls="foto" aria-selected="false">Foto</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="divisi-tab" data-toggle="tab" href="#divisi" role="tab" aria-controls="divisi" aria-selected="true">Divisi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="karyawan-tab" data-toggle="tab" href="#karyawan" role="tab" aria-controls="karyawan" aria-selected="false">Karyawan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="alamat-tab" data-toggle="tab" href="#alamat" role="tab" aria-controls="alamat" aria-selected="false">Alamat</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="gaji-tab" data-toggle="tab" href="#gaji" role="tab" aria-controls="gaji" aria-selected="false">Rekening</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga" aria-selected="false">Keluarga</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="bpjs-tab" data-toggle="tab" href="#bpjs" role="tab" aria-controls="bpjs" aria-selected="false">BPJS</a>
        </li>
    </ul>
    <!-- End Tab Lihat Data Karyawan -->

    <div class="tab-content" id="myTabContent">

        <!-- Tab Foto -->
        <div class="tab-pane fade show active" id="foto" role="tabpanel" aria-labelledby="foto-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Foto</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/karyawan/') . $karyawan['foto_karyawan']; ?>" title="Foto Karyawan" class="img-thumbnail">
                        </div>

                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/ktp/') . $karyawan['foto_ktp']; ?>" title="Foto KTP" class="img-thumbnail">
                        </div>

                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/npwp/') . $karyawan['foto_npwp']; ?>" title="Foto NPWP" class="img-thumbnail">
                        </div>

                        <div class="form-group col-md-3">
                            <img src="<?= base_url('assets/img/karyawan/kk/') . $karyawan['foto_kk']; ?>" title="Foto KK" class="img-thumbnail">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Divisi -->
        <div class="tab-pane fade " id="divisi" role="tabpanel" aria-labelledby="divisi-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Form Divisi</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-group row">
                        <label for="perusahaan_id" class="col-sm-3 col-form-label"><b>Perusahaan</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['perusahaan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="penempatan_id" class="col-sm-3 col-form-label"><b>Penempatan</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['penempatan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jabatan_id" class="col-sm-3 col-form-label"><b>Jabatan</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['jabatan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jam_kerja_id" class="col-sm-3 col-form-label"><b>Jam Kerja</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= "( Jam Masuk " . $karyawan['jam_masuk'] . " )" . " s/d " . "( Jam Pulang " . $karyawan['jam_pulang'] . " )"; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status_kerja" class="col-sm-3 col-form-label"><b>Status Kerja</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['status_kerja'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggal_mulai_kerja" class="col-sm-3 col-form-label"><b>Tanggal Masuk Kerja</b></label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $tanggalmulaikerja ?>">
                        </div>
                    </div>
                    <?php if ($karyawan['tanggal_akhir_kerja'] == "0000-00-00") : ?>
                        <div class="form-group row">
                            <label for="tanggal_akhir_kerja" class="col-sm-3 col-form-label"><b>Tanggal Akhir Kerja</b></label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="00-00-0000">
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="form-group row">
                            <label for="tanggal_akhir_kerja" class="col-sm-3 col-form-label"><b>Tanggal Akhir Kerja</b></label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $tanggalakhirkerja ?>">
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Tab Karyawan -->
        <div class="tab-pane fade" id="karyawan" role="tabpanel" aria-labelledby="karyawan-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Form Karyawan</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-group row">
                        <label for="nik_karyawan" class="col-sm-3 col-form-label"><b>NIK Karyawan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nik_karyawan'] ?>">
                        </div>

                        <label for="nama_karyawan" class="col-sm-3 col-form-label"><b>Nama Karyawan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nama_karyawan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email_karyawan" class="col-sm-3 col-form-label"><b>Email Karyawan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['email_karyawan'] ?>">
                        </div>

                        <label for="nomor_absen" class="col-sm-3 col-form-label"><b>Nomor Absen</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_absen'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nomor_npwp" class="col-sm-3 col-form-label"><b>Nomor NPWP</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_npwp'] ?>">
                        </div>

                        <label for="tempat_lahir" class="col-sm-3 col-form-label"><b>Tempat Lahir</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['tempat_lahir'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="agama" class="col-sm-3 col-form-label"><b>Agama</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['agama'] ?>">
                        </div>

                        <label for="tanggal_lahir" class="col-sm-3 col-form-label"><b>Tanggal Lahir</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $tanggallahir ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jenis_kelamin" class="col-sm-3 col-form-label"><b>Jenis Kelamin</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['jenis_kelamin'] ?>">
                        </div>

                        <label for="pendidikan_terakhir" class="col-sm-3 col-form-label"><b>Pendidikan Terakhir</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['pendidikan_terakhir'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nomor_handphone" class="col-sm-3 col-form-label"><b>Nomor Handphone</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_handphone'] ?>">
                        </div>

                        <label for="golongan_darah" class="col-sm-3 col-form-label"><b>Golongan Darah</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['golongan_darah'] ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Alamat -->
        <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Form Alamat</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-group row">
                        <label for="provinsi" class="col-sm-3 col-form-label"><b>Provinsi</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['provinsi'] ?>">
                        </div>

                        <label for="kota" class="col-sm-3 col-form-label"><b>Kota</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['kota'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kecamatan" class="col-sm-3 col-form-label"><b>Kecamatan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['kecamatan'] ?>">
                        </div>

                        <label for="kelurahan" class="col-sm-3 col-form-label"><b>Kelurahan</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['kelurahan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kode_pos" class="col-sm-3 col-form-label"><b>Kode POS</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['kode_pos'] ?>">
                        </div>

                        <label for="alamat" class="col-sm-3 col-form-label"><b>Alamat</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['alamat'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="rt" class="col-sm-3 col-form-label"><b>RT</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['rt'] ?>">
                        </div>

                        <label for="rw" class="col-sm-3 col-form-label"><b>RW</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['rw'] ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Gaji -->
        <div class="tab-pane fade" id="gaji" role="tabpanel" aria-labelledby="gaji-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Form Gaji</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-group row">
                        <label for="nomor_rekening" class="col-sm-3 col-form-label"><b>Nomor Rekening</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_rekening'] ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab Keluarga -->
        <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Form Keluarga</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-group row">
                        <label for="nomor_kartu_keluarga" class="col-sm-3 col-form-label"><b>Nomor KK</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_kartu_keluarga'] ?>">
                        </div>

                        <label for="status_nikah" class="col-sm-3 col-form-label"><b>Status Nikah</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['status_nikah'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nama_ayah" class="col-sm-3 col-form-label"><b>Nama Ayah</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nama_ayah'] ?>">
                        </div>

                        <label for="nama_ibu" class="col-sm-3 col-form-label"><b>Nama Ibu</b></label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nama_ibu'] ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tab BPJS -->
        <div class="tab-pane fade" id="bpjs" role="tabpanel" aria-labelledby="bpjs-tab">
            <div class="card border-primary ">
                <h5 class="card-header text-white bg-primary">Form BPJS</h5>
                <div class="card-body border-bottom-primary">

                    <div class="form-group row">
                        <label for="nomor_jht" class="col-sm-2 col-form-label"><b>Nomor JHT</b></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_jht'] ?>">
                        </div>

                        <label for="nomor_jp" class="col-sm-2 col-form-label"><b>Nomor JP</b></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_jp'] ?>">
                        </div>

                        <label for="nomor_jkn" class="col-sm-2 col-form-label"><b>Nomor JKN</b></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $karyawan['nomor_jkn'] ?>">
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <a class="btn btn-danger btn-lg btn-sm btn-block mt-3" href="<?= base_url('karyawan/karyawan'); ?>">BACK</a>
</div>
<!-- /.container-fluid -->