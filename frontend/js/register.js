document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.login-container');

    form.addEventListener('submit', validateForm);
});

function validateForm(event) {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const dob = document.getElementById('dob').value;
    const usernameRegex = /^[a-zA-Z0-9]+$/; // Alphanumeric regex

    let valid = true;
    let messages = [];

    if (!username.match(usernameRegex)) {
        valid = false;
        messages.push('Username must be alphanumeric.');
    }

    if (password.trim() === '') {
        valid = false;
        messages.push('Password cannot be empty.');
    }

    if (!validateDOB(dob, messages)) { 
        valid = false;
    }

    if (!valid) {
        event.preventDefault(); // Prevent form submission
        alert(messages.join('\n')); // Show error messages
    }
}

function validateDOB(dob, messages) {
    if (dob) {
        const dobDate = new Date(dob);
        const currentDate = new Date();
        const age = currentDate.getFullYear() - dobDate.getFullYear();
        const minBirthYear = 1900;

        // Check if the birth date is valid
        if (dobDate < new Date(minBirthYear, 0, 1)) {
            messages.push('Birthdate must be after January 1st, 1900.');
            return false;
        }

        // Ensure the date of birth is not in the future
        if (dobDate > currentDate) {
            messages.push('Birthdate cannot be in the future.');
            return false;
        }

        // Check if the user is at least 7 years old
        if (age < 7 || 
            (age === 7 && (currentDate.getMonth() < dobDate.getMonth() || 
            (currentDate.getMonth() === dobDate.getMonth() && currentDate.getDate() < dobDate.getDate())))) {
            messages.push('You must be at least 7 years old.');
            return false;
        }

        return true;
    } else {
        messages.push('Please enter your date of birth.');
        return false; // No date provided
    }
}
