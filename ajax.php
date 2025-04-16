<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_livreur'){
	$save = $crud->save_livreur();
	if($save)
		echo $save;
}
if($action == 'delete_livreur'){
	$save = $crud->delete_livreur();
	if($save)
		echo $save;
}
if($action == 'delete_client'){
	$save = $crud->delete_client();
	if($save)
		echo $save;
}
if($action == 'save_colis'){
	$save = $crud->save_colis();
	if($save)
		echo $save;
}
if($action == 'delete_colis'){
	$save = $crud->delete_colis();
	if($save)
		echo $save;
}
if($action == 'update_colis'){
	$save = $crud->update_colis();
	if($save)
		echo $save;
}
if($action == 'get_colis_heistory'){
	$get = $crud->get_colis_heistory();
	if($get)
		echo $get;
}

if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}
ob_end_flush();
?>
