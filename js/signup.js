function signup() {
    var formData = $('#signupForm').serialize();
    $.ajax({
        type: 'POST',
        url: 'signup_backend.php', 
        data: formData,
        success: function(response) {
            if (response === 'success') {
                alert('Signup successful! You can now log in.');
                window.location.href = 'login.html'; 
            } else {
                alert('Signup failed. Please try again.');
            }
        },
        error: function(error) {
            alert('Error during signup. Please try again.');
            console.log(error);
        }
    });
}