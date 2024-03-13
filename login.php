<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario / Iniciar Sesión</title>
    <style>
        .login-form {
            display: <?php echo isset($_GET["register"]) ? 'none' : 'block'; ?>;
        }

        .register-form {
            display: <?php echo isset($_GET["register"]) ? 'block' : 'none'; ?>;
        }

        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
</head>
<body>
    <h2>Registro de Usuario / Iniciar Sesión</h2>

    <form class="login-form" id="login-form">
        <label for="login_user">Nombre de usuario:</label><br>
        <input type="text" id="login_user" name="login_user" required><br><br>
        
        <label for="login_pass">Contraseña:</label><br>
        <input type="password" id="login_pass" name="login_pass" required><br><br>
        
        <button type="submit">Iniciar Sesión</button>
        <div id="login-error-message" class="error-message" style="display: none;"></div>
    </form>


    <form class="register-form" id="register-form">
        <label for="register_username">Nombre de usuario:</label><br>
        <input type="text" id="register_username" name="register_username" required><br><br>
        
        <label for="register_password">Contraseña:</label><br>
        <input type="password" id="register_password" name="register_password" required><br><br>
        
        <button type="submit">Registrarse</button>
        <div id="register-error-message" class="error-message" style="display: none;"></div>
        <div id="register-success-message" class="success-message" style="display: none;"></div>
    </form>

    <p>¿No tienes cuenta? <a href="?register=true">Regístrate aquí</a>.</p>
    <p>¿Ya tienes cuenta? <a href="?">Inicia sesión aquí</a>.</p>

    <script>
        document.getElementById("login-form").addEventListener("submit", function(event) {
            event.preventDefault(); 

            const formData = new FormData(this);

            fetch("ajax.login.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data["res"] === "ok") {
                    window.location.href = "index.php";
                } else {
                    document.getElementById("login-error-message").innerText = "Autenticación fallida";
                    document.getElementById("login-error-message").style.display = "block";
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud:", error);
            });
        });

        document.getElementById("register-form").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("ajax.register.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data["success"] === true) {
                    document.getElementById("register-success-message").innerText = data["message"];
                    document.getElementById("register-success-message").style.display = "block";
                    document.getElementById("register-error-message").style.display = "none";
                } else {
                    document.getElementById("register-error-message").innerText = data["message"];
                    document.getElementById("register-error-message").style.display = "block";
                    document.getElementById("register-success-message").style.display = "none";
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud:", error);
            });
        });
    </script>
</body>
</html>
