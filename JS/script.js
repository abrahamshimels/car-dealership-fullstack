// JavaScript for G3 car dealership website

// Search Functionality
document.querySelector('.car-search').addEventListener('submit', function (e) {
    e.preventDefault();

    const selectedEngine = document.getElementById('engine').value;
    const selectedPrice = parseInt(document.getElementById('price').value);

    const cars = document.querySelectorAll('.car-list');
    cars.forEach((car) => {
        const carEngine = car.dataset.engine;
        const carPrice = parseInt(car.dataset.price);

        if (carEngine === selectedEngine && carPrice <= selectedPrice) {
            car.style.display = 'block';
        } else {
            car.style.display = 'none';
        }
    });
});

// Form Validation
function validateform() {
    // Get form inputs

    const form = document.getElementsByName('signUpForm')[0];
    const username = document.getElementsByName('signUpUsername')[0];
    const email = document.getElementsByName('signUpEmail')[0];
    const password = document.getElementsByName('signUpPassword')[0];
    const confirmPassword = document.getElementsByName('signUpCpassword')[0];

    // Check if all fields are filled
    if (
        !username.value.trim() ||
        !email.value.trim() ||
        !password.value.trim() ||
        !confirmPassword.value.trim()
    ) {
        alert('All fields are required.');
        return false;
    }

    var atposition = email.value.indexOf('@');
    var dotposition = email.value.lastIndexOf('.');

    // Ensure `@` exists, `.` exists, and they are in valid positions
    if (
        atposition < 1 ||
        dotposition < atposition + 2 ||
        dotposition + 2 >= email.value.length
    ) {
        alert(
            'Please enter a valid e-mail address.\nHint: "@" and "." must be in appropriate positions.'
        );
        return false;
    }

    //valid password
    if (password.value.length < 6 || password.value.length > 20) {
        alert(
            'the password length must be at least 6 characters and at most 20 characters'
        );
        return false;
    }
    if (password.value != confirmPassword.value) {
        alert('password and confirm password must be the same');
        return false;
    }
}

//contact form validation
function selectOption(button) {
    // Remove black background from all buttons
    const buttons = document.querySelectorAll('.contact-button');
    buttons.forEach((btn) => (btn.style.backgroundColor = ''));
    // Remove 'selected' class from all buttons
    buttons.forEach((btn) => btn.classList.remove('selected'));
    // Add 'selected' class to the clicked button
    button.classList.add('selected');
}

//process sign up
document.addEventListener('DOMContentLoaded', function () {
    document
        .querySelector('#signupForm')
        .addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent page reload

            let formData = new FormData(this); // Collect form data

            // Send data to PHP via AJAX
            fetch('process_signup.php', {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json()) // Convert response to JSON
                .then((data) => {
                    // Clear previous errors
                    document.querySelector('#usernameErr').textContent = '';
                    document.querySelector('#emailErr').textContent = '';
                    document.querySelector('#passwordErr').textContent = '';
                    document.querySelector('#confirmPasswordErr').textContent =
                        '';
                    document.querySelector('#agreeErr').textContent = '';
                    document.querySelector('#successMessage').textContent = '';

                    if (data.success) {
                        document.querySelector('#successMessage').textContent =
                            data.message;
                    } else {
                        if (data.errors.username)
                            document.querySelector('#usernameErr').textContent =
                                data.errors.username;
                        if (data.errors.email)
                            document.querySelector('#emailErr').textContent =
                                data.errors.email;
                        if (data.errors.password)
                            document.querySelector('#passwordErr').textContent =
                                data.errors.password;
                        if (data.errors.confirmPassword)
                            document.querySelector(
                                '#confirmPasswordErr'
                            ).textContent = data.errors.confirmPassword;
                        if (data.errors.agree)
                            document.querySelector('#agreeErr').textContent =
                                data.errors.agree;
                    }
                })
                .catch((error) => console.error('Error:', error));
        });
});
