<?php 
require_once("./helper/connexion.php");
require_once("./helper/functions.php");

session_start();


// 1 ) TEST DE RECUPERATION DU INPUT USERNAME (PARAMETRE REEL) AVANT DE REDIGER LA FONCTION A PARAMETRES FICTIFS:
// if(isset($_REQUEST["register"])) {
//     if(empty(trim($_REQUEST['username']))) {
//         // erreur si utilisateur na pas rempli les champs:
//         array_push($errors, "PLEASE FILL IN THE INFORMATIONS");
//         $_SESSION["errors"] = $errors;
//         print_r($_SESSION["errors"]);
//     }else{ 
//     // resultat si il a bien rempli tout:
//         echo htmlspecialchars($_REQUEST['username']);
//     }    
// }

// 2 ) GERER LA RECUPERATION DES INPUTS DE FORMULAIRES GRACE A UNE FONCTION AVEC PARAMETRE FICTIF $INPUTNAME: voir fichier functions.php


//3) CALL DE FONCTION GETINPUT SUR REGISTER :
if(isset($_REQUEST["register"])) {
    $username = getInput("username");
    $email = getInput("email");
    $password = getInput("password");
    
    // CRYPTING PASSWORD BY SECURITY:
    $cryptedPassword = password_hash($password, PASSWORD_BCRYPT);

    if($username == null or $email == null or $password== null ){
        header("location:./register.php");
    }

    // 4) INSERT REGISTER INFOS IN DATABASE SQL AFTER CONNECTING IT (LOOK AT FILE : connexion.php) :

        // SQL CODE LINE TO INSERT INTO TABLE USER:
        $sql = "INSERT INTO users (username,email,password) values (:username, :email, :password);";

        // ANNOUNCING AND BIDING THE PARAMETERS TO GIVE THEM THEIR VALUES FROM THE INPUTS:
        $params = [
            "username"=> $username,
            "email"=> $email,
            "password"=> $cryptedPassword
        ];
        $stmt = $conn->prepare($sql);
        
        if($stmt->execute($params)) {
            $_SESSION["success"] = "Your account has been successfully registered";
            header("location:./login.php");
        }else{
            $_SESSION["error"] = "Registration successfully failed";
            header("location:./register.php");
        }
    
}

//4) MANAGING THE LOGIN : 
    if (isset($_REQUEST["login"])){
        $email = getInput("email");
        $password = getInput("password");

        if($email == null or $password== null ){
            header("location:./login.php");
        }
        
        // GETTING LOGIN INFOS FROM DATABASE SQL (WITH FETCH) TO CONTROL IF THE LOGIN INFOS ARE CORRECT :
        $sql = "SELECT * FROM users WHERE email = :email";
        $params = [
            "email" => $email,
        ];
        $stmt = $conn->prepare($sql);
        $stmt -> execute($params);
        $fetchUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($fetchUser)) {
                if(password_verify($password,$fetchUser["password"])){
                    $_SESSION["success"]= "User logged in successfully"; // li ma fih nfa3 dfa3

                    // Store user informations in the session to control whether or not the user already logged or not:
                    $_SESSION["fetchUser"]=$fetchUser;
                    header("location:./index.php");
                }else{
                    $_SESSION["error"] = "wrong password";
                    header("location:./login.php");
                }     
        }else{
            $_SESSION["error"] = "User account does not exist";
            header("location:./register.php");
        }
    }
    


?>