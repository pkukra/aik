<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if(!$this->session->userdata('user_id')) {
            redirect('login');
        }

        // Ambil role
        if ($this->session->userdata('role') != 'admin') {
            if($this->session->userdata('struktural') == NULL){
                show_error("Anda tidak memiliki akses");
            }
        }
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Report_model');
        $this->load->model('Unit_model');
        $this->load->model('Aktivitas_model');
    }

    // Halaman list unit
    public function index()
    {
        $id = $this->input->get('id');
        // $m  = $this->input->get('m');
        $m = $this->input->get('m');
        $y = $this->input->get('y');

        $m = !empty($m) ? $m : date('m');
        $y = !empty($y) ? $y : date('Y');

        $data['m'] = $m;
        $data['y'] = $y;

        $data['unit'] = $this->Unit_model->get_by_id($id);
        $user = $this->Report_model->get_report_by_unit($id);

        $totbulan = 0; // total semua user
        $list = [];

        foreach ($user as $k) {

            $total_user = 0; // RESET tiap user

            $aktivitas = $this->Aktivitas_model
                            ->count_aktivitas_user($k->id,$m,$y);
            foreach ($aktivitas as $a) {
                $total_user += $a->poin;
            }

            // simpan per user
            $list[] = (object)[
                'nama' => $k->nama,
                'poin' => $total_user
            ];

            // total keseluruhan
            $totbulan += $total_user;
        }

        $data['list']      = $list;
        $data['totbulan']  = $totbulan;

        $this->load->view('templates/header');
        $this->load->view('report_list', $data);
        $this->load->view('templates/footer');
    }



    // Halaman tambah
    public function add() {
        $id = $this->input->get('id');
        $data['sub'] = $this->Subkegiatan_model->get_subkegiatan_by_idkegiatan($id);
        $data['id_kegiatan'] = $id;
        $this->load->view('templates/header');
        $this->load->view('report_add',$data);
        $this->load->view('templates/footer');
    }

    // Proses simpan
    public function save() {
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jam', 'jam', 'required');
        $this->form_validation->set_rules('id_kegiatan', 'Kegiatan', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            return;
        }

        $id_kegiatan = $this->input->post('id_kegiatan');
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $waktu_report = $tanggal.' '.$jam;

        $data = [
            'id_kegiatan' => $id_kegiatan,
            'id_sub' => $this->input->post('id_sub'),
            'nama_report' => $this->input->post('nama_report'),
            'waktu_report' => $waktu_report,
            'keterangan' => $this->input->post('keterangan'),
            'id_user' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->Report_model->insert($data);
        redirect('report?id='.$id_kegiatan);
    }

    // Halaman edit
    public function edit($id) {
        $data['detail'] = $this->Report_model->get_by_id($id);
        $data['icon'] = $this->Report_model->get_icon();
        if (!$data['detail']) {
            show_404();
        }

        $this->load->view('templates/header');
        $this->load->view('report_edit', $data);
        $this->load->view('templates/footer');
    }

    // Proses update
    public function update($id) {
        $data = [
            'nama_report' => $this->input->post('nama_unit'),
            'poin' => $this->input->post('poin'),
            'icon' => $this->input->post('icon'),
        ];

        $this->Report_model->update($id, $data);
        redirect('report');
    }

    // Hapus unit
    public function delete($id) {
        $report = $this->Report_model->get_by_id($id);
        $id_kegiatan = $report->id_kegiatan;
        $this->Report_model->delete($id);
        redirect('report?id='.$id_kegiatan);
    }
        
    public function export_excel($id)
    {
        include APPPATH.'third_party/PHPExcel.php';
        $m = (int) $this->input->get('m');
        $y = $this->input->get('y');
        $bulanIndo = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Nama bulan terpilih
        $namaBulan = $bulanIndo[$m];

        $unit   = $this->Unit_model->get_by_id($id);
        $list   = $this->Report_model->get_report_by_unit($id);

        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();
        $sheet->setTitle('Data Pegawai');

        // Judul
        $sheet->setCellValue('A1', 'LAPORAN POIN PEGAWAI');
        $sheet->setCellValue('A2', 'Bulan '.$namaBulan.' '.$y);

        // Merge
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        // Bold + center
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A1:F2')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Header
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Pegawai');
        $sheet->setCellValue('C4', 'Poin');
        $sheet->setCellValue('D4', 'Persen Poin');
        $sheet->setCellValue('E4', 'Majelis Taklim');
        $sheet->setCellValue('F4', 'Persen Majelis Taklim');

        // Bold header
        $sheet->getStyle('A4:F4')->getFont()->setBold(true);

        // Isi data
        $no = 1;
        $row = 5;
        foreach ($list as $u) {
            $totbulan = 0;
            $majelis = 0;
            $aktivitas = $this->Aktivitas_model->count_aktivitas_user($u->id,$m,$y);
            foreach ($aktivitas as $a) {
                $totbulan += $a->poin;
                if($a->id_kegiatan == '15' || $a->id_kegiatan == '16'):
                    $majelis++;
                endif;
            }
            $persen1 = $totbulan/2000*100;
            $persen2 = $majelis/4*100;

            $sheet->setCellValue('A'.$row, $no);
            $sheet->setCellValue('B'.$row, $u->nama);
            $sheet->setCellValue('C'.$row, $totbulan);
            $sheet->setCellValue('D'.$row, $persen1.'%');
            $sheet->setCellValue('E'.$row, $majelis);
            $sheet->setCellValue('F'.$row, $persen2.'%');

            $row++;
            $no++;
        }

        // ===============================
        //          BORDER STYLE
        // ===============================
        $styleBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        // Range border dari header sampai data terakhir
        $lastRow = $row - 1;
        $sheet->getStyle('A4:F'.$lastRow)->applyFromArray($styleBorder);

        // Auto width
        foreach(range('A','D') as $col){
            $excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        // File export
        $unitname = preg_replace('/[^A-Za-z0-9_-]/', '_', $unit->nama_unit);
        $filename = "Pegawai_".$unitname."_".date('F_Y').".xlsx";

        ob_end_clean();
        ob_start();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;

    }

    public function export_excel_all()
    {
        include APPPATH.'third_party/PHPExcel.php';

        $m = (int) $this->input->get('m');
        $y = (int) $this->input->get('y');

        $bulanIndo = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
        $namaBulan = $bulanIndo[$m];

        $list = $this->Report_model->get_report_all();

        // ===============================
        // GROUP BY UNIT
        // ===============================
        $dataUnit = [];
        foreach ($list as $u) {
            $dataUnit[$u->nama_unit][] = $u;
        }

        $excel = new PHPExcel();
        $excel->removeSheetByIndex(0);

        // Border style
        $styleBorder = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ]
            ]
        ];

        $sheetIndex = 0;

        // ===============================
        // LOOP PER UNIT → PER SHEET
        // ===============================
        foreach ($dataUnit as $namaUnit => $pegawai) {

            $sheet = $excel->createSheet($sheetIndex);
            $sheetName = preg_replace('/[\\\\\\/\\?\\*\\:\\[\\]]/', '', $namaUnit);
            $sheetName = trim($sheetName);
            $sheetName = substr($sheetName, 0, 31);

            $sheet->setTitle($sheetName);

            // ===== JUDUL =====
            $sheet->setCellValue('A1', 'LAPORAN POIN PEGAWAI');
            $sheet->setCellValue('A2', 'Unit : '.$namaUnit);
            $sheet->setCellValue('A3', 'Bulan '.$namaBulan.' '.$y);

            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:G2');
            $sheet->mergeCells('A3:G3');

            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1:G3')->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // ===== HEADER =====
            $sheet->setCellValue('A5', 'No');
            $sheet->setCellValue('B5', 'Nama Pegawai');
            $sheet->setCellValue('C5', 'Unit');
            $sheet->setCellValue('D5', 'Poin');
            $sheet->setCellValue('E5', 'Persen Poin');
            $sheet->setCellValue('F5', 'Majelis Taklim');
            $sheet->setCellValue('G5', 'Persen Majelis Taklim');
            $sheet->getStyle('A5:G5')->getFont()->setBold(true);

            // ===== DATA =====
            $row = 6;
            $no  = 1;

            foreach ($pegawai as $u) {
                $totbulan = 0;
                $majelis = 0;
                $aktivitas = $this->Aktivitas_model->count_aktivitas_user($u->id,$m,$y);
                foreach ($aktivitas as $a) {
                    $totbulan += $a->poin;
                    if($a->id_kegiatan == '15' || $a->id_kegiatan == '16'):
                        $majelis++;
                    endif;
                }
                //echo $u->id.' '.$u->nama.' '.$namaUnit.' '.$totbulan.'<br>';
                $persen1 = $totbulan/2000*100;
                $persen2 = $majelis/4*100;

                $sheet->setCellValue('A'.$row, $no);
                $sheet->setCellValue('B'.$row, $u->nama);
                $sheet->setCellValue('C'.$row, $namaUnit);
                $sheet->setCellValue('D'.$row, $totbulan);
                $sheet->setCellValue('E'.$row, $persen1.'%');
                $sheet->setCellValue('F'.$row, $majelis);
                $sheet->setCellValue('G'.$row, $persen2.'%');

                $row++;
                $no++;
            }
            // ===== BORDER & AUTOSIZE =====
            $lastRow = $row - 1;
            $sheet->getStyle('A5:G'.$lastRow)->applyFromArray($styleBorder);

            foreach (range('A','G') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Freeze header
            $sheet->freezePane('A6');

            $sheetIndex++;
        }

        // ===============================
        // EXPORT FILE
        // ===============================
        $excel->setActiveSheetIndex(0);

        $filename = "Laporan_Poin_Pegawai_{$namaBulan}_{$y}.xlsx";

        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }


    
}
