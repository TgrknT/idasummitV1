<?php
require '../config.php'; // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri alın
    $ad_soyad = $_POST['ad_soyad'];
    $okul = $_POST['okul'];
    $bolum = $_POST['bolum'];
    $sinif = $_POST['sinif'];
    $cep_tel = $_POST['cep_tel'];
    $email = $_POST['email'];

    // Veritabanına ekleme işlemi
    $stmt = $conn->prepare("INSERT INTO katilim_formu (ad_soyad, okul, bolum, sinif, cep_tel, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $ad_soyad, $okul, $bolum, $sinif, $cep_tel, $email);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
