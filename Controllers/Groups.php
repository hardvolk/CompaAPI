<?php
/**
 * Created by Compa for the CompaApp project
 * Date: 16/09/2016
 */
 
require_once dirname(__DIR__) . "/Model/Model.php";

// Prepare the response in the API type (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");



/*
$allGroups = $Groups->GetGroups();
echo json_encode($allGroups);
*/

if(!empty($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
    if(function_exists($action)) $action();
    else http_response_code(404);
}

function GetNearestGroups()
{
    $Groups = new Groups(); //Model class

    $lat = $_REQUEST['lat'];
    $long = $_REQUEST['long'];
    $dist = $_REQUEST['dist'];

    $groups = $Groups->GetNearestGroups($lat, $long, $dist);
    echo json_encode($groups);
}