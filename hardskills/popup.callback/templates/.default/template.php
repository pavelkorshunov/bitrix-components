<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="hsfeedback">
    <?if(!empty($arResult["ERROR_MESSAGE"]))
    {
        foreach($arResult["ERROR_MESSAGE"] as $v)
            ShowError($v);
    }
    if($arParams["SHOW_POPUP"] === "Y" && strlen($arResult["OK_MESSAGE"]) > 0)
    {
    ?>
        <div class="hspopup__background">
            <div class="hspopup__wrap">
                <span class="hspopup__close">&times;</span>
                <div class="hspopup-ok-text"><?=$arResult["OK_MESSAGE"]?></div>
            </div>
        </div>
        <script>
            (function(){
                var hsclose = document.querySelector('.hspopup__close');
                var hsbackground = document.querySelector('.hspopup__background');
                hsclose.addEventListener('click', function(){
                    hsbackground.style.display = 'none';
                });
            })();
        </script>
    <?   
    }
    elseif(strlen($arResult["OK_MESSAGE"]) > 0)
    {
        ?><div class="hs-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
    }
    ?>

    <form class="hs-form" action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <?=bitrix_sessid_post()?>

        <?if(empty($arParams["FILL_FIELDS"]) || in_array("NAME", $arParams["FILL_FIELDS"])):?>
        <div class="hs-form__wrapper">
            <div class="hs-form__text">
                <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="hs-form__req">*</span><?endif?><?=GetMessage("POPUP_TMP_NAME")?>
            </div>
            <input type="text" name="user_name" placeholder="<?=GetMessage("POPUP_TMP_EXAMPLE_NAME")?>">
        </div>
        <?endif;?>

        <?if(empty($arParams["FILL_FIELDS"]) || in_array("EMAIL", $arParams["FILL_FIELDS"])):?>
        <div class="hs-form__wrapper">
            <div class="hs-form__text">
                <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="hs-form__req">*</span><?endif?><?=GetMessage("POPUP_TMP_EMAIL")?>
            </div>
            <input type="text" name="user_email" placeholder="<?=GetMessage("POPUP_TMP_EXAMPLE_EMAIL")?>">
        </div>
        <?endif;?>

        <?if(empty($arParams["FILL_FIELDS"]) || in_array("PHONE", $arParams["FILL_FIELDS"])):?>
            <div class="hs-form__wrapper">
                <div class="hs-form__text">
                    <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="hs-form__req">*</span><?endif?><?=GetMessage("POPUP_TMP_PHONE")?>
                </div>
                <input type="text" name="user_phone" placeholder="<?=GetMessage("POPUP_TMP_EXAMPLE_PHONE")?>">
            </div>
        <?endif;?>

        <?if(empty($arParams["FILL_FIELDS"]) || in_array("MESSAGE", $arParams["FILL_FIELDS"])):?>
        <div class="hs-form__wrapper">
            <div class="hs-form__text">
                <?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="hs-form__req">*</span><?endif?><?=GetMessage("POPUP_TMP_MESSAGE")?>
            </div>
            <textarea name="MESSAGE" rows="7" cols="40"><?=$arResult["MESSAGE"]?></textarea>
        </div>
        <?endif;?>

        <?if($arParams["USE_CAPTCHA"] == "Y"):?>
            <div class="hs-form__captcha">
                <div class="hs-form__text"><?=GetMessage("POPUP_TMP_CAPTCHA")?></div>
                <input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
                <div class="hs-form__text"><?=GetMessage("POPUP_TMP_CAPTCHA_CODE")?><span class="hs-form__req">*</span></div>
                <input type="text" name="captcha_word" size="30" maxlength="50" value="">
            </div>
        <?endif;?>
        <input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
        <input class="hs-form__submit" type="submit" name="submit" value="<?=GetMessage("POPUP_TMP_SUBMIT")?>">
    </form>
</div>