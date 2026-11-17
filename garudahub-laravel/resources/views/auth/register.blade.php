<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - GarudaHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: #fff; padding: 32px; border-radius: 8px; width: 340px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { margin-top: 0; font-size: 22px; }
        label { display: block; margin-top: 12px; font-size: 14px; }
        input, select { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; margin-top: 20px; padding: 10px; background: #2563eb; color: #fff; border: 0; border-radius: 4px; cursor: pointer; }
        .error { color: #dc2626; font-size: 13px; margin-top: 4px; }
        p { font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Daftar Akun GarudaHub</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="role">Daftar sebagai</label>
            <select id="role" name="role" required>
                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Klien</option>
                <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>Developer</option>
            </select>
            @error('role')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password (min. 8 karakter)</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Ulangi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
</body>
</html>