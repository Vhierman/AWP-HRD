<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<?= form_open_multipart('gaji/hasileditrekongajikaryawan'); ?>
	<div class="card">
		<h5 class="card-header">Form <?= $title; ?></h5>
		<div class="card-body">

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Nama - Jabatan - Penempatan</b></label>
					<input type="hidden" class="form-control" readonly="readonly" value="<?= $editrekongaji['nik_karyawan'] ?>" name="nik_karyawan" maxlength="16" onkeyup="angka(this);" placeholder="Masukan Nama Karyawan">
					<input type="text" class="form-control" readonly="readonly" value="<?= $editrekongaji['nama_karyawan'] . '-' . $editrekongaji['jabatan'] . '-' . $editrekongaji['penempatan'] ?>" name="nama_karyawan" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Nama Karyawan">
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Gaji Pokok</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['gaji_pokok_history'] ?>" name="gaji_pokok" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Gaji Pokok">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Uang Makan</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['uang_makan_history'] ?>" name="uang_makan" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Uang Makan">
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Uang Transport</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['uang_transport_history'] ?>" name="uang_transport" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Uang Transport">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Tunjangan Tugas</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['tunjangan_tugas_history'] ?>" name="tunjangan_tugas" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Tunjangan Tugas">
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Tunjangan Pulsa</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['tunjangan_pulsa_history'] ?>" name="tunjangan_pulsa" maxlength="10" onkeyup="angka(this);" placeholder="Masukan Tunjangan Pulsa">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>POTONGAN BPJS</b></label>

					<!-- CHECKBOX BPJS KESEHATAN -->
					<?php if ($editrekongaji['potongan_bpjsks_perusahaan_history'] != "") :
						$check = "checked";
						echo "
						<input class='form-control-input' name='jkn' type='checkbox' id='inlineCheckbox1' value='JKN' checked>
						<label class='form-control-label' for='inlineCheckbox1'><b>JKN</b></label>
						";
					?>
					<?php else :
						$check = "";
						echo "
						<input class='form-control-input' name='jkn' type='checkbox' id='inlineCheckbox1' value='JKN'>
						<label class='form-control-label' for='inlineCheckbox1'><b>JKN</b></label>
						";
					?>
					<?php endif; ?>

					<!-- CHECKBOX BPJS KETENAGAKERJAAN JHT -->
					<?php if ($editrekongaji['potongan_jht_perusahaan_history'] != "") :
						$check = "checked";
						echo "
						<input class='form-control-input' name='jht' type='checkbox' id='inlineCheckbox1' value='JHT' checked>
						<label class='form-control-label' for='inlineCheckbox1'><b>JHT</b></label>
						";
					?>
					<?php else :
						$check = "";
						echo "
						<input class='form-control-input' name='jht' type='checkbox' id='inlineCheckbox1' value='JHT'>
						<label class='form-control-label' for='inlineCheckbox1'><b>JHT</b></label>
						";
					?>
					<?php endif; ?>

					<!-- CHECKBOX BPJS KETENAGAKERJAAN JP -->
					<?php if ($editrekongaji['potongan_jp_perusahaan_history'] != "") :
						$check = "checked";
						echo "
						<input class='form-control-input' name='jp' type='checkbox' id='inlineCheckbox1' value='JP' checked>
						<label class='form-control-label' for='inlineCheckbox1'><b>JP</b></label>
						";
					?>
					<?php else :
						$check = "";
						echo "
						<input class='form-control-input' name='jp' type='checkbox' id='inlineCheckbox1' value='JP'>
						<label class='form-control-label' for='inlineCheckbox1'><b>JP</b></label>
						";
					?>
					<?php endif; ?>

					<!-- CHECKBOX BPJS KETENAGAKERJAAN JKK -->
					<?php if ($editrekongaji['potongan_jkk_perusahaan_history'] != "") :
						$check = "checked";
						echo "
						<input class='form-control-input' name='jkk' type='checkbox' id='inlineCheckbox1' value='JKK' checked>
						<label class='form-control-label' for='inlineCheckbox1'><b>JKK</b></label>
						";
					?>
					<?php else :
						$check = "";
						echo "
						<input class='form-control-input' name='jkk' type='checkbox' id='inlineCheckbox1' value='JKK'>
						<label class='form-control-label' for='inlineCheckbox1'><b>JKK</b></label>
						";
					?>
					<?php endif; ?>

					<!-- CHECKBOX BPJS KETENAGAKERJAAN JKM -->
					<?php if ($editrekongaji['potongan_jkm_perusahaan_history'] != "") :
						$check = "checked";
						echo "
						<input class='form-control-input' name='jkm' type='checkbox' id='inlineCheckbox1' value='JKM' checked>
						<label class='form-control-label' for='inlineCheckbox1'><b>JKM</b></label>
						";
					?>
					<?php else :
						$check = "";
						echo "
						<input class='form-control-input' name='jkm' type='checkbox' id='inlineCheckbox1' value='JKM'>
						<label class='form-control-label' for='inlineCheckbox1'><b>JKM</b></label>
						";
					?>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Mulai Tanggal</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['periode_awal_gaji_history'] ?>" name="mulai_tanggal" maxlength="16" placeholder="YYYY-MM-DD" readonly="readonly">
				</div>
				<div class="form-group col-md-6">
					<label for="perusahaan_id" class="col-md-6 col-form-label"><b>Sampai Tanggal</b></label>
					<input type="text" class="form-control" value="<?= $editrekongaji['periode_akhir_gaji_history'] ?>" name="sampai_tanggal" maxlength="16" placeholder="YYYY-MM-DD" readonly="readonly">
				</div>
			</div>

			<!-- Button Simpan Dan Cancel -->
			<button type="submit" class="btn btn-success btn-sm btn-lg btn-block">UPDATE</button>
			<a class="btn btn-danger btn-lg btn-sm btn-block" href="<?= base_url('gaji/editrekongaji'); ?>">CANCEL</a>

		</div>
	</div>
	</form>
</div>
