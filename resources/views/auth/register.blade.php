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
    

<div class="register-page">
    <div class="register-card">
        <h1>Crear cuenta</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" required>
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" required>
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
                @error('password') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-primary">Registrarme</button>
        </form>

        <p class="login-link">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </p>
    </div>
</div>
</body>
</html>