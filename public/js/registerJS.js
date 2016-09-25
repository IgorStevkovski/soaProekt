$(document).ready(function () {

    $("#errorInput").hide(8000);

});

function validateEmailPom(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validateEmail(){
    $("#resultEmail").text("");
    var email = $("#mail").val();
    if(validateEmailPom(email)){
        $("#resultEmail").text(email+" is valid!");
        $("#resultEmail").css("color","green");
        return true;
    }else{
        $("#resultEmail").text(email+" is NOT valid!");
        $("#resultEmail").css("color","red");
        return false;
    }

}

function validatePass(){
    $("#resultPass").text("");
    var pass = $("#passw").val();
    if(pass ==""||pass==null)
    {
        $("#resultPass").text("Password is NOT OK!");
        $("#resultPass").css("color","red");
        return false;
    }else{
        $("#resultPass").text("Password is OK!");
        $("#resultPass").css("color","green");
        return true;
    }

}

function validateRepeatPass(){
    $("#resultRepeatPass").text("");
    $("#resultPass").text("");
    var rPass = $("#repeatPassw").val();
    var pass = $("#passw").val();

    if(rPass === pass){
        $("#resultRepeatPass").text("Passwords are same!");
        $("#resultRepeatPass").css("color","green");
        return true;
    }
    else{
        $("#resultRepeatPass").text("Passwords are NOT same!");
        $("#resultRepeatPass").css("color","red");
        return false
    }

}

function validateName(){
    $("#resultName").text("");
    var name = $("#nameName").val();
    if(name ==""||name==null)
    {
        $("#resultName").text("Name is required!");
        $("#resultName").css("color","red");
        return false;
    }else{
        $("#resultName").text("Name is OK!");
        $("#resultName").css("color","green");
        return true;
    }

}

function validacija(){
    if(validateEmail() && validatePass() && validateRepeatPass() && validateName()){
        $("#formID").submit();
    }
    else{
        event.preventDefault();
    }
}