document.addEventListener('DOMContentLoaded', function() {
    const firstNameInput = document.getElementById('firstName');
    const lastNameInput = document.getElementById('lastName');
    const emailInput = document.getElementById('reg-email');
    const passwordInput = document.getElementById('reg-password');
    const confirmPasswordInput = document.getElementById('reg-confirmPassword');

    function validateUserName() {
        const firstNameValue = firstNameInput.value.trim();
        const lastNameValue = lastNameInput.value.trim();
        const firstNameRegex = /^[a-zA-Z0-9_-]{3,20}$/;
        const lastNameRegex = /^[a-zA-Z0-9_-]{3,20}$/;

        if (firstNameRegex.test(firstNameValue)) {
            firstNameInput.classList.remove('invalid');
            firstNameInput.classList.add('valid');
        } else {
            firstNameInput.classList.remove('valid');
            firstNameInput.classList.add('invalid');
        }

        if (lastNameRegex.test(lastNameValue)) {
            lastNameInput.classList.remove('invalid');
            lastNameInput.classList.add('valid');
        } else {
            lastNameInput.classList.remove('valid');
            lastNameInput.classList.add('invalid');
        }
    }

    function validateEmail() {
        const emailValue = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(emailValue)) {
            emailInput.classList.remove('invalid');
            emailInput.classList.add('valid');
        } else {
            emailInput.classList.remove('valid');
            emailInput.classList.add('invalid');
        }
    }

    function validatePassword() {
        const passwordValue = passwordInput.value;
        const passwordMessage = document.getElementById('password-message');

        // Liste complète des exigences du mot de passe
        const requirementsList = [
            "Le mot de passe doit avoir au moins 12 caractères",
            "Le mot de passe doit contenir au moins une lettre majuscule",
            "Le mot de passe doit contenir au moins une lettre minuscule",
            "Le mot de passe doit contenir au moins un chiffre",
            "Le mot de passe doit contenir au moins un caractère spécial parmi : ! @ # $ % ^ & * _ - + = ~ ` | \\ / : ; ?"
        ];

        if (passwordValue.length >= 12 &&
            /[a-z]/.test(passwordValue) &&
            /[A-Z]/.test(passwordValue) &&
            /[0-9]/.test(passwordValue) &&
            /[^a-zA-Z0-9]/.test(passwordValue)) {
            passwordInput.classList.remove('invalid');
            passwordInput.classList.add('valid');
            passwordMessage.innerHTML = ''; // Efface le message
        } else {
            passwordInput.classList.remove('valid');
            passwordInput.classList.add('invalid');
            passwordMessage.innerHTML = '<ul id="password-requirements"></ul>'; // Affiche la liste complète des exigences

            const passwordRequirements = document.getElementById('password-requirements');
            requirementsList.forEach(function(requirement) {
                const requirementItem = document.createElement('li');
                requirementItem.textContent = requirement;
                passwordRequirements.appendChild(requirementItem);
            });
        }
    }


    function validateConfirmPassword() {
        const confirmPasswordValue = confirmPasswordInput.value;
        const passwordValue = passwordInput.value;

        if (confirmPasswordValue === passwordValue && confirmPasswordValue.length >= 12) {
            confirmPasswordInput.classList.remove('invalid');
            confirmPasswordInput.classList.add('valid');
        } else {
            confirmPasswordInput.classList.remove('valid');
            confirmPasswordInput.classList.add('invalid');
        }
    }

    firstNameInput.addEventListener('input', validateUserName);
    lastNameInput.addEventListener('input', validateUserName);
    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', validatePassword);
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);
});
