$(document).ready(function () {
    $("#subAddRcp").click(function () {
        //alert("123");
        var name = $("#name").val();
        var urlImg = $("#URL").val();
        var recetteText = $("#recetteText").val();
        var ingrement = $("#ingrement1").val();
        var quantity = $("#ingrement1").val();
        var index = 2;
        var ingrements = new Array();
        var quantities = new Array();
        while (ingrement !== undefined && quantity !== undefined) {
            ingrements[index - 1] = ingrement;
            quantities[index - 1] = quantity;
            ingrement = $("#ingrement" + index.toString()).val();
            quantity = $("#quantity" + index.toString()).val();
            //alert("#ingrement" + index.toString());
            index++;
        }
        var n = index;

        //var
        if (name === "" || recetteText === "") { //必填字段
            alert("Nom ou le content ne peuvent pas être vide"); //这个方法太暴力，可以想想其他的
            return false;
        } else if (name.length > 30) {
            alert('Nom de plat trop long');
            return false;
        } else {
            var data = {
                "name": name,
                "recetteText": recetteText,
                "urlImg": urlImg
            };
            for (var i = 0; i < n; i++) {
                data["ingrement" + (index+1).toString()] = ingrements[i];
                data["quantity" + (index+1).toString()] = quantities[i];
            }   
        }
    });
});
