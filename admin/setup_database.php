<?php
require_once '../config/database.php';

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS home_info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            `key` VARCHAR(255) NOT NULL UNIQUE,
            `value` TEXT NOT NULL
        );

        CREATE TABLE IF NOT EXISTS skills (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            category VARCHAR(255) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS education (
            id INT AUTO_INCREMENT PRIMARY KEY,
            institution VARCHAR(255) NOT NULL,
            major VARCHAR(255) NOT NULL,
            `year` VARCHAR(255) NOT NULL,
            description TEXT
        );

        CREATE TABLE IF NOT EXISTS contact_info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL UNIQUE,
            `value` VARCHAR(255) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS projects (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            image_path VARCHAR(255),
            link VARCHAR(255)
        );

        CREATE TABLE IF NOT EXISTS experience (
            id INT AUTO_INCREMENT PRIMARY KEY,
            description TEXT NOT NULL,
            sort_order INT NOT NULL,
            timeline_position VARCHAR(10) NOT NULL
        );

        CREATE TABLE IF NOT EXISTS social_media (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            url VARCHAR(255) NOT NULL,
            icon_class VARCHAR(255) NOT NULL,
            display_order INT DEFAULT 0
        );
    ");

    // Optionally, pre-fill some data for home_info to make editing easier later
    $pdo->exec("
        INSERT IGNORE INTO home_info (`key`, `value`) VALUES
        ('main_title', 'Annisa Julianty'),
        ('subtitle', 'Mahasiswa Sistem Informasi'),
        ('about_me', 'Saya seorang mahasiswi sistem informasi semester 6 di Universitas Muhammadiyah Purwokerto. Saya memiliki minat besar dalam pengembangan web dan desain UI/UX. Saya selalu bersemangat untuk mempelajari hal-hal baru dan berkolaborasi dalam proyek-proyek yang menantang.'),
        ('hobby', 'Membaca, Menulis, dan Mendengarkan Musik'),
        ('umur', '20');
    ");
    
    // Pre-fill contact info
    $pdo->exec("
        INSERT IGNORE INTO contact_info (name, value) VALUES
        ('Alamat', 'Purwokerto, Jawa Tengah'),
        ('Email', 'annisajulianty@example.com'),
        ('Telepon', '+62 812 3456 7890');
    ");

    // Pre-fill education
    $pdo->exec("
        INSERT IGNORE INTO education (institution, major, `year`, description) VALUES
        ('Universitas Muhammadiyah Purwokerto', 'Sistem Informasi', '2021-Sekarang', 'Mahasiswa Aktif Semester 6'),
        ('SMA Negeri 1 Purwokerto', 'Ilmu Pengetahuan Alam', '2018-2021', 'Lulus dengan predikat baik.');
    ");

    // Pre-fill experience
    $pdo->exec("
        INSERT IGNORE INTO experience (description, sort_order, timeline_position) VALUES
        ('Olimpiade Sains Nasional (OSN) IPA (2021)', 1, 'right'),
        ('OSIS (Organisasi Siswa Intra Sekolah) (2021-2023)', 2, 'left'),
        ('Mengikuti Lomba KKR tingkat kecamatan (2022)', 3, 'right'),
        ('Pengurus Lab IPA (2022-2023)', 4, 'left'),
        ('Mengikuti lomba MAPSI (2022 dan 2023)', 5, 'right'),
        ('Olimpiade Sains Nasional (OSN) Matematika (2022 dan 2023)', 6, 'left'),
        ('Mengikuti lomba LCC museum (2023)', 7, 'right'),
        ('Mengikuti FTBI (2023)', 8, 'left'),
        ('Kader Literasi (2023)', 9, 'right'),
        ('Panitia di Kegiatan CKC (Computer Kids Club) (2024)', 10, 'left'),
        ('Anggota Organisasi PSPG (2024-sekarang)', 11, 'right');
    ");

    // Pre-fill social media
    $pdo->exec("
        INSERT IGNORE INTO social_media (name, url, icon_class, display_order) VALUES
        ('Instagram', 'https://www.instagram.com/_annisajlnty/', 'fab fa-instagram', 1),
        ('GitHub', 'https://github.com/username', 'fab fa-github', 2);
    ");

    echo "Database tables created and initialized successfully!";

} catch (PDOException $e) {
    die("ERROR: Could not execute setup script. " . $e->getMessage());
}
?>