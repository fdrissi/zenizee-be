<?php 
require 'evconfing.php';
$GLOBALS['evmulti'] = $evmulti;
class Event {
 

	function evmultilogin($username,$password,$tblname) {
		
		if($tblname == 'admin')
		{
		$q = "select * from ".$tblname." where username='".$username."' and password='".$password."'";
	return $GLOBALS['evmulti']->query($q)->num_rows;
		}
		else 
		{
			$q = "select * from ".$tblname." where email='".$username."' and password='".$password."'";
	return $GLOBALS['evmulti']->query($q)->num_rows;
		}
		
	}
	
	function evmultiinsertdata($field,$data,$table){

    $field_values= implode(',',$field);
    $data_values=implode("','",$data);

    $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
    $result=$GLOBALS['evmulti']->query($sql);
  return $result;
  }
  
  
function str_replace_first($search, $replace, $subject)
{
    $search = '/'.preg_quote($search, '/').'/';
    return preg_replace($search, $replace, $subject, 1);
}

  function evmultizoneinsertdata($field,$data,$table){

    $field_values= implode(',',$field);
    $data_values=implode("','",$data);
$data_values=$this->str_replace_first("','",",'",$data_values)."'"; 
    $sql = "INSERT INTO $table($field_values)VALUES($data_values)";
    $result=$GLOBALS['evmulti']->query($sql);
  return $result;
  }
  
  function insmulti($field,$data,$table){

    $field_values= implode(',',$field);
    $data_values=implode("','",$data);

    $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
    $result=$GLOBALS['evmulti']->multi_query($sql);
  return $result;
  }
  
  function evmultiinsertdata_id($field,$data,$table){

    $field_values= implode(',',$field);
    $data_values=implode("','",$data);

    $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
    $result=$GLOBALS['evmulti']->query($sql);
  return $GLOBALS['evmulti']->insert_id;
  }
  
  function evmultiinsertdata_Api($field,$data,$table){

    $field_values= implode(',',$field);
    $data_values=implode("','",$data);

    $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
    $result=$GLOBALS['evmulti']->query($sql);
  return $result;
  }
  
  function evmultiinsertdata_Api_Id($field,$data,$table){

    $field_values= implode(',',$field);
    $data_values=implode("','",$data);

    $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
    $result=$GLOBALS['evmulti']->query($sql);
  return $GLOBALS['evmulti']->insert_id;
  }
  
  function evmultiupdateData($field,$table,$where){
$cols = array();

    foreach($field as $key=>$val) {
        if($val != NULL) // check if value is not null then only add that colunm to array
        {
			
           $cols[] = "$key = '$val'"; 
			
        }
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " $where";
$result=$GLOBALS['evmulti']->query($sql);
    return $result;
  }
  
  function evmultiupdateDatanull_Api($field,$table,$where){
$cols = array();

    foreach($field as $key=>$val) {
        if($val != NULL) // check if value is not null then only add that colunm to array
        {
           $cols[] = "$key = '$val'"; 
        }
		else 
		{
			$cols[] = "$key = NULL"; 
		}
    }
	
 $sql = "UPDATE $table SET " . implode(', ', $cols) . " $where";
$result=$GLOBALS['evmulti']->query($sql);
    return $result;
  }
  
  
  function evmultizoneupdateData($field,$table,$where){
$cols = array();

    foreach($field as $key=>$val) {
        if($val != NULL) // check if value is not null then only add that colunm to array
        {
			if($key == 'coordinates')
			{
				$cols[] = "$key = $val"; 
			}
			else 
			{
           $cols[] = "$key = '$val'"; 
			}
        }
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " $where";
$result=$GLOBALS['evmulti']->query($sql);
    return $result;
  }
  
   function evmultiupdateData_Api($field,$table,$where){
$cols = array();

    foreach($field as $key=>$val) {
        if($val != NULL) // check if value is not null then only add that colunm to array
        {
           $cols[] = "$key = '$val'"; 
        }
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " $where";
$result=$GLOBALS['evmulti']->query($sql);
    return $result;
  }
  
  
  
  
  function evmultiupdateData_single($field,$table,$where){
$query = "UPDATE $table SET $field";

$sql =  $query.' '.$where;
$result=$GLOBALS['evmulti']->query($sql);
  return $result;
  }
  
  function evmultiDeleteData($where,$table){

    $sql = "Delete From $table $where";
    $result=$GLOBALS['evmulti']->query($sql);
  return $result;
  }
  
  function evmultiDeleteData_Api($where,$table){

    $sql = "Delete From $table $where";
    $result=$GLOBALS['evmulti']->query($sql);
  return $result;
  }
 
}
?>