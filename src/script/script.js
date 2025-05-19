// Formun doğru şekilde gönderildiğini kontrol et
document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.querySelector('form');

    // Kayıt formu gönderildiğinde doğrulama yap
    registerForm.addEventListener("submit", function (event) {
        const username = document.querySelector('#username').value;
        const email = document.querySelector('#email').value;
        const password = document.querySelector('#password').value;

        if (!username || !email || !password) {
            alert("Lütfen tüm alanları doldurun!");
            event.preventDefault(); // Formun gönderilmesini engelle
        }
    });

    // Giriş formu doğrulama
    const loginForm = document.querySelector('form');

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            const email = document.querySelector('#email').value;
            const password = document.querySelector('#password').value;

            if (!email || !password) {
                alert("Lütfen e-posta ve şifrenizi girin!");
                event.preventDefault(); // Formun gönderilmesini engelle
            }
        });
    }
});
