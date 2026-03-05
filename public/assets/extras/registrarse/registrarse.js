// Mostrar/ocultar contraseña
const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");
togglePassword.addEventListener("click", () => {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    togglePassword.classList.toggle("bi-eye-slash-fill");
});

// Mostrar/ocultar confirmar contraseña
const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
const confirmPassword = document.getElementById("confirmPassword");
toggleConfirmPassword.addEventListener("click", () => {
    const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
    confirmPassword.setAttribute("type", type);
    toggleConfirmPassword.classList.toggle("bi-eye-slash-fill");
});

// Validación en tiempo real
const passwordError = document.getElementById("passwordError");

function validatePasswords() {
    const mismatch = confirmPassword.value && password.value !== confirmPassword.value;
    passwordError.style.display = mismatch ? "block" : "none";
    confirmPassword.classList.toggle("input-error", mismatch);
}

password.addEventListener("input", validatePasswords);
confirmPassword.addEventListener("input", validatePasswords);

// Bloquear envío si no coinciden
document.getElementById("registerForm").addEventListener("submit", function (e) {
    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        passwordError.style.display = "block";
        confirmPassword.classList.add("input-error");
        confirmPassword.focus();
    }
});