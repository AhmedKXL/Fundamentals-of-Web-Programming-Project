document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.querySelector('.edit-profile');
    const inputs = document.querySelectorAll('.input-field');
    const form = document.querySelector('#user-info');

    let editing = false;

    editButton.addEventListener('click', () => {
        if (!editing) {
            // Enable editing
            inputs.forEach(input => input.disabled = false);
            editButton.textContent = 'Save Changes';
            editing = true;
        } else {
            form.submit();
        }
    });
});
