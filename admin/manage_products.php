<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include '../includes/db.php';
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        td img {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        .actions a {
            width: 70px;
            text-align: center;
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .actions a:first-child {
            background-color: #007bff;
        }

        .actions a:last-child {
            background-color: #dc3545;
        }

        .actions a:hover {
            opacity: 0.9;
        }

        .btn-back {
            display: block;
            width: 180px;
            margin: 30px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        /* Fix widths */
        th:nth-child(5), td:nth-child(5) {
            width: 100px; /* Image */
        }

        th:nth-child(6), td:nth-child(6) {
            width: 120px; /* Actions */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Products</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= $product['id']; ?></td>
                <td><?= htmlspecialchars($product['name']); ?></td>
                <td>$<?= number_format($product['price'], 2); ?></td>
                <td><?= htmlspecialchars($product['description']); ?></td>
                <td>
                    <?php if (!empty($product['image']) && file_exists("../images/" . $product['image'])): ?>
                        <img src="../images/<?= htmlspecialchars($product['image']); ?>" alt="Product Image">
                    <?php else: ?>
                        <em style="color: grey;">No Image</em>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="edit_product.php?id=<?= $product['id']; ?>">Edit</a>
                    <a href="delete_product.php?id=<?= $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
</div>

</body>
</html>

