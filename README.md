<<<<<<< HEAD
# PPL2025_B1
RDFARM : SISTEM INFORMASI PENJUALAN SUSU SAPI DAN LAPORAN PENJUALAN BERBASIS WEBSITE
=======
### Cara menjalankan project github PPL_B1 : 
### 1. Buka terminal dan jalankan
```bash
git clone https://github.com/YesaAditya/PPL_B1.git
cd PPL_B1
```
### 2. Jalankan Composer
```bash
composer install
```

### 3. Siapkan file env
```bash
cp .env.example .env
```

### 4. Generate app key
```bash
php artisan key:generate
```

### 5. Install npm
```bash
npm install
npm run build
```

### 6. Sesuaikan database di dengan nama DB_DATABASE. Jangan lupa menyalakan laragon/SAMP/ yang lain
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppl_b1
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Lalu buat table migrationnya
```bash
php artisan:migrate
```

### 8. Lalu isi tablenya dengan seeder
```bash
php artisan db:seed
```

### Program bisa dijalankan, apabila ada error dan lain sebagainya coba pakai ini
```bash
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```
