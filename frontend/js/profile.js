document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.querySelector('.edit-profile');
    const inputs = document.querySelectorAll('.input-field');

    let editing = false;

    editButton.addEventListener('click', () => {
        if (!editing) {
            // Enable editing
            inputs.forEach(input => input.disabled = false);
            editButton.textContent = 'Save Changes';
            editing = true;
        } else {
            // Collect data BEFORE disabling
            const formData = new FormData();
            inputs.forEach(input => {
                formData.append(input.name, input.value);
            });

            fetch('../php/update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                inputs.forEach(input => input.disabled = true);
                editButton.textContent = 'Edit Profile';
                editing = false;
            })
            .catch(err => console.error(err));
        }
    });
});
