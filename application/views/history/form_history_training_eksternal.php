<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Menampilkan Pesan Kesalahan -->
    <?= $this->session->flashdata('message'); ?>

    <div class="card">
        <h5 class="card-header">Form <?= $title; ?></h5>
        <div class="card-body">

            <a class="btn btn-success btn-lg btn-sm btn-block" href="<?= base_url('history/caritrainingeksternal'); ?>">CARI</a>
            <a class="btn btn-primary btn-lg btn-sm btn-block" href="<?= base_url('history/tambahtrainingeksternal'); ?>">TAMBAH</a>

        </div>
    </div>

</div>
</form>
</div>