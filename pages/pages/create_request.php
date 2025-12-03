<?php
require '../db.php';
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }

// Handle Form Submission
if (isset($_POST['submit_request'])) {
    $user_id = $_SESSION['user_id'];
    $doc_type = $_POST['document_type'];
    $purpose = trim($_POST['purpose']);
    
    // File Upload Logic
    $filename = null;
    if (!empty($_FILES['attachment']['name'])) {
        $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        
        if (in_array(strtolower($ext), $allowed)) {
            $filename = "doc_" . time() . "." . $ext;
            // Ensure the 'uploads' folder exists in 'assets'
            $target_dir = "../assets/uploads/";
            if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
            
            move_uploaded_file($_FILES['attachment']['tmp_name'], $target_dir . $filename);
        }
    }
    
    if(!empty($purpose)) {
        $stmt = $pdo->prepare("INSERT INTO requests (user_id, document_type, purpose, status, file_path) VALUES (?, ?, ?, 'Pending', ?)");
        $stmt->execute([$user_id, $doc_type, $purpose, $filename]);
        
        // Redirect to History page after success
        header("Location: BarangayDocumentRequestSystemRequestHistory.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Request</title>
  <link rel="stylesheet" href="../style/style.css">
  <style>
      .form-container { background: white; padding: 30px; border-radius: 8px; border: 1px solid #ddd; max-width: 600px; margin: 0 auto; }
      .form-group { margin-bottom: 20px; }
      .form-label { display: block; margin-bottom: 8px; font-weight: bold; }
      .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
      .btn-submit { background: #00813d; color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;}
      .btn-submit:hover { background: #006b33; }
  </style>
</head>
<body>

  <div class="main-container">
    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-profile">
          <div class="profile-seal-container">
            <div class="profile-seal-bg"></div>
            <img src="../assets/images/img_barangay_seal.png" alt="Seal" class="profile-seal">
          </div>
          <img src="../assets/images/<?php echo $_SESSION['profile_pic'] ?? 'img_profile.png'; ?>" alt="Profile" class="profile-image">
          <h2 class="profile-name"><?php echo $_SESSION['full_name'] ?? 'User'; ?></h2>
          <span class="user-badge">User</span>
        </div>

        <nav class="sidebar-menu">
          <button class="menu-item" onclick="window.location.href='BarangayDocumentRequestSystemDashboard.php'">
            <span class="menu-text">Dashboard</span>
          </button>
          
          <button class="menu-item active" onclick="window.location.href='SeeiMUBarangayDocumentRequestDashboard.php'">
            <span class="menu-text">Documents</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='BarangayDocumentRequestSystemRequestHistory.php'">
            <span class="menu-text">Request History</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='SeeiMUBarangayDocumentRequestSystemAccountDashboard.php'">
            <span class="menu-text">Account & Settings</span>
          </button>
          
          <button class="logout-item" onclick="window.location.href='logout.php'">
             <img src="../assets/images/img_icon.svg" alt="Icon" class="logout-icon">
             <span>Log Out</span>
          </button>
        </nav>
    </aside>

    <main class="main-content">
      <div class="content-wrapper">
        <section class="hero-section"><h1 class="hero-title">Request a Document</h1></section>

        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Document Type</label>
                    <select name="document_type" class="form-control">
                        <option>Barangay Certificate of Residency</option>
                        <option>Barangay Clearance</option>
                        <option>Certificate of Indigency</option>
                        <option>Business Clearance</option>
                        <option>Barangay Protection Order</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Purpose of Request</label>
                    <textarea name="purpose" class="form-control" rows="4" placeholder="e.g. Scholarship Application" required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Attachment (Optional)</label>
                    <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    <small style="color: #666; font-size: 0.85rem;">Allowed: JPG, PNG, PDF</small>
                </div>

                <button type="submit" name="submit_request" class="btn-submit">Submit Request</button>
                <a href="BarangayDocumentRequestSystemDashboard.php" style="display:block; text-align:center; margin-top:15px; text-decoration:none; color:#555;">Cancel</a>
            </form>
        </div>
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
             <img src="../assets/images/img_image_1.png" alt="Step 1" style="width: 48px; height: 16px;">
        </div>
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #2</h3>
            <p class="step-description">Fill-out the request form</p>
        </div>
        <img src="../assets/images/img_image_3.png" alt="Step 2" style="width: 76px; height: 64px;">
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #3</h3>
            <p class="step-description">Wait for the Barangay Office to review.</p>
        </div>
        <img src="../assets/images/img_70_iconos_grati.png" alt="Step 3" style="width: 52px; height: 52px;">
      </div>

      <div class="step-item">
        <div class="step-content">
            <h3 class="step-title">Step #4</h3>
            <p class="step-description">Set your appointment date.</p>
        </div>
        <div style="display: flex; flex-direction: column; align-items: center;">
            <img src="../assets/images/img_24_time_calendar_checked.svg" alt="Calendar" style="width: 14px; height: 14px; margin-bottom: 2px;">
            <img src="../assets/images/img_image_5.png" alt="Step 4" style="width: 50px; height: 38px;">
        </div>
      </div>
    </aside>

  </div>
</body>
</html>