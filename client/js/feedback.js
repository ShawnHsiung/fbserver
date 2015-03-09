/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//var server_root = "http://10.20.48.147/fbserver/";
var server_root = "http://192.168.1.104/fbserver/";

var api_key = null;
//get groups from server
    function get_groups(){
        var group = [];
         $.ajax({
             type: "GET",
             url: server_root + "group",
             dataType:"json",
             cache: false,
             async: false,
             success:function (data) {
                 group = data;
             }
         }); 
         return group
    }
    //add groups from server
    function add_group(name){
        var data = [];
         $.ajax({
             type: "POST",
             url: server_root + "group",
             dataType:"json",
             data:{"name":name},
             cache: false,
             async:false,
             success:function (data) {
                 data = data;
             }
         }); 
         return data;
    }
    //delete group from server
    function delete_group(name){
        var data = [];
        $.ajax({
            type: "DELETE",
            url: server_root + "group/" + name,
            dataType:"json",
            cache: false,
            async:false,
            success:function (data) {
                data = data;
            }
        }); 
        return data;
    }
    
    //get questions from server
    function get_question(){
        var question = [];
        $.ajax({
             type: "GET",
             url: server_root + "question",
             dataType:"json",
             cache: false,
             async:false,
             success:function (data) {
                 question = data;
             }
         });
         return question;
    }
    function add_question(text,name){
        var flag = false;
        $.ajax({
            type: "POST",
            url: server_root + "question",
            dataType:"json",
            cache: false,
            async:false,
            data:{"text":text,"name":name},
            success:function (data) {
                if(!data.error){
                    flag = true;
                }
            }
        }); 
        return flag;
    }
    
$(function () {
    $('#leftnav ').on( 'click', 'li', function () {
        if ( !$(this).hasClass('active') ) {
            table.$('li.active').removeClass('active');
            $(this).addClass('active');
        }
    });
});
var resource = {
    '1': "./client/sub_home.php",
    '2': "./client/group.php",
    '3': "./client/question.php",
    '4': "./client/questionnaire.php"
//    '5': "./client/sub_home.php"
};
function showpage(i){
    if(1 !== i){
        clearInterval(timerId);
    }
    htmlobj=$.ajax({url: resource[i],async:false});
//    $().html()
    $("#page-wrapper").html(htmlobj.responseText);
}


//    $("#login").click(function () {
//        $.ajax({
//            type: "POST",
//            url: server_root + "login",
//            dataType:"json",
//            cache: false,
//            data: {username : $("#username").val(), password :$('#password').val()},
//            beforeSend: function () { $("#info").html("Logining..."); },
//            success:function (data) {
//                $("#info").html(data.message);
//                if(!data.error){
//                    window.location.href = "./home.php";
//                    api_key = data.api_key;
//                    return;
//                }
//                $(".password").val("");
//                $(".identify").val("");
//            },
//            error: function () { $("#info").html("Asynchronous read failed！"); }
//        }); 
//    });



//function formhash(form, password) {
//    // Create a new element input, this will be our hashed password field. 
//    var p = document.createElement("input");
// 
//    // Add the new element to our form. 
//    form.appendChild(p);
//    p.name = "p";
//    p.type = "hidden";
//    p.value = hex_sha512(password.value);
// 
//    // Make sure the plaintext password doesn't get sent. 
//    password.value = "";
// 
//    // Finally submit the form. 
//    form.submit();
//}