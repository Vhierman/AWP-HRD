<?php
class Chart_model extends CI_Model
{

    //Menghitung Jumlah Karyawan Wanita
    public function JumlahKaryawanWanita()
    {
        $query = $this->db->query("SELECT * FROM karyawan where jenis_kelamin = 'Wanita' ");
        $karyawanwanita = $query->num_rows();
        return $karyawanwanita;
    }

    //Menghitung Jumlah Karyawan Pria
    public function JumlahKaryawanPria()
    {
        $query = $this->db->query("SELECT * FROM karyawan where jenis_kelamin = 'Pria' ");
        $karyawanpria = $query->num_rows();
        return $karyawanpria;
    }

    //Menghitung Jumlah Karyawan Petra
    public function JumlahKaryawanPetra()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('perusahaan', 'perusahaan.id=karyawan.perusahaan_id');
        $this->db->where('perusahaan', 'PT Petra Ariesca ( Outsourching )');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Prima
    public function JumlahKaryawanPrima()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('perusahaan', 'perusahaan.id=karyawan.perusahaan_id');
        $this->db->where('perusahaan', 'PT Prima Komponen Indonesia');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Islam
    public function JumlahKaryawanIslam()
    {
        $query = $this->db->query("SELECT * FROM karyawan where agama = 'Islam' ");
        $karyawanislam = $query->num_rows();
        return $karyawanislam;
    }

    //Menghitung Jumlah Karyawan Non Islam
    public function JumlahKaryawanNonIslam()
    {
        $query = $this->db->query("SELECT * FROM karyawan where agama != 'Islam' ");
        $karyawannonislam = $query->num_rows();
        return $karyawannonislam;
    }

    //Menghitung Jumlah Karyawan Tetap
    public function JumlahKaryawanTetap()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_kerja = 'PKWTT' ");
        $karyawantetap = $query->num_rows();
        return $karyawantetap;
    }

    //Menghitung Jumlah Karyawan Kontrak
    public function JumlahKaryawanKontrak()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_kerja = 'PKWT' ");
        $karyawankontrak = $query->num_rows();
        return $karyawankontrak;
    }

    //Menghitung Jumlah Karyawan Outsourcing
    public function JumlahKaryawanOutsourcing()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_kerja = 'Outsourcing' ");
        $karyawanoutsourcing = $query->num_rows();
        return $karyawanoutsourcing;
    }

    //Menghitung Jumlah Karyawan Single
    public function JumlahKaryawanSingle()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_nikah = 'Single' ");
        $karyawansingle = $query->num_rows();
        return $karyawansingle;
    }

    //Menghitung Jumlah Karyawan Menikah
    public function JumlahKaryawanMenikah()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_nikah = 'Menikah' ");
        $karyawanmenikah = $query->num_rows();
        return $karyawanmenikah;
    }

    //Menghitung Jumlah Karyawan Janda
    public function JumlahKaryawanJanda()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_nikah = 'Janda' ");
        $karyawanjanda = $query->num_rows();
        return $karyawanjanda;
    }

    //Menghitung Jumlah Karyawan Duda
    public function JumlahKaryawanDuda()
    {
        $query = $this->db->query("SELECT * FROM karyawan where status_nikah = 'Duda' ");
        $karyawanduda = $query->num_rows();
        return $karyawanduda;
    }

    //Menghitung Jumlah Karyawan HRD
    public function JumlahPenempatanHRD()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'HRD - GA');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan IT
    public function JumlahPenempatanIT()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'IT');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan HRD
    public function JumlahPenempatanDocumentControl()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Document Control');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Purchasing
    public function JumlahPenempatanPurchasing()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Purchasing');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Accounting
    public function JumlahPenempatanAccounting()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Accounting');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Marketing
    public function JumlahPenempatanMarketing()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Marketing');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Engineering
    public function JumlahPenempatanEngineering()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Engineering');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Quality
    public function JumlahPenempatanQuality()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Quality');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PPC
    public function JumlahPenempatanPPC()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PPC');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PPC
    public function JumlahPenempatanIC()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Inventory Control');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Produksi
    public function JumlahPenempatanProduksi()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Produksi');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Delivery
    public function JumlahPenempatanDelivery()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Delivery');
        return $this->db->get()->num_rows();
    }
    //Menghitung Jumlah Karyawan DeliveryProduksi
    public function JumlahPenempatanDeliveryProduksi()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Delivery Produksi');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Gudang Raw Material
    public function JumlahPenempatanGudangRawMaterial()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Gudang Raw Material');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Gudang Finish Goods
    public function JumlahPenempatanGudangFinishGoods()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Gudang Finish Goods');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Blok BL
    public function JumlahPenempatanBlokBL()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Blok BL');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Blok E
    public function JumlahPenempatanBlokE()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Blok E');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan Security
    public function JumlahPenempatanSecurity()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'Security');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Daihatsu Cibinong
    public function JumlahPenempatanPDCDaihatsuCibinong()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Daihatsu Cibinong');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Daihatsu Sunter
    public function JumlahPenempatanPDCDaihatsuSunter()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Daihatsu Sunter');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Daihatsu Cibitung
    public function JumlahPenempatanPDCDaihatsuCibitung()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Daihatsu Cibitung');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Daihatsu Karawang Timur
    public function JumlahPenempatanPDCDaihatsuKarawangTimur()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Daihatsu Karawang Timur');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Isuzu P Ungu
    public function JumlahPenempatanPDCIsuzuPUngu()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Isuzu P.UNGU');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Toyota Sunterlake
    public function JumlahPenempatanPDCToyotaSunterlake()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Toyota Sunterlake');
        return $this->db->get()->num_rows();
    }

    //Menghitung Jumlah Karyawan PDC Toyota Cibitung
    public function JumlahPenempatanPDCToyotaCibitung()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('penempatan', 'PDC Toyota Cibitung');
        return $this->db->get()->num_rows();
    }
}
