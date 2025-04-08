<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: manage_products.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $product['image']; // Keep old image unless a new one is uploaded

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/";
        $new_image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $new_image_name;
        }
    }

    $updateStmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
    $updateStmt->execute([$name, $price, $description, $image, $id]);

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 40px;
        }
        .container {
            width: 400px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        img {
            max-width: 100px;
            margin-top: 10px;
        }
        .btn {
            margin-top: 20px;
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" required>

        <label>Description:</label>
        <textarea name="description" rows="4"><?= htmlspecialchars($product['description']); ?></textarea>

        <label>Current Image:</label>
        <?php if ($product['image']) : ?>
            <img src="../images/<?= $product['image']; ?>" alt="Current Image">
        <?php else: ?>
            <p><i>No image</i></p>
        <?php endif; ?>

        <label>Replace Image:</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit" class="btn">Update Product</button>
    </form>

    <a href="manage_products.php" class="back">Back</a>
</div>

</body>
</html>

