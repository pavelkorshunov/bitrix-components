<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("subscribe"))
{
	ShowError(GetMessage("CC_BSS_MODULE_NOT_INSTALLED"));
	return;
}

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;

if(is_object($USER) && $USER->GetID() > 0)
{
	$USER_ID = $USER->GetID();
}

$obSubscription = new CSubscription;
$arResult["ERRORS"] = array();

if($_SERVER["REQUEST_METHOD"] == "POST" && array_key_exists("update", $_POST) && check_bitrix_sessid())
{
	$email = htmlspecialcharsbx($_POST["email"]);
	if(!check_email($email) || empty($email))
		$arResult["ERRORS"][] = GetMessage("CC_BSS_ERROR_EMAIL");

	if(empty($arResult["ERRORS"]) && !isset($USER_ID))
	{
		$rsSubscription = $obSubscription->GetList(array(), array("EMAIL" => $email));
	 	$arSubscription = $rsSubscription->Fetch();

 		if(empty($arSubscription))
 		{
 			$arFeilds = array("EMAIL" => $email, "ACTIVE" => "Y", "FORMAT" => "text", "SEND_CONFIRM" => "N");
 			if($obSubscription->Add($arFeilds))
 			{
				$arResult["RESULT"] = GetMessage("CC_BSS_RESULT_SUCCESS");
 			}
 			else
 			{
 				$arResult["RESULT"] = GetMessage("CC_BSS_RESULT_ERROR");
 			}
 		}
 		else
 		{
 			$arResult["RESULT"] = GetMessage("CC_BSS_RESULT_ISSET");
 		}
	}
	else
	{
		$arResult["RESULT"] = GetMessage("CC_BSS_RESULT_ISSET");
	}
}

$arResult["FORM_ACTION"] = $APPLICATION->GetCurPage();

$this->IncludeComponentTemplate();
?>
