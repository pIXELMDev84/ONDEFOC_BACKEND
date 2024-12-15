<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        /* Styles intégrés */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .login-box {
            background: white;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }

        .login-logo {
            width: 100px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .loginbtn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .loginbtn:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #e74c3c;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">

            <form id="loginForm">
                <input type="text" id="username" placeholder="Nom d'utilisateur" required>
                <input type="password" id="password" placeholder="Mot de passe" required>
                <button type="submit" class="loginbtn">Se connecter</button>
                <p id="errorMessage" class="error-message"></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            try {
                const response = await fetch("http://localhost:8000/api/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ username, password }),
                });

                const data = await response.json();

                if (response.ok && data.user) {
                    localStorage.setItem("user", JSON.stringify(data.user));

                    // Rediriger selon le rôle
                    if (data.user.role === "admin") {
                        window.location.href = "/dashboard";
                    } else if (data.user.role === "user") {
                        window.location.href = "/dashboardUser";
                    } else if (data.user.role === "magasinier") {
                        window.location.href = "/dashboardMagasinier";
                    } else {
                        errorMessage.textContent = "Rôle non reconnu.";
                    }
                } else {
                    errorMessage.textContent = data.message || "Nom d'utilisateur ou mot de passe incorrect";
                }
            } catch (error) {
                console.error("Erreur de connexion:", error);
                errorMessage.textContent = "Une erreur s'est produite. Veuillez réessayer plus tard.";
            }
        });
    </script>
</body>
</html>
