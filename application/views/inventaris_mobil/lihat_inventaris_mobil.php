<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card mb-2">
        <h5 class="card-header">Form <?= $title; ?></h5>

        <div class="row no-gutters">
            <div class="form-group row">

                <div class="col-md-4 mt-3 ml-4 mb-3">
                    <img src="<?= base_url('assets/img/inventaris/mobil/stnk/') . $lihat['foto_stnk_mobil']; ?>" class="card-img" alt="Foto STNK Mobil">
                </div>

                <div class="col-sm-3 mt-3">
                    <input type="text" readonly class="form-control-plaintext" value="NIK Karyawan">
                    <input type="text" readonly class="form-control-plaintext" value="Nama Karyawan">
                    <input type="text" readonly class="form-control-plaintext" value="Jabatan">
                    <input type="text" readonly class="form-control-plaintext" value="Penempatan">
                    <input type="text" readonly class="form-control-plaintext" value="Merk Mobil">
                    <input type="text" readonly class="form-control-plaintext" value="Type Mobil">
                    <input type="text" readonly class="form-control-plaintext" value="Nomor Polisi">
                </div>

                <div class="col-sm-4 mt-3">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['nik_karyawan'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['nama_karyawan'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['jabatan'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['penempatan'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['merk_mobil'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['type_mobil'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['nomor_polisi'] ?>">
                </div>
            </div>
        </div>

        <div class="row no-gutters">
            <div class="form-group row">

                <div class="col-md-4 mt-3 ml-4 mb-3">
                    <img src="<?= base_url('assets/img/inventaris/mobil/mobil/') . $lihat['foto_mobil']; ?>" class="card-img" alt="Foto Mobil">
                </div>

                <div class="col-sm-3 mt-3">
                    <input type="text" readonly class="form-control-plaintext" value="Warna Mobil">
                    <input type="text" readonly class="form-control-plaintext" value="Nomor Rangka">
                    <input type="text" readonly class="form-control-plaintext" value="Nomor Mesin">
                    <input type="text" readonly class="form-control-plaintext" value="Tahun Pembuatan">
                    <input type="text" readonly class="form-control-plaintext" value="Tanggal Pajak">
                    <input type="text" readonly class="form-control-plaintext" value="Tanggal Plat">
                    <input type="text" readonly class="form-control-plaintext" value="Tanggal Penyerahan">
                </div>

                <div class="col-sm-4 mt-3">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['warna_mobil'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['nomor_rangka_mobil'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['nomor_mesin_mobil'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $lihat['tahun_pembuatan_mobil'] ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $tanggal_akhir_pajak_mobil; ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $tanggal_akhir_plat_mobil; ?>">
                    <input type="text" readonly class="form-control-plaintext" value="<?= $tanggal_penyerahan_mobil; ?>">
                </div>

            </div>
        </div>

    </div>
    <!-- End Page Content -->
</div>