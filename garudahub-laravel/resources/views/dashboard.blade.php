<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - GarudaHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        nav { background: #1e3a8a; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        nav button { background: #fff; color: #1e3a8a; border: 0; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
        main { max-width: 800px; margin: 32px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .badge { display: inline-block; background: #dbeafe; color: #1e40af; padding: 2px 10px; border-radius: 12px; font-size: 13px; }
        .btn { background: #2563eb; color: #fff; padding: 8px 14px; border-radius: 4px; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <nav>
        <div>
            <strong>GarudaHub</strong>
            <a href="{{ route('dashboard') }}" style="margin-left:24px;">Dashboard</a>
            <a href="{{ route('projects.index') }}">Proyek</a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Keluar</button>
        </form>
    </nav>

    <main>
        <h1>Halo, {{ auth()->user()->name }}!</h1>
        <p>Peran kamu: <span class="badge">{{ auth()->user()->role == 'client' ? 'Klien' : 'Developer' }}</span></p>
        <p><a class="btn" href="{{ route('projects.index') }}">Lihat Daftar Proyek</a></p>
    </main>
</body>
</html>