<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = array("ACTIVE" => "Y");
if($site !== false)
    $arFilter["LID"] = $site;

$arEvent = array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
    $arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arEventType = array();
$dbEventType = CEventType::GetList(array("LID" => "ru"));

while($arET = $dbEventType->Fetch())
    $arEventType[$arET["EVENT_NAME"]] = "[".$arET["ID"]."] ".$arET["EVENT_NAME"];


$arComponentParameters = array(
    "PARAMETERS" => array(
        "AJAX_MODE" => array(),
        "USE_CAPTCHA" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ),
        "OK_TEXT" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_MESSAGE_OK"),
            "TYPE" => "STRING",
            "DEFAULT" => GetMessage("POPUP_CALLBACK_MESSAGE_DEFAULT"),
            "PARENT" => "BASE",
        ),
        "SHOW_POPUP" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_SHOW_POPUP"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
            "PARENT" => "BASE",
        ),
        "FILL_FIELDS" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_FILL_FIELDS"),
            "TYPE"=>"LIST",
            "MULTIPLE"=>"Y",
            "VALUES" => array(
                "NAME" => GetMessage("POPUP_CALLBACK_NAME"),
                "EMAIL" => "E-mail",
                "PHONE" => GetMessage("POPUP_CALLBACK_PHONE"),
                "MESSAGE" => GetMessage("POPUP_CALLBACK_MESSAGE"),
                "FILE" => GetMessage("POPUP_CALLBACK_FILE")),
            "DEFAULT"=>"",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),
        "REQUIRED_FIELDS" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_REQUIRED_FIELDS"),
            "TYPE"=>"LIST",
            "MULTIPLE"=>"Y",
            "VALUES" => array(
                "NONE" => GetMessage("POPUP_CALLBACK_REQUIRED_N"),
                "NAME" => GetMessage("POPUP_CALLBACK_NAME"),
                "EMAIL" => "E-mail",
                "PHONE" => GetMessage("POPUP_CALLBACK_PHONE"),
                "MESSAGE" => GetMessage("POPUP_CALLBACK_MESSAGE")),
            "DEFAULT"=>"",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),
        "EVENT_MESSAGE_ID" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_EMAIL_TEMPLATES"),
            "TYPE"=>"LIST",
            "VALUES" => $arEvent,
            "DEFAULT"=>"",
            "MULTIPLE"=>"N",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),
        "EVENT_NAME" => array(
            "NAME" => GetMessage("POPUP_CALLBACK_EVENT_NAME"),
            "TYPE"=>"LIST",
            "VALUES" => $arEventType,
            "DEFAULT"=>"",
            "MULTIPLE"=>"N",
            "COLS"=>25,
            "PARENT" => "BASE",
        ),

    )
);