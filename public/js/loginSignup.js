// Forms
const login = document.getElementById("login");
const register = document.getElementById("register");

// Buttons
const showRegister = document.getElementById("showRegister");
const showLogin = document.getElementById("showLogin");

// Mostrar registro
showRegister.addEventListener("click", () => {

    login.classList.add("hidden");
    register.classList.remove("hidden");

});

// Mostrar login
showLogin.addEventListener("click", () => {

    register.classList.add("hidden");
    login.classList.remove("hidden");

});

// Imagen
const profileImage = document.getElementById("profileImage");
const profilePreview = document.getElementById("profilePreview");

profileImage.addEventListener("change", () => {
    const file = profileImage.files[0];

    if (file) {
        const imageURL = URL.createObjectURL(file);
        profilePreview.src = imageURL;

    }
});

// Login
document.getElementById("loginForm").addEventListener("submit", (event) => {
    event.preventDefault();
    window.location.href = "main.php";
});

// Registro
document.getElementById("registerForm").addEventListener("submit", (event) => {
    event.preventDefault();
});