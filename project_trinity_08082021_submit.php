<?php

session_start();

error_reporting(error_reporting() & ~E_NOTICE);
date_default_timezone_set('Asia/Dhaka');
mysql_connect('localhost', 'root', '') or die('ERROR: ' . mysql_error());
mysql_select_db('bat_ob') or die('ERROR: ' . mysql_error());


$msisdn = $_POST['msisdn'];
$code = $_POST['code'];
$nameverified = $_POST['nameverified'];
$ageverified = $_POST['ageverified'];
$cbr = $_POST['cbr'];

$full_flavoured_somke = $_POST['full_flavoured_somke'];
$blueberry_and_lemon_flavour = $_POST['blueberry_and_lemon_flavour'];
$current_primary_brand = $_POST['current_primary_brand'];
$current_secon_brand = $_POST['current_secon_brand'];
$current_primary_brand_other = $_POST['current_primary_brand_other'];
$current_secon_brand_other = $_POST['current_secon_brand_other'];
$profession = $_POST['profession'];
$job_business_study = $_POST['job_business_study'];
$express_thanks = $_POST['express_thanks'];

$callstatus = $_POST['callstatus'];
$callremarks = $_POST['callremarks'];
$chk_call = $_POST['chk_call'];

$Stime = date('Y/m/d H:i:s A');
$userid = $_COOKIE['derbyuserid'];

$statusquery = mysql_query("SELECT firstStatus,SecondStatus FROM project_trinity_08082021  WHERE sl='$code'");
$rowupdata = mysql_fetch_array($statusquery);
$fstatus = $rowupdata['firstStatus'];
$sstatus = $rowupdata['SecondStatus'];
$BRCode = $rowupdata['BRCode'];
$ContactDate = $rowupdata['ContactDate'];

if (empty($fstatus)) {
	$sql = "UPDATE project_trinity_08082021  SET firstStatus='$callstatus', firstRemarks='$callremarks', NameVerified='$nameverified', AgeVerified='$ageverified',ConductedbyBR='$cbr',full_flavoured_somke='$full_flavoured_somke',blueberry_and_lemon_flavour='$blueberry_and_lemon_flavour',current_primary_brand='$current_primary_brand',current_primary_brand_other='$current_primary_brand_other',current_secon_brand='$current_secon_brand',current_secon_brand_other='$current_secon_brand_other',profession='$profession',job_business_study='$job_business_study',express_thanks='$express_thanks',SubmitDate='$Stime',Callstatus='$callstatus',Callremarks='$callremarks',UseriD='$userid',chk_call='$chk_call' WHERE sl='$code'";
} elseif (empty($sstatus)) {
	$sql = "UPDATE project_trinity_08082021  SET SecondStatus='$callstatus', SecondRemarks='$callremarks', NameVerified='$nameverified', AgeVerified='$ageverified',ConductedbyBR='$cbr',full_flavoured_somke='$full_flavoured_somke',blueberry_and_lemon_flavour='$blueberry_and_lemon_flavour',current_primary_brand='$current_primary_brand',current_primary_brand_other='$current_primary_brand_other',current_secon_brand='$current_secon_brand',current_secon_brand_other='$current_secon_brand_other',profession='$profession',job_business_study='$job_business_study',express_thanks='$express_thanks',SubmitDate='$Stime',Callstatus='$callstatus',Callremarks='$callremarks',UseriD='$userid',chk_call='$chk_call' WHERE sl='$code'";
} else {
	$sql = "UPDATE project_trinity_08082021  SET ThirdStatus='$callstatus', ThirdRemarks='$callremarks', NameVerified='$nameverified', AgeVerified='$ageverified',ConductedbyBR='$cbr',full_flavoured_somke='$full_flavoured_somke',blueberry_and_lemon_flavour='$blueberry_and_lemon_flavour',current_primary_brand='$current_primary_brand',current_primary_brand_other='$current_primary_brand_other',current_secon_brand='$current_secon_brand',current_secon_brand_other='$current_secon_brand_other',profession='$profession',job_business_study='$job_business_study',express_thanks='$express_thanks',SubmitDate='$Stime',Callstatus='$callstatus',Callremarks='$callremarks',UseriD='$userid',chk_call='$chk_call' WHERE sl='$code'";
}


$updatedb = mysql_query($sql);
//header("location:search.php")
if ($updatedb) {
	echo '<script type="text/javascript">alert("You have submitted data successfully !!");</script>';
	mysql_close();
	echo "<script>setTimeout(\"location.href = 'project_trinity_08082021.php';\",100);</script>";
} else {
	echo '<script type="text/javascript">alert("Data Can not be inserted.!!");</script>';
	mysql_close();
}
