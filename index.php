<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? '';

if ($search) {
    $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title');
    $statement->bindValue(':title', "%$search%");
} else{
   $statement = $pdo->prepare('SELECT * FROM products');
}
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Header.php -->
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <link href="app.css" rel="stylesheet" />
    <title>Products CRUD</title>
</head>

<body>
    <h1>Products CRUD</h1>

    <p>
        <a href="create.php" type="button" class="btn btn-success btn-sm">
            Add Products
        </a>
    </p>
    <form action="index.php" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search For Products" name="search">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Serial No</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Created At</th>
                <th scope="col">Actions</th>
                <th scope="col">ID</th>
            </tr>
        </thead>
        <tbody>
            <!-- $products is a associative array  -->
            <?php foreach ($products as $i => $product) { ?>

                <tr>
                    <th scope="row">
                        <?php echo $i + 1 ?>
                    </th>
                    <td>
                        <!-- Image -->
                        <img src="<?php echo $product['image'] ?>" class="product-img">

                    </td>
                    <td>
                        <!-- Title -->
                        <?php echo $product['title'] ?>
                    </td>
                    <td>
                        <!-- Price -->
                        <?php echo $product['price'] ?>
                    </td>
                    <td>
                        <!-- Creaated At -->
                        <?php echo $product['created_date'] ?>
                    </td>
                    <td>
                        <a href="Update1.php?id=<?php echo $product['id'] ?>" type="submit" class="btn btn-primary">Edit</a>
                        <form action="delete.php" method="POST" style="display: inline-block">
                            <input type="hidden" name="id" value="<?php echo $product['id'] ?>" />
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <!-- <form method="post" action="delete.php" style="display: inline-block">
                            <input type="hidden" name="id" value="<?php echo $product['id'] ?>" />
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form> -->
                    </td>
                    <td>
                        <?php echo $product['id'] ?>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</body>

</html>