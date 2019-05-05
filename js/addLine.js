
//初始参数个数
var varCount = 1;
 
$(function () {
    //新增按钮点击
    $('#addVar').on('click', function(){
                
		//window.alert() 
		$("#btnDel"+varCount).remove();
		varCount++;
        $node = '<li><label for="'+varCount+'">quantity '+varCount+': </label>'
        + '<input type="text" name="quantity'+varCount+'" id="quantity'+varCount+'" required>'
        +'<br><br><label for="ingredient'+varCount+'">ingrédient '+varCount+': </label>'
        + '<input type="text" name="ingredient '+varCount+'" id="ingredient'+varCount+'" required>'
        +'<span class="removeVar" id="btnDel'+varCount+ '">Supprimer</span></li>';//+ '<span class="removeVar">Supprimer</span>'
        $(this).parent().before($node);
				
    });
 
    //删除按钮点击
    $('form').on('click', '.removeVar', function(){
	if (varCount>2){
		$node = '<span class="removeVar" id="btnDel'+(varCount-1)+'">Supprimer</span>';
		$("#ingredient"+(varCount-1)).after($node);
		$("#ingredient"+varCount).parent().remove();//
		varCount--;
	}
	else if (varCount==2){
		$("#ingredient"+varCount).parent().remove();//
		varCount--;
	}
            
			
    });
});