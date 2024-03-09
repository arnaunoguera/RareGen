function changeTextColor(button, newColor) {
	button.style.color = newColor;
}

function revertTextColor(button) {
	button.style.color = "";
}

function changeBackgroundColor(button, newColor) {
	button.style.backgroundColor = newColor;
}

function revertBackgroundColor(button) {
	button.style.backgroundColor = "";
}

function goToGene() {
	var searchInputValue = document.getElementById("searchInput").value;
	console.log("GENE + Search input value:", searchInputValue);
}

function goToDisease() {
	var searchInputValue = document.getElementById("searchInput").value;
	console.log("DIS + Search input value:", searchInputValue);
}

function goToOrg() {
	var searchInputValue = document.getElementById("searchInput").value;
	console.log("ORG + Search input value:", searchInputValue);
}

function Signup() {
	console.log("Signup");
}
function Login() {
	console.log("Login");
}

// function validateForm() {
// 	var inputField = document.getElementsByName('search')[0];
// 	var inputValue = inputField.value.trim();

// 	if (inputValue.length < 3) {
// 	alert('Please enter at least 3 characters in the search field.');
// 	return false;
// 	}

// 	return true;
// }

function validateForm() {
	var inputField = document.getElementsByName('search')[0];
	var inputValue = inputField.value.trim();
	var passwordError = document.getElementById("Error");

	if (inputValue.length < 3) {
		passwordError.textContent = "Please, enter at least 3 characters in the search field.";
		return false;
	}

	// Clear previous error message if all checks pass
	passwordError.textContent = "";
	return true;
}

function validateSignUp() {
	var username = document.getElementsByName("user")[0].value;
	var password1 = document.getElementById("password1").value;
	var password2 = document.getElementById("password2").value;
	var email = document.getElementsByName("email")[0].value;
	var country = document.getElementsByName("country")[0].value;
	var passwordError = document.getElementById("Error");

	// Check if any input field is empty
	if (username.trim() === '' || password1.trim() === '' || password2.trim() === '' || email.trim() === '' || country.trim() === '') {
		passwordError.textContent = "Error: all fields are compulsory.";
		return false; // Prevent form submission
	}

	// Check if email is valid
	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if (!emailRegex.test(email)) {
		passwordError.textContent = "Please enter a valid email address.";
		return false; // Prevent form submission
	}

	// Check if passwords match
	if (password1 !== password2) {
		passwordError.textContent = "Passwords do not match. Please try again.";
		return false; // Prevent form submission
	}

	// Clear previous error message if all checks pass
	passwordError.textContent = "";
	return true; // Allow form submission
}

// Function to clear error message when input fields are changed
document.querySelectorAll('input').forEach(input => {
	input.addEventListener('input', function() {
		var passwordError = document.getElementById("Error");
		passwordError.textContent = ""; // Clear error message
	});
});

function togglePasswordVisibility(passwordFieldId) {
	var passwordField = document.getElementById(passwordFieldId);
	if (passwordField) {
		if (passwordField.type === "password") {
			passwordField.type = "text";
		} else {
			passwordField.type = "password";
		}
	} else {
		console.log("Password field not found!");
	}
}

