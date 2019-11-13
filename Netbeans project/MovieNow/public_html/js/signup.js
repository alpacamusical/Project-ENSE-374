/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener('load', cargar);
var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024);
var msg;

db.transaction(function (tx){
    tx.executeSql('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, email TEXT, firstName TEXT, lastName TEXT, username TEXT, password TEXT)');
});

function cargar(){
    document.getElementById('btnSave').addEventListener("click", saveUserInfo);
}

function saveUserInfo(){
    var email = document.getElementById('email').value;
    var firstName = document.getElementById('firstname').value;
    var lastName = document.getElementById('lastname').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var confirmedPassword = document.getElementById('confirmpassword').value;
    
    if(password !== confirmedPassword){
        window.alert("Your password is different! Try again");
    } else {
         db.transaction(function(tx){
             tx.executeSql('INSERT INTO users (email, firstName, lastName, username, password) VALUES(?,?,?,?,?)', [email, firstName, lastName, username, password]);
          });
    }
}
