<?php

include 'koneksidb.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet    = new Spreadsheet();
$sheet          = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1','No');
$sheet->setCellValue('B1','Nama');
$sheet->setCellValue('C1','Kelas');
$sheet->setCellValue('D1','Alamat');

$sql = mysqli_query($conn,"SELECT * FROM tb_siswa");
$i  = 2;
$no = 1;
while ($row = mysqli_fetch_array($sql)) {
    $sheet->setCellValue('A'.$i,$no++);
    $sheet->setCellValue('B'.$i,$row['nama']);
    $sheet->setCellValue('C'.$i,$row['kelas']);
    $sheet->setCellValue('D'.$i,$row['alamat']);
    $i++;
}

$styleArray = [
    'borders'=>[
        'allBorders'=>[
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$i = $i - 1;
$sheet->getStyle('A1:D'.$i)->applyFromArray($styleArray);

$writer         = new Xlsx($spreadsheet);
$writer->save('Report Data Siswa Baru.Xlsx');
if ($writer) { 
    header("location: cetakdata.php"); 
} 
?>