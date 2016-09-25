$(document).ready(function(){

    var br = 0;

    $("#btnHoteli").click(function(){
       if(br == 0){
           $("#listaHoteli").hide();
           br = 1;
       }
        else{
           $("#listaHoteli").show();
           br = 0;
       }
    });

});

