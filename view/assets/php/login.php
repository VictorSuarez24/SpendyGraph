<?php
include '../../../backend/config/config.php';

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); 
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE name = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];

            header("Location: ../../dashboard.html");
            exit();
        } else {
            echo "<script>
                    alert('Incorrect password');
                    window.location.href = '../../login.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User does not exist');
                window.location.href = '../../login.html';
              </script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>
