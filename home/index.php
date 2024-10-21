<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ida Summit 2024</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="nav-logo">
            <img src="logo.png" alt="Logo" class="logo-img">
        </div>
        <div class="nav-menu">
            <ul>
                <li><a href="#home">Ana Sayfa</a></li>
                <li><a href="#about">Hakkında</a></li>
                <li><a href="#motivation">Motivasyon</a></li>
                <li><a href="#speakers">Konuşmacılar</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <a href="#katilim-formu" class="katilim-btn">Katılım Formu</a>
        </div>
    </nav>

    <!-- Header Bölümü -->
    <header class="header" id="home">
        <video autoplay muted loop id="background-video">
            <source src="tanitim.mp4" type="video/mp4">
            Tarayıcınız video etiketini desteklemiyor.
        </video>

        <div class="header-content">
            <h1>Ida Summit 2024</h1>
            <p>Ida Summit 2024 | 27 Kasım 2024 | Altınoluk</p>
            <div id="countdown" class="countdown">
                <span id="days">00</span> Gün 
                <span id="hours">00</span> Saat 
                <span id="minutes">00</span> Dakika 
                <span id="seconds">00</span> Saniye
            </div>
            <div class="action-buttons">
                <a href="#katilim-formu" class="katilim-btn">Katılım Formu</a>
            </div>
        </div>
    </header>

    <!-- Hakkında Bölümü -->
    <section id="about" class="content-section">
        <div class="content-container">
            <div class="text-container">
                <h2>Hakkında</h2>
                <p>İdasummer 24, teknoloji ve inovasyon dünyasına adım atmak isteyen genç zihinleri, alanında uzman kişilerle buluşturan bir etkinlik olarak tasarlanmıştır. Etkinlik, teknolojinin hızla gelişen dünyasında gençlerin yaratıcılıklarını ve potansiyellerini en üst düzeye çıkararak, onları geleceğin liderleri ve yenilikçileri haline getirmeyi hedefler.</p>
            </div>
            <div class="image-container rotate-left">
                <img src="ida3.png" alt="Hakkında Resim">
            </div>
        </div>
    </section>

    <!-- Sürdürülebilir Motivasyon Bölümü -->
    <section id="motivation" class="content-section">
        <div class="content-container">
            <div class="text-container">
                <h2>Sürdürülebilir Motivasyon</h2>
                <p>Etkinliğimiz, gençlerin sürdürülebilir bir gelecek için yaratıcılıklarını teşvik etmeyi amaçlamaktadır. Her katılımcı, çevreye duyarlı projeler geliştirme konusunda motive edilir.</p>
            </div>
            <div class="image-container rotate-right">
                <img src="ida2.png" alt="Sürdürülebilir Motivasyon Resim">
            </div>
        </div>
    </section>

    <section id="speakers" class="content-section">
    <div class="container">
        <h2>Konuşmacılar</h2>
        <div class="slider-wrapper">
            <div id="slider" class="slider">
                <?php
                // config.php dosyasını dahil et
                include '../config.php';
                
                // Konuşmacı bilgilerini çek
                $sql = "SELECT image_name, name, title FROM katilimcilar";
                $result = $conn->query($sql);
                
                // Konuşmacıları bir diziye kaydet
                $speakers = [];
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $speakers[] = $row;
                    }
                }

                // Eğer konuşmacı verisi varsa, 100 kez tekrarla
                if (!empty($speakers)) {
                    for ($i = 0; $i < 100; $i++) {
                        foreach ($speakers as $speaker) {
                            echo '<div class="slide">';
                            echo '<img src="./katilimcilar/' . $speaker["image_name"] . '" alt="' . $speaker["name"] . '">';
                            echo '<p class="name">' . $speaker["name"] . '</p>';
                            echo '<p class="title">' . $speaker["title"] . '</p>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo "Konuşmacı bulunamadı.";
                }

                // Veritabanı bağlantısını kapat
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</section>

<section id="partners" class="content-section">
    <div class="container">
        <h2>Partnerler</h2>
        <p>Etkinliğimize destek veren iş ortakları ve sponsorlar, gençlerin yaratıcı fikirlerini hayata geçirmeleri için önemli fırsatlar sunuyor. İşte bu yılın partnerleri:</p>

        <div class="partners-logos">
            <?php
            // config.php dosyasını dahil et
            include '../config.php';

            // Partner bilgilerini çek
            $sql = "SELECT logo_name, partner_name, link FROM partnerler";
            $result = $conn->query($sql);

            // Partnerleri diziye ekle
            $partners = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $partners[] = $row;
                }
            }

            // Eğer partner verisi varsa, ilk partneri en üste ekle
            if (!empty($partners)) {
                // En üstteki partner
                $first_partner = array_shift($partners);
                echo '<div class="single-partner">';
                echo '<a href="' . $first_partner["link"] . '" target="_blank">';
                echo '<img src="./partnerler/' . $first_partner["logo_name"] . '" alt="' . $first_partner["partner_name"] . '">';
                echo '</a>';
                echo '</div>';

                // Kalan partnerleri dört sütun halinde ekle
                echo '<div class="partners-grid">';
                foreach ($partners as $index => $partner) {
                    echo '<div class="partner">';
                    echo '<a href="' . $partner["link"] . '" target="_blank">';
                    echo '<img src="./partnerler/' . $partner["logo_name"] . '" alt="' . $partner["partner_name"] . '">';
                    echo '</a>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "Partner bulunamadı.";
            }

            // Veritabanı bağlantısını kapat
            $conn->close();
            ?>
        </div>
    </div>
</section>


    <!-- Katılım Formu Modal -->
<!-- Katılım Formu Modal -->
<div id="formModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Katılım Formu</h2>
        <form action="#" method="post">
            <label for="name">İsim:</label>
            <input type="text" id="name" name="name" placeholder="İsminizi girin" required>

            <label for="surname">Soyisim:</label>
            <input type="text" id="surname" name="surname" placeholder="Soyisminizi girin" required>

            <label for="phone">Telefon No:</label>
            <input type="tel" id="phone" name="phone" placeholder="Telefon numaranızı girin" required>

            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" placeholder="E-posta adresinizi girin" required>

            <button type="submit">Gönder</button>
        </form>
    </div>
</div>



    <!-- Footer -->
    <footer class="footer">
        <div class="footer-social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p>&copy; Grknn. Tüm Hakları Saklıdır.</p>
    </footer>

    <!-- JavaScript -->
    <script src="script.js"></script>
</body>
</html>
