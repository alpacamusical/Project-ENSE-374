/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener('load', btnSignUp);
window.addEventListener('load', btnLogin);
var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024);
var msg;

db.transaction(function (tx){
    tx.executeSql('CREATE TABLE IF NOT EXISTS users (email TEXT, firstName TEXT, lastName TEXT, username TEXT, password TEXT)');
});

function btnSignUp(){
    document.getElementById('btnSignUp').addEventListener("click", SaveUserInfo);
}

function btnLogin(){
    document.getElementById('btnLogin').addEventListener("click",comparUserInfo);
}

function SaveUserInfo(){
    var email = document.getElementById('email').value;
    var firstName = document.getElementById('firstname').value;
    var lastName = document.getElementById('lastname').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmedPassword = document.getElementById('confirmpassword').value;
    
    /*
     * validation for email, username and password
    db.transaction(function(tx){
             tx.executeSql('SELECT * FROM users WHERE (email='+email+', username='+username+',password='+password+')');
          });
    */
    if(email === "" || firstName === "" || lastName === "" || username === "" || password === "" || confirmedPassword === ""){
        window.alert("You must fill every field!");
    }else if(password !== confirmedPassword){
        window.alert("Your password is different! Try again");
    } else {
         db.transaction(function(tx){
             tx.executeSql('INSERT INTO users (email, firstName, lastName, username, password) VALUES(?,?,?,?,?)', [email, firstName, lastName, username, password]);
          });
    }
}

function comparUserInfo(){
    var usernameLog = document.getElementById('usernameLog').value;
    var passwordLog = document.getElementById('passwordLog').value;
    
    db.transaction(function(tx){
             tx.executeSql('SELECT * FROM users WHERE username=? AND password=?',[usernameLog, passwordLog], function(tx,results) {
                 if(results.rows.length > 0 ){
                     window.alert("Login Succesful");
                     window.location = "home.html";
                 } else {
                     window.alert("Invalid username or password");
                 }
             }, null);
         });
}
