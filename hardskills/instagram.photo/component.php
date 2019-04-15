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

$parseUrl = "https://api.instagram.com/v1/users/self/media/recent/";

$arResult["ERROR_MESSAGE"] = array();

if(!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 604800;

if(strlen($arParams["ACCESS_TOKEN"]) <= 0)
    $arResult["ERROR_MESSAGE"][] = GetMessage("ERROR_ACCESS_TOKEN");
if(strlen($arParams["IMAGE_SIZE"]) <= 0)
    $arResult["ERROR_MESSAGE"][] = GetMessage("ERROR_IMAGE_SIZE");
if(strlen($arParams["IMAGE_COUNT"]) <= 0)
    $arParams["IMAGE_COUNT"] = "5";

$queryString = $parseUrl . "?access_token=" . $arParams["ACCESS_TOKEN"] . "&count=" . $arParams["IMAGE_COUNT"];

if($this->startResultCache(false))
{

    if(function_exists('curl_init'))
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $queryString,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $options);

        $content = curl_exec($ch);
        curl_close($ch);
    }
    else
    {
        $content = file_get_contents($queryString);
    }

    if($content)
    {
        $contentJson = json_decode($content);

        foreach ($contentJson->data as $count => $result)
        {
            if($count + 1 > $arParams["IMAGE_COUNT"])
            {
                break;
            }

            if($arParams["IMAGE_SIZE"] == "SMALL")
            {
                $arResult["ITEMS"][$count] = $result->images->thumbnail;
                $arResult["ITEMS"][$count]->link = $result->link;
            }
            elseif($arParams["IMAGE_SIZE"] == "MEDIUM")
            {
                $arResult["ITEMS"][$count] = $result->images->low_resolution;
                $arResult["ITEMS"][$count]->link = $result->link;
            }
            else
            {
                $arResult["ITEMS"][$count] = $result->images->standard_resolution;
                $arResult["ITEMS"][$count]->link = $result->link;
            }
        }
    }
    else
    {
        $this->abortResultCache();
        $arResult["ERROR_MESSAGE"][] = GetMessage("ERROR_STREAM_FALL");
    }

    $this->IncludeComponentTemplate();
}