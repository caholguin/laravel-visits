<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite('resources/css/app.css')
</head>
<body>
    


<div class="login-page">
    <div class="login-card">
        <h1>Iniciar sesión</h1>

        <form id="loginForm">
            @csrf
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" required>
                
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
                
            </div>

            <button type="submit" class="btn-primary">Entrar</button>
        </form>

        <p class="register-link">
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a>
        </p>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const response = await fetch("{{ route('auth.login') }}", {
        method: "POST",
        headers: {
            "Accept": "application/json"
        },
        body: formData
    });

    const data = await response.json();
    if (data.token) {
        localStorage.setItem("auth_token", data.token);     
        window.location.href = "/index";
    } else {
        alert("Error: " + JSON.stringify(data));
    }
});
</script>
</body>
</html>