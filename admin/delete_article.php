<?php
require_once 'auth_check.php';
require_once '../config/database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $article_id = $_GET['id'];

    // Opsional: Hapus file gambar terkait jika ada
    $sql_select = "SELECT image_path FROM articles WHERE id = :id";
    if ($stmt_select = $pdo->prepare($sql_select)) {
        $stmt_select->bindParam(":id", $article_id, PDO::PARAM_INT);
        $stmt_select->execute();
        if ($row = $stmt_select->fetch()) {
            if (!empty($row['image_path']) && file_exists('../' . $row['image_path'])) {
                unlink('../' . $row['image_path']);
            }
        }
    }

    // Hapus record dari database
    $sql_delete = "DELETE FROM articles WHERE id = :id";
    if ($stmt_delete = $pdo->prepare($sql_delete)) {
        $stmt_delete->bindParam(":id", $article_id, PDO::PARAM_INT);
        $stmt_delete->execute();
    }
}

header("location: dashboard.php");
exit();
?>