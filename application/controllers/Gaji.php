<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil model Gaji
        $this->load->model('gaji/Gaji_model', 'gaji');
        //Memanggil library validation
        $this->load->library('form_validation');
        //Memanggil library fpdf
        $this->load->library('pdf');
        //Memanggil Helper Login
        is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
    }

    //untuk mencari data gaji berdasarkan NIK Karyawan
    public function get_gajikaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan');
        $data = $this->gaji->get_gaji_bynik($nikkaryawan);
        echo json_encode($data);
    }

    //Menampilkan halaman awal cetak slip gaji
    public function slipgaji()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data Slip Gaji';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //menampilkan halaman Cetak Slip Gaji
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gaji/cetak_slipgaji', $data);
            $this->load->view('templates/footer');
        
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak slip gaji
    public function cetakslipgaji()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Slip Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data dari model Gaji
        $karyawan = $this->gaji->getKaryawanByNIK();

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai kerja
        $tanggal_mulai_kerja    = IndonesiaTgl($karyawan['tanggal_mulai_kerja']);
        $tanggalmulaikerja      = substr($tanggal_mulai_kerja, 0, -8);
        $bulankerja             = substr($tanggal_mulai_kerja, 3, -5);
        $tahunkerja             = substr($tanggal_mulai_kerja, -4);


        //Mengambil Data Dari Inputan
        $nikkaryawan            = $this->input->post('nik_karyawan', true);
        $tanggalawal            = $this->input->post('tanggal_awal', true);
        $tanggalakhir            = $this->input->post('tanggal_akhir', true);

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai kerja
        $tanggal_awal            = IndonesiaTgl($tanggalawal);
        $periodeawaltanggal           = substr($tanggal_awal, 0, -8);
        $periodeawalbulan             = substr($tanggal_awal, 3, -5);
        $periodeawaltahun             = substr($tanggal_awal, -4);

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai kerja
        $tanggal_akhir            = IndonesiaTgl($tanggalakhir);
        $periodeakhirtanggal           = substr($tanggal_akhir, 0, -8);
        $periodeakhirbulan             = substr($tanggal_akhir, 3, -5);
        $periodeakhirtahun             = substr($tanggal_akhir, -4);

        $pdf = new FPDF('L', 'cm', array(21, 14));
        $pdf->setTopMargin(0.2);
        $pdf->setLeftMargin(0.6);
        $pdf->AddPage();

        $pdf->Ln(0.3);

        $pdf->SetFont('Arial', 'B', '8');
        $pdf->Cell(0.1);
        $pdf->Cell(10, 1, "PT Prima Komponen Indonesia", 0, 0, 'L');
        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(10, 1, "Jl.Kawasan Industri Taman Tekno, Blok F2. No.10-11", 0, 0, 'L');
        $pdf->Ln(0.4);
        $pdf->Cell(0.1);
        $pdf->Cell(10, 1, "BSD City, Tangerang Selatan. 15314.", 0, 0, 'L');

        $pdf->SetFont('Arial', 'B', '10');
        $pdf->Ln(0.3);
        $pdf->Cell(22, 1, "Bukti Tanda Terima Slip Gaji", 0, 0, 'C');
        $pdf->SetFont('Arial', '', '10');
        $pdf->Ln(0.4);
        $pdf->Cell(22, 1, "Periode " . bulan($periodeawalbulan) . " " . $periodeawaltahun . "", 0, 0, 'C');
        $pdf->Ln(0.4);
        $pdf->Cell(22, 1, "------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'C');
        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(3, 1, "Nama ", 0, 0, 'L');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(5, 1, $karyawan['nama_karyawan'], 0, 0, 'L');

        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(3, 1, "Tanggal Mulai Kerja ", 0, 0, 'L');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(5, 1, $tanggalmulaikerja . ' ' . bulan($bulankerja) . ' ' . $tahunkerja . '', 0, 0, 'L');

        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(3, 1, "Jabatan ", 0, 0, 'L');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(5, 1, $karyawan['jabatan'] . " / " . $karyawan['penempatan'] . "", 0, 0, 'L');

        $pdf->SetFont('Arial', '', '9');
        $pdf->Ln(0.4);
        $pdf->Cell(22, 1, "--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'C');
        $pdf->Ln(0.4);

        $pdf->SetFont('Arial', 'BI', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(5.4, 1, "Jumlah Upah ", 0, 0, 'L');
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $pdf->Cell(1.7, 1, format_angka($karyawan['jumlah_upah']), 0, 0, 'R');
        $pdf->SetFont('Arial', 'I', '9');
        $pdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $pdf->Ln(0.6);
        $pdf->SetFont('Arial', 'BI', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(3, 1, "Potongan ", 0, 0, 'L');

        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(5.4, 1, "Iuran BPJS Ketenagakerjaan(JHT) 2%", 0, 0, 'L');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $pdf->Cell(1.7, 1, format_angka($karyawan['potongan_jht']), 0, 0, 'R');
        $pdf->SetFont('Arial', 'I', '9');
        $pdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(5.4, 1, "Iuran BPJS Ketenagakerjaan(JP) 1%", 0, 0, 'L');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $pdf->Cell(1.7, 1, format_angka($karyawan['potongan_jp']), 0, 0, 'R');
        $pdf->SetFont('Arial', 'I', '9');
        $pdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(5.4, 1, "Iuran BPJS Kesehatan 1%", 0, 0, 'L');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $pdf->Cell(1.7, 1, format_angka($karyawan['potongan_jkn']), 0, 0, 'R');
        $pdf->SetFont('Arial', 'I', '9');
        $pdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $pdf->Ln(0.2);
        $pdf->Cell(22, 1, "--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------", 0, 0, 'C');
        $pdf->Ln(0.4);

        $pdf->SetFont('Arial', 'BI', '9');
        $pdf->Cell(0.1);
        $pdf->Cell(5.4, 1, "Jumlah Upah Yang Diterima ", 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(0.6, 1, " : ", 0, 0, 'L');
        $pdf->Cell(0.5, 1, "Rp.", 0, 0, 'L');
        $pdf->Cell(1.8, 1, format_angka($karyawan['total_gaji']), 0, 0, 'R');
        $pdf->SetFont('Arial', 'BI', '9');
        $pdf->Cell(1.5, 1, "Perbulan", 0, 0, 'L');

        $pdf->Ln(0.6);
        $pdf->SetFont('Arial', 'BI', '8');
        $pdf->Cell(0.1);
        $pdf->Cell(1.8, 1, "Tangerang Selatan, " . bulan($periodeawalbulan) . " " . $periodeawaltahun . "", 0, 0, 'L');

        $pdf->Ln(0.4);
        $pdf->SetFont('Arial', 'B', '8');
        $pdf->Cell(0.1);
        $pdf->Cell(1.8, 1, "Mengetahui", 0, 0, 'L');
        $pdf->Cell(11.5);
        $pdf->Cell(1.8, 1, "Menerima", 0, 0, 'C');

        $pdf->Ln(2.5);
        $pdf->Cell(0.1);
        $pdf->Cell(1.8, 1, "Rudiyanto", 0, 0, 'L');
        $pdf->Cell(11.5);
        $pdf->Cell(1.8, 1, $karyawan['nama_karyawan'], 0, 0, 'C');

        $pdf->Ln(0.4);
        $pdf->Cell(0.1);
        $pdf->Cell(1.8, 1, "( Manager HRD - GA )", 0, 0, 'L');
        $pdf->Cell(11.5);
        $pdf->Cell(1.8, 1, "( " . $karyawan['jabatan'] . " " .  $karyawan['penempatan'] . " )", 0, 0, 'C');
        $pdf->Output();

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal Rekonsiliasi Data Gaji
    public function rekonsiliasigaji()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Rekonsiliasi Data Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Rekonsiliasi Data Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/rekonsiliasi_gaji', $data);
        $this->load->view('templates/footer');

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }

    }

    //Menampilkan halaman awal Rekonsiliasi Data Gaji
    public function tampilrekonsiliasigaji()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Rekonsiliasi Data Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Query Tampil Data Rekon
        $data['rekon'] = $this->gaji->getRekonsiliasiDataGaji();

        //menampilkan halaman Rekonsiliasi Data Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/tampil_rekonsiliasi_gaji', $data);
        $this->load->view('templates/footer');

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Melakukan Rekonsiliasi Data Gaji
    public function prosesdatarekonsiliasigaji($mulai_tanggal, $sampai_tanggal)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil Method Rekon Pada Model
        $rekon    = $this->gaji->RekonsiliasiDataGaji();

        //Melakukan Insert Pada Table History Gaji
        $result = array();
        foreach ($rekon as $key => $val) {
            $result[] = array(
                "karyawan_id_history"                   => $val['karyawan_id_master'],
                "periode_awal_gaji_history"             => $mulai_tanggal,
                "periode_akhir_gaji_history"            => $sampai_tanggal,
                "gaji_pokok_history"                    => $val['gaji_pokok_master'],
                "upah_lembur_perjam_history"            => $val['upah_lembur_perjam_master'],
                "uang_makan_history"                    => $val['uang_makan_master'],
                "uang_transport_history"                => $val['uang_transport_master'],
                "tunjangan_tugas_history"               => $val['tunjangan_tugas_master'],
                "tunjangan_pulsa_history"               => $val['tunjangan_pulsa_master'],
                "jumlah_upah_history"                   => $val['jumlah_upah_master'],
                "potongan_bpjsks_perusahaan_history"    => $val['potongan_bpjsks_perusahaan_master'],
                "potongan_bpjsks_karyawan_history"      => $val['potongan_bpjsks_karyawan_master'],
                "potongan_jht_karyawan_history"         => $val['potongan_jht_karyawan_master'],
                "potongan_jp_karyawan_history"          => $val['potongan_jp_karyawan_master'],
                "jumlah_bpjstk_karyawan_history"        => $val['jumlah_bpjstk_karyawan_master'],
                "potongan_jht_perusahaan_history"       => $val['potongan_jht_perusahaan_master'],
                "potongan_jp_perusahaan_history"        => $val['potongan_jp_perusahaan_master'],
                "potongan_jkk_perusahaan_history"       => $val['potongan_jkk_perusahaan_master'],
                "potongan_jkm_perusahaan_history"       => $val['potongan_jkm_perusahaan_master'],
                "jumlah_bpjstk_perusahaan_history"      => $val['jumlah_bpjstk_perusahaan_master'],
                "take_home_pay_history"                 => $val['take_home_pay_master']
            );
        }

        $this->db->insert_batch('history_gaji', $result);
        $this->db->trans_complete();

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil Diproses</div>');
        //dan mendirect kehalaman rekon
        redirect('gaji/rekonsiliasigaji/');

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Cancel Proses Rekon
    public function canceldatarekonsiliasigaji($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Menghapus Data Berdasarkan Tanggal Rekon
        $this->db->delete('history_gaji', [
            'periode_awal_gaji_history'     => $mulai_tanggal,
            'periode_akhir_gaji_history'    => $sampai_tanggal
        ]);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil Diproses</div>');
        //dan mendirect kehalaman rekon
        redirect('gaji/rekonsiliasigaji/');

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    // Download Data Rekon Prima
    public function downloadrekonsiliasigajiprima()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekonsiliasi Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan Description awal file excel
        $excel->getProperties()->setCreator('Vhierman Sach')
            ->setLastModifiedBy('Vhierman Sach')
            ->setTitle("Data Rekonsiliasi Gaji Prima")
            ->setSubject("Rekonsiliasi Gaji Prima")
            ->setDescription("Laporan Data Rekonsiliasi Gaji Prima")
            ->setKeywords("Data Rekonsiliasi Gaji Prima");

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

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA REKONSILIASI GAJI");

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
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL MULAI KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "STATUS KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "GAJI POKOK");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "UANG MAKAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "UANG TRANSPORT");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "TUNJANGAN TUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "TUNJANGAN PULSA");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "JUMLAH UPAH");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "UPAH LEMBUR PERJAM");
        $excel->setActiveSheetIndex(0)->setCellValue('P6', "JHT BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "JP BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('R6', "JKN BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('S6', "JHT BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('T6', "JP BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('U6', "JKN BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('V6', "JKM BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('W6', "JKK BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('X6', "JUMLAH BPJSTK KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Y6', "JUMLAH BPJSTK PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Z6', "JUMLAH BPJSKS KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AA6', "JUMLAH BPJSKS PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AB6', "TAKE HOME PAY");

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
        $excel->getActiveSheet()->getStyle('W6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('X6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Y6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Z6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AA6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AB6')->applyFromArray($style_col);

        // Panggil function view yang ada di Model untuk menampilkan semua data
        $join = $this->gaji->DownloadDataGaji();

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    // Download Data Rekon Prima
    public function downloadrekonsiliasigajipetra()
    {
    }

    //Menampilkan halaman awal cetak REKAP gaji
    public function rekapgaji()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekap Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Rekap Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/rekap_gaji', $data);
        $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak REKAP gaji Prima Komponen Indonesia
    public function rekap_gaji_prima_komponen_indonesia()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Rekap Gaji Prima Komponen Indonesia';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Rekap Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/rekap_gaji_prima_komponen_indonesia', $data);
        $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak REKAP gaji Petra Ariesca
    public function rekap_gaji_petra_ariesca()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Rekap Gaji Petra Ariesca';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Rekap Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/rekap_gaji_petra_ariesca', $data);
        $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak REKAP gaji Prima Komponen Indonesia
    public function tampil_rekap_gaji_prima_komponen_indonesia()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Rekap Gaji Prima';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model Gaji
        $data['rekap'] = $this->gaji->getRekapGajiPrimaKomponenIndonesia();

        //Validation Form Input
        $this->form_validation->set_rules('mulai_tanggal', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('sampai_tanggal', 'Tanggal Akhir', 'required');

        //jika validasinya salah akan menampilkan halaman rekap gaji
        if ($this->form_validation->run() == false) {
            //menampilkan halaman Cetak Rekap Gaji
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gaji/rekap_gaji_prima_komponen_indonesia', $data);
            $this->load->view('templates/footer');
        } else {

            if ($data['rekap'] == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tersebut Belum Di Rekon ( Harap Di Rekonsiliasi Terlebih Dahulu )</div>');
                //dan mendirect kehalaman rekon
                redirect('gaji/rekap_gaji_prima_komponen_indonesia/');
            } else {
                //menampilkan halaman Cetak Rekap Gaji
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('gaji/tampil_rekap_gaji_prima_komponen_indonesia', $data);
                $this->load->view('templates/footer');
            }
        }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak REKAP gaji Petra Ariesca
    public function tampil_rekap_gaji_petra_ariesca()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Rekap Gaji Petra';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model Gaji
        $data['rekap'] = $this->gaji->getRekapGajiPetraAriesca();

        //Validation Form Input
        $this->form_validation->set_rules('mulai_tanggal', 'Tanggal Mulai', 'required');
        $this->form_validation->set_rules('sampai_tanggal', 'Tanggal Akhir', 'required');

        //jika validasinya salah akan menampilkan halaman rekap gaji
        if ($this->form_validation->run() == false) {
            //menampilkan halaman Cetak Rekap Gaji
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gaji/rekap_gaji_petra_ariesca', $data);
            $this->load->view('templates/footer');
        } else {

            if ($data['rekap'] == NULL) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tersebut Belum Di Rekon ( Harap Di Rekonsiliasi Terlebih Dahulu )</div>');
                //dan mendirect kehalaman rekon
                redirect('gaji/rekap_gaji_petra_ariesca/');
            } else {
                //menampilkan halaman Cetak Rekap Gaji
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('gaji/tampil_rekap_gaji_petra_ariesca', $data);
                $this->load->view('templates/footer');
            }
        }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    // Download Data Rekonsiliasi Prima
    public function downloadrekonsiliasigajiprimaexcell($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekonsiliasi Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan Description awal file excel
        $excel->getProperties()->setCreator('Vhierman Sach')
            ->setLastModifiedBy('Vhierman Sach')
            ->setTitle("Data Rekonsiliasi Gaji Prima")
            ->setSubject("Data Rekonsiliasi Gaji Prima")
            ->setDescription("Laporan Data Rekonsiliasi Gaji Prima")
            ->setKeywords("Data Rekonsiliasi Gaji Prima");

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

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA REKONSILIASI GAJI");

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
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL MULAI KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "STATUS KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "GAJI POKOK");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "UANG MAKAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "UANG TRANSPORT");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "TUNJANGAN TUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "TUNJANGAN PULSA");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "JUMLAH UPAH");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "UPAH LEMBUR PERJAM");
        $excel->setActiveSheetIndex(0)->setCellValue('P6', "JHT BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "JP BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('R6', "JKN BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('S6', "JHT BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('T6', "JP BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('U6', "JKN BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('V6', "JKM BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('W6', "JKK BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('X6', "JUMLAH BPJSTK KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Y6', "JUMLAH BPJSTK PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Z6', "JUMLAH BPJSKS KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AA6', "JUMLAH BPJSKS PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AB6', "TAKE HOME PAY");

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
        $excel->getActiveSheet()->getStyle('W6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('X6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Y6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Z6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AA6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AB6')->applyFromArray($style_col);


        // Panggil function view yang ada di Model untuk menampilkan semua data
        $join = $this->gaji->DownloadRekonGajiPrimaExcell($mulai_tanggal, $sampai_tanggal);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($join as $data) {

            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "'" . $data->nik_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jabatan);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->penempatan);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->tanggal_mulai_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->status_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->gaji_pokok_master);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->uang_makan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->uang_transport_master);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->tunjangan_tugas_master);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->tunjangan_pulsa_master);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->jumlah_upah_master);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->upah_lembur_perjam_master);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->potongan_jht_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->potongan_jp_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->potongan_bpjsks_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->potongan_jht_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->potongan_jp_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->potongan_bpjsks_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->potongan_jkm_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data->potongan_jkk_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, $data->jumlah_bpjstk_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data->jumlah_bpjstk_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data->potongan_bpjsks_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data->potongan_bpjsks_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data->take_home_pay_master);

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
            $excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);

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
        $excel->getActiveSheet()->getColumnDimension('W')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('X')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30); // Set width kolom 

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul Sheet excel nya
        $excel->getActiveSheet(0)->setTitle("Data Rekonsiliasi Gaji");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekap Gaji Karyawan Prima.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    // Download Data Rekonsiliasi Petra
    public function downloadrekonsiliasigajipetraexcell($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekonsiliasi Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan Description awal file excel
        $excel->getProperties()->setCreator('Vhierman Sach')
            ->setLastModifiedBy('Vhierman Sach')
            ->setTitle("Data Rekonsiliasi Gaji Petra")
            ->setSubject("Data Rekonsiliasi Gaji Petra")
            ->setDescription("Laporan Data Rekonsiliasi Gaji Petra")
            ->setKeywords("Data Rekonsiliasi Gaji Petra");

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

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA REKONSILIASI GAJI");

        $excel->getActiveSheet()->mergeCells('B2:H2'); // Set Merge Cell 
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE); // Set bold
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16); // Set font size
        $excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set text center 

        $excel->setActiveSheetIndex(0)->setCellValue('B3', "PT PETRA ARIESCA");
        // Set kolom B2 dengan tulisan "PT PETRA ARIESCA"

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
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL MULAI KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "STATUS KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "GAJI POKOK");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "UANG MAKAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "UANG TRANSPORT");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "TUNJANGAN TUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "TUNJANGAN PULSA");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "JUMLAH UPAH");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "UPAH LEMBUR PERJAM");
        $excel->setActiveSheetIndex(0)->setCellValue('P6', "JHT BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "JP BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('R6', "JKN BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('S6', "JHT BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('T6', "JP BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('U6', "JKN BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('V6', "JKM BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('W6', "JKK BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('X6', "JUMLAH BPJSTK KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Y6', "JUMLAH BPJSTK PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Z6', "JUMLAH BPJSKS KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AA6', "JUMLAH BPJSKS PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AB6', "TAKE HOME PAY");

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
        $excel->getActiveSheet()->getStyle('W6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('X6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Y6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Z6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AA6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AB6')->applyFromArray($style_col);


        // Panggil function view yang ada di Model untuk menampilkan semua data
        $join = $this->gaji->DownloadRekonGajiPetraExcell($mulai_tanggal, $sampai_tanggal);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($join as $data) {

            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "'" . $data->nik_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jabatan);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->penempatan);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->tanggal_mulai_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->status_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->gaji_pokok_master);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->uang_makan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->uang_transport_master);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->tunjangan_tugas_master);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->tunjangan_pulsa_master);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->jumlah_upah_master);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->upah_lembur_perjam_master);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->potongan_jht_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->potongan_jp_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->potongan_bpjsks_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->potongan_jht_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->potongan_jp_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->potongan_bpjsks_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->potongan_jkm_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data->potongan_jkk_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, $data->jumlah_bpjstk_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data->jumlah_bpjstk_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data->potongan_bpjsks_karyawan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data->potongan_bpjsks_perusahaan_master);
            $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data->take_home_pay_master);

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
            $excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);

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
        $excel->getActiveSheet()->getColumnDimension('W')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('X')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30); // Set width kolom 

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul Sheet excel nya
        $excel->getActiveSheet(0)->setTitle("Data Rekonsiliasi Gaji");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekap Gaji Karyawan Petra.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    // Download Data Rekap Prima
    public function downloadrekapgajiprimaexcell($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekap Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan Description awal file excel
        $excel->getProperties()->setCreator('Vhierman Sach')
            ->setLastModifiedBy('Vhierman Sach')
            ->setTitle("Data Rekap Gaji Prima")
            ->setSubject("Data Rekap Gaji Prima")
            ->setDescription("Laporan Data Rekap Gaji Prima")
            ->setKeywords("Data Rekap Gaji Prima");

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

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA REKAP GAJI");

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
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL MULAI KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "STATUS KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "GAJI POKOK");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "UANG MAKAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "UANG TRANSPORT");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "TUNJANGAN TUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "TUNJANGAN PULSA");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "JUMLAH UPAH");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "UPAH LEMBUR PERJAM");
        $excel->setActiveSheetIndex(0)->setCellValue('P6', "JHT BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "JP BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('R6', "JKN BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('S6', "JHT BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('T6', "JP BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('U6', "JKN BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('V6', "JKM BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('W6', "JKK BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('X6', "JUMLAH BPJSTK KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Y6', "JUMLAH BPJSTK PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Z6', "JUMLAH BPJSKS KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AA6', "JUMLAH BPJSKS PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AB6', "TAKE HOME PAY");

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
        $excel->getActiveSheet()->getStyle('W6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('X6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Y6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Z6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AA6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AB6')->applyFromArray($style_col);


        // Panggil function view yang ada di Model untuk menampilkan semua data
        $join = $this->gaji->DownloadRekapGajiPrimaExcell($mulai_tanggal, $sampai_tanggal);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($join as $data) {

            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "'" . $data->nik_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jabatan);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->penempatan);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->tanggal_mulai_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->status_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->gaji_pokok_history);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->uang_makan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->uang_transport_history);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->tunjangan_tugas_history);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->tunjangan_pulsa_history);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->jumlah_upah_history);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->upah_lembur_perjam_history);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->potongan_jht_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->potongan_jp_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->potongan_bpjsks_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->potongan_jht_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->potongan_jp_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->potongan_bpjsks_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->potongan_jkm_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data->potongan_jkk_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, $data->jumlah_bpjstk_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data->jumlah_bpjstk_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data->potongan_bpjsks_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data->potongan_bpjsks_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data->take_home_pay_history);

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
            $excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);

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
        $excel->getActiveSheet()->getColumnDimension('W')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('X')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30); // Set width kolom 

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul Sheet excel nya
        $excel->getActiveSheet(0)->setTitle("Data Rekap Gaji");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekap Gaji Karyawan Prima.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    // Download Data Rekap Petra
    public function downloadrekapgajipetraexcell($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekap Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan Description awal file excel
        $excel->getProperties()->setCreator('Vhierman Sach')
            ->setLastModifiedBy('Vhierman Sach')
            ->setTitle("Data Rekap Gaji Petra")
            ->setSubject("Data Rekap Gaji Petra")
            ->setDescription("Laporan Data Rekap Gaji Petra")
            ->setKeywords("Data Rekap Gaji Petra");

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

        $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA REKAP GAJI");

        $excel->getActiveSheet()->mergeCells('B2:H2'); // Set Merge Cell 
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE); // Set bold
        $excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16); // Set font size
        $excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set text center 

        $excel->setActiveSheetIndex(0)->setCellValue('B3', "PT PETRA ARIESCA");
        // Set kolom B2 dengan tulisan "PT PETRA ARIESCA"

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
        $excel->setActiveSheetIndex(0)->setCellValue('G6', "TANGGAL MULAI KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('H6', "STATUS KERJA");
        $excel->setActiveSheetIndex(0)->setCellValue('I6', "GAJI POKOK");
        $excel->setActiveSheetIndex(0)->setCellValue('J6', "UANG MAKAN");
        $excel->setActiveSheetIndex(0)->setCellValue('K6', "UANG TRANSPORT");
        $excel->setActiveSheetIndex(0)->setCellValue('L6', "TUNJANGAN TUGAS");
        $excel->setActiveSheetIndex(0)->setCellValue('M6', "TUNJANGAN PULSA");
        $excel->setActiveSheetIndex(0)->setCellValue('N6', "JUMLAH UPAH");
        $excel->setActiveSheetIndex(0)->setCellValue('O6', "UPAH LEMBUR PERJAM");
        $excel->setActiveSheetIndex(0)->setCellValue('P6', "JHT BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Q6', "JP BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('R6', "JKN BEBAN KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('S6', "JHT BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('T6', "JP BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('U6', "JKN BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('V6', "JKM BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('W6', "JKK BEBAN PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('X6', "JUMLAH BPJSTK KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Y6', "JUMLAH BPJSTK PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('Z6', "JUMLAH BPJSKS KARYAWAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AA6', "JUMLAH BPJSKS PERUSAHAAN");
        $excel->setActiveSheetIndex(0)->setCellValue('AB6', "TAKE HOME PAY");

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
        $excel->getActiveSheet()->getStyle('W6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('X6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Y6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Z6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AA6')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('AB6')->applyFromArray($style_col);


        // Panggil function view yang ada di Model untuk menampilkan semua data
        $join = $this->gaji->DownloadRekapGajiPetraExcell($mulai_tanggal, $sampai_tanggal);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($join as $data) {

            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, "'" . $data->nik_karyawan);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->jabatan);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->penempatan);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->tanggal_mulai_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->status_kerja);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->gaji_pokok_history);
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->uang_makan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->uang_transport_history);
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->tunjangan_tugas_history);
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->tunjangan_pulsa_history);
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->jumlah_upah_history);
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->upah_lembur_perjam_history);
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->potongan_jht_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->potongan_jp_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, $data->potongan_bpjsks_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, $data->potongan_jht_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->potongan_jp_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->potongan_bpjsks_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->potongan_jkm_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, $data->potongan_jkk_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, $data->jumlah_bpjstk_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data->jumlah_bpjstk_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data->potongan_bpjsks_karyawan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data->potongan_bpjsks_perusahaan_history);
            $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data->take_home_pay_history);

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
            $excel->getActiveSheet()->getStyle('W' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('X' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Y' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Z' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AA' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('AB' . $numrow)->applyFromArray($style_row);

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
        $excel->getActiveSheet()->getColumnDimension('W')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('X')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(30); // Set width kolom 
        $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(30); // Set width kolom 

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(25);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul Sheet excel nya
        $excel->getActiveSheet(0)->setTitle("Data Rekap Gaji");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekap Gaji Karyawan Petra.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak REKAP gaji Prima Komponen Indonesia
    public function downloadrekapgajiprimapdf($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Rekap Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model Gaji
        $rekap = $this->gaji->DownloadRekapGajiPrimaPDF($mulai_tanggal, $sampai_tanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai
        $mulaitanggal           = IndonesiaTgl($mulai_tanggal);
        $tanggalmulai           = substr($mulaitanggal, 0, -8);
        $bulanmulai             = substr($mulaitanggal, 3, -5);
        $tahunmulai             = substr($mulaitanggal, -4);

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal sampai
        $sampaitanggal           = IndonesiaTgl($sampai_tanggal);
        $tanggalsampai           = substr($sampaitanggal, 0, -8);
        $bulansampai             = substr($sampaitanggal, 3, -5);
        $tahunsampai             = substr($sampaitanggal, -4);



        $pdf = new FPDF('L', 'mm', 'legal');
        $pdf->AddPage();

        $pdf->Cell(-8);
        $pdf->SetFont('Arial', 'BI', '8');
        $pdf->Cell(200, 7, 'PT PRIMA KOMPONEN INDONESIA', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(-8);
        $pdf->Cell(200, 7, 'Kawasan Industri Taman Tekno, Tangerang Selatan', 0, 0, 'L');

        $pdf->Ln(5);
        $pdf->Cell(68);
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->Cell(200, 10, 'DAFTAR REKAP GAJI KARYAWAN', 0, 0, 'C');

        $pdf->Ln(7);
        $pdf->Cell(68);
        $pdf->Cell(200, 10, 'PT Prima Komponen Indonesia', 0, 0, 'C');

        $pdf->Ln(7);

        $pdf->Cell(68);
        $pdf->Cell(200, 10, 'Periode ' . $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalsampai . ' ' . bulan($bulansampai) . ' ' . $tahunsampai . '', 0, 0, 'C');
        $pdf->Ln(10);

        $pdf->Cell(-7);
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $pdf->Cell(26, 10, 'No.Rekening', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Gaji Pokok', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Uang Makan', 1, 0, 'C', 1);
        $pdf->Cell(26, 10, 'Uang Transport', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Jumlah Upah', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Tunj Tugas', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Tunj Pulsa', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'BPJS Kes', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'BPJSTK JHT', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'BPJSTK JP', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Tot Gaji', 1, 0, 'C', 1);

        $no = 1;
        $total_gaji_pokok = 0;
        $total_uang_makan = 0;
        $total_uang_transport = 0;
        $total_tunjangan_tugas = 0;
        $total_tunjangan_pulsa = 0;
        $total_jumlah_upah = 0;
        $total_potongan_jkn = 0;
        $total_potongan_jht = 0;
        $total_potongan_jp = 0;
        $total_total_gaji = 0;

        foreach ($rekap as $rkp) :
            $pdf->Ln();
            $pdf->Cell(-7);
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(10, 8, $no, 1, 0, 'C');
            $pdf->Cell(55, 8, $rkp['nama_karyawan'], 1, 0, 'L');
            $pdf->Cell(26, 8, $rkp['nomor_rekening'], 1, 0, 'C');

            $pdf->Cell(25, 8, format_angka($rkp['gaji_pokok_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['uang_makan_history']), 1, 0, 'C');
            $pdf->Cell(26, 8, format_angka($rkp['uang_transport_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['jumlah_upah_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['tunjangan_tugas_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['tunjangan_pulsa_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['potongan_bpjsks_karyawan_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['potongan_jht_karyawan_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['potongan_jp_karyawan_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['take_home_pay_history']), 1, 0, 'C');
            $no++;

            $total_gaji_pokok += $rkp['gaji_pokok_history'];
            $total_uang_makan += $rkp['uang_makan_history'];
            $total_uang_transport += $rkp['uang_transport_history'];
            $total_jumlah_upah += $rkp['jumlah_upah_history'];
            $total_tunjangan_tugas += $rkp['tunjangan_tugas_history'];
            $total_tunjangan_pulsa += $rkp['tunjangan_pulsa_history'];
            $total_potongan_jkn += $rkp['potongan_bpjsks_karyawan_history'];
            $total_potongan_jht += $rkp['potongan_jht_karyawan_history'];
            $total_potongan_jp += $rkp['potongan_jp_karyawan_history'];
            $total_total_gaji += $rkp['take_home_pay_history'];

        endforeach;

        $pdf->Ln();
        $pdf->Cell(-7);
        $pdf->SetFont('Arial', 'BI', '9');
        $pdf->Cell(91, 8, 'Jumlah', 1, 0, 'R');
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(25, 8, format_angka($total_gaji_pokok), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_uang_makan), 1, 0, 'C');
        $pdf->Cell(26, 8, format_angka($total_uang_transport), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_jumlah_upah), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_tunjangan_tugas), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_tunjangan_pulsa), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_potongan_jkn), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_potongan_jht), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_potongan_jp), 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(25, 8, format_angka($total_total_gaji), 1, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', '12');
        $pdf->Ln(20);
        $pdf->Cell(10);
        $pdf->Cell(70, 0, 'Tangerang Selatan, ' . $tanggal . " " . bulan($bulan) . " " . $tahun, 0, 0, 'C');
        $pdf->Ln();

        $pdf->Cell(6);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(75, 10, 'Dibuat oleh.', 0, 0, 'C');

        $pdf->Cell(100);
        $pdf->Cell(50, 10, 'Mengetahui.', 0, 0, 'C');

        $pdf->Ln(25);
        $pdf->Cell(6);
        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(75, 10, 'Rudiyanto.', 0, 0, 'C');

        $pdf->Cell(100);
        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(50, 10, 'Mely Susan Gunawan.', 0, 0, 'C');


        $pdf->Ln();
        $pdf->Cell(6);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(75, 0, '( Manager HRD - GA )', 0, 0, 'C');
        $pdf->Cell(100);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(50, 0, '( Manager Accounting )', 0, 0, 'C');
        $pdf->Output();
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak REKAP gaji Prima Komponen Indonesia
    public function downloadrekapgajipetrapdf($mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Rekap Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model Gaji
        $rekap = $this->gaji->DownloadRekapGajiPetraPDF($mulai_tanggal, $sampai_tanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai
        $mulaitanggal           = IndonesiaTgl($mulai_tanggal);
        $tanggalmulai           = substr($mulaitanggal, 0, -8);
        $bulanmulai             = substr($mulaitanggal, 3, -5);
        $tahunmulai             = substr($mulaitanggal, -4);

        //Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal sampai
        $sampaitanggal           = IndonesiaTgl($sampai_tanggal);
        $tanggalsampai           = substr($sampaitanggal, 0, -8);
        $bulansampai             = substr($sampaitanggal, 3, -5);
        $tahunsampai             = substr($sampaitanggal, -4);



        $pdf = new FPDF('L', 'mm', 'legal');
        $pdf->AddPage();

        $pdf->Cell(-8);
        $pdf->SetFont('Arial', 'BI', '8');
        $pdf->Cell(200, 7, 'PT PRIMA KOMPONEN INDONESIA', 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(-8);
        $pdf->Cell(200, 7, 'Kawasan Industri Taman Tekno, Tangerang Selatan', 0, 0, 'L');

        $pdf->Ln(5);
        $pdf->Cell(68);
        $pdf->SetFont('Arial', 'B', '14');
        $pdf->Cell(200, 10, 'DAFTAR REKAP GAJI KARYAWAN', 0, 0, 'C');

        $pdf->Ln(7);
        $pdf->Cell(68);
        $pdf->Cell(200, 10, 'PT Prima Komponen Indonesia', 0, 0, 'C');

        $pdf->Ln(7);

        $pdf->Cell(68);
        $pdf->Cell(200, 10, 'Periode ' . $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalsampai . ' ' . bulan($bulansampai) . ' ' . $tahunsampai . '', 0, 0, 'C');
        $pdf->Ln(10);

        $pdf->Cell(-7);
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $pdf->Cell(26, 10, 'No.Rekening', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Gaji Pokok', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Uang Makan', 1, 0, 'C', 1);
        $pdf->Cell(26, 10, 'Uang Transport', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Jumlah Upah', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Tunj Tugas', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Tunj Pulsa', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'BPJS Kes', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'BPJSTK JHT', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'BPJSTK JP', 1, 0, 'C', 1);
        $pdf->Cell(25, 10, 'Tot Gaji', 1, 0, 'C', 1);

        $no = 1;
        $total_gaji_pokok = 0;
        $total_uang_makan = 0;
        $total_uang_transport = 0;
        $total_tunjangan_tugas = 0;
        $total_tunjangan_pulsa = 0;
        $total_jumlah_upah = 0;
        $total_potongan_jkn = 0;
        $total_potongan_jht = 0;
        $total_potongan_jp = 0;
        $total_total_gaji = 0;

        foreach ($rekap as $rkp) :
            $pdf->Ln();
            $pdf->Cell(-7);
            $pdf->SetFont('Arial', '', '9');
            $pdf->Cell(10, 8, $no, 1, 0, 'C');
            $pdf->Cell(55, 8, $rkp['nama_karyawan'], 1, 0, 'L');
            $pdf->Cell(26, 8, $rkp['nomor_rekening'], 1, 0, 'C');

            $pdf->Cell(25, 8, format_angka($rkp['gaji_pokok_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['uang_makan_history']), 1, 0, 'C');
            $pdf->Cell(26, 8, format_angka($rkp['uang_transport_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['jumlah_upah_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['tunjangan_tugas_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['tunjangan_pulsa_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['potongan_bpjsks_karyawan_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['potongan_jht_karyawan_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['potongan_jp_karyawan_history']), 1, 0, 'C');
            $pdf->Cell(25, 8, format_angka($rkp['take_home_pay_history']), 1, 0, 'C');
            $no++;

            $total_gaji_pokok += $rkp['gaji_pokok_history'];
            $total_uang_makan += $rkp['uang_makan_history'];
            $total_uang_transport += $rkp['uang_transport_history'];
            $total_jumlah_upah += $rkp['jumlah_upah_history'];
            $total_tunjangan_tugas += $rkp['tunjangan_tugas_history'];
            $total_tunjangan_pulsa += $rkp['tunjangan_pulsa_history'];
            $total_potongan_jkn += $rkp['potongan_bpjsks_karyawan_history'];
            $total_potongan_jht += $rkp['potongan_jht_karyawan_history'];
            $total_potongan_jp += $rkp['potongan_jp_karyawan_history'];
            $total_total_gaji += $rkp['take_home_pay_history'];

        endforeach;

        $pdf->Ln();
        $pdf->Cell(-7);
        $pdf->SetFont('Arial', 'BI', '9');
        $pdf->Cell(91, 8, 'Jumlah', 1, 0, 'R');
        $pdf->SetFont('Arial', '', '9');
        $pdf->Cell(25, 8, format_angka($total_gaji_pokok), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_uang_makan), 1, 0, 'C');
        $pdf->Cell(26, 8, format_angka($total_uang_transport), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_jumlah_upah), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_tunjangan_tugas), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_tunjangan_pulsa), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_potongan_jkn), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_potongan_jht), 1, 0, 'C');
        $pdf->Cell(25, 8, format_angka($total_potongan_jp), 1, 0, 'C');
        $pdf->SetFont('Arial', 'B', '9');
        $pdf->Cell(25, 8, format_angka($total_total_gaji), 1, 0, 'C');

        $pdf->Ln(10);
        $pdf->SetFont('Arial', '', '12');
        $pdf->Ln(20);
        $pdf->Cell(10);
        $pdf->Cell(70, 0, 'Tangerang Selatan, ' . $tanggal . " " . bulan($bulan) . " " . $tahun, 0, 0, 'C');
        $pdf->Ln();

        $pdf->Cell(6);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(75, 10, 'Dibuat oleh.', 0, 0, 'C');

        $pdf->Cell(100);
        $pdf->Cell(50, 10, 'Mengetahui.', 0, 0, 'C');

        $pdf->Ln(25);
        $pdf->Cell(6);
        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(75, 10, 'Rudiyanto.', 0, 0, 'C');

        $pdf->Cell(100);
        $pdf->SetFont('Arial', 'BU', '12');
        $pdf->Cell(50, 10, 'Mely Susan Gunawan.', 0, 0, 'C');


        $pdf->Ln();
        $pdf->Cell(6);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(75, 0, '( Manager HRD - GA )', 0, 0, 'C');
        $pdf->Cell(100);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(50, 0, '( Manager Accounting )', 0, 0, 'C');
        $pdf->Output();
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal data update gaji
    public function updategaji()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Update Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data dari model Gaji
        $data['penempatan'] = $this->gaji->getPenempatan();
        //menampilkan halaman Update Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/form_update_gaji', $data);
        $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal data update gaji
    public function updategajikaryawan()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Update Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data karyawan
        $data['karyawan']           = $this->gaji->datakaryawan();

        //menampilkan halaman Update Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/update_gaji', $data);
        $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }


    //Melakukan update gaji
    public function hasilupdategajikaryawan()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Update Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Validation Form Input
        $this->form_validation->set_rules('gaji_pokok', 'Gaji Pokok', 'required');
        $this->form_validation->set_rules('uang_makan', 'Uang Makan', 'required');
        $this->form_validation->set_rules('uang_transport', ' Uang Transport', 'required');

        //jika validasinya salah akan menampilkan halaman lembur
        if ($this->form_validation->run() == false) {
            //menampilkan halaman Update Gaji
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gaji/update_gaji', $data);
            $this->load->view('templates/footer');
        }
        //
        else {

            //Query Untuk Mencari Rincian Potongan BPJS Kesehatan
            $this->db->select('*');
            $this->db->from('potongan_bpjs_kesehatan');
            $bpjsks = $this->db->get()->row_array();

            $databpjsks = [
                'potongan_bpjs_kesehatan_karyawan'      => $bpjsks['potongan_bpjs_kesehatan_karyawan'],
                'potongan_bpjs_kesehatan_perusahaan'    => $bpjsks['potongan_bpjs_kesehatan_perusahaan'],
                'maksimal_iuran_bpjs_kesehatan'         => $bpjsks['maksimal_iuran_bpjs_kesehatan']
            ];
            //End Untuk Mencari Rincian Potongan BPJS Kesehatan

            //Query Untuk Mencari Rincian Potongan BPJS Ketenagakerjaan
            $this->db->select('*');
            $this->db->from('potongan_bpjs_ketenagakerjaan');
            $bpjstk = $this->db->get()->row_array();

            $databpjstk = [
                'potongan_jht_karyawan'         => $bpjstk['potongan_jht_karyawan'],
                'potongan_jht_perusahaan'       => $bpjstk['potongan_jht_perusahaan'],
                'potongan_jp_karyawan'          => $bpjstk['potongan_jp_karyawan'],
                'potongan_jp_perusahaan'        => $bpjstk['potongan_jp_perusahaan'],
                'potongan_jkk_perusahaan'       => $bpjstk['potongan_jkk_perusahaan'],
                'potongan_jkm_perusahaan'       => $bpjstk['potongan_jkm_perusahaan'],
                'jumlah_potongan_karyawan'      => $bpjstk['jumlah_potongan_karyawan'],
                'jumlah_potongan_perusahaan'    => $bpjstk['jumlah_potongan_perusahaan'],
                'maksimal_iuran_jp'             => $bpjstk['maksimal_iuran_jp']
            ];
            //End Untuk Mencari Rincian Potongan BPJS Ketenagakerjaan

            //Mengambil variabel dari inputan
            $nikkaryawan        = $this->input->post('nik_karyawan', TRUE);
            $gajipokok          = $this->input->post('gaji_pokok', TRUE);
            $uangmakan          = $this->input->post('uang_makan', TRUE);
            $uangtransport      = $this->input->post('uang_transport', TRUE);
            $tunjangantugas     = $this->input->post('tunjangan_tugas', TRUE);
            $tunjanganpulsa     = $this->input->post('tunjangan_pulsa', TRUE);

            //Menghitung Jumlah Upah
            $jumlahupah         = $gajipokok + $uangmakan + $uangtransport + $tunjangantugas + $tunjanganpulsa;

            $jkn        = $this->input->post('jkn', TRUE);
            $jht        = $this->input->post('jht', TRUE);
            $jp         = $this->input->post('jp', TRUE);
            $jkk        = $this->input->post('jkk', TRUE);
            $jkm        = $this->input->post('jkm', TRUE);
            //

            //Checkbox BPJS
            //Jika Ikut Semua Kepesertaan BPJS Kesehatan Dan Ketenagakerjaan
            if ($jkn != null && $jht != null && $jp != null && $jkk != null && $jkm != null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = $databpjsks['potongan_bpjs_kesehatan_karyawan'];
                $potongan_bpjs_kesehatan_perusahaan = $databpjsks['potongan_bpjs_kesehatan_perusahaan'];
                $maksimal_iuran_bpjs_kesehatan      = $databpjsks['maksimal_iuran_bpjs_kesehatan'];
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = $databpjstk['potongan_jht_karyawan'];
                $potongan_jht_perusahaan            = $databpjstk['potongan_jht_perusahaan'];
                $potongan_jp_karyawan               = $databpjstk['potongan_jp_karyawan'];
                $potongan_jp_perusahaan             = $databpjstk['potongan_jp_perusahaan'];
                $potongan_jkk_perusahaan            = $databpjstk['potongan_jkk_perusahaan'];
                $potongan_jkm_perusahaan            = $databpjstk['potongan_jkm_perusahaan'];
                $jumlah_potongan_karyawan           = $databpjstk['jumlah_potongan_karyawan'];
                $jumlah_potongan_perusahaan         = $databpjstk['jumlah_potongan_perusahaan'];
                $maksimal_iuran_jp                  = $databpjstk['maksimal_iuran_jp'];

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //Jika Hanya Ikut Kepesertaan BPJS Kesehatan Saja
            elseif ($jkn != null && $jht == null && $jp == null && $jkk == null && $jkm == null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = $databpjsks['potongan_bpjs_kesehatan_karyawan'];
                $potongan_bpjs_kesehatan_perusahaan = $databpjsks['potongan_bpjs_kesehatan_perusahaan'];
                $maksimal_iuran_bpjs_kesehatan      = $databpjsks['maksimal_iuran_bpjs_kesehatan'];
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = 0;
                $potongan_jht_perusahaan            = 0;
                $potongan_jp_karyawan               = 0;
                $potongan_jp_perusahaan             = 0;
                $potongan_jkk_perusahaan            = 0;
                $potongan_jkm_perusahaan            = 0;
                $jumlah_potongan_karyawan           = 0;
                $jumlah_potongan_perusahaan         = 0;
                $maksimal_iuran_jp                  = 0;

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //Jika Hanya Ikut Kepesertaan BPJS Ketenagakerjaan Saja
            elseif ($jkn == null && $jht != null && $jp != null && $jkk != null && $jkm != null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = $databpjsks['potongan_bpjs_kesehatan_karyawan'];
                $potongan_bpjs_kesehatan_perusahaan = $databpjsks['potongan_bpjs_kesehatan_perusahaan'];
                $maksimal_iuran_bpjs_kesehatan      = $databpjsks['maksimal_iuran_bpjs_kesehatan'];
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = $databpjstk['potongan_jht_karyawan'];
                $potongan_jht_perusahaan            = $databpjstk['potongan_jht_perusahaan'];
                $potongan_jp_karyawan               = 0;
                $potongan_jp_perusahaan             = 0;
                $potongan_jkk_perusahaan            = $databpjstk['potongan_jkk_perusahaan'];
                $potongan_jkm_perusahaan            = $databpjstk['potongan_jkm_perusahaan'];
                $jumlah_potongan_karyawan           = $databpjstk['jumlah_potongan_karyawan'];
                $jumlah_potongan_perusahaan         = $databpjstk['jumlah_potongan_perusahaan'];
                $maksimal_iuran_jp                  = 0;

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //JIka tidak ikut kepsertaaan Jaminan Pensiun
            elseif ($jkn != null && $jht != null && $jp == null && $jkk != null && $jkm != null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = 0;
                $potongan_bpjs_kesehatan_perusahaan = 0;
                $maksimal_iuran_bpjs_kesehatan      = 0;
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = $databpjstk['potongan_jht_karyawan'];
                $potongan_jht_perusahaan            = $databpjstk['potongan_jht_perusahaan'];
                $potongan_jp_karyawan               = $databpjstk['potongan_jp_karyawan'];
                $potongan_jp_perusahaan             = $databpjstk['potongan_jp_perusahaan'];
                $potongan_jkk_perusahaan            = $databpjstk['potongan_jkk_perusahaan'];
                $potongan_jkm_perusahaan            = $databpjstk['potongan_jkm_perusahaan'];
                $jumlah_potongan_karyawan           = $databpjstk['jumlah_potongan_karyawan'];
                $jumlah_potongan_perusahaan         = $databpjstk['jumlah_potongan_perusahaan'];
                $maksimal_iuran_jp                  = $databpjstk['maksimal_iuran_jp'];

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //Jika tidak Ikut Semua Kepesertaan BPJS Kesehatan Dan BPJS Ketenagakerjaan
            else {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = 0;
                $potongan_bpjs_kesehatan_perusahaan = 0;
                $maksimal_iuran_bpjs_kesehatan      = 0;
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = 0;
                $potongan_jht_perusahaan            = 0;
                $potongan_jp_karyawan               = 0;
                $potongan_jp_perusahaan             = 0;
                $potongan_jkk_perusahaan            = 0;
                $potongan_jkm_perusahaan            = 0;
                $jumlah_potongan_karyawan           = 0;
                $jumlah_potongan_perusahaan         = 0;
                $maksimal_iuran_jp                  = 0;

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }


            //Menghitung Total Gaji
            $takehomepay            = $jumlahupah - $jumlahbpjstkbebankaryawan - $jknbebankaryawan;

            //Menghitung Upah Lembur Perjam
            $upahlemburperjam       = $jumlahupah / 173;

            //Mengirimkan data ke model
            $hasil = $this->gaji->updatedatagaji($nikkaryawan, $gajipokok, $uangmakan, $uangtransport, $tunjangantugas, $tunjanganpulsa, $jumlahupah, $upahlemburperjam, $jknbebankaryawan, $jknbebanperusahaan, $jhtbebankaryawan, $jhtbebanperusahaan, $jpbebankaryawan, $jpbebanperusahaan, $jkkbebanperusahaan, $jkmbebanperusahaan, $jumlahbpjstkbebankaryawan, $jumlahbpjstkbebanperusahaan, $takehomepay);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Gaji</div>');
            //dan mendirect kehalaman lembur
            redirect('gaji/updategaji');
        }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal data edit rekon gaji
    public function editrekongaji($id_history_gaji, $mulai_tanggal, $sampai_tanggal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Edit Rekon Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data edit rekon gaji
        $data['editrekongaji']           = $this->gaji->editRekonGaji($id_history_gaji, $mulai_tanggal, $sampai_tanggal);

        //menampilkan halaman Edit Rekon Gaji
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gaji/edit_rekon_gaji', $data);
        $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    public function hasileditrekongajikaryawan()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Edit Rekon Gaji';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Validation Form Input
        $this->form_validation->set_rules('gaji_pokok', 'Gaji Pokok', 'required');
        $this->form_validation->set_rules('uang_makan', 'Uang Makan', 'required');
        $this->form_validation->set_rules('uang_transport', ' Uang Transport', 'required');

        //jika validasinya salah akan menampilkan halaman lembur
        if ($this->form_validation->run() == false) {
            //menampilkan halaman Update Gaji
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('gaji/tampil_rekon_gaji', $data);
            $this->load->view('templates/footer');
        }
        //
        else {

            //Query Untuk Mencari Rincian Potongan BPJS Kesehatan
            $this->db->select('*');
            $this->db->from('potongan_bpjs_kesehatan');
            $bpjsks = $this->db->get()->row_array();

            $databpjsks = [
                'potongan_bpjs_kesehatan_karyawan'      => $bpjsks['potongan_bpjs_kesehatan_karyawan'],
                'potongan_bpjs_kesehatan_perusahaan'    => $bpjsks['potongan_bpjs_kesehatan_perusahaan'],
                'maksimal_iuran_bpjs_kesehatan'         => $bpjsks['maksimal_iuran_bpjs_kesehatan']
            ];

            //End Untuk Mencari Rincian Potongan BPJS Kesehatan

            //Query Untuk Mencari Rincian Potongan BPJS Ketenagakerjaan
            $this->db->select('*');
            $this->db->from('potongan_bpjs_ketenagakerjaan');
            $bpjstk = $this->db->get()->row_array();

            $databpjstk = [
                'potongan_jht_karyawan'         => $bpjstk['potongan_jht_karyawan'],
                'potongan_jht_perusahaan'       => $bpjstk['potongan_jht_perusahaan'],
                'potongan_jp_karyawan'          => $bpjstk['potongan_jp_karyawan'],
                'potongan_jp_perusahaan'        => $bpjstk['potongan_jp_perusahaan'],
                'potongan_jkk_perusahaan'       => $bpjstk['potongan_jkk_perusahaan'],
                'potongan_jkm_perusahaan'       => $bpjstk['potongan_jkm_perusahaan'],
                'jumlah_potongan_karyawan'      => $bpjstk['jumlah_potongan_karyawan'],
                'jumlah_potongan_perusahaan'    => $bpjstk['jumlah_potongan_perusahaan'],
                'maksimal_iuran_jp'             => $bpjstk['maksimal_iuran_jp']
            ];
            //End Untuk Mencari Rincian Potongan BPJS Ketenagakerjaan

            //Mengambil variabel dari inputan
            $nikkaryawan        = $this->input->post('nik_karyawan', TRUE);
            $gajipokok          = $this->input->post('gaji_pokok', TRUE);
            $uangmakan          = $this->input->post('uang_makan', TRUE);
            $uangtransport      = $this->input->post('uang_transport', TRUE);
            $tunjangantugas     = $this->input->post('tunjangan_tugas', TRUE);
            $tunjanganpulsa     = $this->input->post('tunjangan_pulsa', TRUE);
            $mulai_tanggal     = $this->input->post('mulai_tanggal', TRUE);
            $sampai_tanggal     = $this->input->post('sampai_tanggal', TRUE);

            //Menghitung Jumlah Upah
            $jumlahupah         = $gajipokok + $uangmakan + $uangtransport + $tunjangantugas + $tunjanganpulsa;

            //Checkbox BPJSTK Dan BPJSKS
            $jkn        = $this->input->post('jkn', TRUE);
            $jht        = $this->input->post('jht', TRUE);
            $jp         = $this->input->post('jp', TRUE);
            $jkk        = $this->input->post('jkk', TRUE);
            $jkm        = $this->input->post('jkm', TRUE);
            //

            //Checkbox BPJS
            //Jika Ikut Semua Kepesertaan BPJS Kesehatan Dan Ketenagakerjaan
            if ($jkn != null && $jht != null && $jp != null && $jkk != null && $jkm != null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = $databpjsks['potongan_bpjs_kesehatan_karyawan'];
                $potongan_bpjs_kesehatan_perusahaan = $databpjsks['potongan_bpjs_kesehatan_perusahaan'];
                $maksimal_iuran_bpjs_kesehatan      = $databpjsks['maksimal_iuran_bpjs_kesehatan'];
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = $databpjstk['potongan_jht_karyawan'];
                $potongan_jht_perusahaan            = $databpjstk['potongan_jht_perusahaan'];
                $potongan_jp_karyawan               = $databpjstk['potongan_jp_karyawan'];
                $potongan_jp_perusahaan             = $databpjstk['potongan_jp_perusahaan'];
                $potongan_jkk_perusahaan            = $databpjstk['potongan_jkk_perusahaan'];
                $potongan_jkm_perusahaan            = $databpjstk['potongan_jkm_perusahaan'];
                $jumlah_potongan_karyawan           = $databpjstk['jumlah_potongan_karyawan'];
                $jumlah_potongan_perusahaan         = $databpjstk['jumlah_potongan_perusahaan'];
                $maksimal_iuran_jp                  = $databpjstk['maksimal_iuran_jp'];

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //Jika Hanya Ikut Kepesertaan BPJS Kesehatan Saja
            elseif ($jkn != null && $jht == null && $jp == null && $jkk == null && $jkm == null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = $databpjsks['potongan_bpjs_kesehatan_karyawan'];
                $potongan_bpjs_kesehatan_perusahaan = $databpjsks['potongan_bpjs_kesehatan_perusahaan'];
                $maksimal_iuran_bpjs_kesehatan      = $databpjsks['maksimal_iuran_bpjs_kesehatan'];
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = 0;
                $potongan_jht_perusahaan            = 0;
                $potongan_jp_karyawan               = 0;
                $potongan_jp_perusahaan             = 0;
                $potongan_jkk_perusahaan            = 0;
                $potongan_jkm_perusahaan            = 0;
                $jumlah_potongan_karyawan           = 0;
                $jumlah_potongan_perusahaan         = 0;
                $maksimal_iuran_jp                  = 0;

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //Jika Hanya Ikut Kepesertaan BPJS Ketenagakerjaan Saja
            elseif ($jkn == null && $jht != null && $jp != null && $jkk != null && $jkm != null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = $databpjsks['potongan_bpjs_kesehatan_karyawan'];
                $potongan_bpjs_kesehatan_perusahaan = $databpjsks['potongan_bpjs_kesehatan_perusahaan'];
                $maksimal_iuran_bpjs_kesehatan      = $databpjsks['maksimal_iuran_bpjs_kesehatan'];
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = $databpjstk['potongan_jht_karyawan'];
                $potongan_jht_perusahaan            = $databpjstk['potongan_jht_perusahaan'];
                $potongan_jp_karyawan               = 0;
                $potongan_jp_perusahaan             = 0;
                $potongan_jkk_perusahaan            = $databpjstk['potongan_jkk_perusahaan'];
                $potongan_jkm_perusahaan            = $databpjstk['potongan_jkm_perusahaan'];
                $jumlah_potongan_karyawan           = $databpjstk['jumlah_potongan_karyawan'];
                $jumlah_potongan_perusahaan         = $databpjstk['jumlah_potongan_perusahaan'];
                $maksimal_iuran_jp                  = 0;

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }

            //JIka tidak ikut kepsertaaan Jaminan Pensiun
            elseif ($jkn != null && $jht != null && $jp == null && $jkk != null && $jkm != null) {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = 0;
                $potongan_bpjs_kesehatan_perusahaan = 0;
                $maksimal_iuran_bpjs_kesehatan      = 0;
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = $databpjstk['potongan_jht_karyawan'];
                $potongan_jht_perusahaan            = $databpjstk['potongan_jht_perusahaan'];
                $potongan_jp_karyawan               = $databpjstk['potongan_jp_karyawan'];
                $potongan_jp_perusahaan             = $databpjstk['potongan_jp_perusahaan'];
                $potongan_jkk_perusahaan            = $databpjstk['potongan_jkk_perusahaan'];
                $potongan_jkm_perusahaan            = $databpjstk['potongan_jkm_perusahaan'];
                $jumlah_potongan_karyawan           = $databpjstk['jumlah_potongan_karyawan'];
                $jumlah_potongan_perusahaan         = $databpjstk['jumlah_potongan_perusahaan'];
                $maksimal_iuran_jp                  = $databpjstk['maksimal_iuran_jp'];

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }
            //Jika tidak Ikut Semua Kepesertaan BPJS Kesehatan Dan BPJS Ketenagakerjaan
            else {
                //Potongan BPJS Kesehatan
                $potongan_bpjs_kesehatan_karyawan   = 0;
                $potongan_bpjs_kesehatan_perusahaan = 0;
                $maksimal_iuran_bpjs_kesehatan      = 0;
                //Potongan BPJS Ketenagakerjaan
                $potongan_jht_karyawan              = 0;
                $potongan_jht_perusahaan            = 0;
                $potongan_jp_karyawan               = 0;
                $potongan_jp_perusahaan             = 0;
                $potongan_jkk_perusahaan            = 0;
                $potongan_jkm_perusahaan            = 0;
                $jumlah_potongan_karyawan           = 0;
                $jumlah_potongan_perusahaan         = 0;
                $maksimal_iuran_jp                  = 0;

                //Jika Gaji Di Atas Maksimal Iuran BPJS Kesehatan
                if ($jumlahupah > $maksimal_iuran_bpjs_kesehatan) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $maksimal_iuran_bpjs_kesehatan * 1 / 100;
                    $jknbebanperusahaan             = $maksimal_iuran_bpjs_kesehatan * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Diatas Iuran Maksimal BPJSTK Dan Dibawah Iuran Maksimal BPJS Kesehatan
                else if ($jumlahupah < $maksimal_iuran_bpjs_kesehatan && $jumlahupah > $maksimal_iuran_jp) {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $maksimal_iuran_jp * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $maksimal_iuran_jp * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //Jika Gaji Dibawah Iuran Maksimal BPJSTK
                else {
                    //Potongan BPJS Kesehatan
                    $jknbebankaryawan               = $jumlahupah * 1 / 100;
                    $jknbebanperusahaan             = $jumlahupah * 4 / 100;
                    //Potongan BPJS Ketenagakerjaan
                    $jhtbebankaryawan               = $jumlahupah * $potongan_jht_karyawan / 100;
                    $jhtbebanperusahaan             = $jumlahupah * $potongan_jht_perusahaan / 100;
                    $jpbebankaryawan                = $jumlahupah * $potongan_jp_karyawan / 100;
                    $jpbebanperusahaan              = $jumlahupah * $potongan_jp_perusahaan / 100;
                    $jkkbebanperusahaan             = $jumlahupah * $potongan_jkk_perusahaan / 100;
                    $jkmbebanperusahaan             = $jumlahupah * $potongan_jkm_perusahaan / 100;
                    $jumlahbpjstkbebankaryawan      = $jhtbebankaryawan + $jpbebankaryawan;
                    $jumlahbpjstkbebanperusahaan    = $jhtbebanperusahaan + $jpbebanperusahaan + $jkkbebanperusahaan + $jkmbebanperusahaan;
                }
                //
            }


            //Menghitung Total Gaji
            $takehomepay            = $jumlahupah - $jumlahbpjstkbebankaryawan - $jknbebankaryawan;

            //Menghitung Upah Lembur Perjam
            $upahlemburperjam       = $jumlahupah / 173;

            //Mengirimkan data ke model
            $hasil = $this->gaji->updatedatarekongaji($nikkaryawan, $mulai_tanggal, $sampai_tanggal, $gajipokok, $uangmakan, $uangtransport, $tunjangantugas, $tunjanganpulsa, $jumlahupah, $upahlemburperjam, $jknbebankaryawan, $jknbebanperusahaan, $jhtbebankaryawan, $jhtbebanperusahaan, $jpbebankaryawan, $jpbebanperusahaan, $jkkbebanperusahaan, $jkmbebanperusahaan, $jumlahbpjstkbebankaryawan, $jumlahbpjstkbebanperusahaan, $takehomepay);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Rekon Gaji</div>');
            //dan mendirect kehalaman tampil rekon gaji
            redirect('gaji/rekonsiliasigaji');
        }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
