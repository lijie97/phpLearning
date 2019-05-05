<?php
/**
* set title 
*/
//is admin login?
session_start();
if (!$_SESSION['admin']) {
	header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″ />
      <link href="styles/main.css" rel="stylesheet">
      <link href="styles/responsive.css" rel="stylesheet">
      <link href="styles/print.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Roboto+Mono:400|Material+Icons"
         rel="stylesheet">
      <meta name="viewport" content="initial-scale=1, width=device-width">
      
      <meta charset="utf-8">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
      <title>Cuire à la maison</title>
	  <style>

         :-moz-placeholder {
         color: blue;
         }
         :-webkit-input-placeholder {
         color: blue;
         }
         
        .window {
            margin: 0 auto;
            padding-left: 25px;
            padding-right: 25px;
            padding-top: 15px;
            width: 350px;
            height: 240px;
            background: #FFFFFF;
            /*以下css用于让登录表单垂直居中在界面,可删除*/
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -200px;
            margin-left: -175px;
            z-index : 5;
            box-shadow : 10px 10px 5px #888888;
            border :  1px solid #000000;
        }
      </style>
   </head>

  

   <?php 


require 'config.php';
require 'mysql.class.php';

$gb_count_sql_recipes = 'SELECT count(*) FROM ' . GB_TABLE_RECIPES;
$gb_count_sql_ingredient = 'SELECT count(*) FROM ' . GB_TABLE_INGREDIENT;
DB::connect();
$gb_count_res = mysqli_query(DB::$con,$gb_count_sql_recipes);
$gb_count = mysqli_fetch_row($gb_count_res)[0];

mysqli_query(DB::$con,'set names utf8');



$pagedata_sql_recipes = 'SELECT  rid,dish,text,img FROM ' . GB_TABLE_RECIPES . ' ORDER BY rid ASC';
$pagedata_sql_ingredient = 'SELECT  iid,rid,name_ingredient,quantity FROM ' . GB_TABLE_INGREDIENT . ' ORDER BY rid ASC';

$sql_page_result_recipes = mysqli_query(DB::$con,$pagedata_sql_recipes);
$sql_page_result_ingredient = mysqli_query(DB::$con,$pagedata_sql_ingredient);
// var_dump($sql_page_result_recipes);

while($temp = mysqli_fetch_array($sql_page_result_recipes)) {
    $sql_page_array_recipes[] = $temp;
}
while($temp = mysqli_fetch_array($sql_page_result_ingredient)) {
    $sql_page_array_ingredient[] = $temp;
}
DB::close();
?>


   <body class="color-cyan">
      <header>

         <div class="header-wrapper">
            <div class="header-title">
               <span class="section-title">Cuire à la maison</span>
               <span class="chapter-title">
               <span class="title-separator">–</span> Introduction
               </span>
            </div>
         </div>
		          <div>
		<form class="contact_form"  method="post" name="contact_form" action="logout.php">
            <table>
               <tr>
                  <button class="submit">Déconnextion</button>
               </tr>
            </table>
		</form>
         </div>
      </header>
      <div id="grid-cont" >
         <section class="grid_outer chapter">
            <h1 class="chapter-title">Cuire à la maison</h1>
            <div class="chapter-content">
               <div class="article-content chapter-intro">
                  <figure class="s-tag-media">
                     <div class="media">
                        <div class="frame">	
                           <img alt="" src="https://static01.nyt.com/images/2015/04/30/dining/29BIGAPPETITE/29BIGAPPETITE-superJumbo.jpg" />
                        </div>
                     </div>
                  </figure>
                  <h1>
                     Nous sommes un site recettes dédié à recommander des plats cuisinés à la maison.
                  </h1>  
            </div>
		
		<?php 
					if (!empty($sql_page_array_recipes)) {
						foreach($sql_page_array_recipes as $key => $recipes){
							

							echo '<div style="chapter-title"><li class="chapter-title">Le plat ：<span>'. $recipes['dish'].'   ID = '.$recipes["rid"].'</span> ';
							echo '<div class="chapter-content"><div class="article-content chapter-intro">';
							echo '<figure class="s-tag-media"><div class="media"><div class="frame"><img alt="" src="'.$recipes['img'].'" /></div></div></figure>';
							$str = str_replace(array("\r\n", "\r", "\n"), "<br>", $recipes['text']);  
							echo '<li class="chapter-title">Recette： </li>';
							echo '<li class="list-group-item l">' . $str .'</li>';
							if (!empty($recipes['reply'])) {
								echo '<li class="list-group-item list-group-item-warning">Commentaire ：' . $recipes['reply'] ;
								echo '<span style="float:right;">Temps ：' . $recipes['replytime'] .'</span></li>';
							}
							echo '<li class="chapter-title">Ingrédient: </li>';
							foreach($sql_page_array_ingredient as $key => $ingrements){
								if ($ingrements["rid"]==$recipes["rid"])
									echo '<li class="list-group-item l">'.$ingrements["quantity"].' '. $ingrements["name_ingredient"] .'</li>';
							}
							echo '<br>';
							echo '</div><hr>';
						}
					}

					echo '<br><h2> La nombre de recettes : '.$gb_count.'</h2>';
				?>
		<canvas id="canvas">
		
		</canvas>

		<script>
		window.addEventListener("resize", resizeCanvas, false);

		function resizeCanvas() {
			w = canvas.width = window.innerWidth;
			h = canvas.height = window.innerHeight;
		}

		</script>
		<section class="grid_outer chapter">
			<h1 class="chapter-title">Modifier</h1>
				<div class="chapter-content">
					<form class="contact_form"  method="post" name="contact_form" action="modify.php"><!---->
						<ul>
							<li>
							<label for="id">ID:</label>
							<input type="text" name="id" id="id" placeholder="ID (10 chiffres) (Ajouter s'il n'existe)"/>
							</li>
							<li>
							<label for="name">Nom de plat:</label>
							<input type="text" name="name" id="name" placeholder="Nom de plat (vide comme Supprimer)"/>
							</li>
							<li>
							<label for="imgURL">URL de l'image:</label>
							<input type="text" name="URL" id="URL" placeholder="URL de l'image"/>
							</li>
							</li>
							<li>
							<label for="Recette">Recette:</label>
							<textarea name="recetteText" id="recetteText" cols="40" rows="6" ></textarea>
							</li>

							<li>
								<!--<button class="submit" type="button" onclick="document.body.insertAdjacentHTML('afterend','<li></li>')">Ajouter</button>
								-->
								<label for="'+varCount+'">quantity 1:</label>
								<input type="text" name="quantity1" id="quantity1">
								<br><br>
								<label for="ingredient1">ingrédient 1: </label>
								<input type="text" name="ingredient1" id="ingrédient1">
								<!--<span class="removeVar">Supprimer</span>-->
								
							</li>
							<li>
								<input id="addVar" class="addVar" type="button" id = "addingrédient" value="Ajouter un ingrédient"/>
								
							</li>
							<li>
								<button class="submit" type="submit" id="subAddRcp">Submit Form</button>
							</li>
							
						</ul>
					</form>
					
				</div>
			</div>
		</div>
      </div>
      </section>
      </div>
      <footer>
         <div class="footer-grid">
         </div>
      </footer>

	  <script type="text/javascript" src="js/ajax_submit.js"></script>
	  
	  <script type="text/javascript" src="js/addLine.js"></script>
	  <!--<script type="text/javascript" src="js/ajax_submit.js"></script>-->
   </body>
</html>


