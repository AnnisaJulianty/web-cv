<?php
require_once 'config/database.php';

$selected_category_id = $_GET['category'] ?? null;
$page_title_suffix = '';
$social_medias = [];

// Mengambil semua kategori untuk filter
$categories = [];
try {
    $categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Abaikan error, biarkan halaman render
}

try {
    $stmt = $pdo->query("SELECT * FROM social_media ORDER BY display_order ASC, id ASC");
    $social_medias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error or handle gracefully
}

// Mengambil artikel
$articles = [];
try {
    // Query dasar dengan JOIN
    $sql = "SELECT a.*, c.name AS category_name 
            FROM articles a 
            LEFT JOIN categories c ON a.category_id = c.id";

    // Jika ada kategori yang dipilih, tambahkan WHERE
    if ($selected_category_id) {
        $sql .= " WHERE a.category_id = :category_id";
    }

    $sql .= " ORDER BY a.created_at DESC";

    $stmt = $pdo->prepare($sql);

    if ($selected_category_id) {
        $stmt->bindParam(':category_id', $selected_category_id, PDO::PARAM_INT);
        // Cari nama kategori untuk judul halaman
        foreach ($categories as $cat) {
            if ($cat['id'] == $selected_category_id) {
                $page_title_suffix = ' - ' . htmlspecialchars($cat['name']);
                break;
            }
        }
    }

    $stmt->execute();
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Abaikan error
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel<?php echo $page_title_suffix; ?> - Annisa Julianty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Annisa Julianty</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">About Me</a></li>
                    <li class="nav-item"><a class="nav-link" href="pendidikan.php">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="pengalaman.php">Pengalaman</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="skill.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link active" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content: Artikel -->
    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Artikel <?php echo $page_title_suffix; ?></h2>

            <!-- Filter Kategori -->
            <div class="text-center mb-5">
                <a href="artikel.php" class="btn btn-sm <?php echo !$selected_category_id ? 'btn-custom' : 'btn-outline-light'; ?>">Semua</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="artikel.php?category=<?php echo $cat['id']; ?>" class="btn btn-sm <?php echo ($selected_category_id == $cat['id']) ? 'btn-custom' : 'btn-outline-light'; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="row g-4">
                <?php if (count($articles) > 0): ?>
                    <?php foreach ($articles as $article): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($article['image_path'] ? $article['image_path'] : 'https://via.placeholder.com/400x250/00ddff/0d021a?text=Artikel'); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($article['title']); ?>">
                            <div class="card-body d-flex flex-column">
                                <?php if ($article['category_name']): ?>
                                    <p class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($article['category_name']); ?></p>
                                <?php endif; ?>
                                <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                                                                <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr(strip_tags($article['content']), 0, 100)) . '...'; ?></p>
                                <div class="mt-4 text-start">
                                    <a href="baca_artikel.php?id=<?= $article['id']; ?>" class="btn-custom">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <p>Belum ada artikel yang dipublikasikan<?php echo $page_title_suffix ? ' dalam kategori ini' : ''; ?>.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="social-icons text-center mb-3">
                <?php if (count($social_medias) > 0): ?>
                    <?php foreach ($social_medias as $social): ?>
                        <a href="<?= htmlspecialchars($social['url']); ?>" target="_blank" class="social-icon"><i class="<?= htmlspecialchars($social['icon_class']); ?>"></i></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback: hardcoded Instagram link as before -->
                    <a href="https://www.instagram.com/_annisajlnty" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
            </div>
            <p>&copy; <?php echo date('Y'); ?> Annisa Julianty. Dibuat dengan <i class="fa-solid fa-heart"></i></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
