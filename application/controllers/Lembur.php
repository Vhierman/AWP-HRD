<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lembur extends CI_Controller
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

    //Menampilkan halaman awal data lembur 
    public function datalembur()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']  = 'Data Lembur';
        //Menyimpan session dari login
        $data['user']   = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data lembur di join dengan data karyawan
        $data['lembur'] = $this->lembur->datalembur();

        //Data Untuk Select Option Pada Tambah Data Lembur
        $data['karyawan']           = $this->lembur->datakaryawan();
        $data['jamlembur']          = $this->lembur->datajamlembur();
        $data['keteranganlembur']   = $this->lembur->dataketeranganlembur();

        //Validation Form Input
        $this->form_validation->set_rules('tanggal_lembur', 'Tanggal Lembur', 'required');
        $this->form_validation->set_rules('jenis_lembur', 'Tanggal Lembur', 'required');
        $this->form_validation->set_rules('jam_lembur', 'Jam Lembur', 'required');
        $this->form_validation->set_rules('keterangan_lembur', 'Keterangan Lembur', 'required');

        //jika validasinya salah akan menampilkan halaman lembur
        if ($this->form_validation->run() == false) {
            //menampilkan halaman data lembur
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('lembur/lembur', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method tambahdatalembur
            $nikkaryawan        = $this->input->post('nik_karyawan', TRUE);
            $jam_lembur         = $this->input->post('jam_lembur', TRUE);
            $keterangan_lembur  = $this->input->post('keterangan_lembur', TRUE);

            //Query Untuk Mencari Jam Masuk, Jam Istirahat, Jam Pulang
            $this->db->select('*');
            $this->db->from('jam_lembur');
            $this->db->where('id_jam_lembur', $jam_lembur);
            $jam = $this->db->get()->row_array();
            $datajam = [
                'jam_masuk' => $jam['jam_masuk'],
                'jam_istirahat' => $jam['jam_istirahat'],
                'jam_pulang' => $jam['jam_pulang']
            ];
            $jammasuk       = $datajam['jam_masuk'];
            $jamistirahat   = $datajam['jam_istirahat'];
            $jampulang      = $datajam['jam_pulang'];
            //End Untuk Mencari Jam Masuk, Jam Istirahat, Jam Pulang

            //Mencari Jumlah Jam Lembur
            $jamlembur = $jampulang - $jamistirahat - $jammasuk;

            //Mencari Uang Makan Lembur
            if ($jamlembur >= "3") {
                $uangmakanlembur = "12500";
            } else {
                $uangmakanlembur = "0";
            }

            //Mengambil Hari jenis Lembur Biasa Atau Libur
            $jenis_lembur = $this->input->post('jenis_lembur', TRUE);
            //End Mengambil Hari jenis Lembur Biasa Atau Libur

            // Rumus Perhitungan Jam 1 s/d 4
            //Jika Hari Libur
            if ($jenis_lembur == "Libur") {

                $jampertama = 0;

                if ($jamlembur < 7) {
                    $jamkedua = $jamlembur;
                    $jamketiga = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur == 7) {
                    $jamkedua = 7;
                    $jamketiga = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur > 7) {

                    $jamkedua = 7;

                    if ($jamlembur - $jamkedua > 1) {
                        $jamketiga = 1;
                        $jamkeempat = $jamlembur - $jamkedua - $jamketiga;
                    } elseif ($jamlembur - $jamkedua == 1) {
                        $jamketiga = 1;
                        $jamkeempat = 0;
                    } else {
                        $jamketiga = $jamlembur - $jamkedua;
                    }
                } else {
                    redirect('lembur/datalembur');
                }
            }
            //Jika Hari Biasa
            elseif ($jenis_lembur == "Biasa") {

                $jampertama = 0;

                if ($jamlembur < 1) {
                    $jampertama = $jamlembur;
                    $jamkedua   = 0;
                    $jamketiga  = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur == 1) {
                    $jampertama = 1;
                    $jamkedua   = 0;
                    $jamketiga  = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur > 1) {

                    $jampertama = 1;

                    if ($jamlembur < 8) {
                        $jamkedua = $jamlembur - $jampertama;
                        $jamketiga = 0;
                        $jamkeempat = 0;
                    } elseif ($jamlembur == 8) {
                        $jamkedua = 7;
                        $jamketiga = 0;
                        $jamkeempat = 0;
                    } elseif ($jamlembur > 8) {

                        $jamkedua = 7;

                        if ($jamlembur - $jamkedua - $jampertama == 1) {

                            $jamketiga = 1;
                            $jamkeempat = 0;
                        } elseif ($jamlembur - $jamkedua - $jampertama > 1) {

                            $jamketiga = 1;
                            $jamkeempat = $jamlembur - $jamketiga - $jamkedua - $jampertama;
                        } elseif ($jamlembur - $jamkedua - $jampertama < 1) {

                            $jamketiga = $jamlembur - $jamkedua - $jampertama;
                            $jamkeempat = 0;
                        }
                    }
                }
            }
            // End Rumus
            // Jika Salah
            else {
                redirect('lembur/datalembur');
            }

            //Hasil Rumus
            $jumlahjampertama     = $jampertama * 1.5;
            $jumlahjamkedua       = $jamkedua * 2;
            $jumlahjamketiga      = $jamketiga * 3;
            $jumlahjamkeempat     = $jamkeempat * 4;
            //End Rumus

            //Mengirimkan data ke model
            $this->lembur->tambahdatalembur($nikkaryawan, $jenis_lembur, $jam_lembur, $keterangan_lembur, $jamlembur, $jampertama, $jumlahjampertama, $jamkedua, $jumlahjamkedua, $jamketiga, $jumlahjamketiga, $jamkeempat, $jumlahjamkeempat, $uangmakanlembur);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Lembur</div>');
            //dan mendirect kehalaman lembur
            redirect('lembur/datalembur');
        }
    }

    //Hapus Data Lembur
    public function hapuslembur($id_slip_lembur)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

        //mendelete kedalam database melalui method pada model lembur berdasarkan id nya
        $this->lembur->hapuslembur($id_slip_lembur);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Lembur</div>');
        //dan mendirect kehalaman lembur
        redirect('lembur/datalembur');

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Edit Data Lembur 
    public function editlembur($id_slip_lembur)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title']  = 'Edit Data Lembur';
        //Menyimpan session dari login
        $data['user']   = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data lembur di join karyawan
        $data['lembur'] = $this->lembur->getLemburByID($id_slip_lembur);
        //Mengambil data jam dan keterangan lembur
        $data['jamlembur'] = $this->lembur->getAllJamLembur();
        $data['keteranganlembur'] = $this->lembur->getAllKeteranganLembur();
        //untuk tipe datanya enum
        $data['jenis_lembur'] = [
            '' => 'Pilih Jenis Lembur',
            'Libur' => 'Libur',
            'Biasa' => 'Biasa'
        ];

        //Validation Form Edit
        $this->form_validation->set_rules('tanggal_lembur', 'Tanggal Lembur', 'required');
        $this->form_validation->set_rules('jenis_lembur', 'Tanggal Lembur', 'required');
        $this->form_validation->set_rules('jam_lembur', 'Jam Lembur', 'required');
        $this->form_validation->set_rules('keterangan_lembur', 'Keterangan Lembur', 'required');

        //jika validasinya salah akan menampilkan halaman lembur
        if ($this->form_validation->run() == false) {
            //menampilkan halaman data lembur
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('lembur/edit_lembur', $data);
            $this->load->view('templates/footer');
        }
        //Jika validasinya benar
        else {
            //Hanya 3 parameter ini yang di edit, jika tanggal lemburnya salah, maka lebih baik dihapus, dan di input ulang
            $jenis_lembur       = $this->input->post('jenis_lembur', TRUE);
            $jam_lembur         = $this->input->post('jam_lembur', TRUE);
            $keterangan_lembur  = $this->input->post('keterangan_lembur', TRUE);

            //Query Untuk Mencari Jam Masuk, Jam Istirahat, Jam Pulang
            $this->db->select('*');
            $this->db->from('jam_lembur');
            $this->db->where('id_jam_lembur', $jam_lembur);
            $jam = $this->db->get()->row_array();
            $datajam = [
                'jam_masuk' => $jam['jam_masuk'],
                'jam_istirahat' => $jam['jam_istirahat'],
                'jam_pulang' => $jam['jam_pulang']
            ];
            $jammasuk       = $datajam['jam_masuk'];
            $jamistirahat   = $datajam['jam_istirahat'];
            $jampulang      = $datajam['jam_pulang'];
            //End Untuk Mencari Jam Masuk, Jam Istirahat, Jam Pulang

            //Mencari Jumlah Jam Lembur
            $jamlembur = $jampulang - $jamistirahat - $jammasuk;

            //Mencari Uang Makan Lembur
            if ($jamlembur >= "3") {
                $uangmakanlembur = "12500";
            } else {
                $uangmakanlembur = "0";
            }
            //End Uang makan lembur

            // Rumus Perhitungan Jam 1 s/d 4
            //Jika Hari Libur
            if ($jenis_lembur == "Libur") {

                $jampertama = 0;

                if ($jamlembur < 7) {
                    $jamkedua = $jamlembur;
                    $jamketiga = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur == 7) {
                    $jamkedua = 7;
                    $jamketiga = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur > 7) {

                    $jamkedua = 7;

                    if ($jamlembur - $jamkedua > 1) {
                        $jamketiga = 1;
                        $jamkeempat = $jamlembur - $jamkedua - $jamketiga;
                    } elseif ($jamlembur - $jamkedua == 1) {
                        $jamketiga = 1;
                        $jamkeempat = 0;
                    } else {
                        $jamketiga = $jamlembur - $jamkedua;
                    }
                } else {
                    redirect('lembur/datalembur');
                }
            }
            //Jika Hari Biasa
            elseif ($jenis_lembur == "Biasa") {

                $jampertama = 0;

                if ($jamlembur < 1) {
                    $jampertama = $jamlembur;
                    $jamkedua   = 0;
                    $jamketiga  = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur == 1) {
                    $jampertama = 1;
                    $jamkedua   = 0;
                    $jamketiga  = 0;
                    $jamkeempat = 0;
                } elseif ($jamlembur > 1) {

                    $jampertama = 1;

                    if ($jamlembur < 8) {
                        $jamkedua = $jamlembur - $jampertama;
                        $jamketiga = 0;
                        $jamkeempat = 0;
                    } elseif ($jamlembur == 8) {
                        $jamkedua = 7;
                        $jamketiga = 0;
                        $jamkeempat = 0;
                    } elseif ($jamlembur > 8) {

                        $jamkedua = 7;

                        if ($jamlembur - $jamkedua - $jampertama == 1) {

                            $jamketiga = 1;
                            $jamkeempat = 0;
                        } elseif ($jamlembur - $jamkedua - $jampertama > 1) {

                            $jamketiga = 1;
                            $jamkeempat = $jamlembur - $jamketiga - $jamkedua - $jampertama;
                        } elseif ($jamlembur - $jamkedua - $jampertama < 1) {

                            $jamketiga = $jamlembur - $jamkedua - $jampertama;
                            $jamkeempat = 0;
                        }
                    }
                }
            }
            // End Rumus
            // Jika Salah
            else {
                redirect('lembur/datalembur');
            }

            //Hasil Rumus
            $jumlahjampertama     = $jampertama * 1.5;
            $jumlahjamkedua       = $jamkedua * 2;
            $jumlahjamketiga      = $jamketiga * 3;
            $jumlahjamkeempat     = $jamkeempat * 4;
            //End Rumus

            //Mengirimkan data ke model
            $this->lembur->editdatalembur($id_slip_lembur, $jam_lembur, $keterangan_lembur, $jamlembur, $jenis_lembur, $jampertama, $jumlahjampertama, $jamkedua, $jumlahjamkedua, $jamketiga, $jumlahjamketiga, $jamkeempat, $jumlahjamkeempat, $uangmakanlembur);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Lembur</div>');
            //dan mendirect kehalaman lembur
            redirect('lembur/datalembur');
        }

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
