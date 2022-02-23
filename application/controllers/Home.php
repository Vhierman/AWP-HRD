<?php
defined('BASEPATH') or exit('No direct script access allowed');

//Controller Untuk Halaman Admin
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil Model Chart_model dengan memberikan nama chart
        $this->load->model('chart/Chart_model', 'chart');
        //load library validation
        $this->load->library('form_validation');
        //helper untuk mengecek, dia sudah login apa belum, dan dia rolenya apa..?
        is_logged_in();
    }

    //method index
    public function index()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Dashboard';
        //Mengambil Session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Donut Chart

        //Donut Chart Jumlah Karyawan Wanita
        $data['jumlahkaryawanwanita'] = $this->chart->JumlahKaryawanWanita();
        //Donut Chart Jumlah Karyawan Pria
        $data['jumlahkaryawanpria'] = $this->chart->JumlahKaryawanPria();

        //Donut Chart Jumlah Karyawan Petra
        $data['jumlahkaryawanpetra'] = $this->chart->JumlahKaryawanPetra();
        //Donut Chart Jumlah Karyawan Prima
        $data['jumlahkaryawanprima'] = $this->chart->JumlahKaryawanPrima();

        //Donut Chart Jumlah Karyawan Islam
        $data['jumlahkaryawanislam'] = $this->chart->JumlahKaryawanIslam();
        //Donut Chart Jumlah Karyawan Non Islam
        $data['jumlahkaryawannonislam'] = $this->chart->JumlahKaryawanNonIslam();

        //Donut Chart Jumlah Karyawan Kontrak
        $data['jumlahkaryawankontrak'] = $this->chart->JumlahKaryawanKontrak();
        //Donut Chart Jumlah Karyawan Tetap
        $data['jumlahkaryawantetap'] = $this->chart->JumlahKaryawanTetap();
        //Donut Chart Jumlah Karyawan Outsourcing
        $data['jumlahkaryawanoutsourcing'] = $this->chart->JumlahKaryawanOutsourcing();

        //Donut Chart Jumlah Karyawan Single
        $data['jumlahkaryawansingle'] = $this->chart->JumlahKaryawanSingle();
        //Donut Chart Jumlah Karyawan Menikah
        $data['jumlahkaryawanmenikah'] = $this->chart->JumlahKaryawanMenikah();
        //Donut Chart Jumlah Karyawan Janda
        $data['jumlahkaryawanjanda'] = $this->chart->JumlahKaryawanJanda();
        //Donut Chart Jumlah Karyawan Duda
        $data['jumlahkaryawanduda'] = $this->chart->JumlahKaryawanDuda();


        //Donut Chart Jumlah Karyawan Per Departement
        //Donut Chart Jumlah Karyawan HRD - GA
        $data['jumlahkaryawanhrdga'] = $this->chart->JumlahPenempatanHRD();
        //Donut Chart Jumlah Karyawan IT
        $data['jumlahkaryawanit'] = $this->chart->JumlahPenempatanIT();
        //Donut Chart Jumlah Karyawan Document Control
        $data['jumlahkaryawandocumentcontrol'] = $this->chart->JumlahPenempatanDocumentControl();
        //Donut Chart Jumlah Karyawan Purchasing
        $data['jumlahkaryawanpurchasing'] = $this->chart->JumlahPenempatanPurchasing();
        //Donut Chart Jumlah Karyawan Accounting
        $data['jumlahkaryawanaccounting'] = $this->chart->JumlahPenempatanAccounting();
        //Donut Chart Jumlah Karyawan Merketing
        $data['jumlahkaryawanmarketing'] = $this->chart->JumlahPenempatanMarketing();
        //Donut Chart Jumlah Karyawan Engineering
        $data['jumlahkaryawanengineering'] = $this->chart->JumlahPenempatanEngineering();
        //Donut Chart Jumlah Karyawan Quality
        $data['jumlahkaryawanquality'] = $this->chart->JumlahPenempatanQuality();
        //Donut Chart Jumlah Karyawan PPC
        $data['jumlahkaryawanppc'] = $this->chart->JumlahPenempatanPPC();
        //Donut Chart Jumlah Karyawan IC
        $data['jumlahkaryawanic'] = $this->chart->JumlahPenempatanIC();
        //Donut Chart Jumlah Karyawan Produksi
        $data['jumlahkaryawanproduksi'] = $this->chart->JumlahPenempatanProduksi();
        //Donut Chart Jumlah Karyawan Delivery
        $data['jumlahkaryawandelivery'] = $this->chart->JumlahPenempatanDelivery();
        //Donut Chart Jumlah Karyawan Delivery Produksi
        $data['jumlahkaryawandeliveryproduksi'] = $this->chart->JumlahPenempatanDeliveryProduksi();
        //Donut Chart Jumlah Karyawan Gudang RM
        $data['jumlahkaryawangudangrawmaterial'] = $this->chart->JumlahPenempatanGudangRawMaterial();
        //Donut Chart Jumlah Karyawan Gudang FG
        $data['jumlahkaryawangudangfinishgoods'] = $this->chart->JumlahPenempatanGudangFinishGoods();
        //Donut Chart Jumlah Karyawan Blok BL
        $data['jumlahkaryawanblokbl'] = $this->chart->JumlahPenempatanBlokBL();
        //Donut Chart Jumlah Karyawan Blok E
        $data['jumlahkaryawanbloke'] = $this->chart->JumlahPenempatanBlokE();
        //Donut Chart Jumlah Karyawan Security
        $data['jumlahkaryawansecurity'] = $this->chart->JumlahPenempatanSecurity();
        //Donut Chart Jumlah Karyawan Daihatsu Cibinong
        $data['jumlahkaryawandaihatsucibinong'] = $this->chart->JumlahPenempatanPDCDaihatsuCibinong();
        //Donut Chart Jumlah Karyawan Daihatsu SUnter
        $data['jumlahkaryawandaihatsusunter'] = $this->chart->JumlahPenempatanPDCDaihatsuSunter();
        //Donut Chart Jumlah Karyawan Daihatsu Cibitung
        $data['jumlahkaryawandaihatsucibitung'] = $this->chart->JumlahPenempatanPDCDaihatsuCibitung();
        //Donut Chart Jumlah Karyawan Daihatsu Karawang Timur
        $data['jumlahkaryawandaihatsukarawangtimur'] = $this->chart->JumlahPenempatanPDCDaihatsuKarawangTimur();
        //Donut Chart Jumlah Karyawan Isuzu P UNGU
        $data['jumlahkaryawanisuzupungu'] = $this->chart->JumlahPenempatanPDCIsuzuPUngu();
        //Donut Chart Jumlah Karyawan Toyota Sunterlake
        $data['jumlahkaryawantoyotasunterlake'] = $this->chart->JumlahPenempatanPDCToyotaSunterlake();
        //Donut Chart Jumlah Karyawan Toyota Cibitung
        $data['jumlahkaryawantoyotacibitung'] = $this->chart->JumlahPenempatanPDCToyotaCibitung();

        //Jumlah Karyawan Seluruh PDC
        $data['karyawanPDC'] = $data['jumlahkaryawantoyotacibitung'] + $data['jumlahkaryawantoyotasunterlake'] + $data['jumlahkaryawanisuzupungu'] + $data['jumlahkaryawandaihatsukarawangtimur'] + $data['jumlahkaryawandaihatsucibitung'] + $data['jumlahkaryawandaihatsusunter'] + $data['jumlahkaryawandaihatsucibinong'];

        //Jumlah Karyawan Seluruh BSD
        $data['karyawanBSD'] = $data['jumlahkaryawanhrdga'] + $data['jumlahkaryawandocumentcontrol'] + $data['jumlahkaryawanit'] + $data['jumlahkaryawanpurchasing']  + $data['jumlahkaryawanmarketing'] + $data['jumlahkaryawanengineering'] + $data['jumlahkaryawanquality'] + $data['jumlahkaryawanppc'] + $data['jumlahkaryawanic'] + $data['jumlahkaryawanproduksi'] + $data['jumlahkaryawandelivery'] + $data['jumlahkaryawandeliveryproduksi'] + $data['jumlahkaryawangudangrawmaterial'] + $data['jumlahkaryawangudangfinishgoods'] + $data['jumlahkaryawanbloke'] + $data['jumlahkaryawansecurity'];

        //Jumlah Semua Karyawan 
        $data['karyawanAccounting'] = $data['jumlahkaryawanaccounting'] + $data['jumlahkaryawanblokbl'] ;
        
        //Jumlah Semua Karyawan 
        $data['karyawanALL'] = $data['karyawanBSD'] + $data['karyawanPDC'] + $data['karyawanAccounting'];

        //menampilkan Halaman Utama
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }
}
