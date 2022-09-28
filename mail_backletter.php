<?
/**
 * @var array $fields;
 * @var string $textLetter;
 *
 * Html форма обратного письма.
 */
?>

<h3>Спасибо, <?if($fields['name']) { ?><strong>Имя: <?= $fields['name'] ?></strong>,<? } ?> за вашу заявку</h3>
<p><?= $textLetter?></p>

