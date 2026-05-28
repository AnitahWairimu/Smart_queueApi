document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const togglePassword = document.getElementById("togglePassword");
    const capsWarning = document.getElementById("capsWarning");

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    togglePassword.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";
        togglePassword.textContent = isPassword ? "Hide" : "Show";
        togglePassword.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");
    });

    passwordInput.addEventListener("keyup", function (event) {
        if (typeof event.getModifierState === "function") {
            const isCapsOn = event.getModifierState("CapsLock");
            capsWarning.style.display = isCapsOn ? "block" : "none";
        }
    });

    form.addEventListener("submit", function (event) {
        let isValid = true;

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        if (!emailPattern.test(email)) {
            emailError.style.display = "block";
            isValid = false;
        } else {
            emailError.style.display = "none";
        }

        if (password.length < 6) {
            passwordError.style.display = "block";
            isValid = false;
        } else {
            passwordError.style.display = "none";
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
