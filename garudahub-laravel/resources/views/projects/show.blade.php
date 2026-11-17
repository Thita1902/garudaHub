<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->title }} - GarudaHub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        nav { background: #1e3a8a; color: #fff; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        nav button { background: #fff; color: #1e3a8a; border: 0; padding: 8px 14px; border-radius: 4px; cursor: pointer; }
        main { max-width: 800px; margin: 32px auto; padding: 0 16px; }
        .card { background: #fff; padding: 24px; border-radius: 8px; margin-top: 16px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { margin-top: 0; font-size: 24px; }
        h2 { font-size: 18px; margin-top: 0; }
        .meta { font-size: 14px; color: #6b7280; line-height: 1.8; }
        .badge { display: inline-block; background: #dbeafe; color: #1e40af; padding: 2px 10px; border-radius: 12px; font-size: 12px; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .btn { background: #2563eb; color: #fff; padding: 8px 14px; border: 0; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-red { background: #dc2626; }
        .btn-green { background: #16a34a; }
        .actions { margin-top: 16px; display: flex; gap: 8px; align-items: center; }
        .actions form { margin: 0; }
        .success { background: #dcfce7; color: #166534; padding: 10px 14px; border-radius: 4px; margin-top: 16px; }
        .error-box { background: #fee2e2; color: #991b1b; padding: 10px 14px; border-radius: 4px; margin-top: 16px; }
        .error { color: #dc2626; font-size: 13px; margin-top: 4px; }
        .bid { border-top: 1px solid #e5e7eb; padding: 12px 0; }
        label { display: block; margin-top: 12px; font-size: 14px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
        textarea { min-height: 90px; }
        .row { display: flex; gap: 12px; }
        .row > div { flex: 1; }
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
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @error('bid')
            <div class="error-box">{{ $message }}</div>
        @enderror

        <div class="card">
            <h1>{{ $project->title }}</h1>
            <div class="meta">
                Oleh {{ $project->client->name }}<br>
                Kategori: {{ $project->category }}<br>
                Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }} - Rp {{ number_format($project->budget_max, 0, ',', '.') }}<br>
                Deadline: {{ $project->deadline->format('d M Y') }}<br>
                Status: <span class="badge">{{ $project->status }}</span>
            </div>
            <p>{!! nl2br(e($project->description)) !!}</p>

            @if (auth()->id() === $project->client_id)
                <div class="actions">
                    <a class="btn" href="{{ route('projects.edit', $project) }}">Edit</a>
                    <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Yakin hapus proyek ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-red">Hapus</button>
                    </form>
                </div>
            @endif
        </div>

        @php
            $isDeveloper = auth()->user()->role === 'developer';
            $sudahMenawar = $isDeveloper && $project->bids->contains('developer_id', auth()->id());
        @endphp

        @if ($isDeveloper && $project->status === 'open' && ! $sudahMenawar)
            <div class="card">
                <h2>Ajukan Penawaran</h2>
                <form method="POST" action="{{ route('bids.store', $project) }}">
                    @csrf
                    <div class="row">
                        <div>
                            <label for="price">Harga (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" required>
                            @error('price')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="duration_days">Durasi (hari)</label>
                            <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days') }}" min="1" required>
                            @error('duration_days')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <label for="proposal">Proposal</label>
                    <textarea id="proposal" name="proposal" required>{{ old('proposal') }}</textarea>
                    @error('proposal')
                        <div class="error">{{ $message }}</div>
                    @enderror

                    <div class="actions">
                        <button type="submit" class="btn">Kirim Penawaran</button>
                    </div>
                </form>
            </div>
        @endif

        @if ($sudahMenawar)
            <div class="card"><p class="meta">Kamu sudah mengajukan penawaran untuk proyek ini.</p></div>
        @endif

        <div class="card">
            <h2>Penawaran ({{ $project->bids->count() }})</h2>
            @forelse ($project->bids as $bid)
                <div class="bid">
                    <strong>{{ $bid->developer->name }}</strong>
                    <span class="badge {{ $bid->status === 'accepted' ? 'badge-green' : ($bid->status === 'rejected' ? 'badge-red' : '') }}">{{ $bid->status }}</span>
                    <div class="meta">
                        Harga: Rp {{ number_format($bid->price, 0, ',', '.') }}
                        &bull; Durasi: {{ $bid->duration_days }} hari
                    </div>
                    <p>{!! nl2br(e($bid->proposal)) !!}</p>

                    @if (auth()->id() === $project->client_id && $project->status === 'open')
                        <form method="POST" action="{{ route('bids.accept', $bid) }}" onsubmit="return confirm('Pilih penawaran ini sebagai pemenang?')">
                            @csrf
                            <button type="submit" class="btn btn-green">Pilih Pemenang</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="meta">Belum ada penawaran.</p>
            @endforelse
        </div>
    </main>
</body>
</html>