<?php
    include_once '../db/Database.php';
    include_once '../db/Cos.php';
    session_start();

    $database = new Database();
    $db = $database->getConnection();
    $cart_op = new CosDao($db);

    // get data from form
    $prod_id = $_POST['product_id'] ?? null;
    $size = $_POST['size'] ?? 00;
    $color = $_POST['color'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;
    $id_col = $_POST['id_col'] ?? 1;

    $today = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];

    // get new id_cos

    //echo "ID: $prod_id\n Size: $size\n Color: $color\n Cant: $quantity IdCOl: $id_col\n Date: $today\n User: $user_id";

    // insert into db
    if($cart_op->insert( $quantity, $today, $user_id, $prod_id, $size, $color, $id_col))
        header("Location: prod_desc.php?id_prod=$prod_id?succes=1");
    else
        header("Location: prod_desc.php?id_prod=$prod_id?succes=0");

    // display on cart page



    //Good example ---------------------------
    // Initialize cart if not exists
//     if (!isset($_SESSION['cart'])) {
//         $_SESSION['cart'] = [];
//     }
//
//     // Get POST data and validate
//     $product_id = $_POST['product_id'] ?? null;
//     $product_name = $_POST['product_name'] ?? '';
//     $price = $_POST['price'] ?? 0;
//     $size = $_POST['size'] ?? '';
//     $color = $_POST['color'] ?? '';
//     $quantity = $_POST['quantity'] ?? 1;
//
//     // Validate required fields
//     if ($product_id && $product_name && $size && $color && $quantity > 0) {
//
//         // Create a unique key per product+size+color
//         $key = $product_id . '_' . $size . '_' . $color;
//
//         if (!isset($_SESSION['cart'][$key])) {
//             $_SESSION['cart'][$key] = [
//                 'product_id' => $product_id,
//                 'name' => $product_name,
//                 'price' => $price,
//                 'size' => $size,
//                 'color' => $color,
//                 'quantity' => $quantity,
//             ];
//         } else {
//             // If already in cart, increase quantity
//             $_SESSION['cart'][$key]['quantity'] += $quantity;
//         }
//
//         // Redirect to cart or back to product
//         header('Location: cart.php');
//         exit;
//     } else {
//         // Missing data
//         echo "Missing data. Please go back and fill out the form.";
//     }

?>