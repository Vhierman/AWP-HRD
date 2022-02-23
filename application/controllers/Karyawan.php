<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Memanggil model karyawan
		$this->load->model('karyawan/Karyawan_model', 'karyawan');
		//Memanggil library validation
		$this->load->library('form_validation');
		//Memanggil library fpdf
		$this->load->library('pdf');
		//Memanggil Helper Login
		is_logged_in();
		//Memanggil Helper
		$this->load->helper('wpp');
	}

	//untuk mencari data karyawan berdasarkan NIK Karyawan Keluar
    public function get_datakaryawankeluarkaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan');
        $data = $this->karyawan->get_karyawan_bynik($nikkaryawan);
        echo json_encode($data);
    }

	//Menampilkan halaman awal data karyawan
	public function karyawan()
	{
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
		$data['title'] = 'Data Karyawan';
		//Menyimpan session dari login
		$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

		//Mengambil data karyawan, dari model, dengan di join dengan data penempatan, dan data jabatan
		$data['joinkaryawan'] = $this->karyawan->getJoinKaryawan();

		//menampilkan halaman data karyawan
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('karyawan/data_karyawan', $data);
		$this->load->view('templates/footer');
	}

	//Method Tambah Data Karyawan
	public function tambahkaryawan()
	{

		//Mengambil Session
		$role_id = $this->session->userdata("role_id");
		//Jika yang login Admin, Dan Staff HRD
		if ($role_id == 1 || $role_id == 11) {

			//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
			$data['title'] = 'Tambah Karyawan';
			//Menyimpan session dari login
			$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

			//Mengambil data karyawan, dari model, dengan di join dengan data penempatan, dan data jabatan
			$data['joinkaryawan'] = $this->karyawan->getJoinKaryawan();
			//Mengambil data perusahaan
			$data['perusahaan'] = $this->karyawan->getAllPerusahaan();
			//Mengambil data penempatan
			$data['penempatan'] = $this->karyawan->getAllPenempatan();
			//Mengambil data jabatan
			$data['jabatan'] = $this->karyawan->getAllJabatan();
			//Mengambil data jamkerja
			$data['jamkerja'] = $this->karyawan->getAllJamKerja();

			

			$this->curl->http_header('x-rapidapi-host','restcountries-v1.p.rapidapi.com');
			$this->curl->http_header('x-rapidapi-key','3e33277e62mshc9ce8b92dcfa9b2p13765djsn809b8f4d5bd8');
			$this->curl->create('https://restcountries-v1.p.rapidapi.com/all');
			$result 	= $this->curl->execute();
			//print_r($result)->exit();
			$data['negara']=json_decode($result);
			

			//Validation Form Input
			$this->form_validation->set_rules('perusahaan_id', 'Nama Perusahaan', 'required');
			$this->form_validation->set_rules('penempatan_id', 'Penempatan', 'required');
			$this->form_validation->set_rules('jabatan_id', 'Jabatan', 'required');
			$this->form_validation->set_rules('jam_kerja_id', 'Jam Kerja', 'required');
			$this->form_validation->set_rules('status_kerja', 'Status Kerja', 'required');
			$this->form_validation->set_rules('tanggal_mulai_kerja', 'Tanggal Mulai Kerja', 'required');
			$this->form_validation->set_rules('tanggal_akhir_kerja', 'Tanggal Akhir Kerja', 'required');
			$this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required|is_unique[karyawan.nik_karyawan]|min_length[16]');
			$this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required|trim');
			$this->form_validation->set_rules('email_karyawan', 'Alamat Email', 'valid_email|trim|is_unique[karyawan.email_karyawan]');
			$this->form_validation->set_rules('nomor_absen', 'Nomor Absen', 'required|min_length[4]');
			$this->form_validation->set_rules('nomor_npwp', 'Nomor NPWP', 'min_length[15]');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('agama', 'Agama', 'required');
			$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
			$this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan Terakhir', 'required');
			$this->form_validation->set_rules('nomor_handphone', 'Nomor Handphone', 'required');
			$this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
			$this->form_validation->set_rules('rt', 'RT', 'required|min_length[3]');
			$this->form_validation->set_rules('rw', 'RW', 'required|min_length[3]');
			$this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
			$this->form_validation->set_rules('kota', 'Kota', 'required');
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
			$this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
			$this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required');
			$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required');
			$this->form_validation->set_rules('gaji_pokok', 'Gaji Pokok', 'required');
			$this->form_validation->set_rules('uang_makan', 'Uang Makan', 'required');
			$this->form_validation->set_rules('uang_transport', 'Uang Transport', 'required');
			$this->form_validation->set_rules('nomor_kartu_keluarga', 'Nomor KK', 'required|min_length[16]');
			$this->form_validation->set_rules('status_nikah', 'Status Nikah', 'required');
			$this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required|trim|min_length[2]');
			$this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'required|trim|min_length[2]');
			$this->form_validation->set_rules('nomor_jht', 'Nomor Jaminan Hari Tua', 'min_length[11]');
			$this->form_validation->set_rules('nomor_jp', 'Nomor Jaminan Pensiun', 'min_length[11]');
			$this->form_validation->set_rules('nomor_jkn', 'Nomor Jaminan Kesehatan', 'min_length[13]');
			//Akhir Validation 

			//Jika form input ada yang salah
			if ($this->form_validation->run() == false) {
				//menampilkan halaman tambah data karyawan
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('karyawan/tambah_karyawan', $data);
				$this->load->view('templates/footer');
			}
			//Jika semua form input benar 
			else {
				//Memanggil model karyawan dengan method tambahKaryawan
				$this->karyawan->tambahKaryawan();
				//Memanggil model karyawan dengan method tambahMasterGaji
				$this->karyawan->tambahMasterGaji();
				//Memanggil model karyawan dengan method tambahHistoryKontrak
				$this->karyawan->tambahHistoryKontrak();
				//Memanggil model karyawan dengan method tambahHistoryJabatan
				$this->karyawan->tambahHistoryJabatan();

				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Karyawan</div>');
				//redirect ke halaman data karyawan
				redirect('karyawan/karyawan');
			}
		}
		//Jika Yang Login Bukan HRD
		else {
			$this->load->view('auth/blocked');
		}
	}

	//Method Edit Data Karyawan
	public function editkaryawan($id)
	{

		//Mengambil Session
		$role_id = $this->session->userdata("role_id");
		//Jika yang login Admin, Dan Staff HRD
		if ($role_id == 1 || $role_id == 11) {

			//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
			$data['title'] = 'Edit Karyawan';
			//Menyimpan session dari login
			$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

			//Mengambil data karyawan, dari model, dengan di join dengan data penempatan, dan data jabatan
			$data['joinkaryawan'] = $this->karyawan->getJoinKaryawan();
			//mengambil data karyawan berdasarkan id nya
			$data['joinkaryawanid'] = $this->karyawan->getJoinKaryawanByID($id);
			//Mengambil data perusahaan
			$data['perusahaan'] = $this->karyawan->getAllPerusahaan();
			//Mengambil data penempatan
			$data['penempatan'] = $this->karyawan->getAllPenempatan();
			//Mengambil data jabatan
			$data['jabatan'] = $this->karyawan->getAllJabatan();
			//Mengambil data jabatan
			$data['jamkerja'] = $this->karyawan->getAllJamKerja();

			//Select Option
			//untuk tipe datanya enum
			$data['jenis_kelamin'] = ['Pria', 'Wanita'];
			$data['jenis_kelamin_anak1'] = [
				'' => 'Pilih Jenis Kelamin Anak 1',
				'Pria' => 'Pria',
				'Wanita' => 'Wanita'
			];
			$data['jenis_kelamin_anak2'] = [
				'' => 'Pilih Jenis Kelamin Anak 2',
				'Pria' => 'Pria',
				'Wanita' => 'Wanita'
			];
			$data['jenis_kelamin_anak3'] = [
				'' => 'Pilih Jenis Kelamin Anak 3',
				'Pria' => 'Pria',
				'Wanita' => 'Wanita'
			];
			$data['agama'] = ['Islam', 'Kristen Protestan', 'Kristen Katholik', 'Hindu', 'Budha'];
			$data['pendidikan_terakhir'] = ['SD', 'SMP', 'SMA / SMK', 'D3', 'S1', 'S2', 'S3'];
			$data['golongan_darah'] = ['A', 'B', 'AB', 'O'];
			$data['status_kerja'] = ['PKWT', 'PKWTT', 'Outsourcing'];
			$data['status_nikah'] = ['Single', 'Menikah', 'Duda', 'Janda'];
			//

			//Validation Form EDIT
			$this->form_validation->set_rules('perusahaan_id', 'Nama Perusahaan', 'required');
			$this->form_validation->set_rules('penempatan_id', 'Penempatan', 'required');
			$this->form_validation->set_rules('jabatan_id', 'Jabatan', 'required');
			$this->form_validation->set_rules('jam_kerja_id', 'Jam Kerja', 'required');
			$this->form_validation->set_rules('status_kerja', 'Status Kerja', 'required');
			$this->form_validation->set_rules('tanggal_mulai_kerja', 'Tanggal Mulai Kerja', 'required');
			$this->form_validation->set_rules('tanggal_akhir_kerja', 'Tanggal Akhir Kerja', 'required');
			$this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required|min_length[16]');
			$this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required|trim');
			$this->form_validation->set_rules('email_karyawan', 'Alamat Email', 'valid_email|trim');
			$this->form_validation->set_rules('nomor_absen', 'Nomor Absen', 'required|min_length[4]');
			$this->form_validation->set_rules('nomor_npwp', 'Nomor NPWP', 'min_length[15]');
			$this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
			$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
			$this->form_validation->set_rules('agama', 'Agama', 'required');
			$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
			$this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan Terakhir', 'required');
			$this->form_validation->set_rules('nomor_handphone', 'Nomor Handphone', 'required');
			$this->form_validation->set_rules('golongan_darah', 'Golongan Darah', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
			$this->form_validation->set_rules('rt', 'RT', 'required|min_length[3]');
			$this->form_validation->set_rules('rw', 'RW', 'required|min_length[3]');
			$this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
			$this->form_validation->set_rules('kota', 'Kota', 'required');
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
			$this->form_validation->set_rules('kelurahan', 'Kelurahan', 'required');
			$this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required');
			$this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'required');
			$this->form_validation->set_rules('nomor_kartu_keluarga', 'Nomor KK', 'required|min_length[16]');
			$this->form_validation->set_rules('status_nikah', 'Status Nikah', 'required');
			$this->form_validation->set_rules('nama_ayah', 'Nama Ayah', 'required|trim|min_length[2]');
			$this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'required|trim|min_length[2]');
			$this->form_validation->set_rules('nomor_jht', 'Nomor Jaminan Hari Tua', 'min_length[11]');
			$this->form_validation->set_rules('nomor_jp', 'Nomor Jaminan Pensiun', 'min_length[11]');
			$this->form_validation->set_rules('nomor_jkn', 'Nomor Jaminan Kesehatan', 'min_length[13]');
			//Akhir Validation 

			//Jika form input ada yang salah
			if ($this->form_validation->run() == false) {
				//menampilkan halaman tambah data karyawan
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar', $data);
				$this->load->view('templates/topbar', $data);
				$this->load->view('karyawan/edit_karyawan', $data);
				$this->load->view('templates/footer');
			}
			//Jika semua form input benar 
			else {

				$upload_karyawan = $_FILES['foto_karyawan']['name'];
				$upload_ktp = $_FILES['foto_ktp']['name'];
				$upload_npwp = $_FILES['foto_npwp']['name'];
				$upload_kk = $_FILES['foto_kk']['name'];

				//Jika Semua Foto Di Edit
				if (!empty($upload_karyawan) && !empty($upload_ktp) && !empty($upload_npwp) && !empty($upload_kk)) {
					//Upload Foto Karyawan 
					//file yang diperbolehkan hanya png dan jpg
					$config['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$config['max_size'] = '500';
					//lokasi penyimpanan file
					$config['upload_path'] = './assets/img/karyawan/karyawan/';
					//memanggil library upload
					$this->load->library('upload', $config);
					//membedakan nama file jika ada yang sama
					$this->upload->initialize($config);
					//melakukan upload foto
					$this->upload->do_upload('foto_karyawan');
					//unlink foto lama
					$old_image_karyawan = $data['karyawan']['foto_karyawan'];
					if ($old_image_karyawan != 'default_karyawan.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
					}
					//mengganti nama foto yang ada di database
					$new_image = $this->upload->data('file_name');

					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_karyawan', $new_image);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto Karyawan


					//Upload Foto KTP
					//file yang diperbolehkan hanya png dan jpg
					$configktp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configktp['max_size'] = '500';
					//lokasi penyimpanan file
					$configktp['upload_path'] = './assets/img/karyawan/ktp/';
					//memanggil library upload
					$this->load->library('upload', $configktp);
					//melakukan inisial nama jika nama file sama
					$this->upload->initialize($configktp);
					//melakukan upload foto
					$this->upload->do_upload('foto_ktp');
					//foto default
					$old_image_ktp = $data['karyawan']['foto_ktp'];
					//unlink / hapus foto lama
					if ($old_image_ktp != 'default_ktp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
					}
					//menyimpan nama foto kedalam database
					$new_image_ktp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_ktp', $new_image_ktp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KTP


					//Upload Foto NPWP
					//file yang diperbolehkan hanya png dan jpg
					$confignpwp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$confignpwp['max_size'] = '500';
					//lokasi penyimpanan file
					$confignpwp['upload_path'] = './assets/img/karyawan/npwp/';
					//memanggil library upload
					$this->load->library('upload', $confignpwp);
					//melakukan inisial nama jika ada nama file yang sama
					$this->upload->initialize($confignpwp);
					//melakukan upload foto
					$this->upload->do_upload('foto_npwp');
					//foto default
					$old_image_npwp = $data['karyawan']['foto_npwp'];
					//unlink foto lama
					if ($old_image_npwp != 'default_npwp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
					}
					//menyimpan nama file kedalam database
					$new_image_npwp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_npwp', $new_image_npwp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto NPWP

					//Upload Foto KK
					//file yang diperbolehkan hanya png dan jpg
					$configkk['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configkk['max_size'] = '500';
					//lokasi penyimpanan file
					$configkk['upload_path'] = './assets/img/karyawan/kk/';
					//memanggil library upload
					$this->load->library('upload', $configkk);
					//melakukan inisial nama foto jika ada yang sama
					$this->upload->initialize($configkk);
					//melakukan upload foto
					$this->upload->do_upload('foto_kk');
					//foto default
					$old_image_kk = $data['karyawan']['foto_kk'];
					//unlink foto
					if ($old_image_kk != 'default_kk.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
					}
					//menyimpan nama file kedalam database
					$new_image_kk = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_kk', $new_image_kk);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KK

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto Karyawan Yang Di Edit
				elseif (!empty($upload_karyawan) && empty($upload_ktp) && empty($upload_npwp) && empty($upload_kk)) {
					//Upload Foto Karyawan 
					//file yang diperbolehkan hanya png dan jpg
					$config['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$config['max_size'] = '500';
					//lokasi penyimpanan file
					$config['upload_path'] = './assets/img/karyawan/karyawan/';
					//memanggil library upload
					$this->load->library('upload', $config);
					//membedakan nama file jika ada yang sama
					$this->upload->initialize($config);
					//melakukan upload foto
					$this->upload->do_upload('foto_karyawan');
					//unlink foto lama
					$old_image_karyawan = $data['karyawan']['foto_karyawan'];
					if ($old_image_karyawan != 'default_karyawan.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
					}
					//mengganti nama foto yang ada di database
					$new_image = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_karyawan', $new_image);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto Karyawan

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto KTP Yang Di Edit
				else if (!empty($upload_ktp) && empty($upload_karyawan) && empty($upload_npwp) && empty($upload_kk)) {

					//Upload Foto KTP
					//file yang diperbolehkan hanya png dan jpg
					$configktp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configktp['max_size'] = '500';
					//lokasi penyimpanan file
					$configktp['upload_path'] = './assets/img/karyawan/ktp/';
					//memanggil library upload
					$this->load->library('upload', $configktp);
					//melakukan inisial nama jika nama file sama
					$this->upload->initialize($configktp);
					//melakukan upload foto
					$this->upload->do_upload('foto_ktp');
					//foto default
					$old_image_ktp = $data['karyawan']['foto_ktp'];
					//unlink / hapus foto lama
					if ($old_image_ktp != 'default_ktp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
					}
					//menyimpan nama foto kedalam database
					$new_image_ktp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_ktp', $new_image_ktp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KTP

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto NPWP Yang Di Edit
				else if (empty($upload_karyawan) && empty($upload_ktp) && !empty($upload_npwp) && empty($upload_kk)) {

					//Upload Foto NPWP
					//file yang diperbolehkan hanya png dan jpg
					$confignpwp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$confignpwp['max_size'] = '500';
					//lokasi penyimpanan file
					$confignpwp['upload_path'] = './assets/img/karyawan/npwp/';
					//memanggil library upload
					$this->load->library('upload', $confignpwp);
					//melakukan inisial nama jika ada nama file yang sama
					$this->upload->initialize($confignpwp);
					//melakukan upload foto
					$this->upload->do_upload('foto_npwp');
					//foto default
					$old_image_npwp = $data['karyawan']['foto_npwp'];
					//unlink foto lama
					if ($old_image_npwp != 'default_npwp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
					}
					//menyimpan nama file kedalam database
					$new_image_npwp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_npwp', $new_image_npwp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto NPWP

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto KK Yang Di Edit
				else if (empty($upload_karyawan) && empty($upload_ktp) && empty($upload_npwp) && !empty($upload_kk)) {

					//Upload Foto KK
					//file yang diperbolehkan hanya png dan jpg
					$configkk['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configkk['max_size'] = '500';
					//lokasi penyimpanan file
					$configkk['upload_path'] = './assets/img/karyawan/kk/';
					//memanggil library upload
					$this->load->library('upload', $configkk);
					//melakukan inisial nama foto jika ada yang sama
					$this->upload->initialize($configkk);
					//melakukan upload foto
					$this->upload->do_upload('foto_kk');
					//foto default
					$old_image_kk = $data['karyawan']['foto_kk'];
					//unlink foto
					if ($old_image_kk != 'default_kk.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
					}
					//menyimpan nama file kedalam database
					$new_image_kk = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_kk', $new_image_kk);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KK

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto Karyawan Dan Foto KTP Yang Di Edit
				else if (!empty($upload_karyawan) && !empty($upload_ktp) && empty($upload_npwp) && empty($upload_kk)) {
					//Upload Foto Karyawan 
					//file yang diperbolehkan hanya png dan jpg
					$config['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$config['max_size'] = '500';
					//lokasi penyimpanan file
					$config['upload_path'] = './assets/img/karyawan/karyawan/';
					//memanggil library upload
					$this->load->library('upload', $config);
					//membedakan nama file jika ada yang sama
					$this->upload->initialize($config);
					//melakukan upload foto
					$this->upload->do_upload('foto_karyawan');
					//unlink foto lama
					$old_image_karyawan = $data['karyawan']['foto_karyawan'];
					if ($old_image_karyawan != 'default_karyawan.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
					}
					//mengganti nama foto yang ada di database
					$new_image = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_karyawan', $new_image);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto Karyawan


					//Upload Foto KTP
					//file yang diperbolehkan hanya png dan jpg
					$configktp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configktp['max_size'] = '500';
					//lokasi penyimpanan file
					$configktp['upload_path'] = './assets/img/karyawan/ktp/';
					//memanggil library upload
					$this->load->library('upload', $configktp);
					//melakukan inisial nama jika nama file sama
					$this->upload->initialize($configktp);
					//melakukan upload foto
					$this->upload->do_upload('foto_ktp');
					//foto default
					$old_image_ktp = $data['karyawan']['foto_ktp'];
					//unlink / hapus foto lama
					if ($old_image_ktp != 'default_ktp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
					}
					//menyimpan nama foto kedalam database
					$new_image_ktp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_ktp', $new_image_ktp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KTP

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto NPWP Dan Foto KK Yang Di Edit
				else if (empty($upload_karyawan) && empty($upload_ktp) && !empty($upload_npwp) && !empty($upload_kk)) {

					//Upload Foto NPWP
					//file yang diperbolehkan hanya png dan jpg
					$confignpwp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$confignpwp['max_size'] = '500';
					//lokasi penyimpanan file
					$confignpwp['upload_path'] = './assets/img/karyawan/npwp/';
					//memanggil library upload
					$this->load->library('upload', $confignpwp);
					//melakukan inisial nama jika ada nama file yang sama
					$this->upload->initialize($confignpwp);
					//melakukan upload foto
					$this->upload->do_upload('foto_npwp');
					//foto default
					$old_image_npwp = $data['karyawan']['foto_npwp'];
					//unlink foto lama
					if ($old_image_npwp != 'default_npwp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
					}
					//menyimpan nama file kedalam database
					$new_image_npwp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_npwp', $new_image_npwp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto NPWP

					//Upload Foto KK
					//file yang diperbolehkan hanya png dan jpg
					$configkk['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configkk['max_size'] = '500';
					//lokasi penyimpanan file
					$configkk['upload_path'] = './assets/img/karyawan/kk/';
					//memanggil library upload
					$this->load->library('upload', $configkk);
					//melakukan inisial nama foto jika ada yang sama
					$this->upload->initialize($configkk);
					//melakukan upload foto
					$this->upload->do_upload('foto_kk');
					//foto default
					$old_image_kk = $data['karyawan']['foto_kk'];
					//unlink foto
					if ($old_image_kk != 'default_kk.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
					}
					//menyimpan nama file kedalam database
					$new_image_kk = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_kk', $new_image_kk);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KK

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto Karyawan Dan Foto NPWP Yang Di Edit
				else if (!empty($upload_karyawan) && empty($upload_ktp) && !empty($upload_npwp) && empty($upload_kk)) {
					//Upload Foto Karyawan 
					//file yang diperbolehkan hanya png dan jpg
					$config['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$config['max_size'] = '500';
					//lokasi penyimpanan file
					$config['upload_path'] = './assets/img/karyawan/karyawan/';
					//memanggil library upload
					$this->load->library('upload', $config);
					//membedakan nama file jika ada yang sama
					$this->upload->initialize($config);
					//melakukan upload foto
					$this->upload->do_upload('foto_karyawan');
					//unlink foto lama
					$old_image_karyawan = $data['karyawan']['foto_karyawan'];
					if ($old_image_karyawan != 'default_karyawan.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
					}
					//mengganti nama foto yang ada di database
					$new_image = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_karyawan', $new_image);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto Karyawan

					//Upload Foto NPWP
					//file yang diperbolehkan hanya png dan jpg
					$confignpwp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$confignpwp['max_size'] = '500';
					//lokasi penyimpanan file
					$confignpwp['upload_path'] = './assets/img/karyawan/npwp/';
					//memanggil library upload
					$this->load->library('upload', $confignpwp);
					//melakukan inisial nama jika ada nama file yang sama
					$this->upload->initialize($confignpwp);
					//melakukan upload foto
					$this->upload->do_upload('foto_npwp');
					//foto default
					$old_image_npwp = $data['karyawan']['foto_npwp'];
					//unlink foto lama
					if ($old_image_npwp != 'default_npwp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
					}
					//menyimpan nama file kedalam database
					$new_image_npwp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_npwp', $new_image_npwp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto NPWP

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto KTP Dan Foto KK Yang Di Edit
				else if (empty($upload_karyawan) && !empty($upload_ktp) && empty($upload_npwp) && !empty($upload_kk)) {

					//Upload Foto KTP
					//file yang diperbolehkan hanya png dan jpg
					$configktp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configktp['max_size'] = '500';
					//lokasi penyimpanan file
					$configktp['upload_path'] = './assets/img/karyawan/ktp/';
					//memanggil library upload
					$this->load->library('upload', $configktp);
					//melakukan inisial nama jika nama file sama
					$this->upload->initialize($configktp);
					//melakukan upload foto
					$this->upload->do_upload('foto_ktp');
					//foto default
					$old_image_ktp = $data['karyawan']['foto_ktp'];
					//unlink / hapus foto lama
					if ($old_image_ktp != 'default_ktp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
					}
					//menyimpan nama foto kedalam database
					$new_image_ktp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_ktp', $new_image_ktp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KTP

					//Upload Foto KK
					//file yang diperbolehkan hanya png dan jpg
					$configkk['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configkk['max_size'] = '500';
					//lokasi penyimpanan file
					$configkk['upload_path'] = './assets/img/karyawan/kk/';
					//memanggil library upload
					$this->load->library('upload', $configkk);
					//melakukan inisial nama foto jika ada yang sama
					$this->upload->initialize($configkk);
					//melakukan upload foto
					$this->upload->do_upload('foto_kk');
					//foto default
					$old_image_kk = $data['karyawan']['foto_kk'];
					//unlink foto
					if ($old_image_kk != 'default_kk.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
					}
					//menyimpan nama file kedalam database
					$new_image_kk = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_kk', $new_image_kk);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KK

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto Karyawan Dan Foto KK Yang Di Edit
				else if (!empty($upload_karyawan) && empty($upload_ktp) && empty($upload_npwp) && !empty($upload_kk)) {
					//Upload Foto Karyawan 
					//file yang diperbolehkan hanya png dan jpg
					$config['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$config['max_size'] = '500';
					//lokasi penyimpanan file
					$config['upload_path'] = './assets/img/karyawan/karyawan/';
					//memanggil library upload
					$this->load->library('upload', $config);
					//membedakan nama file jika ada yang sama
					$this->upload->initialize($config);
					//melakukan upload foto
					$this->upload->do_upload('foto_karyawan');
					//unlink foto lama
					$old_image_karyawan = $data['karyawan']['foto_karyawan'];
					if ($old_image_karyawan != 'default_karyawan.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
					}
					//mengganti nama foto yang ada di database
					$new_image = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_karyawan', $new_image);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto Karyawan

					//Upload Foto KK
					//file yang diperbolehkan hanya png dan jpg
					$configkk['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configkk['max_size'] = '500';
					//lokasi penyimpanan file
					$configkk['upload_path'] = './assets/img/karyawan/kk/';
					//memanggil library upload
					$this->load->library('upload', $configkk);
					//melakukan inisial nama foto jika ada yang sama
					$this->upload->initialize($configkk);
					//melakukan upload foto
					$this->upload->do_upload('foto_kk');
					//foto default
					$old_image_kk = $data['karyawan']['foto_kk'];
					//unlink foto
					if ($old_image_kk != 'default_kk.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
					}
					//menyimpan nama file kedalam database
					$new_image_kk = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_kk', $new_image_kk);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KK

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Foto KTP Dan Foto NPWP Yang Di Edit
				else if (empty($upload_karyawan) && !empty($upload_ktp) && !empty($upload_npwp) && empty($upload_kk)) {

					//Upload Foto KTP
					//file yang diperbolehkan hanya png dan jpg
					$configktp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$configktp['max_size'] = '500';
					//lokasi penyimpanan file
					$configktp['upload_path'] = './assets/img/karyawan/ktp/';
					//memanggil library upload
					$this->load->library('upload', $configktp);
					//melakukan inisial nama jika nama file sama
					$this->upload->initialize($configktp);
					//melakukan upload foto
					$this->upload->do_upload('foto_ktp');
					//foto default
					$old_image_ktp = $data['karyawan']['foto_ktp'];
					//unlink / hapus foto lama
					if ($old_image_ktp != 'default_ktp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
					}
					//menyimpan nama foto kedalam database
					$new_image_ktp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_ktp', $new_image_ktp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto KTP


					//Upload Foto NPWP
					//file yang diperbolehkan hanya png dan jpg
					$confignpwp['allowed_types'] = 'jpg|png';
					//max file 1 mb
					$confignpwp['max_size'] = '500';
					//lokasi penyimpanan file
					$confignpwp['upload_path'] = './assets/img/karyawan/npwp/';
					//memanggil library upload
					$this->load->library('upload', $confignpwp);
					//melakukan inisial nama jika ada nama file yang sama
					$this->upload->initialize($confignpwp);
					//melakukan upload foto
					$this->upload->do_upload('foto_npwp');
					//foto default
					$old_image_npwp = $data['karyawan']['foto_npwp'];
					//unlink foto lama
					if ($old_image_npwp != 'default_npwp.jpg') {
						unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
					}
					//menyimpan nama file kedalam database
					$new_image_npwp = $this->upload->data('file_name');
					//mencari berdasarkan id karyawan
					$idkaryawan =  $this->input->post('id');
					$this->db->set('foto_npwp', $new_image_npwp);
					$this->db->where('id_karyawan', $idkaryawan);
					$this->db->update('karyawan');
					//end Upload Foto NPWP

					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
				//Jika Semua Foto Tidak Ada Yang Di Edit
				else {
					//Memanggil model karyawan dengan method tambahKaryawan
					$this->karyawan->editKaryawan();
					//Menampilkan pesan berhasil
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan</div>');
					//redirect ke halaman data karyawan
					redirect('karyawan/karyawan');
				}
			}
		}
		//Jika Yang Login Bukan HRD
		else {
			$this->load->view('auth/blocked');
		}
	}

	//Method Hapus Data Karyawan
	public function hapuskaryawan($id)
	{

		//Mengambil Session
		$role_id = $this->session->userdata("role_id");
		//Jika yang login Admin, Dan Staff HRD
		if ($role_id == 1 || $role_id == 11) {

			//mengambil data karyawan berdasarkan id nya
			$data['karyawan'] = $this->karyawan->getJoinKaryawanByID($id);

			//foto lama karyawan
			$old_image_karyawan = $data['karyawan']['foto_karyawan'];
			$old_image_ktp = $data['karyawan']['foto_ktp'];
			$old_image_npwp = $data['karyawan']['foto_npwp'];
			$old_image_kk = $data['karyawan']['foto_kk'];
			//unlink foto lama
			if ($old_image_karyawan != 'default_karyawan.jpg') {
				unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
			}
			if ($old_image_ktp != 'default_ktp.jpg') {
				unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
			}
			if ($old_image_npwp != 'default_npwp.jpg') {
				unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
			}
			if ($old_image_kk != 'default_kk.jpg') {
				unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
			}

			//mendelete kedalam database melalui method pada model perusahaan berdasarkan id nya
			$this->karyawan->hapusKaryawan($id);

			//mendelete kedalam database melalui method hapusAbsenKaryawan berdasarkan nik karyawan nya
			$this->karyawan->hapusAbsenKaryawan($id);

			//mendelete kedalam database melalui method hapusInventarisKaryawan berdasarkan nik karyawan nya
			$this->karyawan->hapusInventarisKaryawan($id);

			//mendelete kedalam database melalui method hapus History Kontrak berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryKontrak($id);

			//mendelete kedalam database melalui method hapus History Jabatan berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryJabatan($id);

			//mendelete kedalam database melalui method hapus History Keluarga berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryKeluarga($id);

			//mendelete kedalam database melalui method hapus History Pendidikan Formal berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryPendidikanFormal($id);

			//mendelete kedalam database melalui method hapus History Pendidikan NOn Formal berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryPendidikanNonFormal($id);

			//mendelete kedalam database melalui method hapus History Training Internal berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryTrainingInternal($id);

			//mendelete kedalam database melalui method hapus History Training Eksternal berdasarkan nik karyawan nya
			$this->keluar->hapusHistoryTrainingEksternal($id);

			//menampikan pesan sukses
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Karyawan</div>');
			//dan mendirect kehalaman perusahaan
			redirect('karyawan/karyawan');
		}
		//Jika Yang Login Bukan HRD
		else {
			$this->load->view('auth/blocked');
		}
	}

	//Menampilkan halaman lihat data karyawan
	public function lihatkaryawan($id)
	{
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
		$data['title'] = 'Lihat Data Karyawan';
		//Menyimpan session dari login
		$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

		//Mengambil data karyawan, dari model, dengan di join dari berbagai table
		$data['karyawan'] = $this->karyawan->getJoinKaryawanByID($id);

		//Fungsi untuk merubah format tanggal dari ( yyyy-mm-dd ) menjadi ( dd-mm-yyyy )
		$datatanggal = $this->karyawan->getJoinKaryawanByID($id);
		//membuat variabel tanggal untuk dipanggil di view ()
		$data['tanggallahir']               = date('d-m-Y', strtotime($datatanggal['tanggal_lahir']));
		$data['tanggalmulaikerja']          = date('d-m-Y', strtotime($datatanggal['tanggal_mulai_kerja']));
		$data['tanggalakhirkerja']          = date('d-m-Y', strtotime($datatanggal['tanggal_akhir_kerja']));
		$data['tanggallahiristrisuami']     = date('d-m-Y', strtotime($datatanggal['tanggal_lahir_istri_suami']));
		$data['tanggallahiranak1']          = date('d-m-Y', strtotime($datatanggal['tanggal_lahir_anak1']));
		$data['tanggallahiranak2']          = date('d-m-Y', strtotime($datatanggal['tanggal_lahir_anak2']));
		$data['tanggallahiranak3']          = date('d-m-Y', strtotime($datatanggal['tanggal_lahir_anak3']));

		//Mengambil data perusahaan
		$data['perusahaan'] = $this->karyawan->getAllPerusahaan();
		//Mengambil data penempatan
		$data['penempatan'] = $this->karyawan->getAllPenempatan();
		//Mengambil data jabatan
		$data['jabatan'] = $this->karyawan->getAllJabatan();
		//Mengambil data jam kerja
		$data['jamkerja'] = $this->karyawan->getAllJamKerja();

		//Select Option
		//untuk tipe datanya enum
		$data['jenis_kelamin'] = ['Pria', 'Wanita'];
		$data['jenis_kelamin_anak1'] = [
			'' => 'Pilih Jenis Kelamin Anak 1',
			'Pria' => 'Pria',
			'Wanita' => 'Wanita'
		];
		$data['jenis_kelamin_anak2'] = [
			'' => 'Pilih Jenis Kelamin Anak 2',
			'Pria' => 'Pria',
			'Wanita' => 'Wanita'
		];
		$data['jenis_kelamin_anak3'] = [
			'' => 'Pilih Jenis Kelamin Anak 3',
			'Pria' => 'Pria',
			'Wanita' => 'Wanita'
		];
		$data['agama'] = ['Islam', 'Kristen Protestan', 'Kristen Katholik', 'Hindu', 'Budha'];
		$data['pendidikan_terakhir'] = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];
		$data['golongan_darah'] = ['A', 'B', 'AB', 'O'];
		$data['status_kerja'] = ['Kontrak', 'Tetap'];
		$data['status_nikah'] = ['Single', 'Menikah', 'Duda', 'Janda'];

		//menampilkan halaman data karyawan
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('karyawan/lihat_karyawan', $data);
		$this->load->view('templates/footer');
	}

	//Method untuk membuat load Download Data Karyawan
	public function downloaddatakaryawan()
	{
		//Mengambil Session
		$role_id = $this->session->userdata("role_id");
		//Jika yang login Admin, Manager HRD, Supervisor HRD ,Dan Staff HRD
		if ($role_id == 1 || $role_id == 11 || $role_id == 9 || $role_id == 10 || $role_id == 17 || $role_id == 18) {

			//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
			$data['title'] = 'Download Data Karyawan';
			//Menyimpan session dari login
			$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

			//menampilkan halaman data karyawan
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('karyawan/download_data_karyawan', $data);
			$this->load->view('templates/footer');
		}
		//Jika Yang Login Bukan HRD
		else {
			$this->load->view('auth/blocked');
		}
	}


	//Method untuk membuat Download Data Karyawan
	public function export($id)
	{

		//Mengambil Session
		$role_id = $this->session->userdata("role_id");
		//Jika yang login Admin, Manager HRD, Supervisor HRD ,Dan Staff HRD
		if ($role_id == 1 || $role_id == 11 || $role_id == 9 || $role_id == 10 || $role_id == 17 || $role_id == 18) {

			// Load plugin PHPExcel nya
			include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

			// Panggil class PHPExcel nya
			$excel = new PHPExcel();

			// Settingan Description awal file excel
			$excel->getProperties()->setCreator('Vhierman Sach')
				->setLastModifiedBy('Vhierman Sach')
				->setTitle("Database Karyawan")
				->setSubject("Karyawan")
				->setDescription("Laporan Semua Data Karyawan")
				->setKeywords("Data Karyawan");

			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
			$style_col = array(
				'font' => array('bold' => true), // Set font nya jadi bold
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);

			// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATABASE KARYAWAN PT PRIMA KOMPONEN INDONESIA"); // Set kolom A1 dengan tulisan "DATABASE KARYAWAN PT PRIMA KOMPONEN INDONESIA"

			$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			// Buat header juudl tabel nya pada baris ke 3
			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "PERUSAHAAN"); // Set kolom B3 dengan tulisan PERUSAHAAN
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "PENEMPATAN"); // Set kolom C3 dengan tulisan PENEMPATAN
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "JABATAN"); // Set kolom D3 dengan tulisan JABATAN
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "JAM KERJA"); // Set kolom D3 dengan tulisan JAM KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('F3', "NIK KARYAWAN"); // Set kolom E3 dengan tulisan NIK KARYAWAN
			$excel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA KARYAWAN"); // Set kolom F3 dengan tulisan NAMA KARYAWAN
			$excel->setActiveSheetIndex(0)->setCellValue('H3', "EMAIL KARYAWAN"); // Set kolom G3 dengan tulisan EMAIL KARYAWAN
			$excel->setActiveSheetIndex(0)->setCellValue('I3', "NOMOR ABSEN"); // Set kolom H3 dengan tulisan NOMOR ABSEN
			$excel->setActiveSheetIndex(0)->setCellValue('J3', "NOMOR NPWP"); // Set kolom I3 dengan tulisan NOMOR NPWP
			$excel->setActiveSheetIndex(0)->setCellValue('K3', "TEMPAT LAHIR"); // Set kolom J3 dengan tulisan TEMPAT LAHIR
			$excel->setActiveSheetIndex(0)->setCellValue('L3', "TANGGAL LAHIR"); // Set kolom K3 dengan tulisan TANGGAL LAHIR
			$excel->setActiveSheetIndex(0)->setCellValue('M3', "AGAMA"); // Set kolom L3 dengan tulisan AGAMA
			$excel->setActiveSheetIndex(0)->setCellValue('N3', "JENIS KELAMIN"); // Set kolom M3 dengan tulisan JENIS KELAMIN
			$excel->setActiveSheetIndex(0)->setCellValue('O3', "PENDIDIKAN TERAKHIR"); // Set kolom N3 dengan tulisan PENDIDIKAN TERAKHIR
			$excel->setActiveSheetIndex(0)->setCellValue('P3', "NOMOR HANDPHONE"); // Set kolom O3 dengan tulisan NOMOR HANDPHONE
			$excel->setActiveSheetIndex(0)->setCellValue('Q3', "GOLONGAN DARAH"); // Set kolom P3 dengan tulisan GOLONGAN DARAH
			$excel->setActiveSheetIndex(0)->setCellValue('R3', "PROVINSI"); // Set kolom Q3 dengan tulisan PROVINSI
			$excel->setActiveSheetIndex(0)->setCellValue('S3', "KOTA / KABUPATEN"); // Set kolom R3 dengan tulisan KOTA / KABUPATEN
			$excel->setActiveSheetIndex(0)->setCellValue('T3', "KECAMATAN"); // Set kolom S3 dengan tulisan KECAMATAN
			$excel->setActiveSheetIndex(0)->setCellValue('U3', "KELURAHAN"); // Set kolom T3 dengan tulisan KELURAHAN
			$excel->setActiveSheetIndex(0)->setCellValue('V3', "KODE POS"); // Set kolom U3 dengan tulisan KODE POS
			$excel->setActiveSheetIndex(0)->setCellValue('W3', "ALAMAT"); // Set kolom V3 dengan tulisan ALAMAT
			$excel->setActiveSheetIndex(0)->setCellValue('X3', "RT"); // Set kolom W3 dengan tulisan RT
			$excel->setActiveSheetIndex(0)->setCellValue('Y3', "RW"); // Set kolom X3 dengan tulisan RW
			$excel->setActiveSheetIndex(0)->setCellValue('Z3', "NOMOR REKENING"); // Set kolom Y3 dengan tulisan NOMOR REKENING
			$excel->setActiveSheetIndex(0)->setCellValue('AA3', "TANGGAL MULAI KERJA"); // Set kolom AK3 dengan tulisan TANGGAL MULAI KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('AB3', "TANGGAL AKHIR KERJA"); // Set kolom AL3 dengan tulisan TANGGAL AKHIR KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('AC3', "STATUS KERJA"); // Set kolom AM3 dengan tulisan STATUS KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('AD3', "NOMOR JKN"); // Set kolom AN3 dengan tulisan NOMOR JKN
			$excel->setActiveSheetIndex(0)->setCellValue('AE3', "NOMOR JHT"); // Set kolom AO3 dengan tulisan NOMOR JHT
			$excel->setActiveSheetIndex(0)->setCellValue('AF3', "NOMOR JP"); // Set kolom AP3 dengan tulisan NOMOR JP
			$excel->setActiveSheetIndex(0)->setCellValue('AG3', "NOMOR KARTU KELUARGA"); // Set kolom AU3 dengan tulisan NOMOR KARTU KELUARGA
			$excel->setActiveSheetIndex(0)->setCellValue('AH3', "NAMA AYAH"); // Set kolom AV3 dengan tulisan NAMA AYAH
			$excel->setActiveSheetIndex(0)->setCellValue('AI3', "NAMA IBU"); // Set kolom AW3 dengan tulisan NAMA IBU
			$excel->setActiveSheetIndex(0)->setCellValue('AJ3', "STATUS NIKAH"); // Set kolom AX3 dengan tulisaN STATUS NIKAH

			// Apply style header yang telah kita buat tadi ke masing-masing kolom header
			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);

			// Panggil function view yang ada di Model untuk menampilkan semua data
			$join = $this->karyawan->getJoinDownloadDataKaryawan($id);

			$no = 1; // Untuk penomoran tabel, di awal set dengan 1
			$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
			foreach ($join as $data) { // Lakukan looping pada variabel karyawan

				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->perusahaan);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->penempatan);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jabatan);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jam_masuk . "-" . $data->jam_pulang);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "'" . $data->nik_karyawan);
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->nama_karyawan);
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->email_karyawan);
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->nomor_absen);
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, "'" . $data->nomor_npwp);
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->tempat_lahir);
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, "'" . $data->tanggal_lahir);
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->agama);
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->jenis_kelamin);
				$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->pendidikan_terakhir);
				$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "'" . $data->nomor_handphone);
				$excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->golongan_darah);
				$excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->provinsi);
				$excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->kota);
				$excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->kecamatan);
				$excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->kelurahan);
				$excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->kode_pos);
				$excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data->alamat);
				$excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, "'" . $data->rt);
				$excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, "'" . $data->rw);
				$excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, "'" . $data->nomor_rekening);
				$excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, "'" . $data->tanggal_mulai_kerja);
				$excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, "'" . $data->tanggal_akhir_kerja);
				$excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, $data->status_kerja);
				$excel->setActiveSheetIndex(0)->setCellValue('AD' . $numrow, "'" . $data->nomor_jkn);
				$excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, "'" . $data->nomor_jht);
				$excel->setActiveSheetIndex(0)->setCellValue('AF' . $numrow, "'" . $data->nomor_jp);
				$excel->setActiveSheetIndex(0)->setCellValue('AG' . $numrow, "'" . $data->nomor_kartu_keluarga);
				$excel->setActiveSheetIndex(0)->setCellValue('AH' . $numrow, $data->nama_ayah);
				$excel->setActiveSheetIndex(0)->setCellValue('AI' . $numrow, $data->nama_ibu);
				$excel->setActiveSheetIndex(0)->setCellValue('AJ' . $numrow, $data->status_nikah);

				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AD' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AE' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AF' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AG' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AI' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AJ' . $numrow)->applyFromArray($style_row);

				$no++; // Tambah 1 setiap kali looping
				$numrow++; // Tambah 1 setiap kali looping
			}

			// Set width kolom di excell
			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('M')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('O')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('P')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('R')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('S')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('T')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('U')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('V')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('W')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('X')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(30); // Set width kolom 

			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

			// Set judul Sheet excel nya
			$excel->getActiveSheet(0)->setTitle("Database Karyawan New");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Data Karyawan.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');

			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		}
		//Jika Yang Login Bukan HRD
		else {
			$this->load->view('auth/blocked');
		}
	}

	//Method untuk membuat Download Data Karyawan ALL
	public function exportall()
	{

		//Mengambil Session
		$role_id = $this->session->userdata("role_id");
		//Jika yang login Admin, Manager HRD, Supervisor HRD ,Dan Staff HRD
		if ($role_id == 1 || $role_id == 11 || $role_id == 9 || $role_id == 10 || $role_id == 17 || $role_id == 18) {

			// Load plugin PHPExcel nya
			include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

			// Panggil class PHPExcel nya
			$excel = new PHPExcel();

			// Settingan Description awal file excel
			$excel->getProperties()->setCreator('Vhierman Sach')
				->setLastModifiedBy('Vhierman Sach')
				->setTitle("Database Karyawan")
				->setSubject("Karyawan")
				->setDescription("Laporan Semua Data Karyawan")
				->setKeywords("Data Karyawan");

			// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
			$style_col = array(
				'font' => array('bold' => true), // Set font nya jadi bold
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);

			// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATABASE KARYAWAN PT PRIMA KOMPONEN INDONESIA"); // Set kolom A1 dengan tulisan "DATABASE KARYAWAN PT PRIMA KOMPONEN INDONESIA"

			$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16); // Set font size 15 untuk kolom A1
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

			// Buat header juudl tabel nya pada baris ke 3
			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "PERUSAHAAN"); // Set kolom B3 dengan tulisan PERUSAHAAN
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "PENEMPATAN"); // Set kolom C3 dengan tulisan PENEMPATAN
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "JABATAN"); // Set kolom D3 dengan tulisan JABATAN
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "JAM KERJA"); // Set kolom D3 dengan tulisan JAM KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('F3', "NIK KARYAWAN"); // Set kolom E3 dengan tulisan NIK KARYAWAN
			$excel->setActiveSheetIndex(0)->setCellValue('G3', "NAMA KARYAWAN"); // Set kolom F3 dengan tulisan NAMA KARYAWAN
			$excel->setActiveSheetIndex(0)->setCellValue('H3', "EMAIL KARYAWAN"); // Set kolom G3 dengan tulisan EMAIL KARYAWAN
			$excel->setActiveSheetIndex(0)->setCellValue('I3', "NOMOR ABSEN"); // Set kolom H3 dengan tulisan NOMOR ABSEN
			$excel->setActiveSheetIndex(0)->setCellValue('J3', "NOMOR NPWP"); // Set kolom I3 dengan tulisan NOMOR NPWP
			$excel->setActiveSheetIndex(0)->setCellValue('K3', "TEMPAT LAHIR"); // Set kolom J3 dengan tulisan TEMPAT LAHIR
			$excel->setActiveSheetIndex(0)->setCellValue('L3', "TANGGAL LAHIR"); // Set kolom K3 dengan tulisan TANGGAL LAHIR
			$excel->setActiveSheetIndex(0)->setCellValue('M3', "AGAMA"); // Set kolom L3 dengan tulisan AGAMA
			$excel->setActiveSheetIndex(0)->setCellValue('N3', "JENIS KELAMIN"); // Set kolom M3 dengan tulisan JENIS KELAMIN
			$excel->setActiveSheetIndex(0)->setCellValue('O3', "PENDIDIKAN TERAKHIR"); // Set kolom N3 dengan tulisan PENDIDIKAN TERAKHIR
			$excel->setActiveSheetIndex(0)->setCellValue('P3', "NOMOR HANDPHONE"); // Set kolom O3 dengan tulisan NOMOR HANDPHONE
			$excel->setActiveSheetIndex(0)->setCellValue('Q3', "GOLONGAN DARAH"); // Set kolom P3 dengan tulisan GOLONGAN DARAH
			$excel->setActiveSheetIndex(0)->setCellValue('R3', "PROVINSI"); // Set kolom Q3 dengan tulisan PROVINSI
			$excel->setActiveSheetIndex(0)->setCellValue('S3', "KOTA / KABUPATEN"); // Set kolom R3 dengan tulisan KOTA / KABUPATEN
			$excel->setActiveSheetIndex(0)->setCellValue('T3', "KECAMATAN"); // Set kolom S3 dengan tulisan KECAMATAN
			$excel->setActiveSheetIndex(0)->setCellValue('U3', "KELURAHAN"); // Set kolom T3 dengan tulisan KELURAHAN
			$excel->setActiveSheetIndex(0)->setCellValue('V3', "KODE POS"); // Set kolom U3 dengan tulisan KODE POS
			$excel->setActiveSheetIndex(0)->setCellValue('W3', "ALAMAT"); // Set kolom V3 dengan tulisan ALAMAT
			$excel->setActiveSheetIndex(0)->setCellValue('X3', "RT"); // Set kolom W3 dengan tulisan RT
			$excel->setActiveSheetIndex(0)->setCellValue('Y3', "RW"); // Set kolom X3 dengan tulisan RW
			$excel->setActiveSheetIndex(0)->setCellValue('Z3', "NOMOR REKENING"); // Set kolom Y3 dengan tulisan NOMOR REKENING

			$excel->setActiveSheetIndex(0)->setCellValue('AA3', "TANGGAL MULAI KERJA"); // Set kolom AK3 dengan tulisan TANGGAL MULAI KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('AB3', "TANGGAL AKHIR KERJA"); // Set kolom AL3 dengan tulisan TANGGAL AKHIR KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('AC3', "STATUS KERJA"); // Set kolom AM3 dengan tulisan STATUS KERJA
			$excel->setActiveSheetIndex(0)->setCellValue('AD3', "NOMOR JKN"); // Set kolom AN3 dengan tulisan NOMOR JKN
			$excel->setActiveSheetIndex(0)->setCellValue('AE3', "NOMOR JHT"); // Set kolom AO3 dengan tulisan NOMOR JHT
			$excel->setActiveSheetIndex(0)->setCellValue('AF3', "NOMOR JP"); // Set kolom AP3 dengan tulisan NOMOR JP

			$excel->setActiveSheetIndex(0)->setCellValue('AG3', "NOMOR KARTU KELUARGA"); // Set kolom AU3 dengan tulisan NOMOR KARTU KELUARGA
			$excel->setActiveSheetIndex(0)->setCellValue('AH3', "NAMA AYAH"); // Set kolom AV3 dengan tulisan NAMA AYAH
			$excel->setActiveSheetIndex(0)->setCellValue('AI3', "NAMA IBU"); // Set kolom AW3 dengan tulisan NAMA IBU
			$excel->setActiveSheetIndex(0)->setCellValue('AJ3', "STATUS NIKAH"); // Set kolom AX3 dengan tulisaN STATUS NIKAH


			// Apply style header yang telah kita buat tadi ke masing-masing kolom header
			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('U3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('V3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('W3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('X3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Y3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('Z3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AA3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AB3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AC3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AD3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AE3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AF3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AG3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AH3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AI3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('AJ3')->applyFromArray($style_col);

			// Panggil function view yang ada di Model untuk menampilkan semua data
			$join = $this->karyawan->getJoinDownloadDataKaryawanALL();

			$no = 1; // Untuk penomoran tabel, di awal set dengan 1
			$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
			foreach ($join as $data) { // Lakukan looping pada variabel karyawan

				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data->perusahaan);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->penempatan);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jabatan);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jam_masuk . "-" . $data->jam_pulang);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "'" . $data->nik_karyawan);
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->nama_karyawan);
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->email_karyawan);
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->nomor_absen);
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, "'" . $data->nomor_npwp);
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->tempat_lahir);
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, "'" . $data->tanggal_lahir);
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->agama);
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->jenis_kelamin);
				$excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->pendidikan_terakhir);
				$excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "'" . $data->nomor_handphone);
				$excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->golongan_darah);
				$excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->provinsi);
				$excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->kota);
				$excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->kecamatan);
				$excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->kelurahan);
				$excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->kode_pos);
				$excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data->alamat);
				$excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, "'" . $data->rt);
				$excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, "'" . $data->rw);
				$excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, "'" . $data->nomor_rekening);
				$excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, "'" . $data->tanggal_mulai_kerja);
				$excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, "'" . $data->tanggal_akhir_kerja);
				$excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, $data->status_kerja);
				$excel->setActiveSheetIndex(0)->setCellValue('AD' . $numrow, "'" . $data->nomor_jkn);
				$excel->setActiveSheetIndex(0)->setCellValue('AE' . $numrow, "'" . $data->nomor_jht);
				$excel->setActiveSheetIndex(0)->setCellValue('AF' . $numrow, "'" . $data->nomor_jp);
				$excel->setActiveSheetIndex(0)->setCellValue('AG' . $numrow, "'" . $data->nomor_kartu_keluarga);
				$excel->setActiveSheetIndex(0)->setCellValue('AH' . $numrow, $data->nama_ayah);
				$excel->setActiveSheetIndex(0)->setCellValue('AI' . $numrow, $data->nama_ibu);
				$excel->setActiveSheetIndex(0)->setCellValue('AJ' . $numrow, $data->status_nikah);


				// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
				$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('S' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('T' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('U' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('V' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AD' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AE' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AF' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AG' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AH' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AI' . $numrow)->applyFromArray($style_row);
				$excel->getActiveSheet()->getStyle('AJ' . $numrow)->applyFromArray($style_row);

				$no++; // Tambah 1 setiap kali looping
				$numrow++; // Tambah 1 setiap kali looping
			}

			// Set width kolom di excell
			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('M')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('N')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('O')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('P')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('R')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('S')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('T')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('U')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('V')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('W')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('X')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AC')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AD')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AE')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AF')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AG')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AH')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AI')->setWidth(30); // Set width kolom 
			$excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(30); // Set width kolom 

			// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

			// Set orientasi kertas jadi LANDSCAPE
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

			// Set judul Sheet excel nya
			$excel->getActiveSheet(0)->setTitle("Database Karyawan New");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Data Karyawan.xlsx"'); // Set nama file excel nya
			header('Cache-Control: max-age=0');

			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		}
		//Jika Yang Login Bukan HRD
		else {
			$this->load->view('auth/blocked');
		}
	}

	//Method untuk RESUME KARYAWAN
	public function resumekaryawan($nik_karyawan)
	{
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
		$data['title'] = 'Resume Karyawan';
		//Menyimpan session dari login
		$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

		//Mengambil data dari model
		$karyawan               = $this->karyawan->getResumeKaryawanByID($nik_karyawan);
		$keluarga               = $this->karyawan->getHistoryKeluarga($nik_karyawan);
		$kontrak                = $this->karyawan->getHistoryKontrak($nik_karyawan);
		$jabatan                = $this->karyawan->getHistoryJabatan($nik_karyawan);
		$pendidikanformal       = $this->karyawan->getHistoryPendidikanFormal($nik_karyawan);
		$pendidikannonformal    = $this->karyawan->getHistoryPendidikanNonFormal($nik_karyawan);
		$traininginternal       = $this->karyawan->getHistoryTrainingInternal($nik_karyawan);
		$trainingeksternal      = $this->karyawan->getHistoryTrainingEksternal($nik_karyawan);

		//var_dump($karyawan);
		//die;

		//Mengambil data Tanggal Bulan Dan Tahun Sekarang
		date_default_timezone_set("Asia/Jakarta");
		$tahun      = date('Y');
		$bulan      = date('m');
		$tanggal    = date('d');
		$hari       = date("w");

		// membuat halaman baru Format Potrait Kertas A4
		$pdf = new FPDF('P', 'mm', 'A4');
		$pdf->setTopMargin(2);
		$pdf->setLeftMargin(2);
		$pdf->SetAutoPageBreak(true);

		$pdf->AddPage();

		//Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai kerja
		$tanggalmulaikerja      = IndonesiaTgl($karyawan['tanggal_mulai_kerja']);
		$tanggalmulai           = substr($tanggalmulaikerja, 0, -8);
		$bulankerja             = substr($tanggalmulaikerja, 3, -5);
		$tahunkerja             = substr($tanggalmulaikerja, -4);

		//Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal akhir kerja
		$tanggalakhirkerja      = IndonesiaTgl($karyawan['tanggal_akhir_kerja']);
		$tanggalakhir           = substr($tanggalakhirkerja, 0, -8);
		$bulanakhir             = substr($tanggalakhirkerja, 3, -5);
		$tahunakhir             = substr($tanggalakhirkerja, -4);

		$pdf->Cell(205, 290, '', 1, 0, 'C');
		$pdf->SetFont('Arial', 'B', '8');
		$pdf->Cell(-200);
		$pdf->Ln(2);
		$pdf->Cell(5);
		$pdf->Cell(70, 20, '', 1, 0, 'C');
		$pdf->Image('assets/img/logo/logo.png', 9, 9, 65);
		$pdf->Cell(50, 20, '', 1, 0, 'C');

		$pdf->Cell(30, 5, "No.Form", 1, 0, 'L');
		$pdf->Cell(43, 5, "FR/HRD-GA/HR/006/Rev.01", 1, 0, 'L');

		$pdf->Ln(5);
		$pdf->Cell(125);
		$pdf->Cell(30, 5, "Tgl.Dikeluarkan", 1, 0, 'L');
		$pdf->Cell(43, 5, "24 November 2012", 1, 0, 'L');

		$pdf->Ln(5);
		$pdf->Cell(125);
		$pdf->Cell(30, 5, "Tgl.Revisi", 1, 0, 'L');
		$pdf->Cell(43, 5, "01 April 2015", 1, 0, 'L');

		$pdf->Ln(5);
		$pdf->Cell(125);
		$pdf->Cell(30, 5, "Halaman", 1, 0, 'L');
		$pdf->Cell(43, 5, "1 Dari 2", 1, 0, 'L');

		$pdf->SetFont('Arial', 'B', '12');
		$pdf->Ln(-13);
		$pdf->Cell(75);
		$pdf->Cell(50, 5, "DETAIL", 0, 0, 'C');

		$pdf->Ln(5);
		$pdf->Cell(75);
		$pdf->Cell(50, 5, "RESUME", 0, 0, 'C');

		$pdf->Ln(5);
		$pdf->Cell(75);
		$pdf->Cell(50, 5, "KARYAWAN", 0, 0, 'C');

		if ($karyawan['foto_karyawan'] == NULL) {
			$pdf->Image('assets/img/karyawan/karyawan/default_karyawan.png', 160, 30, 40);
		} else {
			$pdf->Image('assets/img/karyawan/karyawan/' . $karyawan['foto_karyawan'], 160, 30, 40);
		}

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(10);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "A.Identitas Pribadi", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Nama ", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nama_karyawan'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "No NIK KTP ", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nik_karyawan'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "No NPWP", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nomor_npwp'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Tempat,Tanggal Lahir", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['tempat_lahir'] . ', ' . IndonesiaTgl($karyawan['tanggal_lahir']), 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Umur", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, hitung_umur($karyawan['tanggal_lahir']), 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Agama", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['agama'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Jenis Kelamin", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['jenis_kelamin'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Nomor Handphone", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nomor_handphone'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Email", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['email_karyawan'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Pendidikan Terakhir", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['pendidikan_terakhir'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Status Menikah", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['status_nikah'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Alamat", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['alamat'] . ', RT/RW' . $karyawan['rt'] . '/' . $karyawan['rw'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(59);
		$pdf->Cell(140, 5, 'Kelurahan ' . $karyawan['kelurahan'] . ', Kecamatan ' . $karyawan['kecamatan'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(59);
		$pdf->Cell(140, 5, 'Kabupaten/Kota ' . $karyawan['kota'] . ', Provinsi ' . $karyawan['provinsi'] . ', Kode POS ' . $karyawan['kode_pos'], 0, 0, 'L');

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(5);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "B.Identitas Pekerjaan", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "ID Absen", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nomor_absen'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "No Rekening", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nomor_rekening'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Status Kerja", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['status_kerja'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Mulai Kerja", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, IndonesiaTgl($karyawan['tanggal_mulai_kerja']), 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Akhir Kerja", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');

		if ($karyawan['status_kerja'] == "PKWTT") {
			$pdf->Cell(90, 5, "-", 0, 0, 'L');
		} else {
			$pdf->Cell(90, 5, IndonesiaTgl($karyawan['tanggal_akhir_kerja']), 0, 0, 'L');
		}

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Masa Kerja", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, hitung_umur($karyawan['tanggal_mulai_kerja']), 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "Jabatan / Penempatan", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['jabatan'] . ' / ' . $karyawan['penempatan'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "No.BPJSTK", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nomor_jht'], 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(9);
		$pdf->Cell(45, 5, "No.BPJSKS", 0, 0, 'L');
		$pdf->Cell(5, 5, " : ", 0, 0, 'C');
		$pdf->Cell(90, 5, $karyawan['nomor_jkn'], 0, 0, 'L');

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(7);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "C.History Keluarga", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);


		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(70, 8, 'Nama', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'Hubungan Keluarga', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'NIK', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'No BPJSKS', 1, 0, 'C', 1);

		$nokeluarga = 1;

		foreach ($keluarga as $rowkeluarga) :
			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $nokeluarga, 1, 0, 'C');
			$pdf->Cell(70, 8, $rowkeluarga['nama_history_keluarga'], 1, 0, 'L');
			$pdf->Cell(35, 8, $rowkeluarga['hubungan_keluarga'], 1, 0, 'C');
			$pdf->Cell(35, 8, $rowkeluarga['nik_history_keluarga'], 1, 0, 'C');
			$pdf->Cell(35, 8, $rowkeluarga['nomor_bpjs_kesehatan_history_keluarga'], 1, 0, 'C');
			$nokeluarga++;
		endforeach;

		$pdf->Ln(5);

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(7);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "D.History Kontrak", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);


		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(70, 8, 'Awal Kontrak', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'Akhir Kontrak', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'Status', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'Masa Kontrak', 1, 0, 'C', 1);

		$nokontrak = 1;

		foreach ($kontrak as $rowkontrak) :

			if ($rowkontrak['status_kontrak_kerja'] == "PKWT") {
				$tanggal_akhir_kerja    = IndonesiaTgl($rowkontrak['tanggal_akhir_kontrak']);
				$masa_kontrak           = $rowkontrak['masa_kontrak'];
			} else {
				$tanggal_akhir_kerja    = "-";
				$masa_kontrak           = "-";
			}

			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $nokontrak, 1, 0, 'C');
			$pdf->Cell(70, 8, IndonesiaTgl($rowkontrak['tanggal_awal_kontrak']), 1, 0, 'C');
			$pdf->Cell(35, 8, $tanggal_akhir_kerja, 1, 0, 'C');
			$pdf->Cell(35, 8, $rowkontrak['status_kontrak_kerja'], 1, 0, 'C');
			$pdf->Cell(35, 8, $masa_kontrak, 1, 0, 'C');
			$nokontrak++;
		endforeach;

		$pdf->Ln(5);



		$pdf->Ln(90);
		$pdf->Cell(205, 290, '', 1, 0, 'C');

		$pdf->SetFont('Arial', 'B', '8');
		$pdf->Cell(-200);
		$pdf->Ln(2);
		$pdf->Cell(5);
		$pdf->Cell(70, 20, '', 1, 0, 'C');
		$pdf->Image('assets/img/logo/logo.png', 9, 9, 65);
		$pdf->Cell(50, 20, '', 1, 0, 'C');

		$pdf->Cell(30, 5, "No.Form", 1, 0, 'L');
		$pdf->Cell(43, 5, "FR/HRD-GA/HR/006/Rev.01", 1, 0, 'L');

		$pdf->Ln(5);
		$pdf->Cell(125);
		$pdf->Cell(30, 5, "Tgl.Dikeluarkan", 1, 0, 'L');
		$pdf->Cell(43, 5, "24 November 2012", 1, 0, 'L');

		$pdf->Ln(5);
		$pdf->Cell(125);
		$pdf->Cell(30, 5, "Tgl.Revisi", 1, 0, 'L');
		$pdf->Cell(43, 5, "01 April 2015", 1, 0, 'L');

		$pdf->Ln(5);
		$pdf->Cell(125);
		$pdf->Cell(30, 5, "Halaman", 1, 0, 'L');
		$pdf->Cell(43, 5, "2 Dari 2", 1, 0, 'L');

		$pdf->SetFont('Arial', 'B', '12');
		$pdf->Ln(-13);
		$pdf->Cell(75);
		$pdf->Cell(50, 5, "DETAIL", 0, 0, 'C');

		$pdf->Ln(5);
		$pdf->Cell(75);
		$pdf->Cell(50, 5, "RESUME", 0, 0, 'C');

		$pdf->Ln(5);
		$pdf->Cell(75);
		$pdf->Cell(50, 5, "KARYAWAN", 0, 0, 'C');

		$pdf->Cell(5);
		$pdf->Cell(50, 5, "", 0, 0, 'L');



		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(10);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "E.History Jabatan", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);

		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(70, 8, 'Penempatan', 1, 0, 'C', 1);
		$pdf->Cell(70, 8, 'Jabatan', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'Tanggal Mutasi', 1, 0, 'C', 1);

		$nojabatan = 1;

		foreach ($jabatan as $rowjabatan) :

			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $nojabatan, 1, 0, 'C');
			$pdf->Cell(70, 8, $rowjabatan['penempatan'], 1, 0, 'C');
			$pdf->Cell(70, 8, $rowjabatan['jabatan'], 1, 0, 'C');
			$pdf->Cell(35, 8, IndonesiaTgl($rowjabatan['tanggal_mutasi']), 1, 0, 'C');
			$nojabatan++;
		endforeach;

		$pdf->Ln(5);

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(5);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "F.History Pendidikan Formal", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);

		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(40, 8, 'Tingkat', 1, 0, 'C', 1);
		$pdf->Cell(50, 8, 'Nama Instansi', 1, 0, 'C', 1);
		$pdf->Cell(50, 8, 'Jurusan', 1, 0, 'C', 1);
		$pdf->Cell(35, 8, 'Tahun Lulus', 1, 0, 'C', 1);

		$nopendidikanformal = 1;

		foreach ($pendidikanformal as $rowpendidikanformal) :

			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $nopendidikanformal, 1, 0, 'C');
			$pdf->Cell(40, 8, $rowpendidikanformal['tingkat_pendidikan_formal'], 1, 0, 'C');
			$pdf->Cell(50, 8, $rowpendidikanformal['nama_instansi_pendidikan'], 1, 0, 'C');
			$pdf->Cell(50, 8, $rowpendidikanformal['jurusan'], 1, 0, 'C');
			$pdf->Cell(35, 8, $rowpendidikanformal['tahun_lulus'], 1, 0, 'C');
			$nopendidikanformal++;
		endforeach;

		$pdf->Ln(5);

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(5);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "G.History Pendidikan Non Formal", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);

		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(95, 8, 'Nama Instansi', 1, 0, 'C', 1);
		$pdf->Cell(40, 8, 'Awal Pendidikan', 1, 0, 'C', 1);
		$pdf->Cell(40, 8, 'Akhir Pendidikan', 1, 0, 'C', 1);

		$nopendidikannonformal = 1;

		foreach ($pendidikannonformal as $rowpendidikannonformal) :

			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $nopendidikannonformal, 1, 0, 'C');
			$pdf->Cell(95, 8, $rowpendidikannonformal['nama_instansi_pendidikan_non_formal'], 1, 0, 'C');
			$pdf->Cell(40, 8, IndonesiaTgl($rowpendidikannonformal['tanggal_awal_pendidikan_non_formal']), 1, 0, 'C');
			$pdf->Cell(40, 8, IndonesiaTgl($rowpendidikannonformal['tanggal_akhir_pendidikan_non_formal']), 1, 0, 'C');
			$nopendidikannonformal++;
		endforeach;

		$pdf->Ln(5);

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(5);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "H.History Training Internal", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);

		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(65, 8, 'Waktu Training', 1, 0, 'C', 1);
		$pdf->Cell(110, 8, 'Materi Training', 1, 0, 'C', 1);

		$notraininginternal = 1;

		foreach ($traininginternal as $rowtraininginternal) :

			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $notraininginternal, 1, 0, 'C');
			$pdf->Cell(65, 8, $rowtraininginternal['hari_training_internal'] . ', ' . IndonesiaTgl($rowtraininginternal['tanggal_training_internal']), 1, 0, 'C');
			$pdf->Cell(110, 8, $rowtraininginternal['materi_training_internal'], 1, 0, 'C');
			$notraininginternal++;
		endforeach;

		$pdf->Ln(5);

		$pdf->SetFont('Arial', 'B', '10');

		$pdf->Ln(5);
		$pdf->Cell(5);
		$pdf->Cell(50, 5, "I.History Training Eksternal", 0, 0, 'L');

		$pdf->SetFont('Arial', '', '10');

		$pdf->Ln(5);

		$pdf->Cell(10);
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
		$pdf->Cell(10, 8, 'No', 1, 0, 'C', 1);
		$pdf->Cell(95, 8, 'Nama Institusi', 1, 0, 'C', 1);
		$pdf->Cell(40, 8, 'Awal Training', 1, 0, 'C', 1);
		$pdf->Cell(40, 8, 'Akhir Training', 1, 0, 'C', 1);

		$notrainingeksternal = 1;

		foreach ($trainingeksternal as $rowtrainingeksternal) :
			$pdf->Ln();
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', '10');
			$pdf->Cell(10, 8, $notrainingeksternal, 1, 0, 'C');
			$pdf->Cell(95, 8, $rowtrainingeksternal['institusi_penyelenggara_training_eksternal'], 1, 0, 'C');
			$pdf->Cell(40, 8, IndonesiaTgl($rowtrainingeksternal['tanggal_awal_training_eksternal']), 1, 0, 'C');
			$pdf->Cell(40, 8, IndonesiaTgl($rowtrainingeksternal['tanggal_akhir_training_eksternal']), 1, 0, 'C');
			$notrainingeksternal++;
		endforeach;

		$pdf->Ln(5);

		$pdf->SetFont('Arial', '', '10');

		$pdf->Output();
	}
}
