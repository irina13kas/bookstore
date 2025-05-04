<?php
session_start();
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user = $_SESSION['user'];
$order = $_SESSION['cart'];
$order_details = $_SESSION['order_details'];

$userEmail = $user['email'];
$userName = $user['name'];

$file_name =  $order_details['order_id']. '_' . date('Y-m-d') . '.xlsx';
$file_path = '../assets/template/' . $file_name;

$emailContent = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    
    <td valign='top'>
      <h2 style='margin-top: 0;'>Уважаемый(-ая) $userName!</h2>
      <p>Ваш заказ \"В Гостях у бабушки Кристи\" успешно оформлен.</p>
      
      <h3>Детали заказа:</h3>
      <ul>
";

foreach ($order as $bookId => $item) {
    $bookItem = $item['title'].' - '.$item['qty'].' * '.$item['price'].' = '.$item['price']*$item['qty'];
    $emailContent .= "    <li>$bookItem</li>\n";
}

$emailContent .= "
      </ul>
      <p><strong>Итоговая стоимость:</strong> {$order_details['total_cost']} руб.</p>
      <p>С уважением,<br>Команда В гостях у бабушки Кристи</p>
    </td>
  </tr>
</table>
";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'm.ira13kas@gmail.com';
    $mail->Password = 'krsd fgtd kvug vthv';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->SMTPDebug = 0;
    $mail->CharSet = 'UTF-8';
    $mail->From = "m.ira13kas@gmail.com";
    $mail->FromName = "В гостях у бабушки Кристи";

    $mail->setFrom('m.ira13kas@gmail.com', 'В гостях у бабушки Кристи');
    $mail->addAddress($userEmail, $userName);
    $mail->isHTML(true);
    $mail->Subject = 'Подтверждение заказа книг' . uniqid();
    $mail->Body = $emailContent;
    $mail->CharSet = 'UTF-8';
    $mail->addAttachment($file_path, $file_name);
    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Письмо отправлено на ' . $userEmail]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка: ' . $mail->ErrorInfo]);
}
?>