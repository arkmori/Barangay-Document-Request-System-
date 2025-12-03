<?php
require '../db.php';
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }

$user_id = $_SESSION['user_id'];

// --- 1. PAGINATION & FILTER LOGIC ---
$limit = 5; // Rows per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Get Search and Filter inputs
$search = isset($_GET['search']) ? $_GET['search'] : "";
$status_filter = isset($_GET['status']) ? $_GET['status'] : "";

// --- 2. BUILD QUERY ---
$sql = "SELECT * FROM requests WHERE user_id = :uid";
$params = [':uid' => $user_id];

// Add Search condition
if (!empty($search)) {
    $sql .= " AND (document_type LIKE :search OR purpose LIKE :search)";
    $params[':search'] = "%$search%";
}

// Add Status Filter condition
if (!empty($status_filter)) {
    $sql .= " AND status = :status";
    $params[':status'] = $status_filter;
}

// Finalize Query with Order and Limit
$sql .= " ORDER BY date_requested DESC LIMIT $start, $limit";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Request History</title>
  <link rel="stylesheet" href="../style/style.css">
  <style>
      /* Table Styles */
      table { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; }
      th, td { padding: 12px; border: 1px solid #ddd; text-align: left; font-size: 14px; }
      th { background-color: #f4f4f4; font-weight: bold; color: #333; }
      tr:nth-child(even) { background-color: #f9f9f9; }

      /* Filter Styles */
      .filters { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
      .search-input { flex: 2; padding: 10px; border: 1px solid #ccc; border-radius: 4px; min-width: 200px; }
      .status-select { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; min-width: 120px; }
      .btn-filter { padding: 10px 20px; background: #00813d; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; }
      .btn-filter:hover { background: #006b33; }

      /* Action Buttons */
      .action-link { text-decoration: none; font-weight: 600; margin-right: 8px; font-size: 13px; }
      .edit-btn { color: #007bff; }
      .edit-btn:hover { text-decoration: underline; }
      .delete-btn { color: #dc3545; }
      .delete-btn:hover { text-decoration: underline; }
      .view-file { color: #28a745; font-size: 12px; font-weight: 600; text-decoration: none; }
      .view-file:hover { text-decoration: underline; }
      
      .pagination { margin-top: 20px; text-align: center; }
      .page-link { margin: 0 5px; text-decoration: none; color: #333; }
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
             <img src="../assets/images/img_icon.svg" alt="Icon" class="logout-icon">
             <span>Log Out</span>
          </button>
        </nav>
    </aside>

    <main class="main-content">
       <div class="content-wrapper">
         <section class="hero-section"><h1 class="hero-title">My Request History</h1></section>
         
         <div class="card" style="padding: 20px;">
            
            <form method="GET" class="filters">
                <input type="text" name="search" class="search-input" placeholder="Search document type or purpose..." value="<?php echo htmlspecialchars($search); ?>">
                
                <select name="status" class="status-select">
                    <option value="">All Statuses</option>
                    <option value="Pending" <?php if($status_filter=='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Approved" <?php if($status_filter=='Approved') echo 'selected'; ?>>Approved</option>
                    <option value="Rejected" <?php if($status_filter=='Rejected') echo 'selected'; ?>>Rejected</option>
                </select>
                
                <button type="submit" class="btn-filter">Filter</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Document Type</th>
                        <th>Date Requested</th>
                        <th>Status</th>
                        <th>File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($requests) > 0): ?>
                        <?php foreach($requests as $row): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($row['document_type']); ?></strong><br>
                                <small style="color:#666;"><?php echo htmlspecialchars(substr($row['purpose'], 0, 40)); ?>...</small>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($row['date_requested'])); ?></td>
                            <td>
                                <span style="font-weight:bold; color: <?php echo $row['status']=='Pending'?'orange':($row['status']=='Approved'?'green':'red'); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if($row['file_path']): ?>
                                    <a href="../assets/uploads/<?php echo $row['file_path']; ?>" target="_blank" class="view-file">View File</a>
                                <?php else: ?>
                                    <span style="color:#ccc; font-size:12px;">None</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row['status'] == 'Pending'): ?>
                                    <a href="edit_request.php?id=<?php echo $row['id']; ?>" class="action-link edit-btn">Edit</a>
                                    <a href="delete_request.php?id=<?php echo $row['id']; ?>" class="action-link delete-btn" onclick="return confirm('Are you sure you want to delete this request?')">Delete</a>
                                <?php else: ?>
                                    <span style="color:#999; font-size:11px;">Locked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 20px;">No requests found matching your criteria.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php if($page > 1): ?>
                    <a href="?page=<?php echo $page-1; ?>&search=<?php echo $search; ?>&status=<?php echo $status_filter; ?>" class="page-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <span style="margin: 0 10px; font-weight: bold;">Page <?php echo $page; ?></span>
                
                <a href="?page=<?php echo $page+1; ?>&search=<?php echo $search; ?>&status=<?php echo $status_filter; ?>" class="page-link">Next &raquo;</a>
            </div>

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

  </div> </body>
</html>