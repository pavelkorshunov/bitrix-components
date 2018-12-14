<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"ACCESS_TOKEN" => Array(
            "NAME" => GetMessage("INSTAGRAM_ACCESS_TOKEN"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "PARENT" => "BASE",
        ),
        "IMAGE_SIZE" => Array(
	        "NAME" => GetMessage("INSTAGRAM_IMAGE_SIZE"),
	        "TYPE"=>"LIST",
	        "MULTIPLE"=>"N",
	        "VALUES" => Array(
	            "SMALL" => GetMessage("INSTAGRAM_IMAGE_SMALL"),
	            "MEDIUM" => GetMessage("INSTAGRAM_IMAGE_MEDIUM"),
	            "BIG" => GetMessage("INSTAGRAM_IMAGE_BIG")),
	        "DEFAULT" => "BIG",
	        "PARENT" => "BASE",
	    ),
	    "IMAGE_COUNT" => array(
			"NAME" => GetMessage("INSTAGRAM_CONT"),
			"TYPE" => "STRING",
			"DEFAULT" => "5",
			"PARENT" => "BASE",
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>3600),
	)
);


?>