<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar akun</title>
</head>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<body>
    <div class="layer">
    <h1>From Registrasi</h1><br>
    <h3>Daftar</h3><br><br>
    <form action="/daftar" method="POST">
        @csrf
        <input name="name" type="text" placeholder="Masukan nama" required><br>
        <input name="email" type="text" placeholder="Masukan email" required><br>
        <input name="password" type="password" placeholder="Masukan kata sandi" required><br>
        <input type="submit" value="Daftar" class="tombol">
        <p>Sudah memiliki akun? ayok <a href="/login">Login</a></p>
    </form>
    </div>
</body>
</html>