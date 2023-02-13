<?php 

$errors = [];
function getInput($inputName) {
    global $errors;
    if(empty(trim($_REQUEST[$inputName]))) {
        // erreur si utilisateur na pas rempli les champs:
        array_push($errors, "Please fill in the information: $inputName");
        $_SESSION["errors"] = $errors;
        return null;
    }else{ 
    // resultat si il a bien rempli tout:
        return htmlspecialchars($_REQUEST[$inputName]);
    }    
}

?>