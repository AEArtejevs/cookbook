document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    loginForm.addEventListener('submit', function (e) {
        document.getElementById('error-email').textContent = '';
        document.getElementById('error-password').textContent = '';

        let hasError = false;

        const email = loginForm.querySelector('[name="email"]');
        const password = loginForm.querySelector('[name="password"]');

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
        }

        if (hasError) {
            e.preventDefault();
        }
    });
});
