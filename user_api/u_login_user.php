<?php
require dirname(dirname(__FILE__)) . '/filemanager/evconfing.php';
$data = json_decode(file_get_contents('php://input'), true);
header('Content-type: text/json');

// User login by mobile number
if (isset($data['mobile']) && isset($data['password']) && !isset($data['type'])) {
    $mobile   = strip_tags(mysqli_real_escape_string($evmulti, $data['mobile']));
    $ccode    = strip_tags(mysqli_real_escape_string($evmulti, $data['ccode']));
    $password = strip_tags(mysqli_real_escape_string($evmulti, $data['password']));

    if ($mobile == '' || $password == '') {
        $returnArr = array(
            "ResponseCode" => "401",
            "Result" => "false",
            "ResponseMsg" => "Something Went Wrong!"
        );
    } else {
        $chek = $evmulti->query("SELECT * FROM tbl_user WHERE mobile='" . $mobile . "' AND ccode='" . $ccode . "' AND password='" . $password . "' AND status=1");

        if ($chek->num_rows != 0) {
            $c = $chek->fetch_assoc();
            $_SESSION['user_id']   = $c['id'];
            $_SESSION['user_type'] = 'user';
            $returnArr = array(
                "UserLogin" => $c,
                "ResponseCode" => "200",
                "Result" => "true",
                "ResponseMsg" => "Login successfully!"
            );
        } else {
            // Check if user exists but wrong password
            $userExists = $evmulti->query("SELECT * FROM tbl_user WHERE mobile='" . $mobile . "' AND ccode='" . $ccode . "'");
            if ($userExists->num_rows == 0) {
                $returnArr = array(
                    "ResponseCode" => "401",
                    "Result" => "false",
                    "ResponseMsg" => "Mobile Number Not Found!"
                );
            } else {
                $returnArr = array(
                    "ResponseCode" => "401",
                    "Result" => "false",
                    "ResponseMsg" => "Invalid Password!"
                );
            }
        }
    }
}
// Organizer / Scanner / Manager login by email
else if (isset($data['email']) && $data['email'] != '' && isset($data['password']) && $data['password'] != '') {
    $email   = strip_tags(mysqli_real_escape_string($evmulti, $data['email']));
    $ccode    = strip_tags(mysqli_real_escape_string($evmulti, $data['ccode']));
    $password = strip_tags(mysqli_real_escape_string($evmulti, $data['password']));
    $type = $data['type'];
	if($type == 'Orgnizer')
	{
    $chek   = $evmulti->query("select * from tbl_sponsore where   email='" . $email . "' and status = 1 and password='" . $password . "'");
    $status = $evmulti->query("select * from tbl_sponsore where status = 1");
    if ($status->num_rows != 0) {
        if ($chek->num_rows != 0) {
            $c = $evmulti->query("select * from tbl_sponsore where  email='" . $email . "' and status = 1 and password='" . $password . "'")->fetch_assoc();
            $_SESSION['user_id']   = $c['id'];
            $_SESSION['user_type'] = 'organizer';

            $returnArr = array(
                "OragnizerLogin" => $c,
                "currency" => $set['currency'],
                "ResponseCode" => "200",
                "Result" => "true",
				"Type"=>"Admin",
                "ResponseMsg" => "Login successfully!"
            );
        } else {
            $returnArr = array(
                "ResponseCode" => "401",
                "Result" => "false",
                "ResponseMsg" => "Invalid Mobile Number Or Email Address or Password!!!"
            );
        }
    } else {
        $returnArr = array(
            "ResponseCode" => "401",
            "Result" => "false",
            "ResponseMsg" => "Your Status Deactivate!!!"
        );
    }
	}
	else if($type == 'SCANNER')
	{
	$chek   = $evmulti->query("select * from tbl_omanager where   email='" . $email . "' and status = 1 and password='" . $password . "' and manager_type='SCANNER'");
    $status = $evmulti->query("select * from tbl_omanager where status = 1");
    if ($status->num_rows != 0) {
        if ($chek->num_rows != 0) {
            $c = $evmulti->query("select * from tbl_omanager where  email='" . $email . "' and status = 1 and password='" . $password . "' and manager_type='SCANNER'")->fetch_assoc();
            $_SESSION['user_id']   = $c['orag_id'];
            $_SESSION['user_type'] = 'scanner';

            $p = array();
            $p["id"] = $c["orag_id"];
            $p["name"] = $c["name"];
            $p["email"] = $c["email"];
            $p["password"] = $c["password"];
            $p["manager_type"] = $c["manager_type"];
            $p["status"] = $c["status"];
            $returnArr = array(
                "OragnizerLogin" => $p,
                "currency" => $set['currency'],
                "ResponseCode" => "200",
                "Result" => "true",
				"Type"=>"SCANNER",
                "ResponseMsg" => "Login successfully!"
            );
        } else {
            $returnArr = array(
                "ResponseCode" => "401",
                "Result" => "false",
                "ResponseMsg" => "Invalid  Email Address or Password!!!"
            );
        }
    } else {
        $returnArr = array(
            "ResponseCode" => "401",
            "Result" => "false",
            "ResponseMsg" => "Your Status Deactivate!!!"
        );
    }
	}
	else
	{
	$chek   = $evmulti->query("select * from tbl_omanager where   email='" . $email . "' and status = 1 and password='" . $password . "' and manager_type='MANAGER'");
    $status = $evmulti->query("select * from tbl_omanager where status = 1");
    if ($status->num_rows != 0) {
        if ($chek->num_rows != 0) {
            $c = $evmulti->query("select * from tbl_omanager where  email='" . $email . "' and status = 1 and password='" . $password . "' and manager_type='MANAGER'")->fetch_assoc();
            $_SESSION['user_id']   = $c['orag_id'];
            $_SESSION['user_type'] = 'manager';

            $p = array();
            $p["id"] = $c["orag_id"];
            $p["name"] = $c["name"];
            $p["email"] = $c["email"];
            $p["password"] = $c["password"];
            $p["manager_type"] = $c["manager_type"];
            $p["status"] = $c["status"];

            $returnArr = array(
                "OragnizerLogin" => $p,
                "currency" => $set['currency'],
                "ResponseCode" => "200",
                "Result" => "true",
				"Type"=>"MANAGER",
                "ResponseMsg" => "Login successfully!"
            );
        } else {
            $returnArr = array(
                "ResponseCode" => "401",
                "Result" => "false",
                "ResponseMsg" => "Invalid  Email Address or Password!!!"
            );
        }
    } else {
        $returnArr = array(
            "ResponseCode" => "401",
            "Result" => "false",
            "ResponseMsg" => "Your Status Deactivate!!!"
        );
    }
	}
} else {
    $returnArr = array(
        "ResponseCode" => "401",
        "Result" => "false",
        "ResponseMsg" => "Something Went Wrong!"
    );
}

echo json_encode($returnArr);
