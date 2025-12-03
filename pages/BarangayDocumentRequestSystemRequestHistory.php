<?php
require '../db.php';
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }

$user_id = $_SESSION['user_id'];
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : "";

// Secure Query
$query = "SELECT * FROM requests WHERE user_id = :uid AND (document_type LIKE :search OR status LIKE :search) LIMIT $start, $limit";
$stmt = $pdo->prepare($query);
$stmt->execute([':uid' => $user_id, ':search' => "%$search%"]);
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Request History</title>
  <link rel="stylesheet" href="../style/style.css">
  <style>
      /* Quick table styling to ensure it looks good */
      table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
      th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
      th { background-color: #f4f4f4; font-weight: bold; }
      tr:nth-child(even) { background-color: #f9f9f9; }
      .search-box { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;}
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
          <img src="../assets/images/<?php echo $_SESSION['profile_pic'] ?? 'img_profile.svg'; ?>" alt="Profile" class="profile-image">
          <h2 class="profile-name"><?php echo $_SESSION['full_name'] ?? 'User'; ?></h2>
          <span class="user-badge">User</span>
        </div>

        <nav class="sidebar-menu">
          <button class="menu-item" onclick="window.location.href='BarangayDocumentRequestSystemDashboard.php'">
            <span class="menu-text">Dashboard</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='SeeiMUBarangayDocumentRequestDashboard.php'">
            <span class="menu-text">Documents</span>
          </button>
          
          <button class="menu-item active" onclick="window.location.href='BarangayDocumentRequestSystemRequestHistory.php'">
            <span class="menu-text">Request History</span>
          </button>
          
          <button class="menu-item" onclick="window.location.href='SeeiMUBarangayDocumentRequestSystemAccountDashboard.php'">
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
         <section class="hero-section"><h1 class="hero-title">My Request History</h1></section>
         
         <div class="card" style="padding: 20px;">
            <form method="GET">
                <input type="text" name="search" class="search-box" placeholder="Search by Document Type or Status..." value="<?php echo htmlspecialchars($search); ?>">
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Document Type</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($requests) > 0): ?>
                        <?php foreach($requests as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['document_type']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['date_requested'])); ?></td>
                            <td style="font-weight:bold; color: <?php echo $row['status']=='Pending'?'orange':'green'; ?>">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;">No requests found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
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