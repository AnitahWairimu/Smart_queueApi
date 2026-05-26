document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registrationForm");
    const passwordInput = document.getElementById("password");
    const strengthBar = document.getElementById("strengthBar");
    const strengthText = document.getElementById("strengthText");
    
    // Real-time password strength checker
    passwordInput.addEventListener("input", function () {
        const val = passwordInput.value;
        let strength = 0;
        
        if (val.length > 5) strength += 1; // Length
        if (val.match(/[a-z]+/)) strength += 1; // Lowercase
        if (val.match(/[A-Z]+/)) strength += 1; // Uppercase
        if (val.match(/[0-9]+/)) strength += 1; // Number
        if (val.match(/[$@#&!]+/)) strength += 1; // Special char
        
        switch (strength) {
            case 0:
                strengthBar.style.width = "0%";
                strengthText.innerText = "";
                break;
            case 1:
            case 2:
                strengthBar.style.width = "40%";
                strengthBar.style.backgroundColor = "red";
                strengthText.innerText = "Weak";
                break;
            case 3:
            case 4:
                strengthBar.style.width = "75%";
                strengthBar.style.backgroundColor = "orange";
                strengthText.innerText = "Medium";
                break;
            case 5:
                strengthBar.style.width = "100%";
                strengthBar.style.backgroundColor = "green";
                strengthText.innerText = "Strong";
                break;
        }
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent form from submitting normally

        
        let isValid = true;
        
        // Input fields
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const role = document.getElementById("role").value;
        
        // Error message elements
        const nameError = document.getElementById("nameError");
        const emailError = document.getElementById("emailError");
        
        // Name Validation
        if (name.trim().length < 3) {
            nameError.style.display = "block";
            isValid = false;
        } else {
            nameError.style.display = "none";
        }
        
        // Email Validation (Simple Regex)
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            emailError.style.display = "block";
            isValid = false;
        } else {
            emailError.style.display = "none";
        }

        // Password Validation
        const passwordError = document.getElementById("passwordError");
        if (passwordInput.value.trim().length === 0) {
            passwordError.style.display = "block";
            isValid = false;
        } else {
            passwordError.style.display = "none";
        }
        
        if (isValid) {
            // Form is valid based on frontend checks.
            // Allow the form to submit to the backend PHP script.
            form.submit();
        }
    });
});

