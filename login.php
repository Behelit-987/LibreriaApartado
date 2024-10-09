<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    include("./db-connect.php"); // Asegúrate de que esta línea esté presente

    $errores = array();

    $email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : null; 
    $password = (isset($_POST['password'])) ? $_POST['password'] : null;

    if(empty($email)) {
        $errores['email'] = "El campo email es requerido";        
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El email no es válido";
    }

    if(empty($password)) {
        $errores['password'] = "El campo password es requerido";
    }

    if (empty($errores)) {
        // Utiliza la conexión existente de db-connect.php
        $sql = "SELECT * FROM usuarios WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $login = false;
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION["usuario_id"] = $row["id"];
                $_SESSION["usuario_nombre"] = $row["nombres"];

                // Si el inicio de sesión es exitoso, establecer login a true
                $login = true;

                // Verificar el rol del usuario
                if ($row['rol'] == 'Usuario') {
                    header("Location: index.php");
                    exit();
                } elseif ($row['rol'] == 'Administrador') {
                    header("Location: index_adm.php");
                    exit();
                }
            }
        }

        // Si llega aquí, significa que el inicio de sesión falló
        echo '<script type="text/javascript">
        alert("El usuario no existe");
        window.location.href="login.html";
        </script>';

        $stmt->close();
        $conn->close();
    } else {
        foreach ($errores as $error) {
            echo "<br/>" . $error . "<br/>";
        }
        echo "<br/> <a href='./login.html'>Regresar al login</a>";
    }
}
?>

