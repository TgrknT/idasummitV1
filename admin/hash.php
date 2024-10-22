<?php
// Şifreyi hashleyelim
$password = '1'; // Güncellenecek şifre
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Hashlenmiş şifreyi ekrana yazdırın
echo $hashed_password;
?>
