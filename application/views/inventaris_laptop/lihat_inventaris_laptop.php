<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card mb-2" style="max-width: 1280px;">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="row no-gutters">
            <div class="col-md-4 mt-2">
                <img src="<?= base_url('assets/img/inventaris/laptop/') . $lihat['foto_laptop']; ?>" class="card-img" alt="Foto Laptop">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="form-group row mb-0">
                        <label for="nik_karyawan" class=" col-sm-4 form-label"><b>NIK Karyawan</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['nik_karyawan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="nama_karyawan" class=" col-sm-4 form-label"><b>Nama Karyawan</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['nama_karyawan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="penempatan" class=" col-sm-4 form-label"><b>Penempatan</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['penempatan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="merk_laptop" class=" col-sm-4 form-label"><b>Merk Laptop</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['merk_laptop'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="type_laptop" class=" col-sm-4 form-label"><b>Type Laptop</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['type_laptop'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="nik_karyawan" class=" col-sm-4 form-label"><b>NIK Karyawan</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['nik_karyawan'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="processor" class=" col-sm-4 form-label"><b>Processor</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['processor'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="ram" class=" col-sm-4 form-label"><b>RAM</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['ram'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="hardisk" class=" col-sm-4 form-label"><b>Hardisk</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['hardisk'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="vga" class=" col-sm-4 form-label"><b>VGA</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['vga'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="sistem_operasi" class=" col-sm-4 form-label"><b>Sistem Operasi</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $lihat['sistem_operasi'] ?>">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <label for="tanggal_penyerahan" class=" col-sm-4 form-label"><b>Tanggal Penyerahan</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $tanggalpenyerahan ?>">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Page Content -->
</div>