<?php
session_start();

// Eğer giriş yapılmamışsa kullanıcıyı login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="adminstyle.css"> <!-- Yukarıdaki CSS dosyasını bağlayın -->
    <script>
        // Alt menülerin açılıp kapanmasını sağlamak için JavaScript
        function toggleMenu(menu) {
            menu.classList.toggle('open');
        }
    </script>
</head>
<body>

    <!-- Yan Menü -->
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
            <li><a href="./homedesign/homeup.php">Ana Sayfa</a></li>
            <li><a href="./textdesign/textdesign.php">Hakkında-Motivasyon</a></li>
            <li><a href="./speakers/speakers.php">Konuşmacılar</a></li>
            <li><a href="./partners/partners.php">Sponsorlar</a></li>
            <li><a href="./katilim/katilim.php">Katılımcılar</a></li>
        </ul>
    </div>

    <!-- İçerik Alanı -->
    <div class="content">
        <h1>Hoş Geldiniz!</h1>
        <p>Bu admin paneli üzerinden site içeriğini yönetebilirsiniz.</p>
    </div>

</body>
</html>
