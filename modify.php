 <?php
require 'config.php';
require 'mysql.class.php';
header("Content-Type: text/html;charset=utf-8");
session_start();
if (!$_SESSION['admin']) {
	header('location:index.php');
}
DB::connect();
mysqli_set_charset(DB::$con,"utf8");

$id = DB::$con->real_escape_string($_POST['id']);
$name = DB::$con->real_escape_string($_POST['name']);
$recetteText = DB::$con->real_escape_string($_POST['recetteText']);
$urlImg = DB::$con->real_escape_string($_POST['URL']);



$i = 1;

//error_log($i, 3, './errors.log');
$ingredient = DB::$con->real_escape_string($_POST['ingredient'.strval($i)]);
$quantity = DB::$con->real_escape_string($_POST['quantity'.strval($i)]);
$ingredients = array($ingredient);
$quantities = array($quantity);
while (True){
	if (isset($_POST['ingredient'.strval($i)]))
		$ingredient = DB::$con->real_escape_string($_POST['ingredient'.strval($i)]);
	else break;
	if (isset($_POST['quantity'.strval($i)]))
		$quantity = DB::$con->real_escape_string($_POST['quantity'.strval($i)]);
	else break;
	if (strlen($ingredient)==0 || strlen($quantity)==0) break;
	
	$incredients[] = $ingredient;
	$quantities[] = $quantity;
	$i ++;
}
$n = $i-1;

if (empty($id) || empty($recetteText)) {
	echo "<script>alert('ID ou contenu ne peuvent pas ¨ºtre vide')</script>";
	//exit('{"error":"1","msg":"Nom de plat ou contenu ne peut pas ¨ºtre vide"}');
}
if (mb_strlen($id) != 10 || mb_strlen($recetteText) > 600) {
	echo "<script>alert('Taille incorrecte')</script>";
	//exit('{"error":"1","msg":"Taille d¨¦pass¨¦"}');
}


$delSQL = 'DELETE FROM ' . GB_TABLE_RECIPES . " WHERE rid='{$id}'";
$delete_status = mysqli_query(DB::$con,$delSQL);
$delSQL = 'DELETE FROM ' . GB_TABLE_INGREDIENT . " WHERE rid='{$id}'";
$delete_status = mysqli_query(DB::$con,$delSQL);
echo "<script>alert('".$name."')</script>";
if (!empty($name)){
	$sql_insert = 'insert into ' . GB_TABLE_RECIPES . ' (dish, text, img) values( ' . "'{$name}', '{$recetteText}', '{$urlImg}');";
	$insert_status = mysqli_query(DB::$con,$sql_insert);
	$rid=mysqli_insert_id(DB::$con);
	$sql_insert = 'insert into '.GB_TABLE_INGREDIENT.' (rid, name_ingredient,quantity) values';
	for ($i=0;$i<$n;$i++)
		 $sql_insert = $sql_insert ."({$rid},'{$incredients[$i]}','{$quantities[$i]}'),";
	$sql_insert = $sql_insert ."({$rid},'{$incredients[$i]}','{$quantities[$i]}');";

	$insert_status = mysqli_query(DB::$con,$sql_insert);
}
DB::close();
 
if($insert_status) {
	echo "<script>alert('Message succ¨¨s')</script>";
} else{
	echo "<script>alert('Message ¨¦chec')</script>";
}

header("Location: /admin.php");  
exit;  