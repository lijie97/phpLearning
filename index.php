
<?php
/**
* set title 
*/
//is admin login?
session_start();
if ($_SESSION['admin']) {
	header('location:admin.php');
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
            .hide{
            display: none;
        }
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
//error_log("你好 ", 3, './errors.log');
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

         <div id="shade" class="c1 hide"></div>
         <div id="modal" class="c2 hide">
            <!--<p>用户：<input type="text" /></p>
            <p>密码：<input type="password" /></p>
            <p> <input type="button" value="确定"> <input type="button" value="取消" onclick="Hide();"> </p>
            -->
            <div class = "window">
              <div class="title">
                    <span>Login</span>
                    <br>
              </div>
          
              <div class="title-msg">
                  <span>Type your login and password</span>
              </div>
          
              <form class="contact_form" method="post"  action="doLogin.php" novalidate >
                  <!--输入框-->
                  <div class="input-content">
                      <!--autoFocus-->
                      <div>
                          <input type="text" autocomplete="off"
                                placeholder="Email" name="userNameOrEmailAddress" required/>
                      </div>
          
                      <div style="margin-top: 16px">
                          <input type="password"
                                autocomplete="off" placeholder="Password" name="password" required maxlength="32"/>
                      </div>
                  </div>
                  <div>
						Remember me
                      <input type = "checkbox" name = "autoLogin[]" value="1"/>
                      
                  </div>
                  <!--登入按钮-->
                  <div>
                      <br>
                      <table>
                        <tr>
                          <th>
                            <button class="submit" type="submit" >Login</button>
                          </th>
                          <!--<th>
                            <button class="submit" onclick="Hide();" >Cancel</button>
                          </th>-->
                        </tr>
                      </table>
                  </div>
              </form>
            </div>
          </div>
         <!--<div class="name">
            <form>
              <ul>
                <li>
                  <label for="name">Login</label>
                  <input type="text" name="login" placeholder = "login" required/>
                </li>
                <li>
                  <label for="password">password</label>
                  <input type="text" name="password" placeholder = "password" required/>
                </li>
              </ul>
            </form>
            </div>-->
         <div class="header-wrapper">
            <div class="header-title">
               <span class="section-title">Cuire à la maison</span>
               <span class="chapter-title">
               <span class="title-separator">–</span> Introduction
               </span>
            </div>
         </div>
		          <div>
            <table>
               <tr>
                  <button class="submit"  onclick="Show();">Login</button>
               </tr>
            </table>
         </div>
      </header>
      <div id="grid-cont" onclick = "Hide();">
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
						//循环输出数据库中满足条件id留言内容
						foreach($sql_page_array_recipes as $key => $recipes){
							

							echo '<div style="chapter-title"><li class="chapter-title">Le plat ：<span>'. $recipes['dish'].'</span> ';//标题
							echo '<div class="chapter-content"><div class="article-content chapter-intro">';//图片自适应
							echo '<figure class="s-tag-media"><div class="media"><div class="frame"><img alt="" src="'.$recipes['img'].'" /></div></div></figure>';
							$str = str_replace(array("\r\n", "\r", "\n"), "<br>", $recipes['text']);  //文字换行处理
							//echo '<div class="media"><div class="frame"><img alt="" src="https://static2.hervecuisine.com/wp-content/uploads/2010/11/recette-crepes-chandeleur-2018-300x200@2x.jpg" /></div></div>'
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
									//echo ''
							}
							echo '<br>';
							echo '</div><hr>';
							//echo '</div>';
						}
					}

					echo '<br><h2> La nombre de recettes : '.$gb_count.'</h2>';
				?>
		<section class="grid_outer chapter">
			<h1 class="chapter-title">Post form</h1>
				<div class="chapter-content">
					<form class="contact_form"  method="post" name="contact_form" action="post.php">
						<ul>
							<li>
							<label for="name">Nom de plat:</label>
							<input type="text" name="name" id="name" placeholder="Nom de plat" required/>
							</li>
							<li>
							<label for="imgURL">URL de l'image:</label>
							<input type="text" name="URL" id="URL" placeholder="URL de l'image" required/>
							</li>
							</li>
							<li>
							<label for="Recette">Recette:</label>
							<textarea name="recetteText" id="recetteText" cols="40" rows="6" required ></textarea>
							</li>

							<li>
								<!--<button class="submit" type="button" onclick="document.body.insertAdjacentHTML('afterend','<li></li>')">Ajouter</button>
								-->
								<label for="'+varCount+'">quantity 1:</label>
								<input type="text" name="quantity1" id="quantity1" required>
								<br><br>
								<label for="ingredient1">ingrédient 1: </label>
								<input type="text" name="ingredient1" id="ingrédient1" required>
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
      <script> 
         function Show(){
           document.getElementById('shade').classList.remove('hide'); 
           document.getElementById('modal').classList.remove('hide'); 
         } 
         function Hide(){ 
           document.getElementById('shade').classList.add('hide'); 
           document.getElementById('modal').classList.add('hide'); 
         } 
          
      </script>
	  
	  
	  <script type="text/javascript" src="js/addLine.js"></script>
   </body>
</html>


