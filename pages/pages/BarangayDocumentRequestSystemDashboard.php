<?php
require '../db.php'; // Updated path
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Documents | SeeiMU</title>
  
  <link rel="stylesheet" href="../style/style.css">
  
  <style>
    .header-section { margin-bottom: 30px; text-align: center; }
    .system-title { font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; }
    .page-title { font-size: 28px; font-weight: 700; color: #1c1c1c; }
    .documents-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 24px; margin-bottom: 40px; }
    .document-card { background: #ffffff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 24px 16px; display: flex; flex-direction: column; align-items: center; text-align: center; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer; }
    .document-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-color: #00813d; }
    .document-icon { width: 64px; height: 64px; margin-bottom: 16px; object-fit: contain; }
    .document-title { font-size: 14px; font-weight: 600; color: #333; line-height: 1.4; }
    .footer-link { color: #468966; font-weight: 700; text-decoration: none; }
  </style>
</head>
<body>

  <div class="main-container">
    
    <header class="mobile-header">
      <button class="hamburger" onclick="toggleSidebar()">☰</button>
      <h1 class="header-title">Available Documents</h1>
    </header>
    
    <div class="sidebar-overlay" onclick="closeSidebar()"></div>
    
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-profile">
          <div class="profile-seal-container">
            <div class="profile-seal-bg"></div>
            <img src="../assets/images/img_barangay_seal.png" alt="Barangay Seal" class="profile-seal">
          </div>
          <img src="../assets/images/<?php echo $_SESSION['profile_pic'] ?? 'img_profile.png'; ?>" alt="Profile" class="profile-image">
          <h2 class="profile-name"><?php echo $_SESSION['full_name'] ?? 'User'; ?></h2>
          <span class="user-badge">User</span>
        </div>

        <nav class="sidebar-menu">
          <button class="menu-item active" onclick="window.location.href='BarangayDocumentRequestSystemDashboard.php'">
            <span class="menu-text">Dashboard</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='SeeiMUBarangayDocumentRequestDashboard.php'">
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
        <header class="header-section">
          <p class="system-title">Barangay Document Request System</p>
          <h1 class="page-title">Available Documents</h1>
        </header>

        <section class="documents-container">
          <div class="documents-grid">
            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Barangay Certificate of Residency</h3>
            </article>

            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Barangay Clearance</h3>
            </article>

            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Certificate of Indigency</h3>
            </article>

            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Business Clearance</h3>
            </article>

            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Certificate of Residency for Scholarship</h3>
            </article>

            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Barangay Certification for Building Permit</h3>
            </article>

            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Barangay Blotter Record/ Incident Report</h3>
            </article>
            
            <article class="document-card">
              <img src="../assets/images/img_image_9.png" alt="Icon" class="document-icon">
              <h3 class="document-title">Barangay Protection Order (BPO)</h3>
            </article>
          </div>

          <div style="text-align: center; margin-bottom: 40px;">
              <button class="request-button" onclick="window.location.href='create_request.php'">Request Now</button>
          </div>

          <footer class="footer-text">
            <a href="#" class="footer-link">SeeiMU Website</a>
            <span class="footer-copyright"> | © Copyright 2025 SeeiMUU</span>
          </footer>
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

  <script>
    function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.querySelector('.sidebar-overlay').classList.toggle('active'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.querySelector('.sidebar-overlay').classList.remove('active'); }
  </script>
</body>
</html>