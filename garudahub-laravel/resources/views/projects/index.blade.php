<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Proyek - GarudaHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        nav { background: #1e3a8a; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        nav button { background: #fff; color: #1e3a8a; border: 0; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
        main { max-width: 900px; margin: 32px auto; padding: 0 16px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .btn { background: #2563eb; color: #fff; padding: 8px 14px; border: 0; border-radius: 4px; text-decoration: none; font-size: 14px; cursor: pointer; }
        .btn-gray { background: #6b7280; }
        .search { display: flex; gap: 8px; margin-top: 16px; }
        .search input { flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; margin-top: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .card h3 { margin: 0 0 6px; }
        .card h3 a { color: #2563eb; text-decoration: underline; }
        .meta { font-size: 13px; color: #6b7280; }
        .badge { display: inline-block; background: #dbeafe; color: #1e40af; padding: 2px 10px; border-radius: 12px; font-size: 12px; }
        .success { background: #dcfce7; color: #166534; padding: 10px 14px; border-radius: 4px; margin-top: 16px; }
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
        <div class="header">
            <h1>Daftar Proyek</h1>
            @if (auth()->user()->role === 'client')
                <a class="btn" href="{{ route('projects.create') }}">+ Buat Proyek</a>
            @endif
        </div>

        <form method="GET" action="{{ route('projects.index') }}" class="search">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari judul, deskripsi, atau kategori...">
            <button type="submit" class="btn">Cari</button>
            @if (!empty($q))
                <a href="{{ route('projects.index') }}" class="btn btn-gray">Reset</a>
            @endif
        </form>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @forelse ($projects as $project)
            <div class="card">
                <h3><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h3>
                <div class="meta">
                    Oleh {{ $project->client->name }}
                    &bull; Kategori: {{ $project->category }}
                    &bull; Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }} - Rp {{ number_format($project->budget_max, 0, ',', '.') }}
                    &bull; Deadline: {{ $project->deadline->format('d M Y') }}
                    &bull; <span class="badge">{{ $project->status }}</span>
                </div>
            </div>
        @empty
            <div class="card">{{ !empty($q) ? 'Tidak ada proyek yang cocok dengan pencarian.' : 'Belum ada proyek.' }}</div>
        @endforelse
    </main>
</body>
</html>