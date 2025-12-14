document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.querySelector('.edit-profile');
    const inputs = document.querySelectorAll('.input-field');

    editButton.addEventListener('click', function () {
        const isEditing = this.textContent === 'Confirm Edits';
        
        // Toggle input fields
        inputs.forEach(input => {
            input.disabled = !isEditing;
        });
        
        if (isEditing) {
            // Change button text back to 'Edit Profile'
            this.textContent = 'Edit Profile';
            
            // Create a FormData object for sending data
            const formData = new FormData();
            inputs.forEach(input => {
                if (!input.disabled) {
                    formData.append(input.id, input.value);
                }
            });

            // Send data to PHP script
            fetch('saveProfile.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Display any response from the server
            })
            .catch(error => console.error('Error:', error));
        } else {
            // Change button text to 'Confirm Edits'
            this.textContent = 'Confirm Edits';
        }
    });
});
