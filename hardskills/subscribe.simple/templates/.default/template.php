<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<?if(count($arResult["ERRORS"]) > 0):?>
	<?foreach($arResult["ERRORS"] as $strError):?>
		<p class="errortext"><?echo $strError?></p>
	<?endforeach?>
<?endif;?>

<?if($arParams["AJAX_MODE"] === "Y" && !empty($arResult["RESULT"]) && count($arResult["ERRORS"]) <= 0):?>
	<script>
		var message = document.createElement('div');
		message.className = 'subscribe-message';
		message.id = "subscribe-message";
		message.innerHTML = '<div class="subscribe-message__result"><i onclick="subscribeClose();" class="subscribe-message__close">&times;</i><?=$arResult["RESULT"]?></div>';
		document.body.appendChild(message);

		function subscribeClose()
		{
			var mess = document.getElementById("subscribe-message");
			document.body.removeChild(mess);
		}
	</script>
<?endif;?>

<?if(is_array($arResult) && !empty($arResult["FORM_ACTION"])):?>
	<div class="subscriber__main">
		<div class="subscriber__text">
			<p class="subscriber_text"><?=GetMessage("CT_BSS_MESSAGE_TEXT");?></p>
		</div>
		<div class="subscriber__form">
			<form class="subscriber_form" action="<?echo $arResult["FORM_ACTION"]?>" method="post">
				<?echo bitrix_sessid_post();?>
				<input class="subscriber__email" type="text" name="email" placeholder="Email" required="">
				<input class="subscriber__submit" type="submit" name="update" value="<?=GetMessage("CT_BSS_FORM_BUTTON");?>">
			</form>
		</div>
	</div>
<?endif;?>
