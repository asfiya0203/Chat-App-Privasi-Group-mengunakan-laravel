<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<body>
    <div class="layer">
        <h1>App Chat</h1><br>
        <h3>Login</h3><br><br>
        <form action="/login" method="post">
            @csrf
            <input name="name" type="text" placeholder="Masukan username" required><br>
            <input name="email" type="text" placeholder="Masukan email" required><br>
            <input name="password" type="password" placeholder="Masukan password" required><br>

            <input type="submit" value="Login" class="tombol">
            <p>Belum memiliki akun, ayok <a href="/daftar">Daftar</a></p>
        </form>
    </div>
</body>
</html>