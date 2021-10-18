<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$errors = [];
$title = '';
$description = '';
$price = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
    $price = $_REQUEST['price'];

    if (!$title) {
        $errors[] = "Product title is required";
    }
    if (!$price) {
        $errors[] = "Product price is required";
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        if ($image) {
            $imagePath = '';
            $imagePath = 'img/' . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        // :title Named Parameter
        $statement = $pdo->prepare("INSERT INTO products (title,description,image,price,created_date)
              VALUES (:title,:description,:image,:price,:date)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
        $statement->execute();
    }
    $title = '';
    $description = '';
    $price = '';
    $imagePath = '';
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="app.css" rel="stylesheet" />
    <title>Products CRUD</title>
</head>

<body>
    <h1>Create A new Product</h1>
    <p>
        <a href="index.php" class="btn btn-success">Back to products</a>
    </p>
    <?php if (!empty($errors)) {  ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) { ?>
                <div>
                    <?php echo $error ?>
                </div>

            <?php }  ?>
        <?php } ?>
        </div>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Image</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="form-group">
                <label>Product Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
            </div>
            <div class="form-group">
                <label>Product Description</label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control">
                    <?php echo $description ?>
                </textarea>
            </div>
            <div class="form-group">
                <label>Product Price</label>
                <input type="number" class="form-control" step=".01" name="price" value="<?php echo $price ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

</body>

</html>