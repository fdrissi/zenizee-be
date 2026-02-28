<?php
require dirname(dirname(__FILE__)) . "/filemanager/evconfing.php";
header("Content-type: application/json");

$check = $evmulti->query("SELECT DISTINCT city FROM tbl_event WHERE status=1 AND city!='' ORDER BY city ASC");
$op = [];
while ($row = $check->fetch_assoc()) {
    $op[] = [
        "title" => $row["city"],
        "id" => strtolower(str_replace(" ", "_", $row["city"]))
    ];
}
$returnArr = [
    "CityData" => $op,
    "ResponseCode" => "200",
    "Result" => "true",
    "ResponseMsg" => "City List Get Successfully!!",
];
echo json_encode($returnArr);
