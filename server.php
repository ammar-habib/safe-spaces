<?php
header('Access-Control-Allow-Origin: *');
include ('db_connect.php');
include ('functions.php');

$req = $_REQUEST['REQUEST'];

switch($req)
{
case 'SIGNUP':
echo SIGNUP($conn);
break;

case 'LOGIN':
echo LOGIN($conn);
break;

case 'RESET_PASSWORD':
echo RESET_PASSWORD($conn);
break;

case 'REGISTER_DEVICE':
echo REGISTER_DEVICE($conn);
break;

case 'ADD_CONTACTS':
echo ADD_CONTACTS($conn);
break;

case 'ADD_SOS_CONTACTS':
echo ADD_SOS_CONTACTS($conn);
break;

case 'GET_BLOGS':
echo GET_BLOGS($conn);
break;

case 'GET_BLOGS_BY_ID':
echo GET_BLOGS_BY_ID($conn);
break;

case 'GET_USER':
echo GET_USER($conn);
break;

case 'UPDATE_USER':
echo UPDATE_USER($conn);
break;

case 'DELETE_USER':
echo DELETE_USER($conn);
break;

case 'REPORT_INCIDENT':
echo GET_USER($conn);
break;


case 'ALERT_SOS_ACCOUNTS':
echo ALERT_SOS_ACCOUNTS($conn);
break;

case 'CONTACT_US':
echo CONTACT_US($conn);
break;

case 'ALERT_SOS_TRACKING':
echo ALERT_SOS_TRACKING($conn);
break;

case 'UPDATE_SOS_TRACKING':
echo UPDATE_SOS_TRACKING($conn);
break;

case 'GET_MARKERS':
echo GET_MARKERS($conn);
break;

case 'STOP_SOS_TRACKING':
echo STOP_SOS_TRACKING($conn);
break;




}


include ('db_close.php');

?>