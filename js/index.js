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

// Open the login modal
function openLoginModal() {
    var modal = document.getElementById("loginModal");
    var form = document.getElementById("loginForm");
    var usernameInput = document.getElementById("username");
    var passwordInput = document.getElementById("password1");
    usernameInput.value = "";
    passwordInput.value = "";

    // Show the modal
	passwordInput.type = "password";
    modal.style.display = "block";
}
// Close the login modal
function closeLoginModal() {
    var modal = document.getElementById("loginModal");
    modal.style.display = "none";
}

// Prevent the form submission for now
document.addEventListener('DOMContentLoaded', function() {
    var diseaseAliases = document.querySelector('.result_item_alias');
    var aliasesText = diseaseAliases.textContent.split(': ')[1].split(', '); // Extract text and split by comma

    var bubbleContainer = document.createElement('p');
    bubbleContainer.classList.add('result_item_alias'); // Add the same class as the original <p> element

    var label = document.createElement('b');
    label.textContent = 'Disease alias:';
    bubbleContainer.appendChild(label); // Append the label to the container
    bubbleContainer.appendChild(document.createElement('br')); // Add line break

    aliasesText.forEach(function(alias, index) {
        var bubble = document.createElement('span');
        bubble.textContent = alias.trim(); // Trim any leading/trailing spaces
        bubble.classList.add('bubble');
        bubbleContainer.appendChild(bubble); // Append bubble to container
        if (index !== aliasesText.length - 1) {
            bubbleContainer.appendChild(document.createTextNode('')); // Add space separator
        }
    });

    diseaseAliases.parentNode.replaceChild(bubbleContainer, diseaseAliases); // Replace original with bubbles
});



