document.addEventListener("DOMContentLoaded", function () {

    const password = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");

    if (password && toggle) {

        toggle.addEventListener("click", function () {

            if (password.type === "password") {

                password.type = "text";

                this.innerHTML = '<i class="fas fa-eye-slash"></i>';

            } else {

                password.type = "password";

                this.innerHTML = '<i class="fas fa-eye"></i>';

            }

        });

    }

});