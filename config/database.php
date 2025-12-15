<?php
// --- Konfigurasi Database ---
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Sesuaikan jika user Anda berbeda
define('DB_PASS', ''); // Sesuaikan jika Anda menggunakan password
define('DB_NAME', 'dbpsas1');

// --- Membuat Koneksi ---
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Tidak bisa terhubung ke database. " . $e->getMessage());
}

// --- Fungsi Bantuan ---
function base_url($path = '') {
    // Mengasumsikan folder proyek ada di root htdocs
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $project_folder = basename(dirname(__DIR__)); // cv-annisa
    return $protocol . "://" . $host . "/" . $project_folder . "/" . ltrim($path, '/');
}
?>