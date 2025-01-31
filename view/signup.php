<?php
// Incluye el archivo de conexión a la base de datos
include '../backend/config/config.php'; // Asegúrate de tener tu conexión establecida correctamente

if (isset($_POST["submit"])) { // Verifica si el formulario ha sido enviado
    // Obtén los datos del formulario
    $name = $_POST["name"]; // Cambié de username a name
    $email = $_POST["email"]; // Cambié de username a email
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validar si los campos están vacíos
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo '<div>Todos los campos son requeridos.</div>';
    } else {
        // Verificar si las contraseñas coinciden
        if ($password !== $confirm_password) {
            echo '<div>Las contraseñas no coinciden.</div>';
        } else {
            // Verificar si el email ya existe en la base de datos
            $sql = $conexion->prepare("SELECT * FROM users WHERE email = ?");
            $sql->bind_param("s", $email);
            $sql->execute();
            $result = $sql->get_result();

            if ($result->num_rows > 0) {
                echo '<div>El email ya está registrado. Por favor, elige otro.</div>';
            } else {
                // Si el email no existe, creamos un nuevo usuario

                // Hashear la contraseña antes de guardarla
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el nuevo usuario en la base de datos
                $insert_sql = $conexion->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $insert_sql->bind_param("sss", $name, $email, $hashed_password);

                if ($insert_sql->execute()) {
                    echo '<div>¡Registro exitoso! Ahora puedes iniciar sesión.</div>';
                    // Redirigir al login después del registro exitoso
                    header("Location: login.html"); // Asegúrate de que login.html existe
                    exit(); // Detener el script después de la redirección
                } else {
                    echo '<div>Error al registrar al usuario: ' . $conexion->error . '</div>';
                }
            }
        }
    }
}
?>
