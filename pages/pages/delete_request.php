<?php
require '../db.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // 1. Get file path to delete physical file
    $stmt = $pdo->prepare("SELECT file_path, status FROM requests WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $request = $stmt->fetch();

    if ($request && $request['status'] == 'Pending') {
        // Delete physical file if it exists
        if ($request['file_path'] && file_exists("../assets/uploads/" . $request['file_path'])) {
            unlink("../assets/uploads/" . $request['file_path']);
        }

        // Delete Database Record
        $delStmt = $pdo->prepare("DELETE FROM requests WHERE id = ?");
        $delStmt->execute([$id]);
    }
}

// Redirect back to list
header("Location: BarangayDocumentRequestSystemRequestHistory.php");
exit();
?>