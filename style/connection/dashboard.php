<?php
//contains codes to be called in other files
session_start();

if(!isset($_SESSION['dms_user_login'])){
	session_start();
	session_unset(); 
	header("location: http://localhost/debt/");	

}

require 'connection.php';

$query1 = "select * from all_sheets";

function result2($sheet_name){
	global $db;
	 $query2 = "SELECT * FROM debt_sheets WHERE `sheet_name` = '$sheet_name' LIMIT 10";
	$result2=$db->query($query2);
	return $result2;
}

function itExistCheck($DBtable, $DBcolumn, $DBdata){
	global $db;
	@ $query2 = "select $DBcolumn from $DBtable where $DBcolumn = '$DBdata'";
	$DBresult=$db->query($query2);
	$DBchecker = $DBresult->num_rows;
	return $DBchecker;
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$result=$db->query($query1);


?>