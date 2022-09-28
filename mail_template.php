<?
/**
 * @var array $fields;
 *
 * Html форма заявки.
 */
?>

<h3>Поступила заявка с сайта:</h3>
<hr>
<?if($fields['name']) { ?>

  <p>Имя: <?= $fields['name'] ?></p>

<? } ?>
<?if($fields['phone']) { ?>

  <p>Телефон: <?= $fields['phone'] ?></p>

<? } ?>
<?if($fields['email']) { ?>

  <p>Email: <?= $fields['email'] ?></p>

<? } ?>

<p>Форма: <?= $fields['formname']?></p>

<?if(!empty($answers)) { ?>
  <p>Ответы:</p>
    <? $i = 1; foreach ($answers as $answer) { ?>
    <p><?= $i++?>) <?= $answer?></p>
    <? } ?>
<? } ?>

<p>Дата, время: <?= $fields['date']?></p>

<p>Страница с которой пришла заявка: <br>

    <?= $fields['pagefrom']?> (<?= 'http://'. $_SERVER['HTTP_HOST'] . $fields['pagefromlink']?>)</p>

<p>Реферальный хвост: <?= $fields['referal']?></p>

<?if($fields['utm_source']) { ?>

<p>utm_source: <?= $fields['utm_source']?></p>

<? } ?>
<?if($fields['utm_content']) { ?>

<p>utm_content: <?= $fields['utm_content']?></p>

<? } ?>
<?if($fields['utm_campaign']) { ?>

<p>utm_campaign: <?= $fields['utm_campaign']?></p>

<? } ?>
<?if($fields['utm_term']) { ?>

<p>utm_term: <?= $fields['utm_term']?></p>

<? } ?>