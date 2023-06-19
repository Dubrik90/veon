
<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

file_put_contents('file.txt', json_encode($_POST), FILE_APPEND);
//file_put_contents('file2.txt', json_encode($_FILE), FILE_APPEND);

# проверка, что ошибки нет
if (!error_get_last()) {

    // Переменные, которые отправляет пользователь
    $formname = 'Форма с главной страницы';
    $firstName = $_POST['firstName'];
    $lastName  = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $companyName = $_POST['companyName'];
    $aboutCompany = $_POST['aboutCompany'];
    $bonus1 = $_POST['bonus1'];
    $bonus2 = $_POST['bonus2'];
    $bonus3 = $_POST['bonus3'];
    $bonus4 = $_POST['bonus4'];
    $personType = $_POST['personType'];
    $budget = $_POST['budget'];
    $service = $_POST['service'];
    $helpFizUser = $_POST['helpFizUser'];
    $helpCompany = $_POST['helpCompany'];
    $comment = $_POST['comment'];
    $file = $_FILES['myFile'];

    if ($test === true) {
        echo '+++';
    } else {
        echo '---';
    }

    if ($bonus1 === 'true') {
        $bonus1 = 'Скидка 100 BYN';
    }
    if ($bonus2 === 'true') {
        $bonus2 = 'Бесплатный логотип';
    }
    if ($bonus3 === 'true') {
        $bonus3 = 'Hostfly.by';
    }
    if ($bonus4 === 'true') {
        $bonus4 = '5% скидка на все услуги';
    }

    // Формирование самого письма

    if (isset($companyName) && !empty($companyName)) {
        $title = "Письмо с сайта Veon-tech";
        $body = "
    <h2>$formname</h2>
    <h3>Обращение от $personType лицо</h3>
    <table align='center' border='1' cellpadding='10' cellspacing='20' width='100%'>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Имя:</b> $firstName</td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Фамилия:</b> $lastName</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Телефон:</b> $phone</td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Email:</b> $email</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Название компании</b> $companyName</td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Чем занимается компания:</b> $aboutCompany</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Бюджет в USD</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$budget</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Бонус</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$bonus1<br/>$bonus2<br/>$bonus3<br/>$bonus4</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>О проекте</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$comment</td></tr>
    <table>
    ";
    } else {
        $title = "Письмо с сайта Veon-tech";
        $body = "
    <h2>$formname</h2>
    <h3>Обращение от $personType лицо</h3>
    <table align='center' border='1' cellpadding='10' cellspacing='20' width='100%'>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Имя:</b> $firstName</td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Фамилия:</b> $lastName</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Телефон:</b> $phone</td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Email:</b> $email</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Бюджет в USD</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$budget</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Услуги</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$service</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>Бонус</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$bonus1<br/>$bonus2<br/>$bonus3<br/>$bonus4</td></tr>
    <tr><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'><b>О проекте</b></td><td style='background-color: #E9FCE5; color: #444; border-radius: 16px;'>$comment</td></tr>
    <table>
    ";
    }
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
    $mail->Username   = 'vitaliam87@gmail.com'; // Логин на почте
    $mail->Password   = 'rjesbpsbuhsbumzb'; // Пароль на почте
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
   // $mail->setFrom('vitaliam87@yandex.ru', 'Veon-tech'); // Адрес самой почты и имя отправителя
    $mail->setFrom('dubrik90@yandex.by', 'Veon-tech'); // Адрес самой почты и имя отправителя

    // Получатель письма
    //$mail->addAddress('dubrik90@yandex.by');
  //  $mail->addAddress('vitaliam87@yandex.ru'); // Ещё один, если нужен

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