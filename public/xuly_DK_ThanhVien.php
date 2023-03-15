

<?php
session_start();
include __DIR__ . "/../bootstrap.php";
require_once __DIR__ . "/../bootstrap.php";

use CT466\Project\dattiec;
use CT466\Project\user;

$errors = [];
$dattiec = new dattiec($PDO);
$user = new user($PDO);



// echo "<pre>";
// print_r($_POST);
// print_r($dattiec->fill($_POST));
// $dattiec->save();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $array = [];
    $array['fullname'] = $_POST['fullname'];
	$array['username'] = $_POST['username'];
    
    

    $array['password'] = $_POST['password'];
	
    $array['diachi'] = $_POST['diachi'];
    $array['phuong'] = $_POST['phuong'];
    $array['quan'] = $_POST['quan'];
    $array['tinh'] = $_POST['tinh'];

    $array['sdt'] = $_POST['sdt'];
	$array['email'] = $_POST['email'];
    
    
}



?>