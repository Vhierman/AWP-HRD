<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Magang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil library validation
        $this->load->library('form_validation');
        //Memanggil library fpdf
        $this->load->library('pdf');
        //Memanggil Helper Login
        is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
        //Memanggil model magang
        $this->load->model('magang/Magang_model', 'magang');
    }

    //untuk mencari data karyawan berdasarkan NIK Karyawan
    public function get_datakaryawan()
    {
        $nikmagang = $this->input->post('nik_magang');
        $data = $this->magang->get_karyawan_bynik($nikmagang);
        echo json_encode($data);
    }

    //Method Data Magang
    public function magang()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Magang';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data magang di join dengan data penempatan
        $data['magang'] = $this->magang->dataMagang();

        //menampilkan halaman data magang
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('magang/datamagang', $data);
        $this->load->view('templates/footer');
    }

    //Method Download Data Magang
    public function downloadmagang()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 9 || $role_id == 1 || $role_id == 11 || $role_id == 10 || $role_id == 17 || $role_id == 18) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data Magang';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data magang di join dengan data penempatan
            $data['magang'] = $this->magang->DownloaddataMagang();

            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            // Panggil class PHPExcel nya
            $excel = new PHPExcel();

            // Settingan Description awal file excel
            $excel->getProperties()->setCreator('Vhierman Sach')
                ->setLastModifiedBy('Vhierman Sach')
                ->setTitle("Data Karyawan Magang")
                ->setSubject("Karyawan Magang")
                ->setDescription("Laporan Data Karyawan Magang")
                ->setKeywords("Data Karyawan Magang");

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

            $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA KARYAWAN MAGANG");
            // Set kolom B2 dengan tulisan "DATA KARYAWAN MAGANG"

            $excel->getActiveSheet()->mergeCells('B2:H2'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            $excel->setActiveSheetIndex(0)->setCellValue('B3', "PT PRIMA KOMPONEN INDONESIA");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B3:H3'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            // Buat header juudl tabel nya pada baris ke 5
            $excel->setActiveSheetIndex(0)->setCellValue('B6', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('C6', "NAMA KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('D6', "NIK KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "JABATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('F6', "PENEMPATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL MASUK MAGANG");
            $excel->setActiveSheetIndex(0)->setCellValue('H6', "TANGGAL SELESAI MAGANG");
            $excel->setActiveSheetIndex(0)->setCellValue('I6', "TEMPAT LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('J6', "TANGGAL LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('K6', "AGAMA");
            $excel->setActiveSheetIndex(0)->setCellValue('L6', "JENIS KELAMIN");
            $excel->setActiveSheetIndex(0)->setCellValue('M6', "NOMOR HANDPHONE");
            $excel->setActiveSheetIndex(0)->setCellValue('N6', "PENDIDIKAN TERAKHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('O6', "ALAMAT");
            $excel->setActiveSheetIndex(0)->setCellValue('P6', "RT");
            $excel->setActiveSheetIndex(0)->setCellValue('Q6', "RW");
            $excel->setActiveSheetIndex(0)->setCellValue('R6', "KELURAHAN");
            $excel->setActiveSheetIndex(0)->setCellValue('S6', "KECAMATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('T6', "KOTA");
            $excel->setActiveSheetIndex(0)->setCellValue('U6', "PROVINSI");
            $excel->setActiveSheetIndex(0)->setCellValue('V6', "KODE POS");

            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('J6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('K6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('L6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('M6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('N6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('O6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('P6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('Q6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('R6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('S6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('T6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('U6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('V6')->applyFromArray($style_col);

            // Panggil function view yang ada di Model untuk menampilkan semua data
            $join = $this->magang->DownloaddataMagang();

            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($join as $data) {

                // Lakukan looping pada variabel karyawan
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "'" . $data->nik_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jabatan);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->penempatan);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->tanggal_masuk_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, "'" . $data->tanggal_selesai_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->tempat_lahir_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, "'" . $data->tanggal_lahir_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->agama_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->jenis_kelamin_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, "'" . $data->nomor_handphone_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->pendidikan_terakhir_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->alamat_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "'" . $data->rt_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, "'" . $data->rw_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->kelurahan_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->kecamatan_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->kota_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->provinsi_magang);
                $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->kode_pos_magang);

                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
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

                $no++; // Tambah 1 setiap kali looping
                $numrow++; // Tambah 1 setiap kali looping

            }

            // Set width kolom di excell
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(5); // Set width kolom 
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

            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Set judul Sheet excel nya
            $excel->getActiveSheet(0)->setTitle("Data Karyawan Magang");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Karyawan Magang.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal tambah magang 
    public function tambahmagang()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data Magang';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data magang di join dengan data penempatan
            $data['magang'] = $this->magang->dataMagang();
            //Mengambil data penempatan untuk ditampilkan kedalam select option pada form tambah dan edit
            $data['penempatan'] = $this->magang->dataPenempatan();
            //Mengambil data penempatan untuk ditampilkan kedalam select option pada form tambah dan edit
            $data['jabatan'] = $this->magang->dataJabatan();

            //Validation Form Data Magang
            $this->form_validation->set_rules('penempatan_id', 'Penempatan', 'required');
            $this->form_validation->set_rules('tanggal_masuk_magang', 'Tanggal Masuk', 'required');
            $this->form_validation->set_rules('tanggal_selesai_magang', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('nik_magang', 'NIK ', 'required|trim|min_length[16]');
            $this->form_validation->set_rules('nama_magang', 'Nama', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('tempat_lahir_magang', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tanggal_lahir_magang', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('agama_magang', 'Agama', 'required');
            $this->form_validation->set_rules('jenis_kelamin_magang', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('nomor_handphone_magang', 'Nomor HP', 'required');
            $this->form_validation->set_rules('alamat_magang', 'Alamat', 'required');
            $this->form_validation->set_rules('rt_magang', 'RT', 'required');
            $this->form_validation->set_rules('rw_magang', 'RW', 'required');
            $this->form_validation->set_rules('kelurahan_magang', 'Kelurahan', 'required');
            $this->form_validation->set_rules('kecamatan_magang', 'Kecamatan', 'required');
            $this->form_validation->set_rules('kota_magang', 'Kota', 'required');
            $this->form_validation->set_rules('provinsi_magang', 'Provinsi', 'required');
            $this->form_validation->set_rules('kode_pos_magang', 'Kode POS', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman tambah data magang
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('magang/tambahmagang', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {
                //Memanggil model magang dengan method tambahMagang
                $this->magang->tambahMagang();
                //Menampilkan pesan berhasil
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Magang</div>');
                //redirect ke halaman data magang
                redirect('magang/magang');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal tambah magang 
    public function editmagang($id_magang)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data Magang';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data magang di join dengan data penempatan berdasarkan id_magang
            $data['magang'] = $this->magang->getdataMagangByID($id_magang);
            //Mengambil data penempatan untuk ditampilkan kedalam select option pada form tambah dan edit
            $data['penempatan'] = $this->magang->dataPenempatan();
            //Mengambil data penempatan untuk ditampilkan kedalam select option pada form tambah dan edit
            $data['jabatan'] = $this->magang->dataJabatan();

            //Select Option
            //untuk tipe datanya enum
            $data['jenis_kelamin_magang'] = ['', 'Pria', 'Wanita'];
            $data['agama_magang'] = ['', 'Islam', 'Kristen Protestan', 'Kristen Katholik', 'Hindu', 'Budha'];
            $data['pendidikan_terakhir_magang'] = ['', 'SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'];

            //Validation Form Edit Data Magang
            $this->form_validation->set_rules('penempatan_id', 'Penempatan', 'required');
            $this->form_validation->set_rules('tanggal_masuk_magang', 'Tanggal Masuk', 'required');
            $this->form_validation->set_rules('tanggal_selesai_magang', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('nik_magang', 'NIK ', 'required|trim|min_length[16]');
            $this->form_validation->set_rules('nama_magang', 'Nama', 'required|trim|min_length[2]');
            $this->form_validation->set_rules('tempat_lahir_magang', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tanggal_lahir_magang', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('agama_magang', 'Agama', 'required');
            $this->form_validation->set_rules('jenis_kelamin_magang', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('nomor_handphone_magang', 'Nomor HP', 'required');
            $this->form_validation->set_rules('alamat_magang', 'Alamat', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit data magang
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('magang/editmagang', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {
                //Memanggil model magang dengan method editMagang
                $this->magang->editMagang();
                //Menampilkan pesan berhasil
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Magang</div>');
                //redirect ke halaman data magang
                redirect('magang/magang');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data Magang
    public function hapusmagang($id_magang)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //mendelete kedalam database melalui method pada model magang berdasarkan id nya
            $this->magang->hapusMagang($id_magang);
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Magang</div>');
            //dan mendirect kehalaman magang
            redirect('magang/magang');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetakpkwtmagang
    public function cetakpkwtmagang($id_magang)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Cetak Surat PKWT Magang';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model magang
            $magang         = $this->magang->getdataMagangByID($id_magang);

            //Mengambil 4 Digit NIK Terakhir Magang
            $nikmagang      = substr($magang['nik_magang'], 12);

            //Mengambil data Tanggal Bulan Dan Tahun Sekarang
            date_default_timezone_set("Asia/Jakarta");
            $tahun      = date('Y');
            $bulan      = date('m');
            $tanggal    = date('d');

            //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai magang
            $tanggal_masuk_magang      = IndonesiaTgl($magang['tanggal_masuk_magang']);
            $tanggalawal           = substr($tanggal_masuk_magang, 0, -8);
            $bulanawal             = substr($tanggal_masuk_magang, 3, -5);
            $tahunawal             = substr($tanggal_masuk_magang, -4);

            //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal akhir magang
            $tanggal_selesai_magang      = IndonesiaTgl($magang['tanggal_selesai_magang']);
            $tanggalselesai           = substr($tanggal_selesai_magang, 0, -8);
            $bulanselesai             = substr($tanggal_selesai_magang, 3, -5);
            $tahunselesai             = substr($tanggal_selesai_magang, -4);

            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->setTopMargin(10);
            $pdf->setLeftMargin(4);
            $pdf->SetAutoPageBreak(true);
            $pdf->AddPage();

            $pdf->SetFont('Arial', 'BU', '12');
            $pdf->Cell(190, 10, 'SURAT PERJANJIAN KERJA HARIAN LEPAS', 0, 0, 'C');
            $pdf->Ln(5);

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(190, 10, 'No : ' . $nikmagang . '/ PK / HRD / ' . bulanromawi($bulan) . ' / ' . $tahun . '.', 0, 0, 'C');

            $pdf->Ln(15);

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Yang bertanda tangan di bawah ini :', 0, 0, 'L');

            $pdf->Ln(10);

            $pdf->Cell(10);
            $pdf->Cell(10, 7, '1. ', 0, 0, 'L');
            $pdf->Cell(50, 7, 'Nama', 0, 0, 'L');
            $pdf->Cell(5, 7, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 7, ' Rudiyanto', 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 7, 'Jabatan', 0, 0, 'L');
            $pdf->Cell(5, 7, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 7, ' Manager HRD-GA PT Prima Komponen Indonesia', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Dalam hal  ini  bertindak atas nama Manager HRD-GA PT Prima Komponen  Indonesia  yang', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'berkedudukan di Kawasan Industri Pergudangan Taman Tekno Blok F2 No.10-11, Kelurahan', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(120, 5, 'Setu, Kecamatan Setu, Tangerang Selatan. Dan selanjutnya disebut', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(50, 5, ' PIHAK  PERTAMA (I).', 0, 0, 'L');

            $pdf->Ln(10);

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10);
            $pdf->Cell(10, 8, '2. ', 0, 0, 'L');
            $pdf->Cell(50, 8, 'No.KTP/SIM', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 8, ' ' . $magang['nik_magang'], 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 8, 'Nama', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 8, ' ' . $magang['nama_magang'], 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 8, 'Tempat,Tanggal Lahir', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 8, ' ' . $magang['tempat_lahir_magang'] . ', ' . IndonesiaTgl($magang['tanggal_lahir_magang']), 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 8, 'Pendidikan Terakhir', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 8, ' ' . $magang['pendidikan_terakhir_magang'], 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 8, 'Jenis Kelamin', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 8, ' ' . $magang['jenis_kelamin_magang'], 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 8, 'Agama', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 8, ' ' . $magang['agama_magang'], 0, 0, 'L');

            $pdf->Ln();

            $pdf->Cell(20);
            $pdf->Cell(50, 8, 'Alamat', 0, 0, 'L');
            $pdf->Cell(5, 8, ' : ', 0, 0, 'C');
            $pdf->Cell(115, 6, ' ' . $magang['alamat_magang'] . ', ' . $magang['rt_magang'] . '/' . $magang['rw_magang'] . ', Kelurahan.' . $magang['kelurahan_magang'], 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(75);
            $pdf->Cell(115, 6, ' Kecamatan.' . $magang['kecamatan_magang'] . ', Kota.' . $magang['kota_magang'] . ', ' . $magang['provinsi_magang'], 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(144, 8, 'Dalam  hal  ini  bertindak  untuk dan atas nama dari pribadi dan selanjutnya disebut', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(27, 8, '  PIHAK', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(30, 8, 'KEDUA (II).', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');

            $pdf->Ln(5);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 1', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PERNYATAAN - PERNYATAAN', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(35, 6, 'PIHAK PERTAMA ', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(96, 6, ' telah   menyatakan   persetujuannya  untuk   menerima', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(30, 6, ' PIHAK  KEDUA', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 6, 'selaku pekerja harian lepas.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(96, 6, 'menyatakan kesediannya selaku pekerja harian lepas yang tunduk pada tata,', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(115, 6, 'tertib, peraturan, dan sistem kerja yang berlaku pada perusahaan', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(28, 6, 'PIHAK PERTAMA ', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');

            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 2', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'RUANG LINGKUP PEKERJAAN', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(57, 6, 'Pekerjaan yang harus dilakukan', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(58, 6, 'selaku pekerja harian lepas pada', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(28, 6, 'PIHAK', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(21, 6, 'PERTAMA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(16, 6, ' adalah ', 0, 0, 'L');
            $pdf->SetFont('Arial', 'BU', '11');
            $pdf->Cell(60, 6, '' . $magang['jabatan'] . ' / ' . $magang['penempatan'], 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(28, 6, 'PIHAK KEDUA ', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(96, 6, 'tidak diperkenankan mengerjakan pekerjaan lain selain yang disebutkan pada,', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(116, 6, 'ayat 1 tersebut di atas, kecuali atas persetujuan dan perintah dari', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(36, 6, ' PIHAK  PERTAMA ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10, 6, ' atau ', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(15, 6, 'atasan', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(36, 6, 'PIHAK KEDUA.', 0, 0, 'L');



            $pdf->Ln(100);

            $pdf->Ln(50);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, '', 0, 0, 'C');


            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 3', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'MASA BERLAKU PERJANJIAN KERJA', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 6, 'Perjanjian kerja ini berlaku untuk jangka waktu 21 hari(dua puluh satu hari), terhitung sejak tanggal', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(135, 6, 'penandatanganan surat perjanjian kerja ini dan akan berakhir pada tanggal : ', 0, 0, 'L');
            $pdf->SetFont('Arial', 'BU', '11');
            $pdf->Cell(30, 6, ' ' . $tanggalselesai . ' ' . bulan($bulanselesai) . ' ' . $tahunselesai . '.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(117, 6, 'Setelah berakhirnya jangka waktu tersebut. Hubungan kerja antara', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 6, 'PIHAK PERTAMA.', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(15, 6, 'dengan', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 6, 'PIHAK KEDUA', 0, 0, 'C');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(115, 6, 'menjadi putus dengan sendirinya tanpa perlu pemberitahuan dari', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 6, 'PIHAK PERTAMA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10, 6, 'pada', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 6, 'PIHAK KEDUA.', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 4', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'CARA KERJA', 0, 0, 'C');

            $pdf->Ln(5);
            $pdf->Cell(20);
            $pdf->Cell(35, 6, 'PIHAK PERTAMA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(95, 6, 'atau wakil perusahaan PT Prima Komponen Indonesia akan memberikan', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(70, 6, 'pengarahan perihal cara kerja sebelum', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(65, 6, 'memulai pekerjaannya.', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 5', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'JAM KERJA', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Berdasarkan peraturan ketenagakerjaan yang berlaku, jam kerja efektif perusahaan ditetapkan', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, '8 (delapan) jam perhari, 40 (empat puluh) jam perminggu, dengan jumlah hari kerja 5 (lima) hari', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'dalam seminggu.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Jam masuk adalah jam 08:00 (delapan) pagi dan jam pulang adalah jam (17:00) (lima sore).', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 3', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '1.  Waktu istirahat pada hari Senin hingga Kamis ditetapkan selama 1 (satu) jam, yaitu', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '     pada pukul 12:00 (dua belas siang) hingga pukul 13:00 (satu siang).', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '2.  Waktu istirahat pada hari Jumat ditetapkan selama 1,5 (satu koma lima) jam, yaitu', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '     pada pukul 11:30 (sebelas tiga puluh siang) hingga pukul 13:00 (satu siang).', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 6', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'UPAH DAN PEMBAYARAN', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(57, 5, 'akan memberikan upah sebesar ', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(70, 5, 'Rp.203.824,- (dua ratus tiga ribu ', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(60, 5, 'delapan ratus dua puluh empat) ', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(50, 5, 'rupiah setiap hari kehadiran', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 5, 'PIHAK KEDUA.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Pembayaran  upah  akan  dibayarkan kurang lebih  14  (empatbelas) hari  kerja setelah masa ', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'kontrak kerja berakhir.', 0, 0, 'L');


            $pdf->Ln(100);

            $pdf->Ln(50);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, '', 0, 0, 'C');


            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 7', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'LEMBUR', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(140, 6, 'diharuskan masuk kerja lembur jika tersedia pekerjaan yang harus segera', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(140, 6, 'diselesaikan atau bersifat mendesak (URGENT).', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(77, 6, 'Sebagai imbalan kerja lembur sesuai ayat 1,', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(33, 6, 'PIHAK PERTAMA ', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(28, 6, 'akan membayar', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 6, ' PIHAK KEDUA', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(16, 6, 'sebesar', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(118, 6, 'Rp.24.455,- (dua puluh empat ribu empat ratus lima puluh lima)', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(40, 6, 'rupiah / jam lembur.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 3', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(150, 6, 'Pembayaran upah lembur akan di satukan dengan pembayaran upah yang akan diterima', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(105, 6, 'sesuai Pasal 6 ayat 2 perjanjian ini.', 0, 0, 'L');

            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 8', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'BERAKHIRNYA PERJANJIAN', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(80, 6, 'Setiap saat hubungan kerja dapat diakhiri jika', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(30, 6, 'PIHAK KEDUA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(50, 6, 'melanggar tata tertib, peraturan,', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(85, 6, 'dan sistem kerja yang berlaku pada perusahaan', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 6, 'PIHAK PERTAMA.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(80, 6, 'Pelanggaran yang dimaksud pada ayat 1 tersebut diatas, adalah :', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '1.   Tidak masuk kerja selama 1 (satu) hari kerja tanpa keterangan tertulis atau alasan sah', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '      yang dapat dibenarkan oleh atasan atau pihak perusahaan.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '2.   Melakukan tindak penipuan, pencurian, penggelapan, atau tindak-tindak melawan', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '      hukum lainnya.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '3.   Menyalahgunakan wewenang dan jabatan untuk kepentingan pribadi.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(125, 5, '4.   Melakukan perusakan dengan sengaja yang menimbulkan kerugian ', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 5, 'PIHAK PERTAMA.', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(125, 5, '5.   Melakukan hal-hal lain karena kecerobohannya yang mengakibatkan', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');
            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '      mengalami kerugian.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '6.   Melakukan perjudian di tempat kerja.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '7.   Mabuk-mabukan atau mengkonsumsi narkotika dan obat-obatan terlarang di lingkungan', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '      kerja perusahaan.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '8.   Melakukan keributan atau keonaran yang mengganggu suasana kerja di lingkungan kerja', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '      perusahaan.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '9.   Melakukan perkelahian atau penganiayaan terhadap pekerja lain.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(29);
            $pdf->Cell(160, 5, '10.  Menghasut para pekerja lain untuk melakukan mogok kerja.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(29);
            $pdf->Cell(160, 5, '11.  Merokok ditempat kerja atau membawa rokok dan korek api dalam lingkungan kerja.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(29);
            $pdf->Cell(160, 5, '12.  Masuk jam kerja tidak tepat waktu selama 2 (dua) kali.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(29);
            $pdf->Cell(160, 5, '13.  Tidak menggunakan alat keselamatan kerja yang sudah ditetapkan.', 0, 0, 'L');

            $pdf->Ln();
            $pdf->Cell(29);
            $pdf->Cell(160, 5, '14.  Tidak menggunakan alat keselamatan dalam berkendara baik berangkat maupun pulang', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(30);
            $pdf->Cell(160, 5, '      kerja.', 0, 0, 'L');

            $pdf->Ln(100);

            $pdf->Ln(50);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, '', 0, 0, 'C');


            $pdf->Ln(20);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 9', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'KEADAAN DARURAT (FORCE MAJEUR)', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Perjanjian kerja ini batal dengan sendirinya jika karena keadaan atau situasi yang memaksa,', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Seperti : Bencana Alam, Pemberontakan, Perang, Huru-hara, Kerusuhan, Peraturan Pemerintah', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'atau apapun.', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 10', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PENYELESAIAN PERSELISIHAN', 0, 0, 'C');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 1', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Apabila terjadi perselisihan antara kedua belah pihak, akan diselesaikan secara musyawarah ', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'untuk mencapai mufakat.', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln(10);
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Ayat 2', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Apabila dengan cara ayat 1 pasal ini tidak tercapai kata sepakat, maka kedua belah pihak sepakat', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'untuk menyelesaikan permasalahan tersebut dilakukan melalui prosedur hukum.', 0, 0, 'L');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PASAL 11', 0, 0, 'C');

            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'PENUTUP', 0, 0, 'C');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Demikianlah perjanjian ini dibuat, disetujui, dan ditandatangani dalam rangkap dua, asli, dan ', 0, 0, 'L');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'tembusan bermaterai cukup dan berkekuatan hukum yang sama. Satu dipegang oleh', 0, 0, 'L');

            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Ln();
            $pdf->Cell(20);
            $pdf->Cell(35, 5, 'PIHAK PERTAMA', 0, 0, 'L');

            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(35, 5, 'dan lainnya untuk', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(35, 5, 'PIHAK KEDUA.', 0, 0, 'L');

            $pdf->Ln(30);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(20);
            $pdf->Cell(170, 5, 'Tangerang Selatan, ' . $tanggalawal . ' ' . bulan($bulanawal) . ' ' . $tahunawal, 0, 0, 'C');

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(50, 5, 'PIHAK PERTAMA', 0, 0, 'C');
            $pdf->Cell(70, 5, '', 0, 0, 'C');
            $pdf->Cell(50, 5, 'PIHAK KEDUA', 0, 0, 'C');

            $pdf->Ln(40);
            $pdf->SetFont('Arial', 'B', '11');
            $pdf->Cell(20);
            $pdf->Cell(50, 5, '( Rudiyanto )', 0, 0, 'C');
            $pdf->Cell(70, 5, '', 0, 0, 'C');
            $pdf->Cell(50, 5, '( ' . $magang['nama_magang'] . ' )', 0, 0, 'C');

            $pdf->Output();
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
