<?php
require '../../config.php'; // Database connection
require '../../vendor/autoload.php'; // PhpSpreadsheet autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

// Fetch participants data from the database
$query = "SELECT * FROM katilim_formu";
$result = $conn->query($query);

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Excel headers
$headers = ['ID', 'Ad Soyad', 'Okul', 'Bölüm', 'Sınıf', 'Telefon', 'E-mail'];
$columnWidths = [10, 20, 20, 20, 10, 15, 25];
$columnLetter = 'A';

// Set column headers and widths
foreach ($headers as $index => $header) {
    $sheet->setCellValue($columnLetter . '1', $header);
    $sheet->getColumnDimension($columnLetter)->setWidth($columnWidths[$index]);
    $columnLetter++;
}

// Style header row with borders
$headerStyle = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN, // Add thin borders to header cells
        ],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => 'FFCCCCCC'],
    ],
];
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

// Write data to the Excel file and style data rows with borders
$rowNum = 2;
$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN, // Add thin borders to data cells
        ],
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNum, $row['id'])
              ->setCellValue('B' . $rowNum, $row['ad_soyad'])
              ->setCellValue('C' . $rowNum, $row['okul'])
              ->setCellValue('D' . $rowNum, $row['bolum'])
              ->setCellValue('E' . $rowNum, $row['sinif'])
              ->setCellValue('F' . $rowNum, $row['cep_tel'])
              ->setCellValue('G' . $rowNum, $row['email']);
        $sheet->getStyle("A$rowNum:G$rowNum")->applyFromArray($dataStyle); // Apply borders to each row
        $rowNum++;
    }
} else {
    $sheet->setCellValue('A2', 'Katılımcı bulunamadı');
    $sheet->mergeCells("A2:G2");
    $sheet->getStyle("A2:G2")->applyFromArray($dataStyle); // Apply borders to 'No participants' message row
}

// Set HTTP headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Katilimci_Listesi.xlsx"');

// Save the spreadsheet to PHP output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
