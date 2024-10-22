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
            <li class="menu">
                <a href="#" class="toggle" onclick="toggleMenu(this.parentNode)">Ana Sayfa</a>
                <ul class="submenu">
                    <li><a href="./homedesign/homeup.php">Üst Başlık</a></li>
                    <li><a href="./homedesign/homevideo.php">Video Düzenleme</a></li>
                </ul>
            </li>
            <li><a href="#">Kullanıcı Yönetimi</a></li>
            <li><a href="#">İçerik Düzenleme</a></li>
            <li><a href="#">Ayarlar</a></li>
        </ul>
    </div>

    <!-- İçerik Alanı -->
    <div class="content">
        <h1>Hoş Geldiniz!</h1>
        <p>Bu admin paneli üzerinden site içeriğini yönetebilirsiniz.</p>
    </div>

</body>
</html>
