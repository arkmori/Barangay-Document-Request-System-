<?php
require '../db.php';
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SeeiMU Barangay Document Request System</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
  <div class="main-container">
    <header class="mobile-header">
      <button class="hamburger" onclick="toggleSidebar()">☰</button>
      <h1 class="header-title">Barangay Document Request System</h1>
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
        <section class="hero-section">
          <h1 class="hero-title">Fast and convenient access to barangay documents</h1>
          <button class="request-button" onclick="window.location.href='create_request.php'">REQUEST NOW</button>
        </section>
         <section class="cards-section">
          <article class="card">
            <header class="card-header">Announcement</header>
            <div class="card-content">
              <p class="announcement-text">
                Please be advised that the Barangay Office will be conducting its Year-End Planning...
              </p>
            </div>
          </article>

          <article class="card transaction-card">
            <header class="card-header">Transaction Days</header>
            <div class="card-content">
              <p class="transaction-text">
                11/23/25 - no transaction<br>
                11/23/25 - 7:00 a.m. to 11:30 a.m.
              </p>
            </div>
          </article>
        </section>

        <section class="faq-section">
          <header class="faq-header">Frequently Asked Questions</header>
          <div class="faq-content">
            <div class="faq-item">How long does it take to process a document request?</div>
            <div class="faq-item">How will I be notified when my document is ready?</div>
            <div class="faq-item">What valid IDs are accepted for claiming a document?</div>
          </div>
        </section>

        <footer>
          <p class="footer-text">
            <span class="highlight">SeeiMU Website</span> | © Copyright 2025 SeeiMUU
          </p>
        </footer>
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

    </div>
  <script>
    function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.querySelector('.sidebar-overlay').classList.toggle('active'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.querySelector('.sidebar-overlay').classList.remove('active'); }
  </script>
</body>
</html>