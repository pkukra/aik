<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // load model jika perlu
        $this->load->model('Aktivitas_model');
        // load composer autoload
        require FCPATH . 'vendor/autoload.php';
    }

    public function aktivitas()
    {
        // ambil data dari database
        $data = $this->Aktivitas_model->get_all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // header Excel
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Aktivitas');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Keterangan');

        // isi data
        $row = 2;
        $no = 1;
        foreach ($data as $d) {
            $sheet->setCellValue('A'.$row, $no++);
            $sheet->setCellValue('B'.$row, $d->nama_aktivitas);
            $sheet->setCellValue('C'.$row, $d->waktu_aktivitas);
            $sheet->setCellValue('D'.$row, $d->keterangan);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        // nama file
        $filename = "Data-Aktivitas-".date('YmdHis').".xlsx";

        // header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=".$filename);
        header('Cache-Control: max-age=0');

        // render excel
        $writer->save('php://output');
    }
}
