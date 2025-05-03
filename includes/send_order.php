<?php
session_start();
include 'template.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'data.php';
if (!isset($_SESSION['user'])) {
    die(json_encode(['success' => false, 'message' => 'Требуется авторизация']));
}

if (!isset($_SESSION['order'])) {
    die(json_encode(['success' => false, 'message' => 'Заказ не найден']));
}

$userEmail = $_SESSION['order']['email'];
$userName = $_SESSION['order']['name'];
$order = $_SESSION['order'];
$currentTourType = $_SESSION['order']['type']['name'];
$tourImage = $tourImages[$currentTourType];

$file_name = $order['surname'] . '_' . date('Y-m-d') . '.xlsx'; // Замените на реальное имя файла
$file_path = '../assets/' . $file_name;

$emailContent = "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <!-- Колонка с изображением -->
    <td width='150' valign='top' style='padding-right: 20px;'>
       <img src='cid:tour_image' width='150' alt='Поехали!' style='display: block;'>
    </td>
    
    <!-- Колонка с текстом -->
    <td valign='top'>
      <h2 style='margin-top: 0;'>Уважаемый(-ая) $userName!</h2>
      <p>Ваш заказ в TravelDream успешно оформлен.</p>
      
      <h3>Детали заказа:</h3>
      <p><strong>Тип путевки:</strong> {$order['type']['name']}</p>
      <p><strong>Страна:</strong> {$order['country']['name']}</p>
      <p><strong>Питание:</strong> {$order['meal']['name']}</p>
      <p><strong>Количество дней:</strong> {$order['days']}</p>
      
      <h4>Дополнительные услуги:</h4>
      <ul>
";

foreach ($order['services'] as $service) {
    $serviceName = is_array($service) ? $service['name'] : $service;
    $emailContent .= "    <li>$serviceName</li>\n";
}

$emailContent .= "
      </ul>
      <p><strong>Итоговая стоимость:</strong> {$order['total_cost']} руб.</p>
      <p>С уважением,<br>Команда Вокруг света за 80 дней</p>
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
    $mail->Password = 'krsd fgtd kvug vthv'; // Пароль приложения Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->SMTPDebug = 0;
    $mail->CharSet = 'UTF-8';
    $mail->From = "m.ira13kas@gmail.com";
    $mail->FromName = "Вокруг света за 80 дней";

    $mail->setFrom('m.ira13kas@gmail.com', 'Вокруг света за 80 дней');
    $mail->addAddress($userEmail, $userName);
    $mail->isHTML(true);
    $mail->Subject = 'Подтверждение заказа оформления путевки' . uniqid();
    $mail->Body = $emailContent;
    $mail->CharSet = 'UTF-8';
    $mail->addAttachment($file_path, $file_name);
    $mail->AddEmbeddedImage($tourImage, 'tour_image', basename($tourImage));
    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Письмо отправлено на ' . $userEmail]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка: ' . $mail->ErrorInfo]);
}
?>