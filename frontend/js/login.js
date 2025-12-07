document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-container');

    form.addEventListener('submit', function(event) {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const usernameRegex = /^[a-zA-Z0-9]+$/; // Alphanumeric regex

        let valid = true;
        let messages = [];

        // Validate Username
        if (!username.match(usernameRegex)) {
            valid = false;
            messages.push('Username must be alphanumeric.');
        }

        // Validate Password
        if (password.trim() === '') {
            valid = false;
            messages.push('Password cannot be empty.');
        }

        // Display messages and prevent form submission if invalid
        if (!valid) {
            event.preventDefault(); // Prevent form submission
            alert(messages.join('\n')); // Show error messages
        }
    });
});