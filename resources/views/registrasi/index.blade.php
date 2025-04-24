<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi TOEIC</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            background-color: #f8f8f8;
        }
        header {
            background-color: #1e63f2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            border-radius: 0 0 50px 50px;
        }
        header img {
            height: 40px;
        }
        header nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: #e6f0ff;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            color: #1e63f2;
            margin-bottom: 25px;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #1e63f2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        footer {
            background-color: #1e63f2;
            text-align: center;
            color: white;
            padding: 10px;
            border-radius: 50px 50px 0 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; align-items: center;">
            <img src="https://upload.wikimedia.org/wikipedia/id/3/3a/Logo_Polinema.png" alt="TOEIC Logo">
            <span style="color:white; font-size: 20px; margin-left: 10px; font-weight: bold;">TOEIC</span>
        </div>
        <nav>
            <a href="#">Home</a>
            <a href="#">Registration Schedule</a>
            <a href="#">Results</a>
            <a href="#">Guide</a>
            <a href="#">Contact</a>
        </nav>
    </header>

    <div class="container">
        <h2>Form Registrasi TOEIC</h2>
        <form>
            <input type="text" placeholder="Nama" required>
            <input type="text" placeholder="NIM" required>
            <input type="text" placeholder="No. WA" required>
            <input type="text" placeholder="Pilih Jurusan" required>
            <input type="text" placeholder="Pilih Program Studi" required>
            <input type="file" placeholder="Scan KTP" required>
            <input type="file" placeholder="Scan KTM" required>
            <input type="file" placeholder="Pas Foto" required>
            <button type="submit">Daftar</button>
        </form>
    </div>

    <footer>
        Copyright © 2025 TOEIC
    </footer>
</body>
</html>
