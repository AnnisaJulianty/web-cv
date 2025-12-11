<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Validasi data
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Jika ada error, kembali ke halaman kontak dengan status error
        header("Location: kontak.php?status=error");
        exit;
    }

    // Set penerima email
    $recipient = "annisajuliantyid@gmail.com";

    // Set subjek email
    $subject = "Pesan Baru dari $name melalui Website CV";

    // Buat konten email
    $email_content = "Nama: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Pesan:\n$message\n";

    // Buat header email
    $email_headers = "From: $name <$email>";

    // Kirim email
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Jika berhasil, kembali ke halaman kontak dengan status sukses
        header("Location: kontak.php?status=sukses");
    } else {
        // Jika gagal, kembali ke halaman kontak dengan status error
        header("Location: kontak.php?status=error");
    }

} else {
    // Jika bukan metode POST, redirect ke halaman utama
    header("Location: index.php");
}
?>
