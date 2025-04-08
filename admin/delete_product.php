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

// Fetch product to get image name
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit();
}

// Delete image file if it exists
if (!empty($product['image'])) {
    $imagePath = "../images/" . $product['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// Delete product from database
$deleteStmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$deleteStmt->execute([$id]);

header("Location: manage_products.php");
exit();
?>
