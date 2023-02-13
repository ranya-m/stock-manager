<?php
session_start();
require_once("./helper/connexion.php");
require_once("./helper/functions.php");

// RECUPERER INPUTS DU FORM PRODUCTS
if(isset($_REQUEST["newProduct"])) {
    $label = getInput("label");
    $description = getInput("description");
    $price = getInput("price");
    $quantity = getInput("quantity");

    // INSERER DATA DU FORMULAIRE PRODUCTS DANS LE DATABASE
    if($label == null || $price == null || $quantity == null){
        header("location:./products.php");
    }
    
    $sql = "INSERT INTO products(label, description, price, quantity, user_id) values(:label, :description, :price, :quantity, :user_id)";

    $params = [
        "label"=> $label,
        "description"=> $description,
        "price"=> $price,
        "quantity"=> $quantity,
        "user_id"=> $_SESSION["fetchUser"]["id"] 
    ];

    $stmt = $conn->prepare($sql);
    if($stmt->execute($params)){
        $_SESSION["success"]="Product added successfully";
        header("location:./products.php");
    } else{
        $_SESSION["error"]="Product add successfully failed ";
        header("location:./products.php");
    }
}


// DELETING A PRODUCT FROM THE LIST
if (isset($_REQUEST["deleteProduct"])) {
    $sql = "Delete from products where product_id = :product_id;";

    $params = [
        "product_id" => $_REQUEST["deleteProduct"]
    ];
    $stmt = $conn->prepare($sql);
    if ($stmt->execute($params)) {
        $_SESSION["success"] = "Product deleted successfully";
        header("location:./products.php");
    } else {
        $_SESSION["error"] = "Product deletion successfully failed";
        header("location:./products.php");
    }
}



// MODIFYING A PRODUCT
if(isset($_REQUEST["modifyProduct"])){
    $label = getInput("label");
    $description = getInput("description");
    $price = getInput("price");
    $quantity = getInput("quantity");
    $product_id = getInput("product_id");


    if($label == null || $price == null || $quantity == null){
        header("location:./products.php");
    }

    $sql = "UPDATE products  SET label = :label, description = :description, price =:price, quantity= :quantity ,user_id = :user:id WHERE product_id = :product_id";
    $params = [
        "label" => $label,
        "description" => $description,
        "quantity" => $quantity,
        "price" => $price,
        "user_id" => $_SESSION["fetchUser"]["id"],
        "product_id" => $product_id
    ];

    $stmt = $conn->prepare($sql);
    if($stmt->execute($params)){
        $_SESSION["success"]= "Your product has been modified successfully";
        header("location:./products.php");
    }else{
        $_SESSION["error"]= "Product modification successfully failed";
        header("location:./products.php ");
    }
}
?>