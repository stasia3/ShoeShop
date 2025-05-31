<?php
    include_once '../db/Database.php';
    include_once '../db/Cos.php';
    session_start();

    $database = new Database();
    $db = $database->getConnection();
    $cart_op = new CosDao($db);

    // Initialize cart if not exists
//     if (!isset($_SESSION['cart'])) {
//         $_SESSION['cart'] = [];
//     }
    $stmt = $cart_op->getByIdUser($_SESSION['user_id']);
    $_SESSION['cart'] = $stmt->fetchAll();

//     echo "<pre>";
//         print_r($stmt);
//         echo "</pre>";

    // read from bd

//     // Remove from cart
//     if (isset($_GET['remove'])) {
//         $id = (int)$_GET['remove'];
//         unset($_SESSION['cart'][$id]);
//         header("Location: cart.php");
//         exit;
//     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: left; }
    .btn { padding: 6px 12px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; }
    .btn:hover { background: #c82333; }
    .back-link { margin-top: 20px; display: inline-block; background: #007bff; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
    .back-link:hover { background: #0056b3; }
  </style>
</head>
<body>

<h2>Your Cart</h2>

<?php if (!empty($_SESSION['cart'])): ?>
  <table>
    <thead>
      <tr>
        <th>Product</th><th>Culoare</th><th>Marime</th><th>Quantity</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; ?>
      <?php foreach ($_SESSION['cart'] as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['id_p']) ?></td>
          <td><?= htmlspecialchars($item['culoare']) ?></td>
          <td><?= htmlspecialchars($item['marime']) ?></td>
          <td><?= htmlspecialchars($item['cantitate']) ?></td>
          <td><a class="btn" href="?remove=<?= $id ?>">Remove</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<!--  <h3>Total: $<?= number_format($total, 2) ?></h3>
 <?php else: ?>
   <p>Your cart is empty.</p>
 <?php endif; ?>-->

<a href="../index.php" class="back-link">Back to Products</a>

</body>
</html>
