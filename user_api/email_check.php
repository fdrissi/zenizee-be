<?php 
require dirname(dirname(__FILE__)) . '/filemanager/evconfing.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');
if($data['email'] == '')
{
    $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");
}
else
{
    $email = strip_tags(mysqli_real_escape_string($evmulti,$data['email']));
    
    
$chek = $evmulti->query("select * from tbl_user where email='".$email."'")->num_rows;

if($chek != 0)
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Already Exist email addess!");
}
else 
{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"New email addess!");
}
}
echo json_encode($returnArr);