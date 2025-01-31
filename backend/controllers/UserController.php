<?php
// Verificar si el formulario de login fue enviado
if (isset($_POST["submit"])) { 
    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validar si los campos están vacíos
    if (empty($username) || empty($password)) {
        echo '<div>"The fields are empty"</div>';
    } else {
        // Consultar el usuario en la base de datos
        $sql = $conexion->prepare("SELECT * FROM users WHERE usuario = ?");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_object();
            // Verificar si la contraseña es correcta
            if (password_verify($password, $user->password)) {
                // Redirigir al usuario a su área protegida
                header("Location: dashboard.php"); 
                exit();
            } else {
                echo '<div>"Access Denied"</div>';
            }
        } else {
            echo '<div>"User not found"</div>';
        }
    }
}
?>
