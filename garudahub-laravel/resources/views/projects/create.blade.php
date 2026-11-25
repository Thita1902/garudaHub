<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Proyek - GarudaHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        nav { background: #1e3a8a; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        nav button { background: #fff; color: #1e3a8a; border: 0; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
        main { max-width: 600px; margin: 32px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { margin-top: 0; font-size: 22px; }
        label { display: block; margin-top: 12px; font-size: 14px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
        textarea { min-height: 120px; }
        .row { display: flex; gap: 12px; }
        .row > div { flex: 1; }
        .error { color: #dc2626; font-size: 13px; margin-top: 4px; }
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
        <h1>Buat Proyek Baru</h1>

        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <label for="title">Judul</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title') <div class="error">{{ $message }}</div> @enderror

            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror

            <label for="category">Kategori (mis. Web, Mobile)</label>
            <input type="text" id="category" name="category" value="{{ old('category') }}" required>
            @error('category') <div class="error">{{ $message }}</div> @enderror

            <div class="row">
                <div>
                    <label for="budget_min">Budget minimum (Rp)</label>
                    <input type="number" id="budget_min" name="budget_min" value="{{ old('budget_min') }}" min="0" required>
                    @error('budget_min') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="budget_max">Budget maksimum (Rp)</label>
                    <input type="number" id="budget_max" name="budget_max" value="{{ old('budget_max') }}" min="0" required>
                    @error('budget_max') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <label for="deadline">Deadline</label>
            <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required>
            @error('deadline') <div class="error">{{ $message }}</div> @enderror

            <div class="actions">
                <button type="submit" class="btn">Simpan</button>
                <a href="{{ route('projects.index') }}" class="btn btn-gray">Batal</a>
            </div>
        </form>
    </main>
</body>
</html>