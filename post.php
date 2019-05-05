 <?php
require 'config.php';
require 'mysql.class.php';
header("Content-Type: text/html;charset=utf-8");
DB::connect();
//mysql_query("SET NAMES 'utf8'");
//file_put_contents('debug.txt', var_export($arg,true)."\n",FILE_APPEND);

//error_log('Hello', 3, './errors.log');
mysqli_set_charset(DB::$con,"utf8");

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
error_log($n, 3, './errors.log');
error_log("\n", 3, './errors.log');
error_log($incredients, 3, './errors.log');
if (empty($name) || empty($recetteText)) {
	echo "<script>alert('Nom de plat ou contenu ne peut pas être vide')</script>";
	//exit('{"error":"1","msg":"Nom de plat ou contenu ne peut pas être vide"}');
}
if (mb_strlen($name) > 10 || mb_strlen($recetteText) > 600) {
	echo "<script>alert('Taille dépassé')</script>";
	//exit('{"error":"1","msg":"Taille dépassé"}');
}	
$sql_insert = 'insert into ' . GB_TABLE_RECIPES . ' (dish, text, img) values( ' . "'{$name}', '{$recetteText}', '{$urlImg}');";

$insert_status = mysqli_query(DB::$con,$sql_insert);
$rid=mysqli_insert_id(DB::$con);
$sql_insert = 'insert into '.GB_TABLE_INGREDIENT.' (rid, name_ingredient,quantity) values';
for ($i=0;$i<$n;$i++)
	 $sql_insert = $sql_insert ."({$rid},'{$incredients[$i]}','{$quantities[$i]}'),";
$sql_insert = $sql_insert ."({$rid},'{$incredients[$i]}','{$quantities[$i]}');";
//error_log($sql_insert, 3, './errors.log');
$insert_status = mysqli_query(DB::$con,$sql_insert);

DB::close();
 
if($insert_status) {
	echo "<script>alert('Message succès')</script>";
	// echo json_encode(['error'=>'0','msg'=>'Success message']);
} else{
	echo "<script>alert('Message échec')</script>";
	//echo json_encode(['error'=>'1','msg'=>'Messages failed']);
}

header("Location: /index.php");  
exit;  