<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CetakLembur extends CI_Controller
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
        //Memanggil model lembur
        $this->load->model('Lembur/Lembur_model', 'lembur');
    }

    //Cetak Slip
    //Menampilkan halaman awal data slip lembur
    public function sliplembur()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Slip Lembur Karyawan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //menampilkan halaman data lembur
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cetak_lembur/cetak_sliplembur', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal data option cetak slip lembur
    public function optioncetak()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Option Slip Lembur';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil inputan select option post
        $sliplembur         = $this->input->post('slip', true);

        if ($sliplembur == "Kecil") {
            redirect('CetakLembur/formsliplemburkecil', $data);
        } else if ($sliplembur == "Besar") {
            redirect('CetakLembur/formsliplemburbesar', $data);
        } else {
            redirect('CetakLembur/sliplembur', $data);
        }
    }

    //Menampilkan halaman awal form slip lemnbur kecil
    public function formsliplemburkecil()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Slip Lembur Kecil';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data penempatan
        $data['penempatan'] = $this->lembur->datapenempatan();
        //menampilkan halaman form slip lemnbur
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cetak_lembur/cetak_sliplembur_kecil', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal data form slip lemnbur besar
    public function formsliplemburbesar()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Slip Lembur Besar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data penempatan
        $data['penempatan'] = $this->lembur->datapenempatan();
        //menampilkan halaman form slip lembur
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cetak_lembur/cetak_sliplembur_besar', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal cetak slip lemburan kecil
    public function cetaksliplemburkecil()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");

        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Cetak Slip Lemburan Kecil';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data 
            $datapenempatan = $this->lembur->datapenempatanByID();
            $data['slip'] = $this->lembur->datacetaksliplemburkecil();



            //Mengambil data penempatan mulai tanggal dan sampai tanggal
            $penempatan         = $this->input->post('penempatan', true);
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
            $tanggalmulai       = substr($mulai_tanggal, 0, -8);
            $bulanmulai         = substr($mulai_tanggal, 3, -5);
            $tahunmulai         = substr($mulai_tanggal, -4);

            //Mengambil masing masing 2 digit
            $tanggalakhir       = substr($sampai_tanggal, 0, -8);
            $bulanakhir         = substr($sampai_tanggal, 3, -5);
            $tahunakhir         = substr($sampai_tanggal, -4);

            //Jika data kosong
            if ($data['slip'] == NULL) {
                redirect('cetaklembur/formsliplemburkecil');
            }
            //Jika Tidak
            else {
                //Jika pemilihan Tanggal salah
                if ($mulaitanggal > $sampaitanggal) {
                    echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
                }
                //Jika Tidak
                else {

                    $pdf = new FPDF('L', 'cm', array(21, 14));
                    $pdf->setTopMargin(0.2);
                    $pdf->setLeftMargin(0.6);
                    $pdf->AddPage();
                    $pdf->SetAutoPageBreak(true);

                    foreach ($data['slip'] as $jl) :

                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(0.1);
                        $pdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
                        $pdf->Ln(0.4);
                        $pdf->SetFont('Arial', '', '9');
                        $pdf->Cell(0.1);
                        $pdf->Cell(10, 1, "BSD - " . $datapenempatan['penempatan'] . "", 0, 0, 'L');

                        $pdf->SetFont('Arial', 'B', '10');
                        $pdf->Ln(0.4);
                        $pdf->Cell(20, 1, "Bukti Tanda Terima Slip Lembur", 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(20, 1, "Periode " . $tanggalmulai . " " . bulan($bulanmulai) . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "", 0, 0, 'C');

                        $pdf->Ln(0.6);

                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Cell(0.1);
                        $pdf->Cell(7, 0.5, "Nama     : " . $jl['nama_karyawan'] . "", 0, 0, 'L');

                        $pdf->Ln(0.4);
                        $pdf->Cell(0.1);
                        $pdf->Cell(7, 0.5, "Bagian   : " . $jl['jabatan'] . " / " . $jl['penempatan'] . "", 0, 0, 'L');

                        $pdf->Ln(0.5);

                        $pdf->Cell(0.1);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->SetFillColor(255, 255, 255); // Warna sel tabel header
                        $pdf->Cell(1, 0.8, 'No', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.8, 'Hari', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.8, 'Tanggal', 1, 0, 'C', 1);

                        $pdf->Cell(4.5, 0.4, 'Jam Lembur ( Dlm Jam )', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.8, '', 1, 0, 'C', 1);

                        $pdf->Cell(4, 0.4, 'Perhitungan Jam Lembur', 1, 0, 'C', 1);
                        $pdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);
                        $pdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);

                        $pdf->Ln(0.4);
                        $pdf->Cell(5.1);
                        $pdf->Cell(1.5, 0.4, 'Masuk', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.4, 'Istirahat', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.4, 'Pulang', 1, 0, 'C', 1);

                        $pdf->Cell(1.5);
                        $pdf->Cell(1, 0.4, '1,5', 1, 0, 'C', 1);
                        $pdf->Cell(1, 0.4, '2', 1, 0, 'C', 1);
                        $pdf->Cell(1, 0.4, '3', 1, 0, 'C', 1);
                        $pdf->Cell(1, 0.4, '4', 1, 0, 'C', 1);

                        $pdf->Ln(-0.4);
                        $pdf->Cell(9.6);
                        $pdf->Cell(1.5, 0.4, 'Jam', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(9.6);
                        $pdf->Cell(1.5, 0.4, 'Lembur', 0, 0, 'C');


                        $pdf->Ln(-0.4);
                        $pdf->Cell(15.4);
                        $pdf->Cell(1.5, 0.4, 'Uang Makan', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(15.4);
                        $pdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

                        $pdf->Ln(-0.4);
                        $pdf->Cell(17.6);
                        $pdf->Cell(1.5, 0.4, 'U. Transport', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(17.6);
                        $pdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

                        $no = 1;
                        $jumlahjampertama = 0;
                        $jumlahjamkedua = 0;
                        $jumlahjamketiga = 0;
                        $jumlahjamkeempat = 0;
                        $uangmakanlembur = 0;
                        //
                        $total = 0;

                        //
                        $mulaitanggal         = $this->input->post('mulai_tanggal', true);
                        $sampaitanggal        = $this->input->post('sampai_tanggal', true);
                        $penempatan           = $this->input->post('penempatan', true);

                        //Mengambil data tahun
                        $tahunlembur         = substr($mulaitanggal, 0, -6);

                        $this->db->select('*');
                        $this->db->from('slip_lembur');
                        $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
                        $this->db->join('history_gaji', 'history_gaji.karyawan_id_history=karyawan.nik_karyawan');
                        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
                        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
                        $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
                        $this->db->where('penempatan_id', $penempatan);
                        $this->db->where('acc_supervisor !=', '');
                        $this->db->where('acc_manager !=', '');
                        $this->db->where('acc_hrd !=', '');
                        $this->db->where('karyawan_id', $jl['nik_karyawan']);
                        $this->db->where('tanggal_lembur >= ', $mulaitanggal);
                        $this->db->where('tanggal_lembur <= ', $sampaitanggal);
                        $this->db->where('periode_awal_gaji_history >= ', $mulaitanggal);
                        $this->db->where('periode_akhir_gaji_history <= ', $sampaitanggal);
                        $this->db->order_by('tanggal_lembur');
                        $coba = $this->db->get()->result_array();

                        foreach ($coba as $hasil) :
                            $upahlemburperjam = $hasil['upah_lembur_perjam_history'];
                            $tanggalsliplembur = IndonesiaTgl($hasil['tanggal_lembur']);
                            $day = date('D', strtotime($hasil['tanggal_lembur']));
                            $dayList = array(
                                'Sun' => 'Minggu',
                                'Mon' => 'Senin',
                                'Tue' => 'Selasa',
                                'Wed' => 'Rabu',
                                'Thu' => 'Kamis',
                                'Fri' => 'Jumat',
                                'Sat' => 'Sabtu'
                            );

                            $pdf->Ln(0.4);
                            $pdf->Cell(0.1);
                            $pdf->Cell(1, 0.4, $no, 1, 0, 'C');
                            $pdf->Cell(2, 0.4, $dayList[$day], 1, 0, 'C');
                            $pdf->Cell(2, 0.4, $tanggalsliplembur, 1, 0, 'C');

                            $pdf->Cell(1.5, 0.4, $hasil['jam_masuk'], 1, 0, 'C');
                            $pdf->Cell(1.5, 0.4, $hasil['jam_istirahat'], 1, 0, 'C');
                            $pdf->Cell(1.5, 0.4, $hasil['jam_pulang'], 1, 0, 'C');
                            $pdf->Cell(1.5, 0.4, $hasil['jam_lembur'], 1, 0, 'C');

                            $pdf->Cell(1, 0.4, $hasil['jam_pertama'], 1, 0, 'C');
                            $pdf->Cell(1, 0.4, $hasil['jam_kedua'], 1, 0, 'C');
                            $pdf->Cell(1, 0.4, $hasil['jam_ketiga'], 1, 0, 'C');
                            $pdf->Cell(1, 0.4, $hasil['jam_keempat'], 1, 0, 'C');

                            $pdf->Cell(2.2, 0.4, format_angka($hasil['uang_makan_lembur']), 1, 0, 'C');
                            $pdf->Cell(2.2, 0.4, ' - ', 1, 0, 'C');

                            //percobaan
                            $total += $no;
                            //percobaan

                            $no++;
                            $jumlahjampertama += $hasil['jumlah_jam_pertama'];
                            $jumlahjamkedua += $hasil['jumlah_jam_kedua'];
                            $jumlahjamketiga += $hasil['jumlah_jam_ketiga'];
                            $jumlahjamkeempat += $hasil['jumlah_jam_keempat'];
                            $uangmakanlembur += $hasil['uang_makan_lembur'];



                        endforeach;
                        //var_dump($total);
                        //die;

                        $jumlahjamlembur    = $jumlahjampertama + $jumlahjamkedua + $jumlahjamketiga + $jumlahjamkeempat;
                        $jumlahuanglembur   = $jumlahjamlembur * $upahlemburperjam;
                        $jumlahuangditerima = $jumlahuanglembur + $uangmakanlembur;

                        $pdf->Ln(0.4);
                        $pdf->Cell(9.4);
                        $pdf->Cell(1.7, 0.4, 'Jumlah Jam', 0, 0, 'L');

                        $pdf->Cell(1, 0.4, $jumlahjampertama, 1, 0, 'C');
                        $pdf->Cell(1, 0.4, $jumlahjamkedua, 1, 0, 'C');
                        $pdf->Cell(1, 0.4, $jumlahjamketiga, 1, 0, 'C');
                        $pdf->Cell(1, 0.4, $jumlahjamkeempat, 1, 0, 'C');
                        $pdf->Cell(2.2, 0.4, format_angka($uangmakanlembur), 1, 0, 'C');
                        $pdf->Cell(2.2, 0.4, " - ", 1, 0, 'C');


                        $pdf->Ln(0.2);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Jam Lembur', 0, 0, 'L');

                        $pdf->Cell(1.5);
                        $pdf->Cell(3, 0.2, $jumlahjamlembur, 0, 0, 'C');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Upah Lembur Perjam', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($upahlemburperjam), 0, 0, 'R');

                        $pdf->SetFont('Arial', 'B', '7');
                        $pdf->Cell(1.5);
                        $pdf->Cell(5, 0.2, 'Note : 0.5 Dlm angka = 30 menit dlm jam ( Jam Istirahat Lembur )', 0, 0, 'L');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Ln(0.1);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Lembur', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($jumlahuanglembur), 0, 0, 'R');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Makan Lembur', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($uangmakanlembur), 0, 0, 'R');


                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Transport Lembur', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, " - ", 0, 0, 'R');


                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

                        $pdf->Ln(0.1);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Yang Diterima', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($jumlahuangditerima), 0, 0, 'R');


                        $pdf->Ln(0.6);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

                        $pdf->Cell(6, 0.2, 'Tangerang, ........................................,' . $tahun, 0, 0, 'L');

                        $pdf->Cell(3);
                        $pdf->Cell(5.4, 0.2, 'Yang Menerima', 0, 0, 'L');


                        $pdf->Ln(1.5);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Iwan Rahmat', 0, 0, 'L');


                        $pdf->Cell(9);
                        $pdf->Cell(5.4, 0.2, $hasil['nama_karyawan'], 0, 0, 'L');


                        $pdf->Ln(60);

                    endforeach;
                    $pdf->Output();
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal cetak slip lemburan besar
    public function cetaksliplemburbesar()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Cetak Slip Lemburan Besar';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data 
            $datapenempatan = $this->lembur->datapenempatanByID();
            $data['slip'] = $this->lembur->datacetaksliplemburbesar();

            //Mengambil data penempatan mulai tanggal dan sampai tanggal
            $penempatan         = $this->input->post('penempatan', true);
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
            $tanggalmulai       = substr($mulai_tanggal, 0, -8);
            $bulanmulai         = substr($mulai_tanggal, 3, -5);
            $tahunmulai         = substr($mulai_tanggal, -4);

            //Mengambil masing masing 2 digit
            $tanggalakhir       = substr($sampai_tanggal, 0, -8);
            $bulanakhir         = substr($sampai_tanggal, 3, -5);
            $tahunakhir         = substr($sampai_tanggal, -4);

            //Jika Data Kosong
            if ($data['slip'] == NULL) {
                redirect('lembur/formsliplemburbesar');
            }
            //Jika Tidak
            else {
                //Jika Pemilihan Tanggal Salah
                if ($mulaitanggal > $sampaitanggal) {
                    echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
                }
                //Jika Tidak
                else {

                    $pdf = new FPDF('P', 'cm', array(21, 28));
                    $pdf->setTopMargin(0.2);
                    $pdf->setLeftMargin(0.6);
                    $pdf->AddPage();
                    $pdf->SetAutoPageBreak(true);

                    foreach ($data['slip'] as $jl) :

                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(0.1);
                        $pdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
                        $pdf->Ln(0.4);
                        $pdf->SetFont('Arial', '', '9');
                        $pdf->Cell(0.1);
                        $pdf->Cell(10, 1, "BSD - " . $datapenempatan['penempatan'] . "", 0, 0, 'L');

                        $pdf->SetFont('Arial', 'B', '10');
                        $pdf->Ln(0.4);
                        $pdf->Cell(20, 1, "Bukti Tanda Terima Slip Lembur", 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(20, 1, "Periode " . $tanggalmulai . " " . bulan($bulanmulai) . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "", 0, 0, 'C');

                        $pdf->Ln(0.6);

                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Cell(0.1);
                        $pdf->Cell(7, 0.5, "Nama     : " . $jl['nama_karyawan'] . "", 0, 0, 'L');

                        $pdf->Ln(0.4);
                        $pdf->Cell(0.1);
                        $pdf->Cell(7, 0.5, "Bagian   : " . $jl['jabatan'] . " / " . $jl['penempatan'] . "", 0, 0, 'L');

                        $pdf->Ln(0.5);

                        $pdf->Cell(0.1);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->SetFillColor(255, 255, 255); // Warna sel tabel header
                        $pdf->Cell(1, 0.8, 'No', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.8, 'Hari', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.8, 'Tanggal', 1, 0, 'C', 1);

                        $pdf->Cell(4.5, 0.4, 'Jam Lembur ( Dlm Jam )', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.8, '', 1, 0, 'C', 1);

                        $pdf->Cell(4, 0.4, 'Perhitungan Jam Lembur', 1, 0, 'C', 1);
                        $pdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);
                        $pdf->Cell(2.2, 0.8, '', 1, 0, 'C', 1);

                        $pdf->Ln(0.4);
                        $pdf->Cell(5.1);
                        $pdf->Cell(1.5, 0.4, 'Masuk', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.4, 'Istirahat', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.4, 'Pulang', 1, 0, 'C', 1);

                        $pdf->Cell(1.5);
                        $pdf->Cell(1, 0.4, '1,5', 1, 0, 'C', 1);
                        $pdf->Cell(1, 0.4, '2', 1, 0, 'C', 1);
                        $pdf->Cell(1, 0.4, '3', 1, 0, 'C', 1);
                        $pdf->Cell(1, 0.4, '4', 1, 0, 'C', 1);

                        $pdf->Ln(-0.4);
                        $pdf->Cell(9.6);
                        $pdf->Cell(1.5, 0.4, 'Jam', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(9.6);
                        $pdf->Cell(1.5, 0.4, 'Lembur', 0, 0, 'C');


                        $pdf->Ln(-0.4);
                        $pdf->Cell(15.4);
                        $pdf->Cell(1.5, 0.4, 'Uang Makan', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(15.4);
                        $pdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

                        $pdf->Ln(-0.4);
                        $pdf->Cell(17.6);
                        $pdf->Cell(1.5, 0.4, 'U. Transport', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(17.6);
                        $pdf->Cell(1.5, 0.4, 'perhari ( Rp )', 0, 0, 'C');

                        $no = 1;
                        $jumlahjampertama = 0;
                        $jumlahjamkedua = 0;
                        $jumlahjamketiga = 0;
                        $jumlahjamkeempat = 0;
                        $uangmakanlembur = 0;
                        //
                        $total = 0;

                        //
                        $mulaitanggal         = $this->input->post('mulai_tanggal', true);
                        $sampaitanggal        = $this->input->post('sampai_tanggal', true);
                        $penempatan           = $this->input->post('penempatan', true);

                        //Mengambil data tahun
                        $tahunlembur         = substr($mulaitanggal, 0, -6);

                        $this->db->select('*');
                        $this->db->from('slip_lembur');
                        $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
                        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
                        $this->db->join('history_gaji', 'history_gaji.karyawan_id_history=karyawan.nik_karyawan');
                        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
                        $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
                        $this->db->where('penempatan_id', $penempatan);
                        $this->db->where('karyawan_id', $jl['nik_karyawan']);
                        $this->db->where('acc_supervisor !=', '');
                        $this->db->where('acc_manager !=', '');
                        $this->db->where('acc_hrd !=', '');
                        $this->db->where('tanggal_lembur >= ', $mulaitanggal);
                        $this->db->where('tanggal_lembur <= ', $sampaitanggal);
                        $this->db->order_by('tanggal_lembur');
                        $coba = $this->db->get()->result_array();

                        foreach ($coba as $hasil) :
                            $upahlemburperjam = $hasil['upah_lembur_perjam_history'];
                            $tanggalsliplembur = IndonesiaTgl($hasil['tanggal_lembur']);
                            $day = date('D', strtotime($hasil['tanggal_lembur']));
                            $dayList = array(
                                'Sun' => 'Minggu',
                                'Mon' => 'Senin',
                                'Tue' => 'Selasa',
                                'Wed' => 'Rabu',
                                'Thu' => 'Kamis',
                                'Fri' => 'Jumat',
                                'Sat' => 'Sabtu'
                            );

                            $pdf->Ln(0.4);
                            $pdf->Cell(0.1);
                            $pdf->Cell(1, 0.4, $no, 1, 0, 'C');
                            $pdf->Cell(2, 0.4, $dayList[$day], 1, 0, 'C');
                            $pdf->Cell(2, 0.4, $tanggalsliplembur, 1, 0, 'C');

                            $pdf->Cell(1.5, 0.4, $hasil['jam_masuk'], 1, 0, 'C');
                            $pdf->Cell(1.5, 0.4, $hasil['jam_istirahat'], 1, 0, 'C');
                            $pdf->Cell(1.5, 0.4, $hasil['jam_pulang'], 1, 0, 'C');
                            $pdf->Cell(1.5, 0.4, $hasil['jam_lembur'], 1, 0, 'C');

                            $pdf->Cell(1, 0.4, $hasil['jam_pertama'], 1, 0, 'C');
                            $pdf->Cell(1, 0.4, $hasil['jam_kedua'], 1, 0, 'C');
                            $pdf->Cell(1, 0.4, $hasil['jam_ketiga'], 1, 0, 'C');
                            $pdf->Cell(1, 0.4, $hasil['jam_keempat'], 1, 0, 'C');

                            $pdf->Cell(2.2, 0.4, format_angka($hasil['uang_makan_lembur']), 1, 0, 'C');
                            $pdf->Cell(2.2, 0.4, ' - ', 1, 0, 'C');

                            //percobaan
                            $total += $no;
                            //percobaan

                            $no++;
                            $jumlahjampertama += $hasil['jumlah_jam_pertama'];
                            $jumlahjamkedua += $hasil['jumlah_jam_kedua'];
                            $jumlahjamketiga += $hasil['jumlah_jam_ketiga'];
                            $jumlahjamkeempat += $hasil['jumlah_jam_keempat'];
                            $uangmakanlembur += $hasil['uang_makan_lembur'];



                        endforeach;
                        //var_dump($total);
                        //die;

                        $jumlahjamlembur    = $jumlahjampertama + $jumlahjamkedua + $jumlahjamketiga + $jumlahjamkeempat;
                        $jumlahuanglembur   = $jumlahjamlembur * $upahlemburperjam;
                        $jumlahuangditerima = $jumlahuanglembur + $uangmakanlembur;

                        $pdf->Ln(0.4);
                        $pdf->Cell(9.4);
                        $pdf->Cell(1.7, 0.4, 'Jumlah Jam', 0, 0, 'L');

                        $pdf->Cell(1, 0.4, $jumlahjampertama, 1, 0, 'C');
                        $pdf->Cell(1, 0.4, $jumlahjamkedua, 1, 0, 'C');
                        $pdf->Cell(1, 0.4, $jumlahjamketiga, 1, 0, 'C');
                        $pdf->Cell(1, 0.4, $jumlahjamkeempat, 1, 0, 'C');
                        $pdf->Cell(2.2, 0.4, format_angka($uangmakanlembur), 1, 0, 'C');
                        $pdf->Cell(2.2, 0.4, " - ", 1, 0, 'C');


                        $pdf->Ln(0.2);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Jam Lembur', 0, 0, 'L');

                        $pdf->Cell(1.5);
                        $pdf->Cell(3, 0.2, $jumlahjamlembur, 0, 0, 'C');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Upah Lembur Perjam', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($upahlemburperjam), 0, 0, 'R');

                        $pdf->SetFont('Arial', 'B', '7');
                        $pdf->Cell(1.5);
                        $pdf->Cell(5, 0.2, 'Note : 0.5 Dlm angka = 30 menit dlm jam ( Jam Istirahat Lembur )', 0, 0, 'L');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

                        $pdf->SetFont('Arial', '', '8');
                        $pdf->Ln(0.1);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Lembur', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($jumlahuanglembur), 0, 0, 'R');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Makan Lembur', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($uangmakanlembur), 0, 0, 'R');


                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Transport Lembur', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, " - ", 0, 0, 'R');


                        $pdf->Ln(0.3);
                        $pdf->Cell(0.1);
                        $pdf->Cell(9.5, 0, '', 1, 0, 'L', 1);

                        $pdf->Ln(0.1);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Jumlah Uang Yang Diterima', 0, 0, 'L');
                        $pdf->Cell(1.5, 0.2, 'Rp.', 0, 0, 'R');
                        $pdf->Cell(3, 0.2, format_angka($jumlahuangditerima), 0, 0, 'R');


                        $pdf->Ln(0.6);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

                        $pdf->Cell(6, 0.2, 'Tangerang, ........................................,' . $tahun, 0, 0, 'L');

                        $pdf->Cell(3);
                        $pdf->Cell(5.4, 0.2, 'Yang Menerima', 0, 0, 'L');


                        $pdf->Ln(1.5);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Iwan Rahmat', 0, 0, 'L');


                        $pdf->Cell(9);
                        $pdf->Cell(5.4, 0.2, $hasil['nama_karyawan'], 0, 0, 'L');


                        $pdf->Ln(60);

                    endforeach;
                    $pdf->Output();
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal data rekap lembur
    public function rekaplembur()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Rekap Lembur';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data penempatan
        $data['penempatan'] = $this->lembur->datapenempatan();
        //menampilkan halaman data rekap lembur
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cetak_lembur/cetak_rekaplembur', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal cetak rekap lemburan
    public function cetakrekaplembur()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Cetak Rekap Lemburan';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data 
            $datapenempatan = $this->lembur->datapenempatanByID();
            $data['rekap']  = $this->lembur->datacetakrekaplembur();

            //Mengambil data penempatan mulai tanggal dan sampai tanggal
            $penempatan         = $this->input->post('penempatan', true);
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
            $tanggalmulai       = substr($mulai_tanggal, 0, -8);
            $bulanmulai         = substr($mulai_tanggal, 3, -5);
            $tahunmulai         = substr($mulai_tanggal, -4);

            //Mengambil masing masing 2 digit
            $tanggalakhir       = substr($sampai_tanggal, 0, -8);
            $bulanakhir         = substr($sampai_tanggal, 3, -5);
            $tahunakhir         = substr($sampai_tanggal, -4);

            //Jika Data Kosong
            if ($data['rekap'] == NULL) {
                redirect('lembur/formrekaplembur');
            }
            //Jika Tidak
            else {
                //Jika Pemilihan Tanggal Salah
                if ($mulaitanggal > $sampaitanggal) {
                    echo "
            <script> alert(' Format Penulisan Tanggal Salah ');
            window . close();
            </script>
            ";
                }
                //Jika Tidak
                else {

                    foreach ($data['rekap'] as $key => $value) :

                        //Jika Data Dibawah 15 Maka Slip Kecil
                        if ($key <= 14) {
                            $pdf = new FPDF('L', 'cm', array(21, 14));
                        }
                        //Jika Diatas 15 Maka Slip Besar
                        else {
                            $pdf = new FPDF('P', 'cm', array(21, 28));
                        }
                        $pdf->setTopMargin(0.2);
                        $pdf->setLeftMargin(0.6);
                        $pdf->AddPage();
                        $pdf->SetAutoPageBreak(true);

                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(0.1);
                        $pdf->Cell(10, 1, "PT PRIMA KOMPONEN INDONESIA", 0, 0, 'L');
                        $pdf->Ln(0.4);
                        $pdf->SetFont('Arial', '', '9');
                        $pdf->Cell(0.1);
                        $pdf->Cell(10, 1, "BSD - " . $datapenempatan['penempatan'] . "", 0, 0, 'L');

                        $pdf->SetFont('Arial', 'B', '10');
                        $pdf->Ln(0.4);
                        $pdf->Cell(20, 1, "Daftar Rekap Lembur Karyawan", 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(20, 1, "Periode " . $tanggalmulai . " " . bulan($bulanmulai) . " s/d " . $tanggalakhir . " " . bulan($bulanakhir) . " " . $tahunakhir . "", 0, 0, 'C');

                        $pdf->Ln(0.6);

                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(0.1);
                        $pdf->Cell(7, 0.5, $datapenempatan['penempatan'], 0, 0, 'L');

                        $pdf->Ln(0.4);

                        $pdf->Cell(0.1);
                        $pdf->SetFont('Arial', '', '8');
                        $pdf->SetFillColor(255, 255, 255); // Warna sel tabel header
                        $pdf->Cell(1, 0.9, 'No', 1, 0, 'C', 1);
                        $pdf->Cell(4, 0.9, 'Nama Karyawan', 1, 0, 'C', 1);
                        $pdf->Cell(3, 0.9, 'Jabatan', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
                        $pdf->Cell(1.5, 0.9, '', 1, 0, 'C', 1);
                        $pdf->Cell(3, 0.9, 'Jumlah Uang Lembur', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.9, '', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.9, '', 1, 0, 'C', 1);
                        $pdf->Cell(2, 0.9, '', 1, 0, 'C', 1);

                        $pdf->Ln(0.1);
                        $pdf->Cell(8.1);
                        $pdf->Cell(1.5, 0.5, 'Jam', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(8.1);
                        $pdf->Cell(1.5, 0.5, 'Lembur', 0, 0, 'C');

                        $pdf->Ln(-0.4);
                        $pdf->Cell(9.6);
                        $pdf->SetFont('Arial', '', '6.5');
                        $pdf->Cell(1.5, 0.5, 'Upah Lembur', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(9.6);
                        $pdf->Cell(1.5, 0.5, 'Perjam', 0, 0, 'C');

                        $pdf->Ln(-0.4);
                        $pdf->Cell(14.3);
                        $pdf->SetFont('Arial', '', '7');
                        $pdf->Cell(1.5, 0.5, 'Uang Makan', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(14.3);
                        $pdf->Cell(1.5, 0.5, 'Lembur', 0, 0, 'C');

                        $pdf->Ln(-0.4);
                        $pdf->Cell(16.3);
                        $pdf->SetFont('Arial', '', '6.5');
                        $pdf->Cell(1.5, 0.5, 'Jumlah Uang', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(16.3);
                        $pdf->Cell(1.5, 0.5, 'Yang Diterima', 0, 0, 'C');

                        $pdf->Ln(-0.4);
                        $pdf->Cell(18.3);
                        $pdf->SetFont('Arial', '', '6.5');
                        $pdf->Cell(1.5, 0.5, 'Hasil Uang', 0, 0, 'C');

                        $pdf->Ln(0.4);
                        $pdf->Cell(18.3);
                        $pdf->Cell(1.5, 0.5, 'Yang Diterima', 0, 0, 'C');

                        $no = 1;
                        $totaljumlahuanglembur = 0;
                        $totaluangmakanlembur = 0;
                        $totaljumlahuangditerima = 0;
                        $totalhasiluangditerima = 0;

                        foreach ($data['rekap'] as $rkp) :

                            $hasilakhirjumlahjamlembur = $rkp['total_jam_pertama'] + $rkp['total_jam_kedua'] +
                                $rkp['total_jam_ketiga']  + $rkp['total_jam_keempat'];
                            $jumlahuanglembur           = $hasilakhirjumlahjamlembur * $rkp['upah_lembur_perjam_history'];
                            $hasiljumlahuangmakanlembur = $rkp['jumlahuangmakanlembur'];
                            $jumlahuangditerima         = $jumlahuanglembur + $hasiljumlahuangmakanlembur;

                            $pdf->SetFont('Arial', '', '7');
                            $pdf->Ln(0.4);
                            $pdf->Cell(0.1);
                            $pdf->Cell(1, 0.4, $no, 1, 0, 'C');
                            $pdf->Cell(4, 0.4, $rkp['nama_karyawan'], 1, 0, 'L');
                            $pdf->Cell(3, 0.4, $rkp['jabatan'], 1, 0, 'L');
                            $pdf->Cell(1.5, 0.4, $hasilakhirjumlahjamlembur, 1, 0, 'C');

                            $pdf->Cell(1.5, 0.4, format_angka($rkp['upah_lembur_perjam_history']), 1, 0, 'C');
                            $pdf->Cell(3, 0.4, format_angka($jumlahuanglembur), 1, 0, 'R');
                            $pdf->Cell(2, 0.4, format_angka($hasiljumlahuangmakanlembur), 1, 0, 'R');
                            $pdf->Cell(2, 0.4, format_angka($jumlahuangditerima), 1, 0, 'R');

                            $jumlahuangditerima = ceil($jumlahuangditerima);
                            if (substr($jumlahuangditerima, -2) >= 0) {
                                $total_jumlahuangditerima = round($jumlahuangditerima, -2);
                            } else {
                                $total_jumlahuangditerima = round($jumlahuangditerima, -2) + 100;
                            }

                            $pdf->Cell(2, 0.4, format_angka($total_jumlahuangditerima), 1, 0, 'R');

                            $no++;
                            $totaljumlahuanglembur += $jumlahuanglembur;
                            $totaluangmakanlembur += $hasiljumlahuangmakanlembur;
                            $totaljumlahuangditerima += $jumlahuangditerima;
                            $totalhasiluangditerima += $total_jumlahuangditerima;
                        endforeach;
                        $pdf->Ln(0.4);
                        $pdf->Cell(11.1);
                        $pdf->Cell(3, 0.4, format_angka($totaljumlahuanglembur), 1, 0, 'R');
                        $pdf->Cell(2, 0.4, format_angka($totaluangmakanlembur), 1, 0, 'R');
                        $pdf->Cell(2, 0.4, format_angka($totaljumlahuangditerima), 1, 0, 'R');
                        $pdf->Cell(2, 0.4, format_angka($totalhasiluangditerima), 1, 0, 'R');

                        $pdf->Ln(0.7);

                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Mengetahui', 0, 0, 'L');

                        $pdf->Cell(6, 0.2, 'Tangerang, ........................................,' . $tahun, 0, 0, 'L');

                        $pdf->Cell(3);
                        $pdf->Cell(5.4, 0.2, 'Diperiksa', 0, 0, 'L');


                        $pdf->Ln(1.5);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, 'Ballin Hadiwidjaya', 0, 0, 'L');



                        $pdf->Cell(9);
                        $pdf->Cell(5.4, 0.2, 'Rudiyanto', 0, 0, 'L');

                        $pdf->Ln(0.3);
                        $pdf->Cell(0.2);
                        $pdf->Cell(2, 0, '', 1, 0, 'L', 1);

                        $pdf->Cell(12);
                        $pdf->Cell(1.1, 0, '', 1, 0, 'L', 1);

                        $pdf->Ln(0.1);
                        $pdf->Cell(0.1);
                        $pdf->Cell(5, 0.2, '( General Manager )', 0, 0, 'L');

                        $pdf->Cell(9);
                        $pdf->Cell(5, 0.2, '( Manager HRD - GA )', 0, 0, 'L');
                    endforeach;
                    $pdf->Output();
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
