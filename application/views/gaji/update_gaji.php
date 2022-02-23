<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<?= form_open_multipart('gaji/hasilupdategajikaryawan'); ?>
	<div class="card">
		<h5 class="card-header">Form <?= $title; ?></h5>
		<div class="card-body">

			<div class="alert alert-info" role="alert">
				Silakan Masukan Nominal Gaji Yang Baru.
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Nama Karyawan</b></label>
					<select class="bootstrap-select" name="nik_karyawan[]" data-width="100%" data-live-search="true" multiple required>
						<?php foreach ($karyawan as $row) : ?>
							<option value="<?= $row['nik_karyawan']; ?>"><?= $row['nama_karyawan'] . "[ " . $row['jabatan'] . " ]" . " [ " . $row['penempatan'] . " ]"; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Gaji Pokok</b></label>
					<input type="text" class="form-control" name="gaji_pokok" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Gaji Pokok">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Uang Makan</b></label>
					<input type="text" class="form-control" name="uang_makan" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Uang Makan">
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Uang Transport</b></label>
					<input type="text" class="form-control" name="uang_transport" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Uang Transport">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Tunjangan Tugas</b></label>
					<input type="text" class="form-control" name="tunjangan_tugas" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Tunjangan Tugas">
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Tunjangan Pulsa</b></label>
					<input type="text" class="form-control" name="tunjangan_pulsa" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Tunjangan Pulsa">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>POTONGAN BPJS</b></label>
					<input class="form-control-input" name="jkn" type="checkbox" id="inlineCheckbox1" value="JKN">
					<label class="form-control-label" for="inlineCheckbox1"><b>JKN</b></label>
					<input class="form-control-input" name="jht" type="checkbox" id="inlineCheckbox1" value="JHT">
					<label class="form-control-label" for="inlineCheckbox1">JHT</label>
					<input class="form-control-input" name="jp" type="checkbox" id="inlineCheckbox1" value="JP">
					<label class="form-control-label" for="inlineCheckbox1">JP</label>
					<input class="form-control-input" name="jkk" type="checkbox" id="inlineCheckbox1" value="JKK">
					<label class="form-control-label" for="inlineCheckbox1">JKK</label>
					<input class="form-control-input" name="jkm" type="checkbox" id="inlineCheckbox1" value="JKM">
					<label class="form-control-label" for="inlineCheckbox1">JKM</label>
				</div>
			</div>

			<!-- Button Simpan Dan Cancel -->
			<button type="submit" class="btn btn-success btn-sm btn-lg btn-block">UPDATE</button>
			<a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('gaji/updategaji'); ?>">CANCEL</a>

		</div>
	</div>
	</form>
</div>
