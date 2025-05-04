<?php
session_start();

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
$totalCost = 0;
    try {
    $templateFile = '../assets/template/Template.xlsx';
    $reader = IOFactory::createReaderForFile($templateFile);
        $spreadsheet = $reader->load($templateFile);
        $sheet = $spreadsheet->getActiveSheet();

        $order = $_SESSION['cart'] ?? [];
        $user = $_SESSION['user'] ?? [];
        
        foreach ($order as $bookId => $item) {
            $totalCost+= $item['price']*$item['qty'];
        }
        
    $orderNumber = rand(1000, 9999);
    $_SESSION['order_details'] = [
        'order_id' => $orderNumber,
        'total_cost' => $totalCost
    ];
    $replacements = [
        'num_order' => $orderNumber,
        'fullName' => $user['name'],
        'phone' => $user['phone'],
        'email' => $user['email'],
        'address' => $user['address'],
        'totalCost' => $totalCost,
        'date' => date('d.m.Y')
    ];

    foreach ($sheet->getRowIterator() as $row) {
        foreach ($row->getCellIterator() as $cell) {
            $cellValue = $cell->getValue();
            
            if (is_string($cellValue)) {
                $newValue = str_replace(
                    array_keys($replacements),
                    array_values($replacements),
                    $cellValue
                );
                
                if ($newValue !== $cellValue) {
                    $cell->setValue($newValue);
                }
            }
        }
    }
    $startRow = 14;
    $orderCount = count($order);

if ($orderCount > 1) {
    $sheet->insertNewRowBefore($startRow + 1, $orderCount - 1);

}

$rowIndex = $startRow;
foreach ($order as $book_id => $item) {
    $sheet->mergeCells("A{$rowIndex}:C{$rowIndex}");
    $sheet->mergeCells("D{$rowIndex}:E{$rowIndex}");
    $sheet->mergeCells("F{$rowIndex}:G{$rowIndex}");
    $sheet->mergeCells("H{$rowIndex}:I{$rowIndex}");
    $sheet->setCellValue('A' . $rowIndex, $item['title']);
    $sheet->setCellValue('D' . $rowIndex, $item['qty']);
    $sheet->setCellValue('F' . $rowIndex, $item['price'] . ' ₽');
    $sheet->setCellValue('H' . $rowIndex, $item['price'] * $item['qty'] . ' ₽');
    $rowIndex++;
}
$rowIndex-=1;
$range = "A{$startRow}:I{$rowIndex}";
$sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $filename = $orderNumber . '_' . date('Y-m-d') . '.xlsx';
    $filePath = '../assets/template/' . $orderNumber . '_' . date('Y-m-d') . '.xlsx';
    
    if (!is_writable(dirname($filePath))) {
        throw new Exception("Нет прав на запись в директорию: " . dirname($filePath));
    }
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($filePath);
    //exit;
    
} catch (Exception $e) {
    error_log("Ошибка в fillTemplate(): " . $e->getMessage());
    throw $e;
}
?>