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
