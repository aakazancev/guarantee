<?php
require_once 'mail/Mail.php';

$fields = $_POST;
if($fields['phone'] == '' || $fields['date'] == '' || $fields['easydata'] != '')
    return;
// Ответы из квиза
$answers = array_filter($fields, function($k) {
    return strpos($k,'que-' ) !== false;
}, ARRAY_FILTER_USE_KEY);

// Комментарии начинающиеся со звездочки (*) означают, что поле обязательное.

$subject = 'Новая заявка!'; // * Тема письма
ob_start();
include __DIR__ . '/mail_template.php'; // * Html форма заявки
$htmlBody = ob_get_clean();

// Текстовая форма заявки
$textBody = "Поступила заявка с сайта:\n".
    "Имя: "                     . $fields['name']     . "\n" .
    "Телефон: "                 . $fields['phone']    . "\n" ;


// * Кому | Пример: ['adress' => 'Адрес', 'name' => 'Имя'] | Имя указывать не обязательно.
//        | Пример без имени: ['adress' => 'Адрес'] |
// Если адрес не один после квадратных скобок нужно ставить запятую.

$recipients = [
//    ['adress' => 'manager@ecorp.com', 'name' => 'Super Manager'],
];
if(isset($emails)) {
    foreach ($emails as $email)
    {
        if($email != '') $recipients[] = ['adress' => $email, 'name' => $name ? $name : ''];
    }
}


// * От кого. Тут указывается адрес для обратной связи.
/**
 * @var $emailfrom string
 * @var $companyfrom string
 */

$from = [ 'email' => $emailfrom ? $emailfrom : 'no-reply@dacorn.com', 'company' => $companyfrom ? $companyfrom : 'daCORN' ];

// ** Обратное письмо клиенту ** //

// * Доп. файлы * //
$attachment = [];

$res['mail'] = Mail::sendMail($recipients, $from, $subject, $htmlBody, $textBody, $attachment);

if(isset($fields['attachment']) && $fields['email'])
{
    $subject = 'Cпасибо за вашу заявку!';
    $textLetter = '';
    /* Example 
      if($fields['attachment'] == 'checklist') {
          $attachment[] = __DIR__ . "/pdf/checklist.pdf";
          $textLetter .= "Вот чек-лист, который мы вам обещали:";
      }
    */
    ob_start();
    include __DIR__ . '/mail_backletter.php';
    $htmlLetter = ob_get_clean();
    $textLetter = "Благодарим вас за заявку!" . "\n" . $textLetter;

    $res['backmail'] = Mail::sendMail([['adress' => $fields['email']]], $from, $subject, $htmlLetter, $textLetter, $attachment);
}
