<?php
// Adjust this path if db.php is in a different folder
// If db.php is in the main folder and this file is in 'pages/', use '../db.php'
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_btn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare SQL to find the user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify password (assumes you used password_hash during registration)
    // If you manually inserted users in DB without hashing, use: if ($user && $password == $user['password'])
    if ($user && password_verify($password, $user['password'])) {
        // Set Session Variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['profile_pic'] = $user['profile_pic'];
        
        // Redirect to Dashboard
        header("Location: BarangayDocumentRequestSystemDashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SeeiMU Barangay Document Request System</title>
  <meta name="description" content="Secure login portal for SeeiMU Barangay Document Request System.">
  <link rel="stylesheet" href="../style/style.css"> 
</head>
<body>
  <main class="main-container">
    <div class="background-overlay"></div>
    <img src="../assets/images/img_laya_at_diwa_edited.png" alt="SeeiMU mascot character illustration" class="character-image">
    
    <div class="content-wrapper">
      <section class="main-content">
        <div class="content-row">
          <div class="left-section">
            <div class="logo-container">
              <div class="logo-background"></div>
              <img src="../assets/images/img_barangay_seal.png" alt="Official Barangay Seal" class="logo-image">
            </div>
            <h1 class="system-title">Barangay Document Request System</h1>
            <p class="system-subtitle">Quick, Easy and Secure: SeeiMU Online Document Request System</p>
          </div>
          
          <div class="right-section">
            <div class="auth-container">
              <div class="tab-header">
                <button class="tab-button active" type="button">User</button>
                <a href="register.php" class="tab-button">Register</a>
              </div>
              <div class="tab-divider"></div>
              
              <form method="POST" class="login-form" role="form" aria-label="User Login Form">
                <header class="form-header">
                  <h2 class="form-title">LOG IN YOUR ACCOUNT</h2>
                  <p class="form-subtitle">Effortlessly request documents online</p>
                </header>
                
                <div class="form-fields">
                  <div class="field-group">
                    <label for="email" class="field-label">Email</label>
                    <input 
                      type="email" 
                      id="email" 
                      name="email" 
                      class="field-input" 
                      placeholder="user@email.com"
                      required
                    >
                  </div>
                  
                  <div class="field-group">
                    <label for="password" class="field-label">Password</label>
                    <input 
                      type="password" 
                      id="password" 
                      name="password" 
                      class="field-input" 
                      placeholder="************"
                      required
                    >
                    <div class="password-actions">
                      <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>
                  </div>
                </div>
                
                <?php if(isset($error)): ?>
                    <p id="message-area" class="message-area" style="color: red; margin-top: 10px; text-align: center;">
                        <?php echo $error; ?>
                    </p>
                <?php endif; ?>

                <button type="submit" name="login_btn" class="login-button">Login</button>
                
                <p class="signup-link">
                  No Account Yet? <a href="register.php" class="link-text">Click Here</a>
                </p>
              </form>
            </div>
            
            <footer class="footer-text">
              <span class="highlight">SeeiMU Website</span> | © Copyright 2025 SeeiMUU | Barangay Document Request System
            </footer>
          </div>
        </div>
      </section>
    </div>
  </main>
</body>
</html>