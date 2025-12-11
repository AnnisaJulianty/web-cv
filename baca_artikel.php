<?php
require_once 'config/database.php';

// Validasi ID artikel
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: artikel.php");
    exit;
}

$article_id = $_GET['id'];
$article = null;

try {
    // Query untuk mengambil satu artikel beserta nama kategori
    $sql = "SELECT a.*, c.name AS category_name 
            FROM articles a 
            LEFT JOIN categories c ON a.category_id = c.id 
            WHERE a.id = :id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $article_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika artikel tidak ditemukan, redirect ke halaman daftar artikel
    if (!$article) {
        header("Location: artikel.php?status=notfound");
        exit;
    }

} catch (PDOException $e) {
    // Jika ada error, redirect atau tampilkan pesan
    // Untuk sekarang, kita redirect saja
    header("Location: artikel.php?status=dberror");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title']); ?> - Annisa Julianty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
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

    <!-- Content: Baca Artikel -->
    <section class="content-section content-section-padded">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <article>
                        <header class="mb-4">
                            <!-- Judul Artikel -->
                            <h1 class="fw-bolder mb-1 section-title"><?= htmlspecialchars($article['title']); ?></h1>
                            <!-- Meta info -->
                            <div class="text-muted fst-italic mb-2">
                                Diposting pada <?= date('d F Y', strtotime($article['created_at'])); ?>
                                <?php if ($article['category_name']): ?>
                                    dalam kategori <a href="artikel.php?category=<?= $article['category_id']; ?>"><?= htmlspecialchars($article['category_name']); ?></a>
                                <?php endif; ?>
                            </div>
                        </header>

                        <!-- Gambar Artikel -->
                        <?php if ($article['image_path']): ?>
                        <figure class="mb-4">
                            <img src="<?= htmlspecialchars($article['image_path']); ?>" class="img-fluid rounded" alt="Gambar artikel: <?= htmlspecialchars($article['title']); ?>">
                        </figure>
                        <?php endif; ?>

                        <!-- Konten Artikel -->
                        <section class="mb-5 article-content">
                            <?= $article['content']; // Tampilkan konten HTML secara langsung ?>
                        </section>

                    </article>
                    
                    <div class="text-center mt-5">
                        <a href="artikel.php" class="btn btn-custom"><i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Artikel</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y'); ?> Annisa Julianty. Dibuat dengan <i class="fa-solid fa-heart"></i></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
