# GarudaHub (Laravel)

Refactoring sistem lelang proyek IT mahasiswa dari PHP Native (spaghetti code) menjadi arsitektur **MVC** dengan **Laravel** dan **Eloquent ORM**.

## Fitur
- Daftar dan login manual (peran: klien atau developer)
- CRUD proyek (klien membuat, mengubah, menghapus proyek)
- Developer mengajukan penawaran (bid), satu kali per proyek
- Klien memilih pemenang: penawaran terpilih `accepted`, lainnya `rejected`, proyek jadi `awarded`

## Skema Database
- `users` (name, email, password, role: client/developer/admin)
- `projects` (client_id -> users, title, description, category, budget_min, budget_max, deadline, status)
- `bids` (project_id -> projects, developer_id -> users, price, duration_days, proposal, status)

Relasi Eloquent: User hasMany Project dan Bid; Project belongsTo User (client) dan hasMany Bid; Bid belongsTo Project dan User (developer).

## Cara Menjalankan
1. `composer install`
2. Salin `.env.example` menjadi `.env`, lalu atur koneksi MySQL (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
3. `php artisan key:generate`
4. `php artisan migrate --seed`
5. `php artisan serve`, lalu buka http://127.0.0.1:8000

## Akun Contoh (dari seeder)
| Peran | Email | Password |
|---|---|---|
| Klien | klien@garudahub.test | password123 |
| Developer | dev1@garudahub.test | password123 |
| Developer | dev2@garudahub.test | password123 |