-- phpMyAdmin SQL Dump
-- Database: `smkku`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1. STRUKTUR TABEL
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `informasi_sekolah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `konten` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- 2. PEMBERSIHAN DATA
-- --------------------------------------------------------
TRUNCATE TABLE `informasi_sekolah`;

-- --------------------------------------------------------
-- 3. PENGISIAN DATA FAKTUAL SMKN 1 KUTASARI & DATA TAMBAHAN
-- --------------------------------------------------------

INSERT INTO `informasi_sekolah` (`kategori`, `judul`, `konten`) VALUES
-- Kategori Profil & Budaya
('profil', 'Profil SMKN 1 Kutasari', 'Sekolah menengah kejuruan yang berlokasi di Purbalingga dengan visi menghasilkan lulusan bertaqwa, berkarakter unggul, professional, dan peduli lingkungan. Sekolah ini dipimpin oleh Bapak Sarjono, S.Pd.'),
('profil', 'Budaya Sekolah SIGAP', 'Budaya kerja SMKN 1 Kutasari adalah SIGAP yang merupakan singkatan dari Santun, Inovatif, Giat, Amanah, dan Percaya Diri.'),
('profil', 'Visi Sekolah', 'Menjadi Sekolah Menengah Kejuruan yang bertaqwa, berkarakter unggul, professional, berdaya saing dan peduli lingkungan hidup.'),
('profil', 'Misi Sekolah', 'Misi sekolah mencakup fasilitasi ibadah, layanan pendidikan berbudaya, disiplin tinggi, pembelajaran standar industri, dan optimalisasi Unit Produksi.'),

-- Kategori Jurusan / Program Keahlian
('jurusan', 'Teknik Komputer dan Jaringan (TKJ)', 'Berdiri sejak 2008, fokus pada kompetensi jaringan komputer. Merupakan mitra resmi Mikrotik Academy dan Cisco Academy.'),
('jurusan', 'Akuntansi dan Keuangan Lembaga (AKL)', 'Terakreditasi A, fokus pada ketelitian pengelolaan keuangan dan administrasi pajak. Bekerja sama dengan BPRS Buana Mitra Perwira.'),
('jurusan', 'Teknik Sepeda Motor (TSM)', 'Bekerja sama resmi dengan PT Yamaha Indonesia Motor Manufacturing (YIMM) untuk standarisasi kurikulum teknisi otomotif.'),
('jurusan', 'Desain Pemodelan dan Informasi Bangunan (DPIB)', 'Mempelajari perencanaan bangunan, gambar konstruksi, dan pemodelan 3D digital yang kreatif dan inovatif.'),
('jurusan', 'Teknik Pemanasan, Tata Udara, dan Pendinginan (TPTU)', 'Program keahlian khusus yang menyiapkan tenaga ahli sistem pendingin (AC) dan tata udara industri.'),

-- Kategori Fasilitas & Kontak
('fasilitas', 'Laboratorium & Bengkel', 'Tersedia Lab Komputer (Mikrotik & Cisco), Bengkel Yamaha, Lab Akuntansi, serta fasilitas pendukung pembelajaran berbasis industri lainnya.'),
('kerjasama', 'Kemitraan Industri', 'Sekolah memiliki kemitraan strategis dengan Yamaha, Mikrotik, Cisco, BPRS Buana Mitra Perwira, dan Panasonic.'),
('alamat', 'Lokasi Sekolah', 'SMK Negeri 1 Kutasari beralamat di Jalan Raya Kutasari, Kecamatan Kutasari, Kabupaten Purbalingga, Provinsi Jawa Tengah.'),
('kontak', 'Media Informasi', 'Informasi resmi dapat diakses melalui website www.smkn1kutasari.sch.id atau langsung mengunjungi kantor tata usaha sekolah.'),

-- Kategori Prestasi & Event
('prestasi', 'Prestasi Terbaru', 'Juara 1 FLS2N Cabang Monolog tingkat Kabupaten Purbalingga 2024 dan Juara LKS Bidang Akuntansi tingkat Kabupaten 2024.'),
('event', 'Kegiatan Sekolah', 'Sekolah aktif mengadakan Gelar Karya Siswa (P5), kunjungan industri, pembinaan karakter mental, dan donor darah rutin.'),

-- Kategori Jadwal (Tambahan/Simulasi)
('jadwal', 'Jadwal Kelas XI TKJ 1', 'Senin: Komputer Terapan & Jaringan Gas. Selasa: Administrasi Infrastruktur Jaringan. Rabu: Produk Kreatif & Kewirausahaan. Kamis: Bahasa Inggris & PJOK. Jumat: Agama & PKN.'),
('jadwal', 'Jadwal Kelas XI TKJ 2', 'Senin: Administrasi Sistem Jaringan. Selasa: Teknologi Layanan Jaringan. Rabu: Bahasa Indonesia & Matematika. Kamis: Kimia & Fisika. Jumat: Dasar Desain Grafis.'),
('jadwal', 'Jadwal Kelas X AKL', 'Senin: Akuntansi Dasar. Selasa: Perbankan Dasar. Rabu: Ekonomi Bisnis. Kamis: Aplikasi Pengolah Angka (Spreadsheet). Jumat: Etika Profesi.'),

-- Kategori Nilai (Tambahan/Simulasi)
('nilai', 'Standar KKM Sekolah', 'Kriteria Ketuntasan Minimal (KKM) untuk mata pelajaran produktif adalah 75, sedangkan untuk mata pelajaran umum (Normatif/Adaptif) adalah 70.'),
('nilai', 'Pengumuman Nilai UTS', 'Nilai UTS Semester Ganjil sudah dapat dilihat melalui wali kelas masing-masing atau melalui portal siakad sekolah mulai tanggal 20 Oktober.'),
('nilai', 'Sistem Penilaian PKL', 'Penilaian Praktik Kerja Lapangan (PKL) meliputi aspek teknis (60%) dan aspek non-teknis/sikap (40%) yang dinilai langsung oleh pembimbing industri.');

COMMIT;