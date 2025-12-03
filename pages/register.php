<?php
// We use '../db.php' because this file is inside the 'pages' folder
require '../db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_btn'])) {
    $fullname = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Basic Validation
    if ($password !== $confirm_pass) {
        $error = "Passwords do not match.";
    } else {
        // 2. Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $error = "Email is already registered.";
        } else {
            // 3. Create the user (Hashing the password for security)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // We insert default values for status/sex/address to avoid errors
            $sql = "INSERT INTO users (full_name, email, password, profile_pic, status, sex, address, contact_no) 
                    VALUES (?, ?, ?, 'img_profile.png', 'Single', 'Female', 'Not Set', 'Not Set')";
            
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$fullname, $email, $hashed_password]);
                
                // Redirect to login page with success message
                header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php?success=registered");
                exit();
            } catch (Exception $e) {
                $error = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | SeeiMU</title>
  
  <link rel="stylesheet" href="../style/style.css"> 
</head>
<body>
  <main class="main-container">
    <div class="background-overlay"></div>
    <img src="../assets/images/login background.svg" alt="Mascot" class="character-image">
    
    <div class="content-wrapper">
      <section class="main-content">
        <div class="content-row">
          <div class="left-section">
            <div class="logo-container">
              <div class="logo-background"></div>
              <img src="../assets/images/barangay seal.svg" alt="Seal" class="logo-image">
            </div>
            <h1 class="system-title">Barangay Document Request System</h1>
            <p class="system-subtitle">Create your account to request documents online.</p>
          </div>
          
          <div class="right-section">
            <div class="auth-container">
              <div class="tab-header">
                <a href="SeeiMUBarangayDocumentRequestSystemLogin.php" class="tab-button">User</a>
                <button class="tab-button active" type="button">Register</button>
              </div>
              <div class="tab-divider"></div>
              
              <form method="POST" class="login-form">
                <header class="form-header">
                  <h2 class="form-title">CREATE ACCOUNT</h2>
                </header>
                
                <div class="form-fields">
                  <div class="field-group">
                    <label class="field-label">Full Name</label>
                    <input type="text" name="full_name" class="field-input" placeholder="Juan Dela Cruz" required>
                  </div>

                  <div class="field-group">
                    <label class="field-label">Email</label>
                    <input type="email" name="email" class="field-input" placeholder="user@email.com" required>
                  </div>
                  
                  <div class="field-group">
                    <label class="field-label">Password</label>
                    <input type="password" name="password" class="field-input" placeholder="************" required>
                  </div>

                  <div class="field-group">
                    <label class="field-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="field-input" placeholder="************" required>
                  </div>
                </div>
                
                <?php if(!empty($error)): ?>
                    <p style="color: red; text-align: center; margin-top: 10px;"><?php echo $error; ?></p>
                <?php endif; ?>

                <button type="submit" name="register_btn" class="login-button">Register</button>
                
                <p class="signup-link">
                  Already have an account? <a href="SeeiMUBarangayDocumentRequestSystemLogin.php" class="link-text">Login Here</a>
                </p>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>
</body>
</html>