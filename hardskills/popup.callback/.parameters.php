<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("ACTIVE" => "Y");
if($site !== false)
    $arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
    $arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arComponentParameters = array(
    "PARAMETERS" => array(
        "AJAX_MODE" => array(),
        "USE_CAPTCHA" => Array(
            "NAME" => GetMessage("POPUP_CALLBACK_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ),
        "OK_TEXT" => Array(
            "NAME" => GetMessage("POPUP_CALLBACK_MESSAGE_OK"),
            "TYPE" => "STRING",
            "DEFAULT" => GetMessage("POPUP_CALLBACK_MESSAGE_DEFAULT"),
            "PARENT" => "BASE",
        ),
        "SHOW_POPUP" => Array(
            "NAME" => GetMessage("POPUP_CALLBACK_SHOW_POPUP"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ),
        "FILL_FIELDS" => Array(
            "NAME" => GetMessage("POPUP_CALLBACK_FILL_FIELDS"),
            "TYPE"=>"LIST",
            "MULTIPLE"=>"Y",
            "VALUES" => Array(
                "NAME" => GetMessage("POPUP_CALLBACK_NAME"),
                "EMAIL" => "E-mail",
                "PHONE" => GetMessage("POPUP_CALLBACK_PHONE"),
                "MESSAGE" => GetMessage("POPUP_CALLBACK_MESSAGE"),
                "FILE" => GetMessage("POPUP_CALLBACK_FILE")),
            "DEFAULT"=>"",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),
        "REQUIRED_FIELDS" => Array(
            "NAME" => GetMessage("POPUP_CALLBACK_REQUIRED_FIELDS"),
            "TYPE"=>"LIST",
            "MULTIPLE"=>"Y",
            "VALUES" => Array(
                "NONE" => GetMessage("POPUP_CALLBACK_REQUIRED_N"),
                "NAME" => GetMessage("POPUP_CALLBACK_NAME"),
                "EMAIL" => "E-mail",
                "PHONE" => GetMessage("POPUP_CALLBACK_PHONE"),
                "MESSAGE" => GetMessage("POPUP_CALLBACK_MESSAGE")),
            "DEFAULT"=>"",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),
        "EVENT_MESSAGE_ID" => Array(
            "NAME" => GetMessage("POPUP_CALLBACK_EMAIL_TEMPLATES"),
            "TYPE"=>"LIST",
            "VALUES" => $arEvent,
            "DEFAULT"=>"",
            "MULTIPLE"=>"Y",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),

    )
);
?>