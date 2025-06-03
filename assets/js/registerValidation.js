document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm');

    if (!registerForm) return;

    registerForm.addEventListener('submit', function (e) {
        // Clear previous messages
        document.getElementById('error-name').textContent = '';
        document.getElementById('error-email').textContent = '';
        document.getElementById('error-password').textContent = '';
        document.getElementById('error-password_confirmation').textContent = '';

        let hasError = false;

        const name = registerForm.querySelector('[name="name"]');
        const email = registerForm.querySelector('[name="email"]');
        const password = registerForm.querySelector('[name="password"]');
        const confirm = registerForm.querySelector('[name="password_confirmation"]');

        if (name.value.trim() === '') {
            document.getElementById('error-name').textContent = 'Name is required.';
            hasError = true;
        }

        if (email.value.trim() === '') {
            document.getElementById('error-email').textContent = 'Email is required.';
            hasError = true;
        } else {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email.value)) {
                document.getElementById('error-email').textContent = 'Invalid email format.';
                hasError = true;
            }
        }

        if (password.value.trim() === '') {
            document.getElementById('error-password').textContent = 'Password is required.';
            hasError = true;
        } else if (password.value.length < 6) {
            document.getElementById('error-password').textContent = 'Password must be at least 6 characters.';
            hasError = true;
        }

        if (confirm.value.trim() === '') {
            document.getElementById('error-password_confirmation').textContent = 'Please confirm your password.';
            hasError = true;
        } else if (password.value !== confirm.value) {
            document.getElementById('error-password_confirmation').textContent = 'Passwords do not match.';
            hasError = true;
        }

        if (hasError) {
            e.preventDefault(); // Stop form from submitting
        }
    });
});
