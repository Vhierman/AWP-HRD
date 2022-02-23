<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil model Laporan
        $this->load->model('laporan/Laporan_model', 'laporan');
        //Memanggil library validation
        $this->load->library('form_validation');
        //Memanggil library fpdf
        $this->load->library('pdf');
        //Memanggil Helper Login
        is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
    }

    //untuk mencari data karyawan berdasarkan NIK Karyawan
    public function get_datakaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan');
        $data = $this->surat->get_karyawan_bynik($nikkaryawan);
        echo json_encode($data);
    }

    //Menampilkan halaman awal laporan karyawan masuk
    public function karyawanmasuk()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Laporan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_karyawan_masuk', $data);
        $this->load->view('templates/footer');
	}
	
	//Menampilkan halaman awal TAMPIL laporan karyawan masuk
    public function tampillaporankaryawanmasuk()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $data['tampillaporan']  = $this->laporan->getLaporanKaryawanMasuk();

        //menampilkan halaman Tampil Laporan Karyawan masuk
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/tampil_laporan_karyawan_masuk', $data);
        $this->load->view('templates/footer');
    }

	/*
    //Menampilkan halaman awal laporan karyawan masuk
    public function cetaklaporankaryawanmasuk()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getKaryawanMasukByNIK();

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulaitanggal       = $this->input->post('mulai_tanggal', true);
        $sampaitanggal      = $this->input->post('sampai_tanggal', true);
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir             = substr($sampai_tanggal, -4);

        //Jika Tidak Ada Data Yang Di Print
        if ($karyawan == NULL) {
            redirect('laporan/karyawanmasuk');
        }
        //Jika ada data
        else {
            //Jika Pemilihan Tanggal Salah
            if ($mulaitanggal > $sampaitanggal) {

                echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
            } else {

                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->AddPage();

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'DATA KARYAWAN MASUK', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

                $pdf->Ln(10);

                $pdf->Cell(1);
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
                $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
                $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'No Rekening', 1, 0, 'C', 1);
                $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);

                $no = 1;

                foreach ($karyawan as $kr) :
                    $tanggal_mulai_kerja = IndonesiaTgl($kr['tanggal_mulai_kerja']);
                    $pdf->Ln();
                    $pdf->Cell(1);
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell(10, 8, $no, 1, 0, 'C');
                    $pdf->Cell(55, 8, $kr['nama_karyawan'], 1, 0, 'L');
                    $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                    $pdf->Cell(40, 8, $kr['nomor_rekening'], 1, 0, 'C');
                    $pdf->Cell(50, 8, $kr['penempatan'], 1, 0, 'C');
                    $no++;
                endforeach;

                $pdf->Output();
            }
        }
	}
	*/

	//Menampilkan halaman awal laporan karyawan masuk
    public function downloadpdfkaryawanmasukprima($mulaitanggal, $sampaitanggal)
    {
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanMasukPDFPrima($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawanmasuk');
        }
        //Jika ada data
        else {
            //Jika Format Pemilihan Tanggal Salah
            if ($mulaitanggal > $sampaitanggal) {

                echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
            } else {
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->AddPage();

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'DATA KARYAWAN MASUK', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'PT PRIMA KOMPONEN INDONESIA', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

                $pdf->Ln(10);

                $pdf->Cell(1);
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
                $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
                $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Nomor Rekening', 1, 0, 'C', 1);
                $pdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

                $no = 1;
                foreach ($karyawan as $row) :
                    $tanggal_mulai_kerja = IndonesiaTgl($row['tanggal_mulai_kerja']);
                    $pdf->Ln();
                    $pdf->Cell(1);
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell(10, 8, $no, 1, 0, 'C');
                    $pdf->Cell(55, 8, $row['nama_karyawan'], 1, 0, 'L');
                    $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                    $pdf->Cell(40, 8, $row['nomor_rekening'], 1, 0, 'C');
                    $pdf->Cell(50, 8, $row['penempatan'], 1, 0, 'C');
                    $no++;
                endforeach;

                $pdf->Output();
            }
        }
	}

	//Menampilkan halaman awal laporan karyawan masuk
    public function downloadpdfkaryawanmasukpetra($mulaitanggal, $sampaitanggal)
    {
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanMasukPDFPetra($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawanmasuk');
        }
        //Jika ada data
        else {
            //Jika Format Pemilihan Tanggal Salah
            if ($mulaitanggal > $sampaitanggal) {

                echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
            } else {
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->AddPage();

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'DATA KARYAWAN MASUK', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'PT PETRA ARIESCA', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

                $pdf->Ln(10);

                $pdf->Cell(1);
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
                $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
                $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Nomor Rekening', 1, 0, 'C', 1);
                $pdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

                $no = 1;
                foreach ($karyawan as $row) :
                    $tanggal_mulai_kerja = IndonesiaTgl($row['tanggal_mulai_kerja']);
                    $pdf->Ln();
                    $pdf->Cell(1);
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell(10, 8, $no, 1, 0, 'C');
                    $pdf->Cell(55, 8, $row['nama_karyawan'], 1, 0, 'L');
                    $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                    $pdf->Cell(40, 8, $row['nomor_rekening'], 1, 0, 'C');
                    $pdf->Cell(50, 8, $row['penempatan'], 1, 0, 'C');
                    $no++;
                endforeach;

                $pdf->Output();
            }
        }
	}

	//Menampilkan halaman awal laporan karyawan masuk
    public function downloadexcellkaryawanmasukprima($mulaitanggal, $sampaitanggal)
    {
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanMasukExcellPrima($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai             = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir             = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawanmasuk');
        }
        //Jika ada data
        else {

            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            // Panggil class PHPExcel nya
            $excel = new PHPExcel();

            // Settingan Description awal file excel
            $excel->getProperties()->setCreator('Vhierman Sach')
                ->setLastModifiedBy('Vhierman Sach')
                ->setTitle("Data Karyawan Masuk")
                ->setSubject("Karyawan Masuk")
                ->setDescription("Laporan Data Karyawan Masuk")
                ->setKeywords("Data Karyawan Masuk");

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

            $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA KARYAWAN MASUK PT PRIMA KOMPONEN INDONESIA");
            // Set kolom B2 dengan tulisan "DATA KARYAWAN MASUK PT PRIMA KOMPONEN INDONESIA"

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

            $excel->setActiveSheetIndex(0)->setCellValue('B4', "PERIODE " . $tanggalmulai . " " . bulan($bulanmulai) . " " . $tahunmulai . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B4:H4'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            // Buat header juudl tabel nya pada baris ke 5
            $excel->setActiveSheetIndex(0)->setCellValue('B6', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('C6', "NAMA KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('D6', "TANGGAL MASUK KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "NOMOR REKENING");
            $excel->setActiveSheetIndex(0)->setCellValue('F6', "PENEMPATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('G6', "NIK");
            $excel->setActiveSheetIndex(0)->setCellValue('H6', "TEMPAT LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('I6', "TANGGAL LAHIR");
            
            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('I6')->applyFromArray($style_col);
           

            // Panggil function view yang ada di Model untuk menampilkan semua data
            $join = $this->laporan->getLaporanKaryawanMasukExcellPrima($mulaitanggal, $sampaitanggal);


            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($join as $data) {


                // Lakukan looping pada variabel karyawan
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow,  "'" . $data->tanggal_mulai_kerja);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nomor_rekening);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "'" . $data->penempatan);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->nik_karyawan);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, "'" . $data->tempat_lahir);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, "'" . $data->tanggal_lahir);
               
                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);

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

            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Set judul Sheet excel nya
            $excel->getActiveSheet(0)->setTitle("Data Karyawan Masuk");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Karyawan Masuk.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
	}

	//Menampilkan halaman awal laporan karyawan masuk
    public function downloadexcellkaryawanmasukpetra($mulaitanggal, $sampaitanggal)
    {
		//Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Masuk';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanMasukExcellPetra($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai             = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir             = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawanmasuk');
        }
        //Jika ada data
        else {

            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            // Panggil class PHPExcel nya
            $excel = new PHPExcel();

            // Settingan Description awal file excel
            $excel->getProperties()->setCreator('Vhierman Sach')
                ->setLastModifiedBy('Vhierman Sach')
                ->setTitle("Data Karyawan Masuk")
                ->setSubject("Karyawan Masuk")
                ->setDescription("Laporan Data Karyawan Masuk")
                ->setKeywords("Data Karyawan Masuk");

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

            $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA KARYAWAN MASUK PT PETRA ARIESCA");
            // Set kolom B2 dengan tulisan "DATA KARYAWAN MASUK PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B2:H2'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            $excel->setActiveSheetIndex(0)->setCellValue('B3', "PT PETRA ARIESCA");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B3:H3'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            $excel->setActiveSheetIndex(0)->setCellValue('B4', "PERIODE " . $tanggalmulai . " " . bulan($bulanmulai) . " " . $tahunmulai . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B4:H4'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            // Buat header juudl tabel nya pada baris ke 5
            $excel->setActiveSheetIndex(0)->setCellValue('B6', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('C6', "NAMA KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('D6', "TANGGAL MASUK KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "NOMOR REKENING");
            $excel->setActiveSheetIndex(0)->setCellValue('F6', "PENEMPATAN");
            
            // Apply style header yang telah kita buat tadi ke masing-masing kolom header
            $excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E6')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F6')->applyFromArray($style_col);
           

            // Panggil function view yang ada di Model untuk menampilkan semua data
            $join = $this->laporan->getLaporanKaryawanMasukExcellPetra($mulaitanggal, $sampaitanggal);


            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($join as $data) {


                // Lakukan looping pada variabel karyawan
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow,  "'" . $data->tanggal_mulai_kerja);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nomor_rekening);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "'" . $data->penempatan);
               
                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
                $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

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

            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Set judul Sheet excel nya
            $excel->getActiveSheet(0)->setTitle("Data Karyawan Masuk");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Karyawan Masuk.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
	}

    //Menampilkan halaman awal laporan karyawan keluar
    public function karyawankeluar()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Laporan Karyawan Keluar
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_karyawan_keluar', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal TAMPIL laporan karyawan keluar
    public function tampillaporankaryawankeluar()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $data['tampillaporan']  = $this->laporan->getLaporanKaryawanKeluar();

        //menampilkan halaman Tampil Laporan Karyawan Keluar
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/tampil_laporan_karyawan_keluar', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal laporan karyawan keluar
    public function downloadpdfkaryawankeluarprima($mulaitanggal, $sampaitanggal)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanKeluarPDFPrima($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawankeluar');
        }
        //Jika ada data
        else {
            //Jika Format Pemilihan Tanggal Salah
            if ($mulaitanggal > $sampaitanggal) {

                echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
            } else {
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->AddPage();

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'DATA KARYAWAN KELUAR', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'PT PRIMA KOMPONEN INDONESIA', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

                $pdf->Ln(10);

                $pdf->Cell(1);
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
                $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
                $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Akhir Kerja', 1, 0, 'C', 1);
                $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);

                $no = 1;
                foreach ($karyawan as $kr) :
                    $tanggal_mulai_kerja = IndonesiaTgl($kr['tanggal_masuk_karyawan_keluar']);
                    $tanggal_akhir_kerja = IndonesiaTgl($kr['tanggal_keluar_karyawan_keluar']);
                    $pdf->Ln();
                    $pdf->Cell(1);
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell(10, 8, $no, 1, 0, 'C');
                    $pdf->Cell(55, 8, $kr['nama_karyawan_keluar'], 1, 0, 'L');
                    $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                    $pdf->Cell(40, 8, $tanggal_akhir_kerja, 1, 0, 'C');
                    $pdf->Cell(50, 8, $kr['penempatan'], 1, 0, 'C');
                    $no++;
                endforeach;

                $pdf->Output();
            }
        }
    }

    //Menampilkan halaman awal laporan karyawan keluar
    public function downloadexcellkaryawankeluarprima($mulaitanggal, $sampaitanggal)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanKeluarExcellPrima($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawankeluar');
        }
        //Jika ada data
        else {

            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            // Panggil class PHPExcel nya
            $excel = new PHPExcel();

            // Settingan Description awal file excel
            $excel->getProperties()->setCreator('Vhierman Sach')
                ->setLastModifiedBy('Vhierman Sach')
                ->setTitle("Data Karyawan Keluar")
                ->setSubject("Karyawan Keluar")
                ->setDescription("Laporan Data Karyawan Keluar")
                ->setKeywords("Data Karyawan Keluar");

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

            $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA KARYAWAN KELUAR PT PRIMA KOMPONEN INDONESIA");
            // Set kolom B2 dengan tulisan "DATA KARYAWAN KELUAR PT PRIMA KOMPONEN INDONESIA"

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

            $excel->setActiveSheetIndex(0)->setCellValue('B4', "PERIODE " . $tanggalmulai . " " . bulan($bulanmulai) . " " . $tahunmulai . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B4:H4'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            // Buat header juudl tabel nya pada baris ke 5
            $excel->setActiveSheetIndex(0)->setCellValue('B6', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('C6', "NAMA KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('D6', "JABATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "PENEMPATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('F6', "NIK KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('G6', "NOMOR NPWP");
            $excel->setActiveSheetIndex(0)->setCellValue('H6', "EMAIL");
            $excel->setActiveSheetIndex(0)->setCellValue('I6', "NOMOR HANDPHONE");
            $excel->setActiveSheetIndex(0)->setCellValue('J6', "TEMPAT LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('K6', "TANGGAL LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('L6', "JENIS KELAMIN");
            $excel->setActiveSheetIndex(0)->setCellValue('M6', "AGAMA");
            $excel->setActiveSheetIndex(0)->setCellValue('N6', "PENDIDIKAN TERAKHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('O6', "NO BPJS KESEHATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('P6', "NO BPJS KETENAGAKERJAAN");
            $excel->setActiveSheetIndex(0)->setCellValue('Q6', "NO REKENING");
            $excel->setActiveSheetIndex(0)->setCellValue('R6', "TANGGAL MASUK KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('S6', "TANGGAL AKHIR KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('T6', "STATUS KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('U6', "KETERANGAN KELUAR");
            $excel->setActiveSheetIndex(0)->setCellValue('V6', "ALAMAT");
            $excel->setActiveSheetIndex(0)->setCellValue('W6', "RT");
            $excel->setActiveSheetIndex(0)->setCellValue('X6', "RW");
            $excel->setActiveSheetIndex(0)->setCellValue('Y6', "KELURAHAN");
            $excel->setActiveSheetIndex(0)->setCellValue('Z6', "KECAMATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('AA6', "KOTA");
            $excel->setActiveSheetIndex(0)->setCellValue('AB6', "PROVINSI");
            $excel->setActiveSheetIndex(0)->setCellValue('AC6', "KODE POS");

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
            $excel->getActiveSheet()->getStyle('AC6')->applyFromArray($style_col);

            // Panggil function view yang ada di Model untuk menampilkan semua data
            $join = $this->laporan->getLaporanKaryawanKeluarExcellPrima($mulaitanggal, $sampaitanggal);


            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($join as $data) {


                // Lakukan looping pada variabel karyawan
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jabatan);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->penempatan);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "'" . $data->nik_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->nomor_npwp_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, "'" . $data->email_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, "'" . $data->nomor_handphone_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->tempat_lahir_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, "'" . $data->tanggal_lahir_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->jenis_kelamin_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->agama_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->pendidikan_terakhir_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, "'" . $data->nomor_jkn_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "'" . $data->nomor_jht_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, "'" . $data->nomor_rekening_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, "'" . $data->tanggal_masuk_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, "'" . $data->tanggal_keluar_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->status_kerja_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->keterangan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->alamat_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, "'" . $data->rt_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, "'" . $data->rw_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data->kelurahan_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data->kecamatan_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data->kota_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data->provinsi_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, "'" .  $data->kode_pos_karyawan_keluar);

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
                $excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);

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
            $excel->getActiveSheet()->getColumnDimension('W')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('X')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('AC')->setWidth(10); // Set width kolom 

            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Set judul Sheet excel nya
            $excel->getActiveSheet(0)->setTitle("Data Karyawan Keluar");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Karyawan Keluar.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }

    //Menampilkan halaman awal laporan karyawan keluar
    public function downloadpdfkaryawankeluarpetra($mulaitanggal, $sampaitanggal)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanKeluarPDFPetra($mulaitanggal, $sampaitanggal);

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawankeluar');
        }
        //Jika ada data
        else {
            //Jika Format Pemilihan Tanggal Salah
            if ($mulaitanggal > $sampaitanggal) {

                echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
            } else {
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->AddPage();

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'DATA KARYAWAN KELUAR', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'PT PETRA ARIESCA', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

                $pdf->Ln(10);

                $pdf->Cell(1);
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
                $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
                $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Akhir Kerja', 1, 0, 'C', 1);
                $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);

                $no = 1;
                foreach ($karyawan as $kr) :
                    $tanggal_mulai_kerja = IndonesiaTgl($kr['tanggal_masuk_karyawan_keluar']);
                    $tanggal_akhir_kerja = IndonesiaTgl($kr['tanggal_keluar_karyawan_keluar']);
                    $pdf->Ln();
                    $pdf->Cell(1);
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell(10, 8, $no, 1, 0, 'C');
                    $pdf->Cell(55, 8, $kr['nama_karyawan_keluar'], 1, 0, 'L');
                    $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                    $pdf->Cell(40, 8, $tanggal_akhir_kerja, 1, 0, 'C');
                    $pdf->Cell(50, 8, $kr['penempatan'], 1, 0, 'C');
                    $no++;
                endforeach;

                $pdf->Output();
            }
        }
    }

    //Menampilkan halaman awal laporan karyawan keluar
    public function downloadexcellkaryawankeluarpetra($mulaitanggal, $sampaitanggal)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getLaporanKaryawanKeluarExcellPetra($mulaitanggal, $sampaitanggal);



        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawankeluar');
        }
        //Jika ada data
        else {

            // Load plugin PHPExcel nya
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

            // Panggil class PHPExcel nya
            $excel = new PHPExcel();

            // Settingan Description awal file excel
            $excel->getProperties()->setCreator('Vhierman Sach')
                ->setLastModifiedBy('Vhierman Sach')
                ->setTitle("Data Karyawan Keluar")
                ->setSubject("Karyawan Keluar")
                ->setDescription("Laporan Data Karyawan Keluar")
                ->setKeywords("Data Karyawan Keluar");

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

            $excel->setActiveSheetIndex(0)->setCellValue('B2', "DATA KARYAWAN KELUAR");
            // Set kolom B2 dengan tulisan "DATA KARYAWAN KELUAR PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B2:H2'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            $excel->setActiveSheetIndex(0)->setCellValue('B3', "PT PETRA ARIESCA");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B3:H3'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            $excel->setActiveSheetIndex(0)->setCellValue('B4', "PERIODE " . $tanggalmulai . " " . bulan($bulanmulai) . " " . $tahunmulai . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "");
            // Set kolom B2 dengan tulisan "PT PRIMA KOMPONEN INDONESIA"

            $excel->getActiveSheet()->mergeCells('B4:H4'); // Set Merge Cell 
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(TRUE); // Set bold
            $excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(16); // Set font size
            $excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // Set text center 

            // Buat header juudl tabel nya pada baris ke 5
            $excel->setActiveSheetIndex(0)->setCellValue('B6', "NO");
            $excel->setActiveSheetIndex(0)->setCellValue('C6', "NAMA KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('D6', "JABATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('E6', "PENEMPATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('F6', "NIK KARYAWAN");
            $excel->setActiveSheetIndex(0)->setCellValue('G6', "NOMOR NPWP");
            $excel->setActiveSheetIndex(0)->setCellValue('H6', "EMAIL");
            $excel->setActiveSheetIndex(0)->setCellValue('I6', "NOMOR HANDPHONE");
            $excel->setActiveSheetIndex(0)->setCellValue('J6', "TEMPAT LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('K6', "TANGGAL LAHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('L6', "JENIS KELAMIN");
            $excel->setActiveSheetIndex(0)->setCellValue('M6', "AGAMA");
            $excel->setActiveSheetIndex(0)->setCellValue('N6', "PENDIDIKAN TERAKHIR");
            $excel->setActiveSheetIndex(0)->setCellValue('O6', "NO BPJS KESEHATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('P6', "NO BPJS KETENAGAKERJAAN");
            $excel->setActiveSheetIndex(0)->setCellValue('Q6', "NO REKENING");
            $excel->setActiveSheetIndex(0)->setCellValue('R6', "TANGGAL MASUK KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('S6', "TANGGAL AKHIR KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('T6', "STATUS KERJA");
            $excel->setActiveSheetIndex(0)->setCellValue('U6', "KETERANGAN KELUAR");
            $excel->setActiveSheetIndex(0)->setCellValue('V6', "ALAMAT");
            $excel->setActiveSheetIndex(0)->setCellValue('W6', "RT");
            $excel->setActiveSheetIndex(0)->setCellValue('X6', "RW");
            $excel->setActiveSheetIndex(0)->setCellValue('Y6', "KELURAHAN");
            $excel->setActiveSheetIndex(0)->setCellValue('Z6', "KECAMATAN");
            $excel->setActiveSheetIndex(0)->setCellValue('AA6', "KOTA");
            $excel->setActiveSheetIndex(0)->setCellValue('AB6', "PROVINSI");
            $excel->setActiveSheetIndex(0)->setCellValue('AC6', "KODE POS");

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
            $excel->getActiveSheet()->getStyle('AC6')->applyFromArray($style_col);

            // Panggil function view yang ada di Model untuk menampilkan semua data
            $join = $this->laporan->getLaporanKaryawanKeluarExcellPetra($mulaitanggal, $sampaitanggal);


            $no = 1; // Untuk penomoran tabel, di awal set dengan 1
            $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
            foreach ($join as $data) {


                // Lakukan looping pada variabel karyawan
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $no);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->jabatan);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->penempatan);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, "'" . $data->nik_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, "'" . $data->nomor_npwp_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, "'" . $data->email_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, "'" . $data->nomor_handphone_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->tempat_lahir_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, "'" . $data->tanggal_lahir_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->jenis_kelamin_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->agama_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->pendidikan_terakhir_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, "'" . $data->nomor_jkn_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, "'" . $data->nomor_jht_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, "'" . $data->nomor_rekening_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, "'" . $data->tanggal_masuk_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('S' . $numrow, "'" . $data->tanggal_keluar_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('T' . $numrow, $data->status_kerja_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('U' . $numrow, $data->keterangan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('V' . $numrow, $data->alamat_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('W' . $numrow, "'" . $data->rt_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('X' . $numrow, "'" . $data->rw_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('Y' . $numrow, $data->kelurahan_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('Z' . $numrow, $data->kecamatan_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('AA' . $numrow, $data->kota_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('AB' . $numrow, $data->provinsi_karyawan_keluar);
                $excel->setActiveSheetIndex(0)->setCellValue('AC' . $numrow, "'" .  $data->kode_pos_karyawan_keluar);

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
                $excel->getActiveSheet()->getStyle('AC' . $numrow)->applyFromArray($style_row);

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
            $excel->getActiveSheet()->getColumnDimension('W')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('X')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('Y')->setWidth(30); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('Z')->setWidth(30); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('AA')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('AB')->setWidth(10); // Set width kolom 
            $excel->getActiveSheet()->getColumnDimension('AC')->setWidth(10); // Set width kolom 

            // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // Set judul Sheet excel nya
            $excel->getActiveSheet(0)->setTitle("Data Karyawan Keluar");
            $excel->setActiveSheetIndex(0);

            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Data Karyawan Keluar.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
        }
    }

    //Menampilkan halaman awal laporan karyawan keluar
    public function cetaklaporankaryawankeluar()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cetak Laporan Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan               = $this->laporan->getKaryawanKeluarByNIK();

        //Mengambil data mulai tanggal dan sampai tanggal

        $mulaitanggal       = $this->input->post('mulai_tanggal', true);
        $sampaitanggal      = $this->input->post('sampai_tanggal', true);


        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

        //Mengambil masing masing 2 digit
        $tanggalmulai           = substr($mulai_tanggal, 0, -8);
        $bulanmulai             = substr($mulai_tanggal, 3, -5);
        $tahunmulai              = substr($mulai_tanggal, -4);

        //Mengambil masing masing 2 digit
        $tanggalakhir           = substr($sampai_tanggal, 0, -8);
        $bulanakhir             = substr($sampai_tanggal, 3, -5);
        $tahunakhir              = substr($sampai_tanggal, -4);

        //Jika tidak ada data ang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawankeluar');
        }
        //Jika ada data
        else {
            //Jika Format Pemilihan Tanggal Salah
            if ($mulaitanggal > $sampaitanggal) {

                echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
            } else {
                $pdf = new FPDF('P', 'mm', 'A4');
                $pdf->AddPage();

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', '18');
                $pdf->Cell(190, 5, 'DATA KARYAWAN KELUAR', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

                $pdf->Ln(10);

                $pdf->Cell(1);
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
                $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
                $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
                $pdf->Cell(40, 10, 'Akhir Kerja', 1, 0, 'C', 1);
                $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);

                $no = 1;
                foreach ($karyawan as $kr) :
                    $tanggal_mulai_kerja = IndonesiaTgl($kr['tanggal_masuk_karyawan_keluar']);
                    $tanggal_akhir_kerja = IndonesiaTgl($kr['tanggal_keluar_karyawan_keluar']);
                    $pdf->Ln();
                    $pdf->Cell(1);
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell(10, 8, $no, 1, 0, 'C');
                    $pdf->Cell(55, 8, $kr['nama_karyawan_keluar'], 1, 0, 'L');
                    $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                    $pdf->Cell(40, 8, $tanggal_akhir_kerja, 1, 0, 'C');
                    $pdf->Cell(50, 8, $kr['penempatan'], 1, 0, 'C');
                    $no++;
                endforeach;

                $pdf->Output();
            }
        }
    }

    //Menampilkan halaman awal laporan karyawan kontrak
    public function karyawankontrak()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Karyawan Kontrak';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Laporan
        $data['penempatan'] = $this->laporan->getAllPenempatan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_karyawan_kontrak', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal laporan karyawan kontrak
    public function cetaklaporankaryawankontrak()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Cetak Laporan Karyawan Kontrak';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan           = $this->laporan->getKaryawanKontrakByPenempatan();
        $datapenempatan     = $this->laporan->getPenempatan();

        //Jika Tidak ada data yang di cetaj
        if ($karyawan == NULL) {
            redirect('laporan/karyawankontrak');
        }
        //Jika ada data
        else {

            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '18');
            $pdf->Cell(190, 5, 'DATA KARYAWAN KONTRAK', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, 'PENEMPATAN', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, $datapenempatan['penempatan'], 0, 1, 'C');

            $pdf->Ln(10);

            $pdf->Cell(1);
            $pdf->SetFont('Arial', 'B', '12');
            $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
            $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
            $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
            $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
            $pdf->Cell(40, 10, 'Akhir Kerja', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

            $no = 1;
            foreach ($karyawan as $kr) :
                $tanggal_mulai_kerja = IndonesiaTgl($kr['tanggal_mulai_kerja']);
                $tanggal_akhir_kerja = IndonesiaTgl($kr['tanggal_akhir_kerja']);
                $pdf->Ln();
                $pdf->Cell(1);
                $pdf->SetFont('Arial', '', '11');
                $pdf->Cell(10, 8, $no, 1, 0, 'C');
                $pdf->Cell(55, 8, $kr['nama_karyawan'], 1, 0, 'L');
                $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                $pdf->Cell(40, 8, $tanggal_akhir_kerja, 1, 0, 'C');
                $pdf->Cell(50, 8, $kr['penempatan'], 1, 0, 'C');
                $no++;
            endforeach;

            $pdf->Output();
        }
    }

    //Menampilkan halaman awal laporan karyawan tetap
    public function karyawantetap()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Karyawan Tetap';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Laporan
        $data['penempatan'] = $this->laporan->getAllPenempatan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_karyawan_tetap', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal laporan karyawan tetap
    public function cetaklaporankaryawantetap()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Cetak Laporan Karyawan Tetap';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan           = $this->laporan->getKaryawanTetapByPenempatan();
        $datapenempatan     = $this->laporan->getPenempatan();

        //Jika tidak ada data yang dicetak
        if ($karyawan == NULL) {
            redirect('laporan/karyawantetap');
        }
        //Jika ada data
        else {
            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '18');
            $pdf->Cell(190, 5, 'DATA KARYAWAN TETAP', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, 'PENEMPATAN', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, $datapenempatan['penempatan'], 0, 1, 'C');

            $pdf->Ln(10);

            $pdf->Cell(1);
            $pdf->SetFont('Arial', 'B', '12');
            $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
            $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
            $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
            $pdf->Cell(40, 10, 'Mulai Kerja', 1, 0, 'C', 1);
            $pdf->Cell(40, 10, 'Jabatan', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

            $no = 1;
            foreach ($karyawan as $kr) :
                $tanggal_mulai_kerja = IndonesiaTgl($kr['tanggal_mulai_kerja']);
                $pdf->Ln();
                $pdf->Cell(1);
                $pdf->SetFont('Arial', '', '11');
                $pdf->Cell(10, 8, $no, 1, 0, 'C');
                $pdf->Cell(55, 8, $kr['nama_karyawan'], 1, 0, 'L');
                $pdf->Cell(40, 8, $tanggal_mulai_kerja, 1, 0, 'C');
                $pdf->Cell(40, 8, $kr['jabatan'], 1, 0, 'C');
                $pdf->Cell(50, 8, $kr['penempatan'], 1, 0, 'C');
                $no++;
            endforeach;

            $pdf->Output();
        }
    }

    //Menampilkan halaman awal laporan data siswa
    public function siswa()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Siswa Prakerin';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data penempatan dari model laporan
        $data['penempatan'] = $this->laporan->getAllPenempatan();
        //menampilkan halaman Cetak Laporan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_siswa', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal laporan siswa
    public function cetaklaporansiswa()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Cetak Laporan Siswa Prakerin';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $siswa              = $this->laporan->getSiswaByPenempatan();
        $datapenempatan     = $this->laporan->getPenempatan();

        //Jika tidak ada data yang dicetak
        if ($siswa == NULL) {
            redirect('laporan/siswa');
        }
        //Jika ada data
        else {

            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '18');
            $pdf->Cell(190, 5, 'DATA SISWA', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, 'PENEMPATAN', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, $datapenempatan['penempatan'], 0, 1, 'C');

            $pdf->Ln(10);

            $pdf->Cell(1);
            $pdf->SetFont('Arial', 'B', '12');
            $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
            $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Nama Siswa', 1, 0, 'C', 1);
            $pdf->Cell(30, 10, 'NIS Siswa', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Sekolah', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);

            $no = 1;
            foreach ($siswa as $ss) :
                $pdf->Ln();
                $pdf->Cell(1);
                $pdf->SetFont('Arial', '', '11');
                $pdf->Cell(10, 8, $no, 1, 0, 'C');
                $pdf->Cell(50, 8, $ss['nama_siswa'], 1, 0, 'L');
                $pdf->Cell(30, 8, $ss['nis_siswa'], 1, 0, 'C');
                $pdf->Cell(50, 8, $ss['nama_sekolah'], 1, 0, 'C');
                $pdf->Cell(50, 8, $ss['penempatan'], 1, 0, 'C');
                $no++;
            endforeach;

            $pdf->Output();
        }
    }

    //Menampilkan halaman awal laporan data magang
    public function magang()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Magang';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data penempatan
        $data['penempatan'] = $this->laporan->getAllPenempatan();
        //menampilkan halaman Cetak Laporan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_magang', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal laporan magang
    public function cetaklaporanmagang()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Cetak Laporan Magang';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $magang             = $this->laporan->getMagangByPenempatan();
        $datapenempatan     = $this->laporan->getPenempatan();
        //Jika tidak ada data yang dicetak
        if ($magang == NULL) {
            redirect('laporan/magang');
        }
        //Jika ada data
        else {

            $pdf = new FPDF('P', 'mm', 'A4');
            $pdf->AddPage();

            $pdf->Ln(10);
            $pdf->SetFont('Arial', 'B', '18');
            $pdf->Cell(190, 5, 'DATA PROGRAM MAGANG', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, 'PENEMPATAN', 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->Cell(190, 5, $datapenempatan['penempatan'], 0, 1, 'C');

            $pdf->Ln(10);

            $pdf->Cell(1);
            $pdf->SetFont('Arial', 'B', '12');
            $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
            $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Nama', 1, 0, 'C', 1);
            $pdf->Cell(50, 10, 'Penempatan', 1, 0, 'C', 1);
            $pdf->Cell(40, 10, 'Tanggal Masuk', 1, 0, 'C', 1);
            $pdf->Cell(40, 10, 'Tanggal Selesai', 1, 0, 'C', 1);

            $no = 1;
            foreach ($magang as $mg) :
                $tanggal_masuk_magang = IndonesiaTgl($mg['tanggal_masuk_magang']);
                $tanggal_Selesai_magang = IndonesiaTgl($mg['tanggal_selesai_magang']);
                $pdf->Ln();
                $pdf->Cell(1);
                $pdf->SetFont('Arial', '', '11');
                $pdf->Cell(10, 8, $no, 1, 0, 'C');
                $pdf->Cell(50, 8, $mg['nama_magang'], 1, 0, 'L');
                $pdf->Cell(50, 8, $mg['penempatan'], 1, 0, 'C');
                $pdf->Cell(40, 8, $tanggal_masuk_magang, 1, 0, 'C');
                $pdf->Cell(40, 8, $tanggal_Selesai_magang, 1, 0, 'C');
                $no++;
            endforeach;

            $pdf->Output();
        }
    }

    //Menampilkan halaman awal laporan inventaris laptop
    public function inventarislaptop()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Laporan Inventaris Laptop';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan           = $this->laporan->getLaporanInventarisLaptop();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', '18');
        $pdf->Cell(275, 5, 'DATA INVENTARIS PERUSAHAAN', 0, 0, 'C');

        $pdf->Ln(7);

        $pdf->Cell(275, 5, 'Jenis Inventaris', 0, 0, 'C');

        $pdf->Ln(10);

        $pdf->Cell(275, 5, 'LAPTOP', 0, 0, 'C');

        $pdf->Ln(10);


        $pdf->Cell(-1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header

        $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'Jabatan', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'Merk', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Type', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Tgl Pemberian', 1, 0, 'C', 1);

        $no = 1;
        foreach ($karyawan as $lp) :
            $tanggal_penyerahan_laptop = IndonesiaTgl($lp['tanggal_penyerahan_laptop']);
            $pdf->Ln();
            $pdf->Cell(-1);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10, 8, $no, 1, 0, 'C');
            $pdf->Cell(55, 8, $lp['nama_karyawan'], 1, 0, 'L');
            $pdf->Cell(50, 8, $lp['jabatan'], 1, 0, 'C');
            $pdf->Cell(50, 8, $lp['penempatan'], 1, 0, 'C');
            $pdf->Cell(35, 8, $lp['merk_laptop'], 1, 0, 'C');
            $pdf->Cell(40, 8, $lp['type_laptop'], 1, 0, 'C');
            $pdf->Cell(40, 8, $tanggal_penyerahan_laptop, 1, 0, 'C');
            $no++;
        endforeach;

        $pdf->Output();
    }

    //Menampilkan halaman awal laporan inventaris motor
    public function inventarismotor()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Laporan Inventaris Motor';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan           = $this->laporan->getLaporanInventarisMotor();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', '18');
        $pdf->Cell(275, 5, 'DATA INVENTARIS PERUSAHAAN', 0, 0, 'C');

        $pdf->Ln(7);

        $pdf->Cell(275, 5, 'Jenis Inventaris', 0, 0, 'C');

        $pdf->Ln(10);

        $pdf->Cell(275, 5, 'MOTOR', 0, 0, 'C');

        $pdf->Ln(10);


        $pdf->Cell(-1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header

        $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'No Polisi', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'Merk', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Type', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Tgl Pemberian', 1, 0, 'C', 1);

        $no = 1;
        foreach ($karyawan as $mt) :
            $tanggal_penyerahan_motor = IndonesiaTgl($mt['tanggal_penyerahan_motor']);
            $pdf->Ln();
            $pdf->Cell(-1);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10, 8, $no, 1, 0, 'C');
            $pdf->Cell(55, 8, $mt['nama_karyawan'], 1, 0, 'L');
            $pdf->Cell(50, 8, $mt['nomor_polisi'], 1, 0, 'C');
            $pdf->Cell(50, 8, $mt['penempatan'], 1, 0, 'C');
            $pdf->Cell(35, 8, $mt['merk_motor'], 1, 0, 'C');
            $pdf->Cell(40, 8, $mt['type_motor'], 1, 0, 'C');
            $pdf->Cell(40, 8, $tanggal_penyerahan_motor, 1, 0, 'C');
            $no++;
        endforeach;

        $pdf->Output();
    }

    //Menampilkan halaman awal laporan inventaris mobil
    public function inventarismobil()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Laporan Inventaris Mobil';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan           = $this->laporan->getLaporanInventarisMobil();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', '18');
        $pdf->Cell(275, 5, 'DATA INVENTARIS PERUSAHAAN', 0, 0, 'C');

        $pdf->Ln(7);

        $pdf->Cell(275, 5, 'Jenis Inventaris', 0, 0, 'C');

        $pdf->Ln(10);

        $pdf->Cell(275, 5, 'MOBIL', 0, 0, 'C');

        $pdf->Ln(10);


        $pdf->Cell(-1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header

        $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(55, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'No Polisi', 1, 0, 'C', 1);
        $pdf->Cell(50, 10, 'Bagian', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'Merk', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Type', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Tgl Pemberian', 1, 0, 'C', 1);

        $no = 1;
        foreach ($karyawan as $mb) :
            $tanggal_penyerahan_mobil = IndonesiaTgl($mb['tanggal_penyerahan_mobil']);
            $pdf->Ln();
            $pdf->Cell(-1);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10, 8, $no, 1, 0, 'C');
            $pdf->Cell(55, 8, $mb['nama_karyawan'], 1, 0, 'L');
            $pdf->Cell(50, 8, $mb['nomor_polisi'], 1, 0, 'C');
            $pdf->Cell(50, 8, $mb['penempatan'], 1, 0, 'C');
            $pdf->Cell(35, 8, $mb['merk_mobil'], 1, 0, 'C');
            $pdf->Cell(40, 8, $mb['type_mobil'], 1, 0, 'C');
            $pdf->Cell(40, 8, $tanggal_penyerahan_mobil, 1, 0, 'C');
            $no++;
        endforeach;

        $pdf->Output();
    }

    //Menampilkan halaman awal laporan data absensikaryawan
    public function absensikaryawan()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan Absensi Karyawan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Laporan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/cetak_laporan_absensi', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal laporan data absensikaryawan
    public function cetaklaporanabsensi()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']      = 'Cetak Laporan Absensi';
        //Menyimpan session dari login
        $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model laporan
        $karyawan           = $this->laporan->getLaporanAbsenKaryawanByNIK();
        $datakaryawan       = $this->laporan->getLaporanAbsenKaryawan();

        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');

        //Mengambil Data Dari Inputan
        $nikkaryawan                    = $this->input->post('nik_karyawan', true);
        $tanggalmulaikerja              = $this->input->post('tanggal_mulai_kerja', true);
        $tanggalmulailaporanabsen       = $this->input->post('tanggal_mulai_laporan_absen', true);
        $tanggalselesailaporanabsen     = $this->input->post('tanggal_selesai_laporan_absen', true);

        //Memisahkan data 2 digit tanggal 2 digit bulan dan 4 digit tahun
        $tanggalmulai       = substr(IndonesiaTgl($tanggalmulailaporanabsen), 0, -8);
        $bulanmulai         = substr(IndonesiaTgl($tanggalmulailaporanabsen), 3, -5);
        $tahunmulai         = substr(IndonesiaTgl($tanggalmulailaporanabsen), -4);

        $tanggalakhir       = substr(IndonesiaTgl($tanggalselesailaporanabsen), 0, -8);
        $bulanakhir         = substr(IndonesiaTgl($tanggalselesailaporanabsen), 3, -5);
        $tahunakhir         = substr(IndonesiaTgl($tanggalselesailaporanabsen), -4);

        $tanggalkerja       = substr(IndonesiaTgl($tanggalmulaikerja), 0, -8);
        $bulankerja         = substr(IndonesiaTgl($tanggalmulaikerja), 3, -5);
        $tahunkerja         = substr(IndonesiaTgl($tanggalmulaikerja), -4);

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', '18');
        $pdf->Cell(190, 5, 'DATA LAPORAN ABSEN KARYAWAN', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->Cell(190, 5, 'PERIODE', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->Cell(190, 5, $tanggalmulai . ' ' . bulan($bulanmulai) . ' ' . $tahunmulai . ' s/d ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . '', 0, 1, 'C');

        $pdf->Ln(15);

        $pdf->Cell(1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(190, 5, 'Nama Karyawan        : ' . $karyawan['nama_karyawan'] . '', 0, 1, 'L');

        $pdf->Ln(3);

        $pdf->Cell(1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(190, 5, 'Jabatan / Bagian       : ' . $karyawan['jabatan'] . ' / ' . $karyawan['penempatan'] . '', 0, 1, 'L');

        $pdf->Ln(3);

        $pdf->Cell(1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->Cell(190, 5, 'Tanggal Mulai Kerja : '  . $tanggalkerja . ' ' . bulan($bulankerja) . ' ' . $tahunkerja . '', 0, 1, 'L');

        $pdf->Ln(3);

        $pdf->Cell(1);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->SetFillColor(192, 192, 192); // Warna sel tabel header
        $pdf->Cell(15, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Tanggal Absen', 1, 0, 'C', 1);
        $pdf->Cell(40, 10, 'Sampai Tanggal', 1, 0, 'C', 1);
        $pdf->Cell(20, 10, 'Jenis', 1, 0, 'C', 1);
        $pdf->Cell(20, 10, 'Lama', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Keterangan', 1, 0, 'C', 1);

        $no = 1;
        foreach ($datakaryawan as $lkr) :
            $pdf->Ln();
            $pdf->Cell(1);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(15, 10, $no, 1, 0, 'C');
            $pdf->Cell(40, 10, IndonesiaTgl($lkr['tanggal_absen']), 1, 0, 'C');
            $pdf->Cell(40, 10, IndonesiaTgl($lkr['tanggal_selesai']), 1, 0, 'C');
            $pdf->Cell(20, 10, $lkr['keterangan_absen'], 1, 0, 'C');
            $pdf->Cell(20, 10, $lkr['lama_absen'], 1, 0, 'C');
            $pdf->Cell(60, 10, $lkr['keterangan'], 1, 0, 'C');
            $no++;
        endforeach;

        $pdf->Output();
	}
	
	//Menampilkan halaman awal laporan data kpi absensi
    public function kpiabsensi()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Laporan KPI Absensi';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman Cetak Laporan KPI Absensi
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/laporan_kpi_absensi', $data);
        $this->load->view('templates/footer');
	}
	
	//Menampilkan halaman cetak laporan KPI Absensi
    public function cetaklaporankpiabsensi()
    {

		 //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
		 $data['title']      = 'Cetak Laporan KPI Absensi';
		 //Menyimpan session dari login
		 $data['user']       = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
 
		 //Mengambil data dari model laporan
		 $kpiabsensi           				= $this->laporan->getLaporanKPIAbsensi();
		 $jumlahkaryawankpi           		= $this->laporan->getJumlahKaryawanKPI();
		 $jumlahabsen           			= $this->laporan->getJumlahAbsenKaryawan();

		 //var_dump($jumlahkaryawankpi);
		 //die;
		 
		 //Mengambil data Tanggal Bulan Dan Tahun Sekarang
		 date_default_timezone_set("Asia/Jakarta");
		 $tahun      = date('Y');
		 $bulan      = date('m');
		 $tanggal    = date('d');
 
		 //Mengambil Data Dari Inputan
		 $mulai_tanggal       = $this->input->post('mulai_tanggal', true);
		 $sampai_tanggal     = $this->input->post('sampai_tanggal', true);
 
		 //Memisahkan data 2 digit tanggal 2 digit bulan dan 4 digit tahun
		 $tanggalmulai       = substr(IndonesiaTgl($mulai_tanggal), 0, -8);
		 $bulanmulai         = substr(IndonesiaTgl($mulai_tanggal), 3, -5);
		 $tahunmulai         = substr(IndonesiaTgl($mulai_tanggal), -4);
 
		 $tanggalakhir       = substr(IndonesiaTgl($sampai_tanggal), 0, -8);
		 $bulanakhir         = substr(IndonesiaTgl($sampai_tanggal), 3, -5);
		 $tahunakhir         = substr(IndonesiaTgl($sampai_tanggal), -4);
		
		 if ($kpiabsensi == NULL) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data KPI Tidak Ada / 100%</div>');
            redirect('laporan/kpiabsensi');
		}
		else{

		
		 $pdf = new FPDF('L', 'mm', 'A4');
		 $pdf->setTopMargin(2);
        $pdf->setLeftMargin(2);
		$pdf->SetAutoPageBreak(TRUE);
			
		 $pdf->AddPage();
		
		 $pdf->Cell(2);

		 $pdf->Image('assets/img/logo/logo.png', 7, 10, 80);

		 

		$pdf->Ln(1);
        $pdf->Cell(2);
		$pdf->Cell(85, 28, '', 1, 0, 'C');

		$pdf->Cell(120, 28, '', 1, 0, 'C');

		$pdf->Cell(80, 7, '', 1, 0, 'C');
		
		$pdf->Ln();
		$pdf->Cell(207);
		$pdf->Cell(80, 7, '', 1, 0, 'C');
		$pdf->Ln();
		$pdf->Cell(207);
		$pdf->Cell(80, 7, '', 1, 0, 'C');
		$pdf->Ln();
		$pdf->Cell(207);
		$pdf->Cell(80, 7, '', 1, 0, 'C');
		

		$pdf->Ln(-21);
		$pdf->Cell(87);
		$pdf->SetFont('Arial', 'B', '16');
		$pdf->Cell(120, 14, "LAPORAN KPI ABSENSI", 0, 0, 'C');

		$pdf->SetFont('Arial', '', '12');
		$pdf->Cell(40, 7, "Nomor Dokumen", 0, 0, 'L');
		$pdf->Cell(40, 7, ": Nomor Dokumen", 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(207);
		$pdf->Cell(40, 7, "Tanggal Dikeluarkan", 0, 0, 'L');
		$pdf->Cell(40, 7, ": 01 Januari 2012", 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(207);
		$pdf->Cell(40, 7, "Pemilik Dokumen", 0, 0, 'L');
		$pdf->Cell(40, 7, ": HRD-GA", 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(207);
		$pdf->Cell(40, 7, "Tanggal Revisi", 0, 0, 'L');
		$pdf->Cell(40, 7, ": -", 0, 0, 'L');

		$pdf->Ln(-7);
		$pdf->Cell(87);
		$pdf->SetFont('Arial', 'B', '16');
		$pdf->Cell(120, 14, "Bulan ".bulan($bulanmulai)." Tahun ".$tahunmulai."", 0, 0, 'C');
		
		$pdf->Ln(14);
		$pdf->Cell(2);
        $pdf->SetFont('Arial', 'B', '12');
        $pdf->SetFillColor(192, 192, 192); 
        $pdf->Cell(10, 10, 'No', 1, 0, 'C', 1);
        $pdf->Cell(70, 10, 'Nama Karyawan', 1, 0, 'C', 1);
        $pdf->Cell(60, 10, 'Penempatan', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'Tanggal Absen', 1, 0, 'C', 1);
        $pdf->Cell(35, 10, 'Sampai Tanggal', 1, 0, 'C', 1);
        $pdf->Cell(45, 10, 'Jenis Ketidakhadiran', 1, 0, 'C', 1);
        $pdf->Cell(30, 10, 'Lama', 1, 0, 'C', 1);
	

		$no = 1;
		$total_absen = 0;
        foreach ($kpiabsensi as $row) :
            $pdf->Ln();
            $pdf->Cell(2);
            $pdf->SetFont('Arial', '', '11');
            $pdf->Cell(10, 10, $no, 1, 0, 'C');
            $pdf->Cell(70, 10, $row['nama_karyawan'], 1, 0, 'L');
            $pdf->Cell(60, 10, $row['penempatan'], 1, 0, 'L');
            $pdf->Cell(35, 10, IndonesiaTgl($row['tanggal_absen']), 1, 0, 'C');
            $pdf->Cell(35, 10, IndonesiaTgl($row['tanggal_selesai']), 1, 0, 'C');
            $pdf->Cell(45, 10, $row['keterangan_absen'], 1, 0, 'C');
			$pdf->Cell(30, 10, $row['lama_absen']." Hari", 1, 0, 'C');
			
			$no++;
			$total_absen += $row['lama_absen'];
		endforeach;
		
		$jumlahmanpower = $jumlahkaryawankpi;

		$pdf->Ln();
		$pdf->Cell(2);
		$pdf->Cell(210, 7, "", 1, 0, 'C');
		$pdf->Cell(45, 7, "Jumlah", 1, 0, 'C');
		$pdf->Cell(30, 7, $total_absen." Hari", 1, 0, 'C');

		$pdf->Ln();
		$pdf->Cell(2);
		$pdf->Cell(95, 7, "A. Jumlah Man Power", 1, 0, 'L');
		$pdf->Cell(5, 7, "", 1, 0, 'C');
		$pdf->Cell(30, 7, "", 1, 0, 'L');
		$pdf->Cell(5, 7, "", 1, 0, 'C');
		$pdf->Cell(25, 7, "", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(40, 7, $jumlahmanpower." Orang ", 1, 0, 'R');
		
		$pdf->Cell(40, 7, "Mengetahui", 1, 0, 'C');
		$pdf->Cell(40, 7, "Dibuat", 1, 0, 'C');

		$pdf->Ln();
		$pdf->Cell(2);
		$pdf->Cell(95, 7, "B. Jumlah Jam Kerja Normal Per Orang", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(30, 7, " 21 Hari Kerja ", 1, 0, 'L');
		$pdf->Cell(5, 7, " x ", 1, 0, 'C');
		$pdf->Cell(25, 7, " 8 Jam/Hari ", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(40, 7, " 168 Jam/Bulan ", 1, 0, 'R');

		$pdf->Cell(40, 7, "Rudiyanto", 1, 0, 'C');
		$pdf->Cell(40, 7, "Achmad Firmansyah", 1, 0, 'C');

		$pdf->Ln();
		$pdf->Cell(2);
		$pdf->Cell(95, 7, "C. Jumlah Jam Kerja Normal Per Bulan", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(30, 7, " 168 Jam/Bulan ", 1, 0, 'L');
		$pdf->Cell(5, 7, " x ", 1, 0, 'C');
		$pdf->Cell(25, 7, $jumlahmanpower. " Orang ", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$jumlahabsenkaryawan = 168*$jumlahmanpower;
		$pdf->Cell(40, 7, format_angka($jumlahabsenkaryawan)." Jam/Bulan", 1, 0, 'R');

		$pdf->Cell(40, 21, "", 1, 0, 'C');
		$pdf->Cell(40, 21, "", 1, 0, 'C');

		$pdf->Ln(7);
		$pdf->Cell(2);
		$pdf->Cell(95, 7, "D. Jumlah Jam Kerja Yang Hilang ( Sakit, Izin, Alpa )", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(30, 7, $total_absen." Hari Kerja ", 1, 0, 'L');
		$pdf->Cell(5, 7, " x ", 1, 0, 'C');
		$pdf->Cell(25, 7, " 8 Jam/Hari ", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$jumlahjamkerjahilang = $total_absen*8;
		$pdf->Cell(40, 7, format_angka($jumlahjamkerjahilang)." Jam/Bulan", 1, 0, 'R');

		$pdf->Ln();
		$pdf->Cell(2);
		$pdf->Cell(95, 7, "E. Jumlah Jam Kerja Sebenarnya ( C-D = E )", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(30, 7, "", 1, 0, 'L');
		$pdf->Cell(5, 7, "", 1, 0, 'C');
		$pdf->Cell(25, 7, "", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$jumlahjamkerjasebenarnya = $jumlahabsenkaryawan-$jumlahjamkerjahilang;
		$pdf->Cell(40, 7, format_angka($jumlahjamkerjasebenarnya)." Jam/Bulan", 1, 0, 'R');

		$pdf->Ln();
		$pdf->Cell(2);
		$pdf->Cell(95, 7, "F. Persentasi Kehadiran ( E/C ) x 100%", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$pdf->Cell(30, 7, "", 1, 0, 'L');
		$pdf->Cell(5, 7, "", 1, 0, 'C');
		$pdf->Cell(25, 7, "", 1, 0, 'L');
		$pdf->Cell(5, 7, " = ", 1, 0, 'C');
		$persentasi = ($jumlahjamkerjasebenarnya/$jumlahabsenkaryawan)*100;
		$pdf->Cell(40, 7, round($persentasi,2)." %", 1, 0, 'R');

		$pdf->Cell(40, 7, "Manager HRD-GA", 1, 0, 'C');
		$pdf->Cell(40, 7, "Staff HRD-GA", 1, 0, 'C');
		
		 $pdf->Output();
	}
}
}
