<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
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

if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach ($arResult["ERROR_MESSAGE"] as $error)
	{
		ShowError($error);
	}

	return;
}
?>
<div class="wrap-instagram">
	<?foreach($arResult["ITEMS"] as $item):?>
		<div class="wrap-instagram__single">
			<img class="wrap-instagram__image" src="<?=$item->url;?>" alt="img">
		</div>
	<?endforeach;?>
</div>