<!-- Function untuk view modal pada sekolah -->
<script type="text/javascript">
    function viewdata($id_Sekolah, $nama_sekolah, $alamat_sekolah, $nomor_telepon_sekolah, $email_sekolah, $nama_guru_pembimbing, $nomor_handphone_guru_pembimbing) {
        $("#id_Sekolah").val($id_Sekolah);
        $("#nama_sekolah").val($nama_sekolah);
        $("#alamat_sekolah").val($alamat_sekolah);
        $("#nomor_telepon_sekolah").val($nomor_telepon_sekolah);
        $("#email_sekolah").val($email_sekolah);
        $("#nama_guru_pembimbing").val($nama_guru_pembimbing);
        $("#nomor_handphone_guru_pembimbing").val($nomor_handphone_guru_pembimbing);
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 ml-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <!-- Menampilkan Pesan Kesalahan -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="<?= base_url('sekolah/tambahsekolah'); ?>" class="btn btn-primary mb-2 ml-4"><i class="fas fa-plus"></i> Tambah Data Sekolah</a>

            <table id="table_id" class="table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Sekolah</th>
                        <th scope="col">Guru Pembimbing</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; ?>
                    <?php
                    foreach ($sekolah as $skl) : ?>
                        <?php
                        $alamat = $skl['alamat_sekolah'];
                        $dataalamat = explode(",", $alamat);
                        $dataalamatsekolah = $dataalamat[0];
                        $datartrwsekolah = $dataalamat[1];
                        $datakelurahansekolah = $dataalamat[2];
                        $datakecamatansekolah = $dataalamat[3];
                        $datakotasekolah = $dataalamat[4];
                        $datakodepos = $dataalamat[5];
                        $alamat_sekolah = $dataalamatsekolah . ',' . $datartrwsekolah . ',' . $datakelurahansekolah . ',' . $datakecamatansekolah . ',' . $datakotasekolah . ',' . $datakodepos;
                        ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= $skl['nama_sekolah']; ?></td>
                            <td><?= $skl['nama_guru_pembimbing']; ?></td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewSekolah" onclick="viewdata(
                                                '<?= $skl['id_sekolah']; ?>',
                                                '<?= $skl['nama_sekolah']; ?>',
                                                '<?= $alamat_sekolah; ?>',
                                                '<?= $skl['nomor_telepon_sekolah']; ?>',
                                                '<?= $skl['email_sekolah']; ?>',
                                                '<?= $skl['nama_guru_pembimbing']; ?>',
                                                '<?= $skl['nomor_handphone_guru_pembimbing']; ?>'
                                                )">
                                    <i class="fas fa-eye"></i> View</a>


                                <a href="<?= base_url(); ?>sekolah/editsekolah/<?= $skl['id_sekolah']; ?>" class="btn btn-success btn-sm "><i class="fas fa-pen"></i> Edit</a>
                                <a href="<?= base_url(); ?>sekolah/hapussekolah/<?= $skl['id_sekolah']; ?>" class="btn btn-danger btn-sm " onclick="return confirm('Apakah anda yakin akan menghapus data ini'); "><i class="fas fa-trash"></i> Delete</a>

                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Modal View Sekolah -->
<div class="modal fade" id="viewSekolah" tabindex="-1" role="dialog" aria-labelledby="viewSekolahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSekolahLabel">View Data Sekolah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('sekolah/sekolah'); ?>" method="post">
                <div class="modal-body border-bottom-danger">

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Nama Sekolah</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="nama_sekolah" name="nama_sekolah">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Alamat Sekolah</label>
                        <div class="col-sm-7">
                            <textarea style="resize:none;width:260px;height:90px;" readonly class="form-control-plaintext" id="alamat_sekolah">
                            <?= set_value('$alamat_sekolah'); ?>
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Nomor Telepon Sekolah</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="nomor_telepon_sekolah" name="nomor_telepon_sekolah">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Email Sekolah</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="email_sekolah" name="email_sekolah">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Nama Guru Pembimbing</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="nama_guru_pembimbing" name="nama_guru_pembimbing">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-5 col-form-label">Nomor Handphone</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" id="nomor_handphone_guru_pembimbing" name="nomor_handphone_guru_pembimbing">
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
<!-- End of Modal Add Jabatan -->