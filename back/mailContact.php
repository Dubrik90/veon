
<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

file_put_contents('file.txt', json_encode($_POST), FILE_APPEND);

# проверка, что ошибки нет
if (!error_get_last()) {

    // Переменные, которые отправляет пользователь
    $formname = 'Форма со страницы контакты';
    $firstName = $_POST['firstName'];
    $phone = $_POST['phone'];
    $comment = $_POST['comment'];

    // Формирование самого письма

    $title = "Письмо с сайта Veon-tech";
    $body = "
    <h2>$formname</h2>
    <table align='center' border='1' cellpadding='10' cellspacing='20' width='100%'>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Имя:</b> $firstName</td>
    <td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Телефон:</b> $phone</td></tr>
    <tr><td colspan = '2' style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Сообщение: </b>$comment</td></tr>
    <table>
    ";

    // Настройки PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 1;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['data']['debug'][] = $str;
    };

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'veontechsite@gmail.com'; // Логин на почте
    $mail->Password   = 'roebckzpvowhxsfo'; // Пароль на почте
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->setFrom('vitaliam87@yandex.ru', 'Veon-tech'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('veontechsite@gmail.com');
    $mail->addAddress('vitaliam87@yandex.ru'); // Ещё один, если нужен

    // Прикрипление файлов к письму
    if (!empty($file['name'][0])) {
        for ($i = 0; $i < count($file['tmp_name']); $i++) {
            if ($file['error'][$i] === 0)
                $mail->addAttachment($file['tmp_name'][$i], $file['name'][$i]);
        }
    }
    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    // Проверяем отправленность сообщения
    if ($mail->send()) {
        $data['result'] = "success";
        $data['info'] = "Сообщение успешно отправлено!";
    } else {
        $data['result'] = "error";
        $data['info'] = "Сообщение не было отправлено. Ошибка при отправке письма";
        $data['desc'] = "Причина ошибки: {$mail->ErrorInfo}";
    }
} else {
    $data['result'] = "error";
    $data['info'] = "В коде присутствует ошибка";
    $data['desc'] = error_get_last();
}

// Отправка результата
header('Content-Type: application/json');
echo json_encode($data);

?>