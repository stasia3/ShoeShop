<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - ShoeStore</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    * {
      box-sizing: border-box;
    }
    body, html {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f2f2f2;
    }
    .container {
      display: flex;
      height: 100vh;
      width: 100vw;
    }
    .left {
      flex: 0 0 40%;
      background: white;
      padding: 3rem 2rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-shadow: 4px 0 15px rgba(0,0,0,0.1);
    }
    .login-container {
      max-width: 350px;
      width: 100%;
      margin: 0 auto;
      text-align: center;
    }
    .login-container h2 {
      margin-bottom: 1.5rem;
      font-weight: 700;
      color: #333;
    }
    .login-container label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      text-align: left;
      color: #555;
    }
    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
      transition: border-color 0.2s ease;
    }
    .login-container input[type="email"]:focus,
    .login-container input[type="password"]:focus {
      border-color: #007bff;
      outline: none;
    }
    .login-container button {
      width: 100%;
      margin-top: 8px;
      padding: 0.6rem;
      background-color: #18204d; //#007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 700;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .login-container button:hover {
      background-color: #6553af;
    }
    .register-link {
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #555;
    }
    .register-link a {
      color: #18204d;
      text-decoration: none;
      font-weight: 600;
    }
    .register-link a:hover {
      text-decoration: underline;
    }

    .right {
      flex: 0 0 60%;
      position: relative;
      background: url('../img/app/img_log.jpg') center center/cover no-repeat;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 3rem 4rem;
      color: white;
      text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
    }
    .right h1 {
      font-size: 3rem;
      margin-bottom: 1rem;
      line-height: 1.1;
    }
    .right p {
      font-size: 1.25rem;
      max-width: 500px;
      line-height: 1.5;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
      .left, .right {
        flex: 1 1 100%;
        height: 50vh;
      }
      .right {
        padding: 2rem;
        font-size: 0.9rem;
      }
      .right h1 {
        font-size: 2rem;
      }
    }


  </style>
</head>
<body>

  <div class="container">

    <div class="left">
      <div class="login-container">
        <h2>Login</h2>
        <form action="login_handle.php" method="POST">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
          <?php if (isset($_GET['error_email'])): ?>
            <div class="err-input">Nu exista utilizatori inregistrati cu acest email.</div>
          <?php endif; ?>

          <label for="passwd">Password</label>
          <input type="password" id="passwd" name="passwd" required />
          <?php if (isset($_GET['error_pas'])): ?>
            <div class="err-input">Parola gresita. Incercati din nou</div>
          <?php endif; ?>

          <button type="submit">Log In</button>
        </form>
        <div class="register-link">
          Don't have an account? <a href="register.php">Register here</a>
        </div>
      </div>
    </div>

    <div class="right">
      <h1>Step Into Style</h1>
      <p>Discover the latest trends and timeless classics in footwear.
      Whether you're hitting the streets or the runway, our curated collection
      of shoes will elevate every step you take. Welcome to your new favorite shoe store.</p>
    </div>

  </div>

</body>
</html>
