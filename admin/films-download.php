<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
    alert('Hanya admin yang diperbolehkan mengakses');
    document.location.href = 'login.php';
    </script>";

    exit;
}


require 'vendor/autoload.php';
require 'config/app.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

$activeWorksheet->setCellValue('A2', 'No')->getColumnDimension('A')->setAutoSize(true);
$activeWorksheet->setCellValue('B2', 'url')->getColumnDimension('B')->setAutoSize(true);
$activeWorksheet->setCellValue('C2', 'Title')->getColumnDimension('C')->setAutoSize(true);
$activeWorksheet->setCellValue('D2', 'Slug')->getColumnDimension('D')->setAutoSize(true);
$activeWorksheet->setCellValue('E2', 'Description')->getColumnDimension('E')->setAutoSize(true);
$activeWorksheet->setCellValue('F2', 'Release Date')->getColumnDimension('F')->setAutoSize(true);
$activeWorksheet->setCellValue('G2', 'Studio')->getColumnDimension('G')->setAutoSize(true);
$activeWorksheet->setCellValue('I2', 'Category')->getColumnDimension('I')->setAutoSize(true);
$activeWorksheet->setCellValue('H2', 'Private')->getColumnDimension('H')->setAutoSize(true);
$activeWorksheet->setCellValue('J2', 'Created At')->getColumnDimension('J')->setAutoSize(true);

$styleColumn = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$no = 1;
$loc = 3;

$films = query("SELECT f.id_film, f.url, f.title, f.slug, f.description, f.release_date, f.studio, f.category_id, f.is_private, f.created_at, c.title AS category_title FROM films f JOIN categories c ON f.category_id = c.id_category ORDER BY f.created_at DESC");


foreach ($films as $film) {
    $activeWorksheet->setCellValue('A' . $loc, $no++);
    $activeWorksheet->setCellValue('B' . $loc, $film['url']);
    $activeWorksheet->setCellValue('C' . $loc, $film['title']);
    $activeWorksheet->setCellValue('D' . $loc, $film['slug']);
    $activeWorksheet->setCellValue('E' . $loc, $film['description']);
    $activeWorksheet->setCellValue('F' . $loc, $film['release_date']);
    $activeWorksheet->setCellValue('G' . $loc, $film['studio']);
    $activeWorksheet->setCellValue('I' . $loc, $film['category_title']);
    $activeWorksheet->setCellValue('H' . $loc, $film['is_private'] ? 'private' : 'public');
    $activeWorksheet->setCellValue('J' . $loc, $film['created_at']);


    $loc++;
}

$activeWorksheet->getStyle('A2:J' . ($loc - 1))->applyFromArray($styleColumn);

$writer = new Xlsx($spreadsheet);
$file_film = 'Films List.xlsx';
$writer->save($file_film);

//ganti proses download ke folder download buka project
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Length:' . filesize($file_film));
header('Content-Disposition: attachment;filename="' . $file_film . '"');
readfile($file_film);
unlink($file_film);
