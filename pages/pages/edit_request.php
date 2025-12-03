<?php
require '../db.php';
if (!isset($_SESSION['user_id'])) { header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php"); exit(); }

if (!isset($_GET['id'])) { header("Location: BarangayDocumentRequestSystemRequestHistory.php"); exit(); }
$request_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch current data
$stmt = $pdo->prepare("SELECT * FROM requests WHERE id = ? AND user_id = ?");
$stmt->execute([$request_id, $user_id]);
$request = $stmt->fetch();

if (!$request || $request['status'] != 'Pending') {
    die("Access Denied: You can only edit your own Pending requests.");
}

// Update Logic
if (isset($_POST['update_request'])) {
    $doc_type = $_POST['document_type'];
    $purpose = $_POST['purpose'];
    
    // Optional File Replacement
    if (!empty($_FILES['attachment']['name'])) {
        $filename = "doc_" . time() . "." . pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['attachment']['tmp_name'], "../assets/uploads/" . $filename);
        
        $sql = "UPDATE requests SET document_type=?, purpose=?, file_path=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$doc_type, $purpose, $filename, $request_id]);
    } else {
        $sql = "UPDATE requests SET document_type=?, purpose=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$doc_type, $purpose, $request_id]);
    }
    
    header("Location: BarangayDocumentRequestSystemRequestHistory.php?msg=updated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Request</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="main-container">
        <main class="main-content">
            <div class="content-wrapper">
                <div class="card" style="max-width: 600px; margin: 40px auto; padding: 30px;">
                    <h2>Edit Request</h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div style="margin-bottom:15px;">
                            <label>Document Type</label>
                            <select name="document_type" style="width:100%; padding:10px;">
                                <option <?php if($request['document_type'] == 'Barangay Certificate of Residency') echo 'selected'; ?>>Barangay Certificate of Residency</option>
                                <option <?php if($request['document_type'] == 'Barangay Clearance') echo 'selected'; ?>>Barangay Clearance</option>
                                <option <?php if($request['document_type'] == 'Certificate of Indigency') echo 'selected'; ?>>Certificate of Indigency</option>
                            </select>
                        </div>
                        <div style="margin-bottom:15px;">
                            <label>Purpose</label>
                            <textarea name="purpose" style="width:100%; padding:10px;" rows="4"><?php echo htmlspecialchars($request['purpose']); ?></textarea>
                        </div>
                        <div style="margin-bottom:15px;">
                            <label>Update Attachment (Leave empty to keep current)</label>
                            <input type="file" name="attachment">
                        </div>
                        <button type="submit" name="update_request" style="background:#00813d; color:white; padding:10px 20px; border:none; cursor:pointer;">Save Changes</button>
                        <a href="BarangayDocumentRequestSystemRequestHistory.php" style="margin-left:10px;">Cancel</a>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>