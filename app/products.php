<?php
    include_once '../db/Database.php';
    include_once '../db/Produs.php';
    include_once '../db/Img.php';
    include_once '../db/CategStil.php';
    session_start();

    function sortProducts(array $products, string $key, string $order = 'asc'): array {
        usort($products, function($a, $b) use ($key, $order) {
            if ($a[$key] == $b[$key]) return 0;

            if ($order === 'asc') {
                return ($a[$key] < $b[$key]) ? -1 : 1;
            } else {
                return ($a[$key] > $b[$key]) ? -1 : 1;
            }
        });

        return $products;
    }


    $database = new Database();
    $db = $database->getConnection();
    $prod = new ProdusDao($db);
    $img = new ImgDao($db);
    $categ_op = new CategSDao($db);

    $search = '';
    $results = [];

    //get all from db produse
    $stmt = $prod->getAll();
    $_SESSION['products'] = $stmt->fetchAll();

    // get all from db img produse
    $stmt = $img->getAll();
    $_SESSION['prod_img'] = $stmt;

    if (isset($_GET['q']) && !empty(trim($_GET['q']))) { // search
        $search = trim($_GET['q']);
        $stmt = $prod->getLike($search);
        $results = $stmt->fetchAll();
    } elseif (isset($_GET['category'])) { // category from index
        $categ = $categ_op->getById((int) $_GET['category']);
        $categ = $categ->fetchColumn();

        $stmt = $prod->getByCateg($categ);
        $results = $stmt->fetchAll();
    } else {
        $results = $_SESSION['products'];
    }

    // filter
    if (isset($_GET['order']) && !empty($_GET['order'])) { //  order
           $results = sortProducts($results, 'pret', $_GET['order']);
    }
    if (isset($_GET['min_price']) || isset($_GET['max_price'])) {
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : PHP_INT_MAX;

        $results = array_filter($results, function ($p) use ($minPrice, $maxPrice) {
            return $p['pret'] >= $minPrice && $p['pret'] <= $maxPrice;
        });
    }


//       echo '<pre>';
//       print_r($stmt);
//       echo '</pre>';



//     foreach ($stmt as $row) {
//         echo htmlspecialchars($row['path']);
//     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop - All Products</title>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 0;
          background: #f9f9f9;
        }

        header {
          background-color: #333;
          color: white;
          padding: 1rem;
          text-align: center;
        }

        .container {
          display: flex;
          margin: 20px;
        }

        .sidebar {
          width: 250px;
          padding: 20px;
          background: #fff;
          box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .sidebar h3 {
          margin-top: 0;
        }

        .sidebar label,
        .sidebar select {
          display: block;
          margin-bottom: 10px;
        }

        .main-content {
          flex: 1;
          margin-left: 20px;
        }

        .search-bar {
          display: flex;
          margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
          flex: 1;
          padding: 10px;
          border: 1px solid #ccc;
          border-right: none;
          border-radius: 4px 0 0 4px;
        }

        .search-bar button {
          padding: 10px 20px;
          border: 1px solid #ccc;
          background-color: #333;
          color: white;
          border-radius: 0 4px 4px 0;
          cursor: pointer;
        }

        .products {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
          gap: 20px;
        }

    .shoe-card {
              max-width: 266px;
              background: white;
              border-radius: 8px;
              box-shadow: 0 2px 8px rgba(0,0,0,0.1);
              overflow: hidden;
              display: flex;
              flex-direction: column;
              cursor: pointer;
              transition: transform 0.2s ease;
            }
            .shoe-card:hover {
              transform: translateY(-5px);
              box-shadow: 0 6px 15px rgba(0,0,0,0.15);
            }
            .shoe-card img {
              width: 100%;
              height: 160px;
              object-fit: cover;
            }
            .shoe-info {
              padding: 1rem;
              flex-grow: 1;
              display: flex;
              flex-direction: column;
              justify-content: space-between;
            }
            .shoe-name {
              font-weight: 700;
              margin-bottom: 0.5rem;
              color: #18204d;
            }
            .shoe-price {
              color: #6553af;
              font-weight: 600;
              font-size: 1.1rem;
            }
            .clear-btn {
                display: inline-block;
                padding: 1px 8px 2px 8px;
                background-color: #f0f0f0;
                border: 1px solid #777;
                color: black;
                text-decoration: none;
                font-size: 14px;
                border-radius: 2px;
                cursor: pointer;
            }

            .clear-btn:hover {
              background-color: #e0e0e0;
                border: 1px solid #555;
            }
    </style>
</head>
<body>

<header>
    <h1>My Online Shop</h1>
</header>

<div class="container">
    <aside class="sidebar">
        <form action="products.php" method="GET">
            <h3>Categories</h3>
            <label><input type="checkbox"> T-shirts</label>
            <label><input type="checkbox"> Jeans</label>
            <label><input type="checkbox"> Jackets</label>
            <label><input type="checkbox"> Accessories</label>

            <h3>Filter by Price</h3>
            <label>Min: <input name="min_price" type="number" placeholder="0"></label>
            <label>Max: <input name="max_price" type="number" placeholder="1000"></label>

            <h3>Order By</h3>
            <select name="order">
                <option value="">Select an option</option>
                <option value="asc">Price: Low to High</option>
                <option value="desc">Price: High to Low</option>
            </select>
            <button type="submit" >Apply</button>
            <a href="products.php" class="clear-btn">Clear</a>
        </form>
    </aside>

    <main class="main-content">
        <form action="products.php" method="GET">
            <div class="search-bar">
                <input type="text" name="q" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Search</button>
            </div>
        </form>

        <div class="products">
            <?php if (!empty($results)):
                foreach ($results as $product): ?>
                <a href="prod_desc.php?id_prod=<?= $product['id_p'] ?>" style="all: unset; cursor: pointer;">
                    <div class="shoe-card">
                        <img src="../<?= (string)$img->getByIdProdMain($product['id_p'])[1] ?>" alt="<?= htmlspecialchars($product['den']) ?>" />
                        <div class="shoe-info">
                            <div class="shoe-name"><?= htmlspecialchars($product['den']) ?></div>
                            <div class="shoe-price"><?= number_format($product['pret'], 2) ?> Lei</div>
                        </div>
                    </div>
                </a>
            <?php endforeach;
            elseif ($search !== ''): ?>
                <p>No results found for <strong><?= htmlspecialchars($search) ?></strong></p>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- FOOTER SECTION -->
  <footer style="background-color: #f8f9fa; padding: 2rem 1rem; margin-top: 3rem;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 2rem;">

      <div style="flex: 1; min-width: 200px;">
        <h4 style="margin-bottom: 1rem;">ShoeShop</h4>
        <p>Shop the latest fashion trends with ease. Fast delivery and secure payments.</p>
      </div>

      <div style="flex: 1; min-width: 150px;">
        <h4 style="margin-bottom: 1rem;">Customer Service</h4>
        <ul style="list-style: none; padding: 0; line-height: 1.8;">
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Return Policy</a></li>
          <li><a href="#">Track Order</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>

      <div style="flex: 1; min-width: 150px;">
        <h4 style="margin-bottom: 1rem;">About</h4>
        <ul style="list-style: none; padding: 0; line-height: 1.8;">
          <li><a href="#">About Us</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <div style="flex: 1; min-width: 200px;">
        <h4 style="margin-bottom: 1rem;">Stay Connected</h4>
        <form>
          <input type="email" placeholder="Your email" style="padding: 0.5rem; width: 100%; max-width: 250px; margin-bottom: 0.5rem; border: 1px solid #ccc; border-radius: 6px;">
          <br />
          <button style="padding: 0.5rem 1rem; background-color: #000; color: #fff; border: none; border-radius: 6px;">Subscribe</button>
        </form>
      </div>

    </div>

    <div style="text-align: center; padding-top: 2rem; border-top: 1px solid #ddd; margin-top: 2rem;">
      <p style="margin: 0;">&copy; 2025 ShoeShop. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
