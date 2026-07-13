CREATE DATABASE IF NOT EXISTS rentgo;
USE rentgo;

-- =========================
-- TABEL USERS
-- =========================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20),
    alamat TEXT,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- TABEL MOBIL
-- =========================

CREATE TABLE mobil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_mobil VARCHAR(100) NOT NULL,
    merk VARCHAR(100) NOT NULL,
    tahun INT NOT NULL,
    plat_nomor VARCHAR(20) NOT NULL,
    warna VARCHAR(50),
    transmisi ENUM('Manual','Matic') NOT NULL,
    bahan_bakar VARCHAR(50),
    kapasitas_penumpang INT,
    harga_per_hari DECIMAL(12,2) NOT NULL,
    foto VARCHAR(255),
    status ENUM('Tersedia','Disewa') DEFAULT 'Tersedia',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- TABEL BOOKING
-- =========================

CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mobil_id INT NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    total_hari INT NOT NULL,
    total_harga DECIMAL(12,2) NOT NULL,
    status ENUM(
        'Menunggu Pembayaran',
        'Dibayar',
        'Diproses',
        'Selesai',
        'Dibatalkan'
    ) DEFAULT 'Menunggu Pembayaran',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (mobil_id) REFERENCES mobil(id)
        ON DELETE CASCADE
);

-- =========================
-- TABEL PEMBAYARAN
-- =========================

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    metode_pembayaran VARCHAR(50),
    bukti_transfer VARCHAR(255),
    jumlah_bayar DECIMAL(12,2),
    status ENUM(
        'Menunggu Verifikasi',
        'Diterima',
        'Ditolak'
    ) DEFAULT 'Menunggu Verifikasi',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id) REFERENCES booking(id)
        ON DELETE CASCADE
);

-- =========================
-- TABEL REVIEW
-- =========================

CREATE TABLE review (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mobil_id INT NOT NULL,
    rating INT NOT NULL,
    komentar TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (mobil_id) REFERENCES mobil(id)
        ON DELETE CASCADE
);

-- =========================
-- DATA ADMIN DEFAULT
-- =========================

INSERT INTO users (
    nama,
    email,
    password,
    role
) VALUES (
    'Administrator',
    'admin@rentgo.com',
    MD5('admin123'),
    'admin'
);

-- =========================
-- DATA MOBIL CONTOH
-- =========================

INSERT INTO mobil (
    nama_mobil,
    merk,
    tahun,
    plat_nomor,
    warna,
    transmisi,
    bahan_bakar,
    kapasitas_penumpang,
    harga_per_hari
) VALUES

(
    'Avanza',
    'Toyota',
    2023,
    'BK1234AA',
    'Putih',
    'Manual',
    'Bensin',
    7,
    400000
),

(
    'Innova Reborn',
    'Toyota',
    2024,
    'BK5678BB',
    'Hitam',
    'Matic',
    'Diesel',
    7,
    550000
),

(
    'Alphard',
    'Toyota',
    2025,
    'BK9999AA',
    'Hitam',
    'Matic',
    'Bensin',
    7,
    1500000
);