<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());

$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
    $arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
    $arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
    $arResult["ERROR_MESSAGE"] = array();
    if(check_bitrix_sessid())
    {
        // Проверка обязательных полей
        if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
        {
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_phone"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_PHONE");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["MESSAGE"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
        }
        //Проверка валидности e-mail
        if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
            $arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");

        //Проверка формата и размера файла. Поле файла должно называться user_file
        $arFileTmp = false;
        if(in_array("FILE", $arParams["FILL_FIELDS"]))
        {
            $arrFile = array(
                "name" => $_FILES["user_file"]["name"],
                "size" => $_FILES["user_file"]["size"],
                "tmp_name" => $_FILES["user_file"]["tmp_name"],
                "type" => $_FILES["user_file"]["type"]
            );
            $res = CFile::CheckFile($arrFile, 2000000, "application/", "doc,docx");
            if(strlen($res)>0)
            {
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_WRONG_FILE");
            }

            //Сохраняем файл в папку upload/attach, если папки нет создаем и регистрируем его в таблице (b_file)
            if(empty($arResult["ERROR_MESSAGE"]))
            {
                $folderName = "attach";
                $pathToAttachDir = $_SERVER["DOCUMENT_ROOT"] . "/upload/" . $folderName;
                if(!file_exists($pathToAttachDir))
                {
                    mkdir($pathToAttachDir);
                }
                $arFileTmp = CFile::SaveFile([
                    "name" => $_FILES['user_file']['name'],
                    "size" => $_FILES['user_file']['size'],
                    "tmp_name" => $_FILES['user_file']['tmp_name'],
                    "type" => $_FILES["user_file"]["type"],
                    "old_file" => "",
                    "del" => "Y",
                    "MODULE_ID" => "form"
                ], $folderName);
            }
        }
        // Подключаем капчу
        if($arParams["USE_CAPTCHA"] == "Y")
        {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
            {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
            }
            else
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");

        }
        //Отправляем, если нет ошибок
        if(empty($arResult["ERROR_MESSAGE"]))
        {
            $pageUrl = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            $arFields = Array(
                "AUTHOR" => htmlspecialcharsbx($_POST["user_name"]),
                "AUTHOR_EMAIL" => htmlspecialcharsbx($_POST["user_email"]),
                "EMAIL_TO" => $arParams["EMAIL_TO"],
                "PHONE" => htmlspecialcharsbx($_POST["user_phone"]),
                "TEXT" => htmlspecialcharsbx($_POST["MESSAGE"]),
                "PAGE_URL" => $pageUrl,
            );
            if(!empty($arParams["EVENT_MESSAGE_ID"]))
            {
                if(IntVal($arParams["EVENT_MESSAGE_ID"]) > 0)
                    CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($arParams["EVENT_MESSAGE_ID"]), [$arFileTmp]);
            }
            else
                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
            $_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
            $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
            LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
        }

        $arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
        $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
    }
    else
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"])
{
    $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}

if(empty($arResult["ERROR_MESSAGE"]))
{
    if($USER->IsAuthorized())
    {
        $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
    }
    else
    {
        if(strlen($_SESSION["MF_NAME"]) > 0)
            $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if(strlen($_SESSION["MF_EMAIL"]) > 0)
            $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
    }
}

if($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());


$this->IncludeComponentTemplate();
