<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
{
    public function penjualan()
    {
        $data['title'] = 'Penjualan Produk';

        $this->load->library('pagination');
        // Halaman Pagination
        $config['total_rows'] = $this->Model_Keuangan->hitung_penjualan();
        $config['base_url'] = 'http://localhost/buku-usaha/keuangan/penjualan';
        // Total Baris Pagination
        $config['per_page'] = 3;

        // INISIALISASI Pagination
        $this->pagination->initialize($config);
        // END INISIALISASI

        $data['start'] = $this->uri->segment(3);
        $data['penjualan'] = $this->Model_Keuangan->get_penjualan($config['per_page'], $data['start']);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('penjualan/penjualan', $data);
        $this->load->view('template/footer');
    }

    public function tambah_penjualan()
    {
        $data['title'] = 'Tambah Data Penjualan Produk';
        $data['produk'] = $this->Model_Keuangan->ambil_produk();
        $this->form_validation->set_rules('produk', 'Produk', 'required', [
            'required' => 'Pilih Salah Satu Produk'
        ]);
        $this->form_validation->set_rules('unit', 'Unit', 'required|max_length[2]|greater_than[0]', [
            'required' => 'Unit Terjual Harus Diisi',
            'max_length' => 'Maksimal Unit Terjual Adalah 99',
            'greater_than' => 'Minimal Unit Terjual Adalah 1'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('penjualan/tambah_penjualan', $data);
            $this->load->view('template/footer');
        } else {
            $this->Model_Keuangan->tambah_penjualan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil</strong> Tambah Data Penjualan
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('keuangan/penjualan');
        }
    }

    public function pembelian()
    {
        $data['title'] = 'Pembelian Produk';
        // $data['pembelian'] = $this->Model_Produk->ambil_pembelian();

        $this->load->library('pagination');
        // Halaman Pagination
        $config['total_rows'] = $this->Model_Keuangan->hitung_pembelian();
        $config['base_url'] = 'http://localhost/buku-usaha/keuangan/pembelian';
        // Total Baris Pagination
        $config['per_page'] = 3;

        // INISIALISASI Pagination
        $this->pagination->initialize($config);
        // END INISIALISASI

        $data['start'] = $this->uri->segment(3);
        $data['pembelian'] = $this->Model_Keuangan->get_pembelian($config['per_page'], $data['start']);
        // END PAGINATION

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pembelian/pembelian', $data);
        $this->load->view('template/footer');
    }
}
