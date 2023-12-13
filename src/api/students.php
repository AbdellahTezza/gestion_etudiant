<?php 
    phpinfo();
 // Error/Exception engine, always use E_ALL
 header('Content-Type: application/json');
 header('Access-Control-Allow-Origin: *');
echo "";


$result = array('error'=> false);
// connection to my db 

$host_name = "localhost";
$host_user = "root";
$host_pass = "";
$host_db = "test";

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connect = @mysqli_connect($host_name, $host_user, $host_pass, 'test');

if($connect = true){
	$result['connection_msg'] = "Connection Succesful!";
	$result['is_db_connected'] = true;
} else{
	$result['connection_msg'] = "Err : connection setup is not correct!";
    $result['connection_msg'] = die(mysqli_error);
	exit;
}

// actions
$action = "";
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if($action == "update"){
    $stsArr[] = array("id"=>"1", "name"=>"abdellah", "email"=>"tizzaabdellah@gmail.com", "phone"=>"09999999999");
    $stsArr[] = array("id"=>"2", "name"=>"Amine", "email"=>"Amine@gmail.com", "phone"=>"0611299731");
    $stsArr[] = array("id"=>"3", "name"=>"Sami", "email"=>"Sami@gmail.com", "phone"=>"017717171");
    $result['students'] = $stsArr;
}
if($action == "delete"){

}
if($action == "add"){
    $stsArr[] = "name :".$_POST['name'];
    $stsArr[] = "email : ".$_POST['email'];
    $stsArr[] = "phone :".$_POST['phone'];
    $result['students'] = $stsArr;
}

if($action == "read"){
	// $requette = "SELECT * FROM students";
    // $sql = @mysqli_query($connect, $requette);
    // if($sql){
    //     $result['ok'] =  "ok";
    // }else{
    //     $result['ok'] =  "not in";
    // }
    $stsArr[] = array("id"=>"1", "name"=>"abdellah", "email"=>"tizzaabdellah@gmail.com", "phone"=>"017717171");
    $stsArr[] = array("id"=>"2", "name"=>"Amine", "email"=>"Amine@gmail.com", "phone"=>"0611299731");
    $stsArr[] = array("id"=>"3", "name"=>"Sami", "email"=>"Sami@gmail.com", "phone"=>"017717171");
    // while($rows = @mysqli_fetch_array($sql)){
    //     array_push($stsArr, $rows);
    // }
    // $stsArr = array_push{};
    // $length = count($stsArr);
    // for($x = 5; $x <= $length; $x++){
    //     array_push($stsArr, $x);
    // }
    $result['students'] = $stsArr;
}

echo json_encode($result);
// @mysqli_close($connect);

?>