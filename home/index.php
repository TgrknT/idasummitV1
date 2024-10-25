<?php
require '../config.php'; // Veritabanı bağlantısı

// Ana içerik verilerini çek
$query = "SELECT * FROM home_content WHERE id = 1";
$result = $conn->query($query);
$content = $result->fetch_assoc();

// Hakkında ve motivasyon verilerini çek
$query_sections = "SELECT section_name, image_url, content_text FROM section_content";
$result_sections = $conn->query($query_sections);

// Verileri bir diziye al
$sections = [];
while ($row = $result_sections->fetch_assoc()) {
    $sections[$row['section_name']] = $row;
}

// Konuşmacı verilerini çek
$query_speakers = "SELECT image_name, name, title FROM katilimcilar";
$result_speakers = $conn->query($query_speakers);

// Verileri bir diziye al
$speakers = [];
if ($result_speakers && $result_speakers->num_rows > 0) {
    while ($row = $result_speakers->fetch_assoc()) {
        $speakers[] = $row;
    }
}

// Partner verilerini çek
$query_partners = "SELECT logo_name, partner_name, link FROM partnerler";
$result_partners = $conn->query($query_partners);

// Verileri bir diziye al
$partners = [];
if ($result_partners && $result_partners->num_rows > 0) {
    while ($row = $result_partners->fetch_assoc()) {
        $partners[] = $row;
    }
}

// Video URL'sini tam yol olarak oluşturun ve sonuna .mp4 ekleyin
$video_url = './video/' . $content['video_url'] . '.mp4';

// Etkinlik tarihini JavaScript için uygun formata dönüştür
$event_date_js = date('Y-m-d\TH:i:s', strtotime($content['event_date']));
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="#formModal" class="katilim-btn">Katılım Formu</a>
        </div>
    </nav>

    <!-- Header Bölümü -->
    <header class="header" id="home">
        <video autoplay muted loop id="background-video">
            <source src="<?php echo $video_url; ?>" type="video/mp4">
            Tarayıcınız video etiketini desteklemiyor.
        </video>

        <div class="header-content">
            <h1><?php echo $content['header_text']; ?></h1>
            <p><?php echo $content['subheader_text']; ?></p>
            <div id="countdown" class="countdown">
                <span id="days">00</span> Gün 
                <span id="hours">00</span> Saat 
                <span id="minutes">00</span> Dakika 
                <span id="seconds">00</span> Saniye
            </div>
            <div class="action-buttons">
                <a href="#formModal" class="katilim-btn">Katılım Formu</a>
            </div>
        </div>
    </header>

<!-- Hakkında Bölümü -->
<?php if (!empty($sections['hakkinda'])): ?>
    <section id="about" class="content-section">
        <div class="content-container">
            <div class="text-container">
                <h2>Hakkında</h2>
                <p><?php echo $sections['hakkinda']['content_text']; ?></p>
            </div>
            <div class="image-container">
                <!-- Masaüstü Resmi -->
                <img class="desktop-image" src="./content/<?php echo $sections['hakkinda']['image_url']; ?>" alt="Hakkında Resim">
            </div>
        </div>
    </section>
<?php endif; ?>

    <!-- Sürdürülebilir Motivasyon Bölümü -->
    <?php if (!empty($sections['motivasyon'])): ?>
        <section id="motivation" class="content-section">
            <div class="content-container">
                <div class="text-container">
                    <h2>Sürdürülebilir Motivasyon</h2>
                    <p><?php echo $sections['motivasyon']['content_text']; ?></p>
                </div>
                <div class="image-container rotate-right">
                    <img src="./content/<?php echo $sections['motivasyon']['image_url']; ?>" alt="Sürdürülebilir Motivasyon Resim">
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Konuşmacılar Bölümü -->
<!-- Konuşmacılar Bölümü -->
<section id="speakers" class="content-section">
    <div class="container">
        <h2>Konuşmacılar</h2>
        <br>
        <div class="slider-wrapper">
            <div id="slider" class="slider">
                <?php
                // Konuşmacı bilgilerini çek
                $sql = "SELECT image_name, name, title FROM katilimcilar";
                $result = $conn->query($sql);

                $speakers = [];
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $speakers[] = $row;
                    }
                }

                // Eğer konuşmacı verisi varsa, 100 kez tekrarla
                if (!empty($speakers)) {
                    for ($i = 0; $i < 300; $i++) {
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
                ?>
            </div>
        </div>
    </div>
</section>

    <!-- Partnerler Bölümü -->
    <section id="partners" class="content-section">
        <div class="container">
            <h2>Partnerler</h2>
            <br>
            <p>Etkinliğimize destek veren iş ortakları ve sponsorlar, gençlerin yaratıcı fikirlerini hayata geçirmeleri için önemli fırsatlar sunuyor.</p>
                <br>
                <br>
            <div class="partners-logos">
                <?php
                // Partner bilgilerini çek
                $sql = "SELECT logo_name, partner_name, link FROM partnerler";
                $result = $conn->query($sql);

                $partners = [];
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $partners[] = $row;
                    }
                }

                if (!empty($partners)) {
                    $first_partner = array_shift($partners);
                    echo '<div class="single-partner">';
                    echo '<a href="' . $first_partner["link"] . '" target="_blank">';
                    echo '<img src="./partnerler/' . $first_partner["logo_name"] . '" alt="' . $first_partner["partner_name"] . '">';
                    echo '</a>';
                    echo '</div>';

                    echo '<div class="partners-grid">';
                    foreach ($partners as $partner) {
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
                ?>
            </div>
        </div>
    </section>

<!-- Katılım Formu Modal -->
<div id="formModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Katılım Formu</h2>
        <form id="katilimFormu" method="post">
            <!-- Ad Soyad -->
            <label for="ad_soyad">Ad Soyad:</label>
            <input type="text" id="ad_soyad" name="ad_soyad" placeholder="Adınızı ve soyadınızı girin" required>

            <!-- Okul -->
            <label for="okul">Okul:</label>
            <select id="okul" name="okul" required>
                <option value="">Okul Seçin</option>
                <option value="Edremit MYO">Edremit MYO</option>
                <option value="Altınoluk MYO">Altınoluk MYO</option>
                <option value="Edremit Sivil Havacılık YO">Edremit Sivil Havacılık YO</option>
                <option value="Havran MYO">Havran MYO</option>
                <option value="Diğer">Diğer</option>
            </select>

            <!-- Bölüm -->
            <label for="bolum">Bölüm:</label>
            <input type="text" id="bolum" name="bolum" placeholder="Bölümünüzü girin" required>

            <!-- Sınıf -->
            <label for="sinif">Sınıf:</label>
            <input type="text" id="sinif" name="sinif" placeholder="Sınıfınızı girin" required>

            <!-- Cep Telefonu -->
            <label for="cep_tel">Cep Telefonu:</label>
            <input type="tel" id="cep_tel" name="cep_tel" placeholder="Telefon numaranızı girin" required>

            <!-- E-posta -->
            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" placeholder="E-posta adresinizi girin" required>

            <!-- Gönderim Butonu -->
            <button type="submit">Gönder</button>
        </form>

        <!-- Başarı Mesajı -->
        <div id="successMessage" style="display: none; color: green; margin-top: 10px;">
            Form başarıyla gönderildi!
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Form gönderildiğinde AJAX ile veriyi işleyin
    $('#katilimFormu').on('submit', function(event) {
        event.preventDefault(); // Sayfanın yenilenmesini önle

        $.ajax({
            url: 'form_submit.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Başarılı gönderim mesajını göster
                $('#successMessage').show();
                // Formu temizle
                $('#katilimFormu')[0].reset();
                // Modal'ı kapat
                setTimeout(function() {
                    closeModal();
                }, 2000);
            },
            error: function() {
                alert('Form gönderimi başarısız! Lütfen tekrar deneyin.');
            }
        });
    });

    // Modal'ı kapatma fonksiyonu
    function closeModal() {
        $('#formModal').hide();
    }

    // Modal'ı açma fonksiyonu
    function openModal() {
        $('#formModal').show();
    }
</script>


    <!-- Footer -->
    <footer class="footer">
        <div class="footer-social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <p>&copy; Grknn. Tüm Hakları Saklıdır.</p>
    </footer>

    <!-- PHP'den gelen tarih bilgisini JavaScript'e aktarma -->
    <script src='script.js'></script>
    <script>
        const eventDate = new Date("<?php echo $event_date_js; ?>").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = eventDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days;
            document.getElementById('hours').textContent = hours;
            document.getElementById('minutes').textContent = minutes;
            document.getElementById('seconds').textContent = seconds;

            if (distance < 0) {
                clearInterval(countdownInterval);
                document.getElementById('countdown').textContent = "Etkinlik başladı!";
            }
        }

        const countdownInterval = setInterval(updateCountdown, 1000);
    </script>

</body>
</html>
