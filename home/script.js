// Katılım formu açma ve kapama işlemleri
const modal = document.getElementById("formModal");
const openBtns = document.querySelectorAll(".katilim-btn"); // Tüm katılım butonlarını seçiyoruz
const closeBtns = document.querySelectorAll(".close-btn"); // Tüm kapatma butonlarını seçiyoruz

// Katılım butonuna tıklayınca formu aç
openBtns.forEach(openBtn => {
    openBtn.addEventListener("click", function(e) {
        e.preventDefault(); // Sayfanın yeniden yüklenmesini engeller
        modal.style.display = "flex"; // Modalı göster
    });
});

// Kapat butonuna tıklayınca formu kapat
closeBtns.forEach(closeBtn => {
    closeBtn.addEventListener("click", function() {
        modal.style.display = "none"; // Modalı gizle
    });
});

// Modal dışında bir yere tıklayınca formu kapat
window.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});



    document.addEventListener("DOMContentLoaded", function() {
        const slider = document.getElementById('slider');

        let scrollAmount = 0; // Kaydırma başlangıç noktası

        function scrollSlider() {
            scrollAmount -= 1; // Her seferinde 1px sola kaydır
            slider.style.transform = `translateX(${scrollAmount}px)`;

            // Eğer kaydırma sonuna ulaştıysa durdurma
            if (Math.abs(scrollAmount) >= slider.scrollWidth - slider.clientWidth) {
                return; // Daha fazla kaydırma yapılmaz
            }

            // Kaydırma işlemi devam eder
            requestAnimationFrame(scrollSlider);
        }

        // Kaydırmayı başlat
        scrollSlider();
    });

