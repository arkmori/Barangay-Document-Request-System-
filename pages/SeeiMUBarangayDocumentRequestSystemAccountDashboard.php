<?php
require '../db.php';
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }

$user_id = $_SESSION['user_id'];

// --- 1. HANDLE PROFILE UPDATE LOGIC ---
if (isset($_POST['update_profile'])) {
    $name = $_POST['full_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    
    // Handle Image Upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $filename = time() . "_" . $_FILES['profile_pic']['name'];
        // Ensure the path is correct relative to this file
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "../assets/images/" . $filename);
        
        $sql = "UPDATE users SET full_name=?, address=?, contact_no=?, profile_pic=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $address, $contact, $filename, $user_id]);
        
        // Update session immediately so sidebar updates
        $_SESSION['profile_pic'] = $filename; 
        $_SESSION['full_name'] = $name;
    } else {
        // Update without changing image
        $sql = "UPDATE users SET full_name=?, address=?, contact_no=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $address, $contact, $user_id]);
        $_SESSION['full_name'] = $name;
    }
    
    // Refresh to show changes
    header("Location: SeeiMUBarangayDocumentRequestSystemAccountDashboard.php?success=1");
    exit();
}

// --- 2. FETCH USER DATA ---
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Account Dashboard</title>
  <link rel="stylesheet" href="../style/style.css">
  <style> 
    .account-card { padding: 24px; background: #fff; border: 1px solid #353535; border-radius: 8px; } 
    .profile-avatar { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-right: 20px; } 
    .form-row { margin-bottom: 15px; }
    .form-label { display: block; font-weight: 600; margin-bottom: 5px; }
    .form-input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
  </style>
</head>
<body>

  <div class="main-container">
    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-profile">
          <div class="profile-seal-container">
            <div class="profile-seal-bg"></div>
            <img src="../assets/images/barangay seal.svg" alt="Seal" class="profile-seal">
          </div>
          <img src="../assets/images/<?php echo $user['profile_pic']; ?>" alt="Profile" class="profile-image">
          <h2 class="profile-name"><?php echo htmlspecialchars($user['full_name']); ?></h2>
          <span class="user-badge">User</span>
        </div>

        <nav class="sidebar-menu">
          <button class="menu-item" onclick="window.location.href='BarangayDocumentRequestSystemDashboard.php'">
            <span class="menu-text">Dashboard</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='SeeiMUBarangayDocumentRequestDashboard.php'">
            <span class="menu-text">Documents</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='BarangayDocumentRequestSystemRequestHistory.php'">
            <span class="menu-text">Request History</span>
          </button>
          
          <button class="menu-item active" onclick="window.location.href='SeeiMUBarangayDocumentRequestSystemAccountDashboard.php'">
            <span class="menu-text">Account & Settings</span>
          </button>
          
          <button class="logout-item" onclick="window.location.href='logout.php'">
             <img src="../assets/images/img_logout.svg" alt="Icon" class="logout-icon">
             <span>Log Out</span>
          </button>
        </nav>
    </aside>

    <main class="main-content">
      <div class="content-wrapper">
        <section class="account-section">
          <h2 class="page-title">Account</h2>
          
          <div class="account-card">
            <form method="POST" enctype="multipart/form-data">
                
                <div style="display:flex; align-items:center; margin-bottom:20px;">
                  <img src="../assets/images/<?php echo $user['profile_pic']; ?>" alt="Profile" class="profile-avatar">
                  <div>
                    <h3 class="profile-title"><?php echo htmlspecialchars($user['full_name']); ?></h3>
                    <input type="file" name="profile_pic" style="margin-top: 10px;">
                  </div>
                </div>
                
                <div class="form-section">
                  <div class="form-row">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-input" value="<?php echo htmlspecialchars($user['full_name']); ?>">
                  </div>
                  
                  <div class="form-row">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-input" value="<?php echo htmlspecialchars($user['address']); ?>">
                  </div>
                  
                  <div class="form-row">
                    <label class="form-label">Contact No.</label>
                    <input type="tel" name="contact" class="form-input" value="<?php echo htmlspecialchars($user['contact_no']); ?>">
                  </div>
                  
                  <div class="form-row">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" readonly style="background: #e0e0e0; cursor: not-allowed;">
                  </div>
                </div>

                <div style="margin-top: 20px; text-align: right;">
                    <button type="submit" name="update_profile" style="background: #00813d; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Save Changes</button>
                </div>
            </form>
          </div>
        </section>
      </div>
    </main>

    <aside class="right-sidebar">
      <img src="../assets/images/img_bell.svg" alt="Bell" class="notification-icon">
      
      <div class="steps-card">
        <div class="steps-header">
          <span class="steps-number">4</span>
          <div class="steps-title">easy steps to<br>create a request</div>
          <img src="../assets/images/img_bulb.svg" alt="Bulb" class="bulb-icon">
        </div>
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #1</h3>
            <p class="step-description">Click the "Request Now" button</p>
        </div>
        <div class="step-icon">
             <img src="../assets/images/img_step1.svg" alt="Step 1" style="width: 48px; height: 16px;">
        </div>
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #2</h3>
            <p class="step-description">Fill-out the request form</p>
        </div>
        <img src="../assets/images/img_step2.svg" alt="Step 2" style="width: 76px; height: 64px;">
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #3</h3>
            <p class="step-description">Wait for the Barangay Office to review.</p>
        </div>
        <img src="../assets/images/img_step3.svg" alt="Step 3" style="width: 52px; height: 52px;">
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #4</h3>
            <p class="step-description">Set your appointment date.</p>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="../assets/images/img_24_time_calendar_checked.svg" alt="Calendar" style="width: 14px; height: 14px; margin-bottom: 2px;">
            <img src="../assets/images/img_step4mail.svg" alt="Step 4" style="width: 50px; height: 38px;">
        </div>
      </div>
    </aside>

  </div> </body>
  
</html>