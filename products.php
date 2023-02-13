<?php require_once("./components/header.php"); 
    
// if (!$logged) {
//     header("location:./login.php");
// }

$updating = isset($_REQUEST["modifyProduct"]);


require_once("./helper/connexion.php");


// FETCHER LES DATA DES PRODUCTS A PARTIR DE LA BASE DE DONNEE POUR PERMETTRE D'AFFICHER SUR LA PAGE (LIST)
    $sql = "SELECT product.*, user.username  from products product, users user WHERE product.user_id = user.id;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Select one product to fill the form : TO BE MODIFIED (after click on icon)
if ($updating) {
    $updateSql = "SELECT *  from products  WHERE product_id = :product_id;";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute(["product_id" => $_REQUEST["modifyProduct"]]);
    $product = $updateStmt->fetch(PDO::FETCH_ASSOC);
}


?>


<div class="container mt-4">
    <div class="row">
<!-- FORM TO ADD A NEW PRODUCT -->
    <?php if (!$updating): ?>
    <main class="form-signin col-4">
    <form action="./traitementProducts.php" method="post" class="">
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
        <form method="post" action="./traitementProducts.php">

    <h1 class="h3 mb-3 fw-normal">Update Product</h1>
    <input type="hidden" name="id" value="<?= $product["product_id"] ?>">
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


    <button class="w-100 btn btn-lg btn-primary" type="submit" name="updateProduct">Update</button>

    </form>
    <?php endif; ?>
</main>


<!--  LIST OF THE NEW PRODUCT -->
    <div class="table-responsive col-8">
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
        </div>

</div>
</div>
<?php require_once("./components/footer.php") ?>