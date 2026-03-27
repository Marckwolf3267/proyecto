function validarRegistro() {
    let nombre = document.getElementById('nombre').value.trim();
    let apellido = document.getElementById('apellido').value.trim();
    let email = document.getElementById('email').value.trim();
    let password = document.getElementById('password').value;

    if (!nombre || !apellido) {
        alert("Por favor ingrese nombre y apellido.");
        return false;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Por favor ingresa un correo con formato válido.");
        return false;
    }

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    if (!passwordRegex.test(password)) {
        alert("La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula y un número.");
        return false;
    }

    return true;
}