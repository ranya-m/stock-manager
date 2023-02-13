<?php require_once("./components/header.php"); 
require_once("./helper/connexion.php");

// if (!$logged) {
//     header("location:./login.php");
// }


// FETCHER LES DATA DES PRODUCTS A PARTIR DE LA BASE DE DONNEE POUR PERMETTRE D'AFFICHER SUR LA PAGE (LIST)
    $sql = "SELECT product.*, user.username  from products product, users user WHERE product.user_id = user.id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Select one product to fill the form : TO BE MODIFIED (after click on icon)
$updating = isset($_REQUEST["modifyProduct"]);


if ($updating) {
    $updateSql = "SELECT *  from products  WHERE product_id = :product_id;";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute(["product_id" => $_REQUEST["modifyProduct"]]);
    $product = $updateStmt->fetch(PDO::FETCH_ASSOC);
}


?>


<div class="container mt-4">
    <div class="row">

    
<main class="form-signin col-4">  
    <?php if (!$updating): ?>
        <!-- FORM TO ADD PRODUCT -->
    <form action="./traitementProducts.php" method="post">
        <h1 class="h3 mb-3 fw-normal">Add new product</h1>

        <div class="form-floating">
            <input type="text" name="label" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Product label</label>
        </div>
        <div class="form-floating">
            <textarea type="text" name="description" class="form-control" id="floatingPassword" placeholder="description"></textarea>
            <label for="floatingPassword">description</label>
        
        </div>
        <div class="form-floating">
            <input type="text" name="price" class="form-control" id="floatingPassword" placeholder="price">
            <label for="floatingPassword">price</label>
        </div>
        <div class="form-floating">
            <input type="text" name="quantity" class="form-control" id="floatingPassword" placeholder="quantity">
            <label for="floatingPassword">quantity</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="newProduct">Add</button>
    </form>
    <?php else: ?>

            <!-- FORM TO MODIFY PRODUCT -->

    <form method="post" action="./traitementProducts.php">

    <h1 class="h3 mb-3 fw-normal">Modify Product</h1>
    <input type="hidden" name="product_id" value="<?= $product["product_id"] ?>">
    <div class="form-floating mb-3">
        <input type="text" name="label" class="form-control" id="label"
            value="<?= $product["label"] ?>" placeholder="name@example.com">
        <label for="label">Label</label>
    </div>
    <div class="form-floating mb-3">
        <textarea name="description" class="form-control" id="description"
            placeholder="name@example.com"><?= $product["description"] ?></textarea>
        <label for="description">Description</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" name="price" class="form-control" id="floatingpu" placeholder="pu"
            value="<?= $product["price"] ?>">
        <label for="floatingpu">Price</label>
    </div>
    <div class="form-floating mb-3">
        <input type="number" name="quantity" class="form-control" id="floatingqte" placeholder="qte"
            value="<?= $product["quantity"] ?>">
        <label for="floatingqte">Quantity</label>
    </div>


    <button class="w-100 btn btn-lg btn-primary" type="submit" name="modifyProduct">Modify</button>

    </form>
    <?php endif; ?>
</main>


<!--  LIST OF THE NEW PRODUCT -->

    <div class="table-responsive col-8">
           <!-- INPUT TO SEARCH A PRODUCT -->
      <form action="" method="GET">
        <div class="input-group mb-4">
            <div class="form-outline w-50">
                <input type="search" name="search" placeholder="Search a product by its label or id"  class="form-control"
                value="<?php if(isset($_GET['search']))
                    echo $_GET['search'];
                  ?>"
                />
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </div>
      </form>
      
    <!-- FILTERED SEARCH TABLE -->
      <?php if(isset($_GET['search'])) :?>

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Label</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Created By</th>
                <!-- <th scope="col">Modified By</th> -->
                </tr>
            </thead>
            <tbody>
               <?php
                    $filterSearch = $_GET['search'];
                    $searchSql = "SELECT * FROM products WHERE CONCAT(product_id, label) LIKE '%$filterSearch%';";
                    $searchStmt = $conn->prepare($searchSql);
                    $searchStmt->execute();
                    $searchedProducts = $searchStmt->fetchAll(PDO::FETCH_ASSOC);  
                                 
                    if(!empty($searchedProducts)){
                        foreach($searchedProducts as $product) {
                            ?>
                            <tr>
                                <td><?= $product["product_id"] ?></td>
                                <td><?= $product["label"] ?></td>
                                <td><?= $product["description"] ?></td>
                                <td><?= $product["price"]?></td>
                                <td><?= $product["quantity"] ?></td>
                                <td><?= $product["username"]?></td>
                                <td>
                                    <a href="./products.php?modifyProduct=<?= $product["product_id"] ?>" class="btn btn-sm btn-info"
                                        title="Modify"> <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="./traitementProducts.php?deleteProduct=<?= $product["product_id"] ?>"
                                        class="btn btn-sm btn-danger" title="Delete"> <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                        <tr>
                        <td>No result found</td>
                        </tr> 
                        <?php
                    }
               ?> 

            </tbody>
            </table>

    <!-- NON FILTERED SEARCH TABLE -->
      <?php else :?> 
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Label</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Created By</th>
                <!-- <th scope="col">Modified By</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product) :?>   

                <tr>
                    <td><?= $product["product_id"] ?></td>
                    <td><?= $product["label"] ?></td>
                    <td><?= $product["description"] ?></td>
                    <td><?= $product["price"]?></td>
                    <td><?= $product["quantity"] ?></td>
                    <td><?= $product["username"]?></td>
                    <td>
                        <a href="./products.php?modifyProduct=<?= $product["product_id"] ?>" class="btn btn-sm btn-info"
                            title="Modify"> <i class="bi bi-pencil"></i>
                        </a>
                        <a href="./traitementProducts.php?deleteProduct=<?= $product["product_id"] ?>"
                            class="btn btn-sm btn-danger" title="Delete"> <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            </table>
      <?php endif ?>


    </div>

</div>
</div>
<?php require_once("./components/footer.php") ?>