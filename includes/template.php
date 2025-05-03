<?php
session_start();

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
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
    $filename = $orderNumber . '_' . date('Y-m-d') . '.xlsx';
    $filePath = '../assets/template/' . $orderNumber . '_' . date('Y-m-d') . '.xlsx';
    
    if (!is_writable(dirname($filePath))) {
        throw new Exception("Нет прав на запись в директорию: " . dirname($filePath));
    }
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($filePath);

    // Отправляем файл на скачивание
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    readfile($filePath);
    exit;
    
} catch (Exception $e) {
    error_log("Ошибка в fillTemplate(): " . $e->getMessage());
    throw $e;
}
?>