<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beri Rating - GarudaHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        nav { background: #1e3a8a; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        nav button { background: #fff; color: #1e3a8a; border: 0; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
        main { max-width: 600px; margin: 32px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { margin-top: 0; font-size: 22px; }
        label { display: block; margin-top: 12px; font-size: 14px; }
        select, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
        textarea { min-height: 100px; }
        .error { color: #dc2626; font-size: 13px; margin-top: 4px; }
        .meta { font-size: 14px; color: #6b7280; }
        .btn { background: #2563eb; color: #fff; padding: 10px 16px; border: 0; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-gray { background: #6b7280; }
        .actions { margin-top: 20px; }
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
        <h1>Beri Rating Developer</h1>
        <p class="meta">Proyek: {{ $project->title }}</p>

        <form method="POST" action="{{ route('ratings.store', $project) }}">
            @csrf

            <label for="score">Nilai (1 sampai 5)</label>
            <select id="score" name="score" required>
                <option value="">Pilih nilai</option>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ old('score') == $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                @endfor
            </select>
            @error('score')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="comment">Komentar (opsional)</label>
            <textarea id="comment" name="comment">{{ old('comment') }}</textarea>
            @error('comment')
                <div class="error">{{ $message }}</div>
            @enderror

            @error('rating')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="actions">
                <button type="submit" class="btn">Kirim Rating</button>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-gray">Kembali</a>
            </div>
        </form>
    </main>
</body>
</html>