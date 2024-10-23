<?php
session_start();
require '../../config.php'; // Veritabanı bağlantısı

// Mevcut katılımcı verilerini çek
$query = "SELECT * FROM katilimcilar";
$result = $conn->query($query);

// Verileri bir diziye al
$participants = [];
while ($row = $result->fetch_assoc()) {
    $participants[] = $row;
}

// Katılımcıyı silme işlemi
if (isset($_GET['delete_id'])) {
    $participant_id = $_GET['delete_id'];

    // Katılımcının resim dosyasını sil
    $query = "SELECT image_name FROM katilimcilar WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $stmt->bind_result($image_name);
    $stmt->fetch();
    $stmt->close();

    if (!empty($image_name) && file_exists("../../home/katilimcilar/" . $image_name)) {
        unlink("../../home/katilimcilar/" . $image_name);
    }

    // Katılımcıyı veritabanından sil
    $stmt = $conn->prepare("DELETE FROM katilimcilar WHERE id = ?");
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('Katılımcı başarıyla silindi!'); window.location.href='speakers.php';</script>";
    exit;
}

// Katılımcıyı ekleme işlemi
if (isset($_POST['add_participant'])) {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $image_file = $_FILES['image_file'];

    // Resim dosyası yüklendiyse
    if (!empty($image_file['name'])) {
        $file_info = pathinfo($image_file['name']);
        $image_name = $file_info['filename'] . '.' . $file_info['extension']; // Dosya adı ve uzantısı
        $image_path = "../../home/katilimcilar/" . $image_name;

        // Yeni resmi yükle
        if (move_uploaded_file($image_file['tmp_name'], $image_path)) {
            // Veritabanına yeni katılımcıyı ekle
            $stmt = $conn->prepare("INSERT INTO katilimcilar (name, title, image_name) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $title, $image_name);
            $stmt->execute();
            $stmt->close();

            // Başarılı mesajı ve sayfayı yenileme
            echo "<script>alert('Katılımcı başarıyla eklendi!'); window.location.href='speakers.php';</script>";
            exit;
        } else {
            echo "<script>alert('Resim yükleme başarısız!');</script>";
        }
    } else {
        echo "<script>alert('Lütfen bir resim seçin.');</script>";
    }
}

// Form gönderimi ile katılımcı verilerini güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['add_participant'])) {
    $participant_id = $_POST['participant_id'];
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $image_file = $_FILES['image_file'];

    // Resim dosyası yüklendiyse
    if (!empty($image_file['name'])) {
        $file_info = pathinfo($image_file['name']);
        $image_name = $file_info['filename'] . '.' . $file_info['extension']; // Dosya adı ve uzantısı
        $image_path = "../../home/katilimcilar/" . $image_name;

        // Mevcut resmi sil
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Yeni resmi yükle
        if (move_uploaded_file($image_file['tmp_name'], $image_path)) {
            // Veritabanını güncelle (resim adı, isim ve unvan)
            $stmt = $conn->prepare("UPDATE katilimcilar SET name = ?, title = ?, image_name = ? WHERE id = ?");
            $stmt->bind_param("sssi", $name, $title, $image_name, $participant_id);
        } else {
            echo "<script>alert('Resim yükleme başarısız!');</script>";
        }
    } else {
        // Sadece isim ve unvanı güncelle
        $stmt = $conn->prepare("UPDATE katilimcilar SET name = ?, title = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $title, $participant_id);
    }

    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('Katılımcı bilgileri başarıyla güncellendi!'); window.location.href='speakers.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katılımcı Düzenleme Paneli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Yan Menü -->
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
            <li><a href="../homedesign/homeup.php">Ana Sayfa</a></li>
            <li><a href="../textdesign/textdesign.php">Hakkında-Motivasyon</a></li>
            <li><a href="./speakers.php">Konuşmacılar</a></li>
            <li><a href="../partners/partners.php">Sponsorlar</a></li>
        </ul>
    </div>

    <!-- Düzenleme Alanı -->
    <div class="content">
        <h1>Katılımcı Düzenleme</h1>

        <!-- Yeni Katılımcı Ekleme Formu -->
        <form action="speakers.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 40px;">
            <h2>Yeni Katılımcı Ekle</h2>

            <!-- İsim Ekleme -->
            <div class="input-group">
                <label for="name">İsim:</label>
                <input type="text" id="name" name="name" placeholder="Katılımcı Adı" required>
            </div>

            <!-- Unvan Ekleme -->
            <div class="input-group">
                <label for="title">Unvan:</label>
                <input type="text" id="title" name="title" placeholder="Katılımcı Unvanı" required>
            </div>

            <!-- Resim Yükleme -->
            <div class="input-group">
                <label for="image_file">Resim Yükle:</label>
                <input type="file" id="image_file" name="image_file" accept="image/*" required>
            </div>

            <!-- Gönderim Butonu -->
            <button type="submit" name="add_participant" class="login-btn">Katılımcı Ekle</button>
        </form>

        <?php if (!empty($participants)): ?>
            <?php foreach ($participants as $participant): ?>
                <form action="speakers.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
                    <h2><?php echo $participant['name']; ?></h2>

                    <!-- İsim Düzenleme -->
                    <div class="input-group">
                        <label for="name_<?php echo $participant['id']; ?>">İsim:</label>
                        <input type="text" id="name_<?php echo $participant['id']; ?>" name="name" value="<?php echo $participant['name']; ?>" required>
                    </div>

                    <!-- Unvan Düzenleme -->
                    <div class="input-group">
                        <label for="title_<?php echo $participant['id']; ?>">Unvan:</label>
                        <input type="text" id="title_<?php echo $participant['id']; ?>" name="title" value="<?php echo $participant['title']; ?>" required>
                    </div>

                    <!-- Mevcut Resim -->
                    <div class="input-group">
                        <label>Mevcut Resim:</label>
                        <img src="../../home/katilimcilar/<?php echo $participant['image_name']; ?>" alt="<?php echo $participant['name']; ?>" width="200">
                    </div>

                    <!-- Resim Yükleme -->
                    <div class="input-group">
                        <label for="image_file_<?php echo $participant['id']; ?>">Resim Yükle:</label>
                        <input type="file" id="image_file_<?php echo $participant['id']; ?>" name="image_file" accept="image/*">
                    </div>

                    <!-- Gönderim ve Kaldırma Butonları -->
                    <input type="hidden" name="participant_id" value="<?php echo $participant['id']; ?>">
                    <button type="submit" class="login-btn">Katılımcıyı Güncelle</button>
                    <a href="speakers.php?delete_id=<?php echo $participant['id']; ?>" class="delete-btn" onclick="return confirm('Bu katılımcıyı silmek istediğinizden emin misiniz?')">Katılımcıyı Kaldır</a>
                </form>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Henüz katılımcı eklenmemiş.</p>
        <?php endif; ?>

    </div>
</body>
</html>
