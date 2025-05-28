<?php
    include_once '../db/Database.php';
    include_once '../db/Produs.php';
    session_start();

    $database = new Database();
    $db = $database->getConnection();
    $prod_op = new ProdusDao($db);


    if (isset($_GET['id_prod'])) {
        $prod = $prod_op->getById($_GET['id_prod']);
    } else
        $prod = $prod_op->getById(1);
    $prod = $prod->fetch(PDO::FETCH_ASSOC);

//     if ($prod) {
//         echo "Name: " . htmlspecialchars($prod['den']) . "<br>";
//         echo "Price: $" . htmlspecialchars($prod['pret']) . "<br>";
//         echo "Category: " . htmlspecialchars($prod['categ']) . "<br>";
//         echo "Style: " . htmlspecialchars($prod['stil']) . "<br>";
//         echo "Producer: " . htmlspecialchars($prod['producator']) . "<br>";
//     } else {
//         echo "Product not found.";
//     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo htmlspecialchars($prod['den']) ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  body {
    font-family: Arial, sans-serif;
    padding: 0 20px;
    background: #fff;
    color: #222;
  }
  .product-wrapper {
    padding:  10px 80px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
  }
  .product-image {
    flex: 1 1 170px;
  }
  .main-image {
    max-width: 500px;
    max-height: 600px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 8px;
  }
  .thumbnail-images {
    margin-top: 15px;
    display: flex;
    gap: 10px;
  }
  .thumbnail-images img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border: 2px solid transparent;
    border-radius: 6px;
    cursor: pointer;
    transition: border-color 0.2s ease;
  }
  .thumbnail-images img.selected {
    border-color: #6553AF;
  }
  .product-info {
    flex: 1 1 400px;
  }
  .product-title {
    font-size: 2rem;
    margin-bottom: 10px;
  }
  .product-price {
    color: #6553AF;
    font-size: 1.6rem;
    margin-bottom: 20px;
  }
  .product-description {
    font-size: 1rem;
    margin-bottom: 25px;
    line-height: 1.5;
  }
  label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
  }
  /* Size selector as buttons */
  .size-options {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
  }
  .size-options button {
    padding: 10px 18px;
    font-size: 1rem;
    border: 1px solid #ccc;
    background: white;
    cursor: pointer;
    border-radius: 5px;
    transition: all 0.2s ease;
  }
  .size-options button.selected {
    background: #6553AF;
    color: white;
    border-color: #18204D;
  }
  .size-options button:hover {
    border-color: #18204D;
  }
  /* Color circles */
  .color-options {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
  }
  .color-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid transparent;
    cursor: pointer;
    transition: border-color 0.2s ease;
  }
  .color-circle.selected {
    border-color: #18204D;
  }
  .color-circle.red { background: #d32f2f; }
  .color-circle.blue { background: #2a6bd6; }
  .color-circle.green { background: #3ca34d; }
  .color-circle.black { background: #222; }
  /* Quantity */
  input[type="number"] {
    padding: 8px;
    font-size: 1rem;
    width: 80px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  button.add-to-cart {
    margin-top: 12px;
    margin-left: 6px;
    background-color: #6553AF;
    border: none;
    color: white;
    padding: 9px 25px;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  button.add-to-cart:hover {
    background-color: #18204D;
  }
  .reviews {
    margin-top: 40px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    font-family: sans-serif;
  }

  .reviews h2, .reviews button {
    display: inline;
  }

  .review-list {
    margin-top: 10px;
  }

  .review {
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
  }

  .review:last-child {
    border-bottom: none;
  }

  .review-header {
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #333;
  }

  .stars {
    color: #f5c518; /* gold stars */
  }

  .comment {
    margin-top: 5px;
    font-size: 15px;
    color: #444;
  }

  .hidden {
    display: none;
  }

  .toggle-btn {
    margin-left: 12px;
    padding: 8px 16px;
    background-color: #222;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .toggle-btn:hover {
    background-color: #444;
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

      .auth-links a {
        margin-left: 1rem;
        text-decoration: none;
        color: #18204d;
        font-weight: 600;
      }

      .featured {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
            gap: 1.5rem;
          }
          .shoe-card {
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
            <img src="../img/logo/logo-b.png" alt="ShoeShop Logo" style="width: 72px;">
        </div>

        <div class="auth-links">
          <a href="#">
            <i class="fas fa-shopping-cart"></i>
          </a>
          <?php if (isset($_SESSION['is_loged']) && ($_SESSION['is_loged'] === true)): ?>
            <a href="../login/logout.php">Log out</a>
          <?php else: ?>
            <a href="../login/login.php">Log in</a>
          <?php endif; ?>
        </div>
      </header>

<div class="product-wrapper">
  <div class="product-image">
    <img id="mainImage" class="main-image" src="../img/img4.jpg" alt="Running Shoe" />
    <div class="thumbnail-images">
      <img src="../img/img4.jpg" alt="Red Shoe" class="selected" onclick="changeImage(this)" />
      <img src="../img/img5.jpg" alt="Blue Shoe" onclick="changeImage(this)" />
      <img src="../img/img3.jpg" alt="Green Shoe" onclick="changeImage(this)" />
      <img src="../img/img1.jpg" alt="Black Shoe" onclick="changeImage(this)" />
    </div>
  </div>
  <div class="product-info">
    <h1 class="product-title"><?php echo htmlspecialchars($prod['den']) ?></h1>
    <p class="product-description">
      Lightweight and breathable running shoe designed for maximum comfort and support. Ideal for daily runs and casual wear.
    </p>
    <p class="product-price">$99.99</p>

    <form action="add_to_cart.php" method="POST" onsubmit="return validateSelection()">
      <label>Select Size</label>
      <div class="size-options" id="sizeOptions">
        <button type="button" data-value="6" onclick="selectSize(this)">6</button>
        <button type="button" data-value="7" onclick="selectSize(this)">7</button>
        <button type="button" data-value="8" onclick="selectSize(this)">8</button>
        <button type="button" data-value="9" onclick="selectSize(this)">9</button>
        <button type="button" data-value="10" onclick="selectSize(this)">10</button>
      </div>
      <input type="hidden" name="size" id="selectedSize" required />

      <label>Select Color</label>
      <div class="color-options" id="colorOptions">
        <div class="color-circle red selected" data-value="Red" onclick="selectColor(this)" title="Red"></div>
        <div class="color-circle blue" data-value="Blue" onclick="selectColor(this)" title="Blue"></div>
        <div class="color-circle green" data-value="Green" onclick="selectColor(this)" title="Green"></div>
        <div class="color-circle black" data-value="Black" onclick="selectColor(this)" title="Black"></div>
      </div>
      <input type="hidden" name="color" id="selectedColor" value="Red" />

      <label for="quantity">Quantity</label>
      <input type="number" id="quantity" name="quantity" min="1" value="1" required />

      <input type="hidden" name="product_id" value="123" />
      <input type="hidden" name="product_name" value="Running Shoe Model X" />
      <input type="hidden" name="price" value="99.99" />

      <button type="submit" class="add-to-cart">Add to Cart</button>
    </form>
  </div>
</div>
<section class="reviews">
          <h2>Customer Reviews</h2>
          <button id="toggle-reviews" class="toggle-btn">Show More Reviews</button>

          <div id="review-list" class="review-list">
            <div class="review">
              <div class="review-header">
                <span class="username">Aliceeee</span>
                <span class="stars">★★★★★</span>
                <span class="date">2025-05-17</span>
              </div>
              <p class="comment">Incredible product! Very satisfied with the quality.</p>
            </div>
            <div class="review">
              <div class="review-header">
                <span class="username">Bob</span>
                <span class="stars">★★★★☆</span>
                <span class="date">2025-05-12</span>
              </div>
              <p class="comment">Good value for money. Would recommend.</p>
            </div>
            <div class="review hidden">
              <div class="review-header">
                <span class="username">Chloe</span>
                <span class="stars">★★★☆☆</span>
                <span class="date">2025-04-28</span>
              </div>
              <p class="comment">Decent, but I expected better packaging.</p>
            </div>
            <div class="review hidden">
              <div class="review-header">
                <span class="username">Daniel</span>
                <span class="stars">★★★★★</span>
                <span class="date">2025-04-22</span>
              </div>
              <p class="comment">Perfect fit and very comfortable shoes!</p>
            </div>
          </div>
      </section>

  <section>
          <h2>Featured Shoes</h2>

          <div class="featured">
              <a href="prod_desc.php">
            <div class="shoe-card">
              <img src="img/img3.jpg" alt="Classic Sneakers" />
              <div class="shoe-info">
                <div class="shoe-name">Classic Sneakers</div>
                <div class="shoe-price">$79.99</div>
              </div>
            </div>
            </a>

            <div class="shoe-card">
              <img src="https://images.unsplash.com/photo-1528701800489-20b6a5f8c2b6?auto=format&fit=crop&w=600&q=80" alt="Running Shoes" />
              <div class="shoe-info">
                <div class="shoe-name">Running Shoes</div>
                <div class="shoe-price">$89.99</div>
              </div>
            </div>

            <div class="shoe-card">
              <img src="https://images.unsplash.com/photo-1528701800483-8a3a1d7ecbc1?auto=format&fit=crop&w=600&q=80" alt="Leather Boots" />
              <div class="shoe-info">
                <div class="shoe-name">Leather Boots</div>
                <div class="shoe-price">$129.99</div>
              </div>
            </div>

            <div class="shoe-card">
              <img src="https://images.unsplash.com/photo-1519741464199-fab7b9b7f9c4?auto=format&fit=crop&w=600&q=80" alt="Casual Slip-ons" />
              <div class="shoe-info">
                <div class="shoe-name">Casual Slip-ons</div>
                <div class="shoe-price">$69.99</div>
              </div>
            </div>
          </div>
        </section>
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


<script>
    const btn = document.getElementById('toggle-reviews');
                  const hiddenReviews = document.querySelectorAll('.review.hidden');
                  let expanded = false;

                  btn.addEventListener('click', () => {
                    expanded = !expanded;
                    hiddenReviews.forEach(review => {
                      review.style.display = expanded ? 'block' : 'none';
                    });
                    btn.textContent = expanded ? 'Show Less Reviews' : 'Show More Reviews';
                  });

  function changeImage(img) {
    document.getElementById('mainImage').src = img.src;
    // Update selected thumbnail border
    const thumbnails = document.querySelectorAll('.thumbnail-images img');
    thumbnails.forEach(t => t.classList.remove('selected'));
    img.classList.add('selected');

    // Also update color selector to match clicked image color
    const colorValue = img.alt.split(' ')[0]; // assumes alt like "Red Shoe"
    const colors = document.querySelectorAll('.color-circle');
    colors.forEach(c => c.classList.remove('selected'));
    colors.forEach(c => {
      if (c.getAttribute('data-value').toLowerCase() === colorValue.toLowerCase()) {
        c.classList.add('selected');
        document.getElementById('selectedColor').value = c.getAttribute('data-value');
      }
    });
  }

  function selectSize(button) {
    const sizeButtons = document.querySelectorAll('.size-options button');
    sizeButtons.forEach(b => b.classList.remove('selected'));
    button.classList.add('selected');
    document.getElementById('selectedSize').value = button.getAttribute('data-value');
  }

  function selectColor(circle) {
    const colorCircles = document.querySelectorAll('.color-circle');
    colorCircles.forEach(c => c.classList.remove('selected'));
    circle.classList.add('selected');
    document.getElementById('selectedColor').value = circle.getAttribute('data-value');

    // Also update main image to match color
    const color = circle.getAttribute('data-value').toLowerCase();
    const mainImage = document.getElementById('mainImage');
    mainImage.src = `https://via.placeholder.com/400x400/${getColorHex(color)}/fff?text=${circle.getAttribute('data-value')}`;

    // Update thumbnail selection as well
    const thumbnails = document.querySelectorAll('.thumbnail-images img');
    thumbnails.forEach(t => {
      if (t.alt.toLowerCase().includes(color)) {
        thumbnails.forEach(t2 => t2.classList.remove('selected'));
        t.classList.add('selected');
      }
    });
  }

  function getColorHex(color) {
    switch(color) {
      case 'red': return 'ff4c4c';
      case 'blue': return '2a6bd6';
      case 'green': return '3ca34d';
      case 'black': return '222222';
      default: return 'cccccc';
    }
  }

  function validateSelection() {
    const size = document.getElementById('selectedSize').value;
    if (!size) {
      alert('Please select a size.');
      return false;
    }
    return true;
  }

  // Preselect first size button disabled so user selects
  // You can also force selection on page load if you want by uncommenting:
  // document.querySelector('.size-options button').click();
</script>

</body>
</html>
