(function() {
    var wooLoginRegister = document.getElementById('customer_login');

    if (wooLoginRegister) {
        var wooRegisterBtn = document.getElementById('Btn_RegisterNow'),
            wooLoginBtn = document.getElementById('Btn_LoginNow'),
            wooLoginForm = document.getElementById('Form_LoginNow'),
            wooRegisterForm = document.getElementById('Form_RegisterNow');

        wooRegisterBtn.addEventListener('click', function() {
            wooLoginForm.classList.add('d-none');
            wooRegisterForm.classList.remove('d-none');
        }, false);

        wooLoginBtn.addEventListener('click', function() {
            wooLoginForm.classList.remove('d-none');
            wooRegisterForm.classList.add('d-none');
        }, false);
    }
})();