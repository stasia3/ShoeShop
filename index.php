<?php
    include_once 'db/Database.php';
    include_once 'db/Produs.php';
    include_once 'db/Img.php';
    include_once 'db/CategStil.php';
    session_start();

    $search = '';

    $database = new Database();
    $db = $database->getConnection();
    $prod = new ProdusDao($db);
    $img = new ImgDao($db);
    $categ = new CategSDao($db);

    // get from db produse
    $stmt = $prod->getAll();
    $_SESSION['products'] = $stmt;

    // get from db img produse
    $stmt = $img->getAll();
    $_SESSION['prod_img'] = $stmt;

    $stmt = $categ->getAll();
    $_SESSION['categ'] = $stmt->fetchAll();

//     echo '<pre>';
//         echo print_r($_SESSION['categ']);
//         echo '</pre>';

//     foreach ($stmt as $row) {
//         echo htmlspecialchars($row['path']);
//     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ShoeShop - Home</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f2f2f2;
      color: #333;
    }

    header {
      background-color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
    }

    .logo {
      font-weight: bold;
      font-size: 1.5rem;
      color: #18204d;
    }

    .search-bar {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.5rem 1rem;
      margin: 0 2rem;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%;
      max-width: 500px;
      color: #888;
    }

    .search-bar i {
      font-size: 1rem;
    }

    .search-bar input {
      border: none;
      background: transparent;
      flex-grow: 1;
    }


    .auth-links a {
      margin-left: 1rem;
      text-decoration: none;
      color: #18204d;
      font-weight: 600;
    }

    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: white;
      padding: 3rem 2rem;
      flex-wrap: wrap;
      background-image: url("img/img1.jpg");
    }

    .hero-text {
      max-width: 500px;
    }

    .hero-text h1 {
      font-size: 2.5rem;
      color: #18204d;
      margin-bottom: 1rem;
    }

    .hero-text p {
      font-size: 1.1rem;
      color: #555;
    }

    .hero-image img {
      max-width: 400px;
      width: 100%;
      border-radius: 40px;
    }

    .categories {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      background-color: #fff;
      padding: 2rem 1rem;
      gap: 1.5rem;
      border-top: 1px solid #ddd;
    }

    .category {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      font-weight: 600;
      color: #18204d;
    }

    .category-icon {
      width: 72px;
      height: 72px;
      background-color: #eee;
      border-radius: 50%;
      margin-bottom: 0.5rem;
      overflow: hidden; /* ensures the image stays within the circle */
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .category-icon img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }


    @media (max-width: 768px) {
      .hero {
        flex-direction: column;
        text-align: center;
      }

      .hero-image img {
        margin-top: 2rem;
      }
    }
        main {
          padding: 2rem;
          max-width: 1200px;
          margin: 0 auto;
        }
    .featured {
          display: grid;
          grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
          gap: 1.5rem;
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
  </style>
</head>
<body>

  <header>
    <div class="logo">
        <img src="img/logo/logo-b.png" alt="ShoeShop Logo" style="width: 72px;">
    </div>
    <form action="app/products.php" method="GET">
        <div class="search-bar">
            <button type="submit" style="all: unset; cursor:pointer;"><i class="fas fa-search"></i></button>
          <input type="text" name="q" placeholder="Search product or brand here..." value="<?= htmlspecialchars($search) ?>" />
        </div>
    </form>
    <div class="auth-links">
      <a href="#">
        <i class="fas fa-shopping-cart"></i>
      </a>
      <?php if (isset($_SESSION['is_loged']) && ($_SESSION['is_loged'] === true)): ?>
        <a href="login/logout.php">Log out</a>
      <?php else: ?>
        <a href="login/login.php">Log in</a>
      <?php endif; ?>
    </div>
  </header>

  <section class="hero">
    <div class="hero-text">
      <h1>Limited Time Offer!<br/>Up to 50% OFF!</h1>
      <p>Redefine Your Everyday Style</p>
    </div>
    <div class="hero-image">
      <img src="img/img1.jpg" alt="Shoes" />
    </div>
  </section>

  <section class="categories">
      <?php foreach ($_SESSION['categ'] as $cat): ?>
        <a href="app/products.php?category=<?= $cat['id_cs']?>" style="all: unset; cursor: pointer;">
            <div class="category">
              <div class="category-icon">
                <img src="<?=$cat['path'] ?>" >
              </div>
              <span><?= htmlspecialchars($cat['den']) ?></span>
            </div>
        </a>
      <?php endforeach; ?>
  </section>

  <main>
    <section>
        <h2>Featured Shoes</h2>
        <div class="featured">
            <?php foreach ($_SESSION['products'] as $product): ?>
                <a href="app/prod_desc.php?id_prod=<?= $product['id_p'] ?>" style="all: unset; cursor: pointer;">
                    <div class="shoe-card">
                        <img src="<?= (string)$img->getByIdProdMain($product['id_p'])[1] ?>" alt="<?= htmlspecialchars($product['den']) ?>" />
                        <div class="shoe-info">
                            <div class="shoe-name"><?= htmlspecialchars($product['den']) ?></div>
                            <div class="shoe-price"><?= number_format($product['pret'], 2) ?> Lei</div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
  </main>
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
