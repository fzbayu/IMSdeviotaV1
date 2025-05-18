<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
            background: linear-gradient(to bottom, #6c2bd9, #ffffff);
        }

        .main-container {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        .login-side {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
        }

        .rules-side {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-container {
            background-color: white;
            border-radius: 20px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: 80px;
        }

        .login-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c2bd9;
        }

        .form-group {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 20px;
            border: 1px solid #e0e0e0;
            background-color: #f8f8f8;
            font-size: 16px;
        }

        .form-group input:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(108, 43, 217, 0.3);
            border-color: #6c2bd9;
        }

        .login-button {
            background-color: #6200ea;
            color: white;
            padding: 12px 20px;
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: #5300c7;
        }

        .admin-login-btn {
            position: absolute;
            top: 45px;
            right: 30px;
            background-color: white;
            color: #7749f8;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .admin-login-btn:hover {
            background-color: #f8f8f8;
            color: #5c38cc;
        }

        .peraturan-container {
            background-color: white;
            color: #333;
            border-radius: 20px;
            padding: 30px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .peraturan-container h3 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #7749f8;
        }

        .peraturan-container ol {
            padding-left: 20px;
            color: #444;
        }

        .peraturan-container li {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .alert {
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Login Side -->
        <div class="login-side">
            <div class="login-container">
                <div class="logo">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo">
                </div>
                
                <div class="login-header">
                    <h2>LOGIN MAHASISWA</h2>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" id="loginForm" style="width: 100%;">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM" required>
                        @error('nim')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="NAMA LENGKAP" required>
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="login-button">LOGIN</button>
                </form>
            </div>
        </div>

        <!-- Rules Side -->
        <div class="rules-side">
            <a href="{{ route('admin.login') }}" class="admin-login-btn">
                Admin Login
            </a>

            <div class="peraturan-container">
                <h3>PERATURAN</h3>
                <ol>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac mattis urna. Aenean eget semper nisl.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac mattis urna. Aenean eget semper nisl.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac mattis urna. Aenean eget semper nisl.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac mattis urna. Aenean eget semper nisl.</li>
                </ol>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            localStorage.removeItem('sessionStartTime');
        });
    </script>
</body>
</html>