<?php
session_start();
require '../config.php'; // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri alın
    $ad_soyad = trim($_POST['ad_soyad']);
    $okul = trim($_POST['okul']);
    $bolum = trim($_POST['bolum']);
    $sinif = trim($_POST['sinif']);
    $cep_tel = trim($_POST['cep_tel']);
    $email = trim($_POST['email']);

    // Telefon ve e-posta kontrolü için sorgu
    $stmt = $conn->prepare("SELECT * FROM katilim_formu WHERE cep_tel = ? OR email = ?");
    $stmt->bind_param("ss", $cep_tel, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Eğer kayıt varsa hata mesajı göster
        echo "Bu telefon numarası veya e-posta adresi zaten kayıtlı!";
    } else {
        // Kayıt yoksa veritabanına ekleyin
        $stmt = $conn->prepare("INSERT INTO katilim_formu (ad_soyad, okul, bolum, sinif, cep_tel, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $ad_soyad, $okul, $bolum, $sinif, $cep_tel, $email);

        // Veritabanına ekleme işlemi
        if ($stmt->execute()) {
            echo "Form başarıyla gönderildi!"; // Başarılı ekleme mesajı
        } else {
            echo "Kayıt sırasında bir hata oluştu: " . $stmt->error; // Hata mesajı
        }
    }

    $stmt->close();
    $conn->close();
}
?>
