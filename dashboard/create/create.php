<?php
require '../../style/connection/dashboard.php';

if (!isset($_POST['sheeetName']) || !isset($_POST['itemPrice']) || empty($_POST['sheeetName'])) {
	//echo $_POST['sheeetName'];
	//die();
	return @header("location: ../create/");
}

$myFlag = itExistCheck('all_sheets', 'sheet', test_input($_POST['sheeetName']));

	$poster = $_SESSION['dms_user_login'];
	$names = test_input($_POST['names']); 
	$item = test_input($_POST['item']); 
	$phonesNumber = test_input($_POST['phonesNumber']); 
	$itemPrice = test_input($_POST['itemPrice']); 
	$dateCollected = test_input($_POST['dateCollected']); 
	$returnDate = test_input($_POST['returnDate']);
	$addInfo = test_input($_POST['addInfo']);  
	$sheetName = test_input($_POST['sheeetName']);

if ($myFlag >= 1) {
	//if it exist, insert to table

	@ $query_insert = "INSERT INTO `debt_sheets` (`debt_id`, `debtor_name`, `item_collected`, `debtor_phone`, `item_cost`, `date_collected`, `date_return`, `additional_info`, `entered_by`, `sheet_name`) VALUES (
	NULL, 
	'$names', '$item', '$phonesNumber',	'$itemPrice', '$dateCollected',	'$returnDate',	'$addInfo',	'$poster',	'$sheetName')";

	$result_insert = $db->query($query_insert);
 
  if ($result_insert) {
    //if it gets inserted successfully
    @header("location: index.php?success=1&s=$sheetName");
  
  }else{
    @header("location: index.php?err");
    
 }

}else if ($myFlag < 1) {
	//when sheet is not in db

	@$query_insert1 = "INSERT INTO `all_sheets` (`id`, `sheet`, `access1`, `access2`, `access3`, `access4`) VALUES (NULL, '$sheetName', '$poster', '', '', '')";

	@ $query_insert = "INSERT INTO `debt_sheets` (`debt_id`, `debtor_name`, `item_collected`, `debtor_phone`, `item_cost`, `date_collected`, `date_return`, `additional_info`, `entered_by`, `sheet_name`) VALUES (
	NULL, 
	'$names', '$item', '$phonesNumber',	'$itemPrice', '$dateCollected',	'$returnDate',	'$addInfo',	'$poster',	'$sheetName')";

	$result_insert = $db->query($query_insert1);
	
  if ($result_insert) {
    //if it gets inserted successfully
    $result_insert1 = $db->query($query_insert);
    header("location: index.php?success=1&s=$sheetName");
  
  }else{
    header("location: index.php?err");
    
 }


}

?>