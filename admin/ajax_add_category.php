<?php
require_once 'auth_check.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Permintaan tidak valid.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);

    if (empty($name)) {
        $response['message'] = 'Nama kategori tidak boleh kosong.';
    } else {
        // Cek duplikat
        $sql_check = "SELECT id FROM categories WHERE name = :name";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            $response['message'] = 'Nama kategori sudah ada.';
        } else {
            // Insert kategori baru
            $sql_insert = "INSERT INTO categories (name) VALUES (:name)";
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':name', $name, PDO::PARAM_STR);

            if ($stmt_insert->execute()) {
                $new_category_id = $pdo->lastInsertId();
                $response['success'] = true;
                $response['message'] = 'Kategori berhasil ditambahkan.';
                $response['category'] = ['id' => $new_category_id, 'name' => $name];
            } else {
                $response['message'] = 'Gagal menyimpan kategori ke database.';
            }
        }
    }
} 

echo json_encode($response);
?>