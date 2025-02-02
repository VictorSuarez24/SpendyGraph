<?php
// Incluir archivo de configuración
include '../../../backend/config/config.php';

// Verificar si el formulario ha sido enviado
if (isset($_POST["submit"])) {
    // Recibir y sanitizar los datos del formulario
    $username = trim(htmlspecialchars($_POST["username"]));
    $email = trim(htmlspecialchars($_POST["email"]));
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validar si los campos están vacíos
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        die('<div>All fields are required.</div>');
    }

    // Validar formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('<div>Invalid email format.</div>');
    }

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        die('<div>Passwords do not match.</div>');
    }

    // Comprobar si el email ya está registrado
    $sql = $conexion->prepare("SELECT id FROM users WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $sql->store_result();

    if ($sql->num_rows > 0) {
        die('<div>The email is already registered. Please choose another one.</div>');
    }

    // Encriptar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $insert_sql = $conexion->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $insert_sql->bind_param("sss", $username, $email, $hashed_password);

    if ($insert_sql->execute()) {
        // Redirigir al usuario a la página de inicio de sesión
        header("Location: ../../../view/login.html");
        exit();
    } else {
        die('<div>Error registering user: ' . $conexion->error . '</div>');
    }
}
?>
