<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - ShoeStore</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f2f2f2;

      /* Background grid of small shoe icons */
      background-image: url("../img/app/img_bg_reg.png");
      background-repeat: repeat;
      background-size: 64px 64px;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 4rem 1rem; /* space top and bottom */
      box-sizing: border-box;
      min-height: 100vh;
    }
    .register-container {
      background: white;
      padding: 2.5rem 3rem;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 100%;
      box-sizing: border-box;
      text-align: center;
      max-height: calc(100vh - 8rem); /* prevent overflow */
      overflow-y: auto;
    }
    .register-container h2 {
      margin-bottom: 1.5rem;
      font-weight: 700;
      color: #18204d;
    }
    label {
      display: block;
      margin-bottom: 0.4rem;
      font-weight: 600;
      text-align: left;
      color: #555;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    select {
      width: 100%;
      padding: 0.5rem 0.6rem;
      margin-bottom: 1.2rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.2s ease;
      box-sizing: border-box;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="date"]:focus,
    select:focus {
      border-color: #18204d;
      outline: none;
    }
    button {
      width: 100%;
      padding: 0.7rem;
      background-color: #18204d;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 700;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #6553af;
    }
    .login-link {
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #555;
    }
    .login-link a {
      color: #18204d;
      text-decoration: none;
      font-weight: 600;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="register-container" role="main">
    <h2>Create Account</h2>
    <?php if (isset($_GET['error_pas']) || isset($_GET['error_email'])): ?>
      <div class="err-input">Nu ati introdus datele corect. Incercati din nou</div>
    <?php endif; ?>
    <?php if (isset($_GET['error_reg'])): ?>
      <div class="err-input">A intervenit o eroare. Incercati din nou</div>
    <?php endif; ?>
    <form action="register_handle.php" method="POST">
      <label for="name">First Name</label>
      <input type="text" id="name" name="name" required />

      <label for="pren">Last Name</label>
      <input type="text" id="pren" name="pren" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />
      <?php if (isset($_GET['error_email'])): ?>
        <div class="err-input">Acest email este deja inregistrat.</div>
      <?php endif; ?>

      <label for="birthdate">Birthdate</label>
      <input type="date" id="birthdate" name="birthdate" required max="9999-12-31" />

      <label for="sex">Sex</label>
      <select id="sex" name="sex" required>
        <option value="" disabled selected>Select your sex</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
        <option value="prefer_not_to_say">Prefer not to say</option>
      </select>

      <label for="passwd">Password</label>
      <input type="password" id="passwd" name="passwd" required />

      <label for="confirm-passwd">Confirm Password</label>
      <input type="password" id="confirm-passwd" name="confirm-passwd" required />
      <?php if (isset($_GET['error_pas'])): ?>
        <div class="err-input">Parola nu coincide. Incercati din nou</div>
      <?php endif; ?>
      <button type="submit">Register</button>
    </form>

    <div class="login-link">
      Already have an account? <a href="login.php">Log in here</a>
    </div>
  </div>

</body>
</html>
