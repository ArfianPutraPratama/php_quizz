-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 08, 2025 at 11:50 AM
-- Server version: 5.5.16
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neoquiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `device_id` varchar(100) NOT NULL,
  `level` int(11) NOT NULL,
  `quiz_ids` varchar(255) NOT NULL,
  `claim_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `username`, `device_id`, `level`, `quiz_ids`, `claim_date`) VALUES
(1, 'fian', 'AE3A.240806.019', 1, '1,2,3', '2025-03-24 09:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `level_number` int(11) NOT NULL,
  `is_completed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `quiz_id`, `level_number`, `is_completed`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 2, 1, 0),
(6, 2, 2, 0),
(7, 2, 3, 0),
(8, 2, 4, 0),
(9, 3, 1, 0),
(10, 3, 2, 0),
(11, 3, 3, 0),
(12, 3, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `level_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 1, 1, 'Apa kegunaan tag <meta charset=\"UTF-8\"> dalam HTML?', 'Menentukan warna latar belakang halaman', 'Menentukan jenis encoding karakter yang digunakan', 'Menghubungkan file CSS eksternal', 'Menambahkan gambar ke halaman web', 'B'),
(2, 1, 1, 'Apa fungsi dari tag <head> dalam HTML?', 'Menampilkan konten utama halaman', 'Mengatur metadata dan link ke file eksternal', 'Membuat daftar item', 'Menambahkan gambar ke halaman web', 'B'),
(3, 1, 1, 'Apa fungsi dari tag <title> dalam HTML?', 'Menampilkan judul halaman di browser', 'Menambahkan gambar ke halaman web', 'Membuat daftar item', 'Mengatur metadata', 'A'),
(4, 1, 1, 'Apa yang dimaksud dengan elemen <p> dalam HTML?', 'Membuat paragraf', 'Menampilkan gambar', 'Membuat tautan', 'Menambahkan tabel', 'A'),
(5, 1, 1, 'Apa fungsi dari atribut \"alt\" dalam tag <img>?', 'Menambahkan gambar latar belakang', 'Memberikan deskripsi gambar jika tidak bisa dimuat', 'Mengatur ukuran gambar', 'Menambahkan efek pada gambar', 'B'),
(6, 1, 2, 'Apa yang dimaksud dengan CSS?', 'Bahasa pemrograman untuk membuat animasi', 'Bahasa untuk mengatur tampilan dan gaya halaman web', 'Bahasa untuk mengatur database', 'Bahasa untuk membuat aplikasi mobile', 'B'),
(7, 1, 2, 'Apa fungsi dari property `margin` dalam CSS?', 'Mengatur warna latar belakang', 'Mengatur jarak antara elemen', 'Mengatur ukuran font', 'Mengatur posisi elemen', 'B'),
(8, 1, 2, 'Apa yang dimaksud dengan elemen <a> dalam HTML?', 'Membuat paragraf', 'Menampilkan gambar', 'Membuat tautan', 'Menambahkan tabel', 'C'),
(9, 1, 2, 'Apa kegunaan tag <ul> dalam HTML?', 'Membuat daftar berurutan', 'Membuat daftar tidak berurutan', 'Menampilkan tabel', 'Menambahkan gambar', 'B'),
(10, 1, 2, 'Apa perbedaan antara tag <strong> dan <b> dalam HTML?', '<strong> memiliki makna semantik, sedangkan <b> hanya untuk tampilan tebal', '<b> memiliki makna semantik, sedangkan <strong> hanya untuk tampilan tebal', 'Tidak ada perbedaan', 'Keduanya hanya digunakan untuk menampilkan teks miring', 'A'),
(11, 1, 3, 'Apa yang dimaksud dengan JavaScript?', 'Bahasa untuk mengatur database', 'Bahasa pemrograman untuk membuat halaman web interaktif', 'Bahasa untuk mengatur tampilan halaman web', 'Bahasa untuk membuat aplikasi mobile', 'B'),
(12, 1, 3, 'Apa fungsi dari method `addEventListener` dalam JavaScript?', 'Menambahkan elemen ke dalam DOM', 'Menambahkan event listener ke elemen', 'Menghapus elemen dari DOM', 'Mengubah style elemen', 'B'),
(13, 1, 3, 'Apa kegunaan tag <footer> dalam HTML?', 'Menampilkan menu navigasi', 'Menampilkan bagian akhir halaman', 'Menampilkan gambar', 'Menambahkan paragraf', 'B'),
(14, 1, 3, 'Apa yang dimaksud dengan tag <nav> dalam HTML?', 'Menampilkan paragraf', 'Menampilkan navigasi halaman', 'Menampilkan gambar', 'Menambahkan tabel', 'B'),
(15, 1, 3, 'Apa kegunaan tag <section> dalam HTML?', 'Membuat daftar tidak berurutan', 'Membagi halaman menjadi bagian atau blok', 'Menampilkan judul utama', 'Menambahkan efek pada teks', 'B'),
(16, 1, 4, 'Apa fungsi dari tag <h1> hingga <h6> dalam HTML?', 'Membuat paragraf', 'Menampilkan gambar', 'Membuat judul dengan tingkat berbeda', 'Menambahkan tabel', 'C'),
(17, 1, 4, 'Apa perbedaan antara tag <div> dan <span> dalam HTML?', '<div> adalah elemen blok, sedangkan <span> adalah elemen inline', '<span> adalah elemen blok, sedangkan <div> adalah elemen inline', 'Tidak ada perbedaan', 'Keduanya hanya digunakan untuk teks miring', 'A'),
(18, 1, 4, 'Apa fungsi dari atribut \"href\" dalam tag <a>?', 'Menentukan teks yang akan ditampilkan', 'Menentukan URL tujuan dari tautan', 'Menentukan ukuran teks', 'Menentukan warna tautan', 'B'),
(19, 1, 4, 'Apa yang dimaksud dengan tag <br> dalam HTML?', 'Membuat daftar', 'Membuat baris baru', 'Menampilkan teks tebal', 'Menambahkan tabel', 'B'),
(20, 1, 4, 'Apa kegunaan atribut \"target=\"_blank\"\" dalam tag <a>?', 'Membuka tautan di tab baru', 'Menambahkan gambar ke halaman', 'Menampilkan teks tebal', 'Mengubah ukuran tautan', 'A'),
(21, 2, 1, 'Apa yang dimaksud dengan Array dalam struktur data?', 'Kumpulan elemen dengan tipe data berbeda', 'Kumpulan elemen dengan tipe data sama yang berurutan', 'Struktur data berbasis pohon', 'Struktur data untuk tautan', 'B'),
(22, 2, 1, 'Apa fungsi dari Stack dalam struktur data?', 'Menyimpan data secara acak', 'Menyimpan data dengan prinsip LIFO', 'Menyimpan data dengan prinsip FIFO', 'Menyimpan data dalam pohon', 'B'),
(23, 2, 1, 'Apa itu Queue dalam struktur data?', 'Struktur data LIFO', 'Struktur data FIFO', 'Struktur data berbasis pohon', 'Struktur data untuk sorting', 'B'),
(24, 2, 1, 'Apa kegunaan Linked List?', 'Menyimpan data secara statis', 'Menyimpan data secara dinamis dengan tautan', 'Menyimpan data dalam array', 'Menyimpan data dalam tabel', 'B'),
(25, 2, 1, 'Apa itu algoritma pencarian biner?', 'Pencarian linier pada daftar', 'Pencarian pada daftar terurut dengan membagi dua', 'Pencarian acak', 'Pencarian berbasis pohon', 'B'),
(26, 2, 2, 'Apa yang dimaksud dengan Tree dalam struktur data?', 'Struktur data linier', 'Struktur data hierarkis dengan node', 'Struktur data berbasis array', 'Struktur data untuk antrian', 'B'),
(27, 2, 2, 'Apa fungsi dari operasi Push pada Stack?', 'Menghapus elemen', 'Menambahkan elemen ke atas stack', 'Mengurutkan elemen', 'Mencari elemen', 'B'),
(28, 2, 2, 'Apa itu operasi Pop pada Stack?', 'Menambahkan elemen', 'Menghapus elemen teratas dari stack', 'Mencari elemen', 'Mengurutkan elemen', 'B'),
(29, 2, 2, 'Apa yang dimaksud dengan Graph?', 'Struktur data linier', 'Struktur data dengan node dan edge', 'Struktur data berbasis array', 'Struktur data untuk antrian', 'B'),
(30, 2, 2, 'Apa kegunaan algoritma BFS?', 'Pencarian mendalam', 'Pencarian lebar pada graph', 'Pengurutan data', 'Penambahan node', 'B'),
(31, 2, 3, 'Apa yang dimaksud dengan Hash Table?', 'Struktur data untuk pencarian berbasis kunci', 'Struktur data berbasis pohon', 'Struktur data untuk antrian', 'Struktur data linier', 'A'),
(32, 2, 3, 'Apa itu Collision dalam Hash Table?', 'Ketika dua kunci memiliki nilai yang sama', 'Ketika dua kunci di-hash ke indeks yang sama', 'Ketika tabel penuh', 'Ketika kunci dihapus', 'B'),
(33, 2, 3, 'Apa fungsi dari Heap?', 'Mengurutkan data secara acak', 'Menyimpan data dalam struktur prioritas', 'Menyimpan data dalam antrian', 'Mencari data secara linier', 'B'),
(34, 2, 3, 'Apa itu Binary Tree?', 'Pohon dengan maksimum dua anak per node', 'Pohon dengan satu anak per node', 'Pohon dengan banyak anak per node', 'Pohon tanpa anak', 'A'),
(35, 2, 3, 'Apa kegunaan algoritma DFS?', 'Pencarian lebar', 'Pencarian mendalam pada graph', 'Pengurutan data', 'Penambahan node', 'B'),
(36, 2, 4, 'Apa yang dimaksud dengan Sorting?', 'Mencari data', 'Mengurutkan data', 'Menghapus data', 'Menambahkan data', 'B'),
(37, 2, 4, 'Apa itu Bubble Sort?', 'Algoritma pengurutan dengan pertukaran berulang', 'Algoritma pencarian', 'Algoritma penambahan', 'Algoritma penghapusan', 'A'),
(38, 2, 4, 'Apa fungsi dari Quick Sort?', 'Mengurutkan data dengan membagi dan menaklukkan', 'Mencari data', 'Menghapus data', 'Menambahkan data', 'A'),
(39, 2, 4, 'Apa yang dimaksud dengan Big-O Notation?', 'Notasi untuk efisiensi waktu algoritma', 'Notasi untuk ukuran data', 'Notasi untuk tipe data', 'Notasi untuk struktur data', 'A'),
(40, 2, 4, 'Apa kegunaan algoritma Merge Sort?', 'Pencarian data', 'Pengurutan data dengan membagi dan menggabungkan', 'Penghapusan data', 'Penambahan data', 'B'),
(41, 3, 1, 'Apa yang dimaksud dengan UI?', 'User Interaction', 'User Interface', 'User Integration', 'User Investigation', 'B'),
(42, 3, 1, 'Apa itu UX?', 'User Experience', 'User Extension', 'User Extraction', 'User Execution', 'A'),
(43, 3, 1, 'Apa fungsi dari Wireframe dalam UI/UX?', 'Membuat kode aplikasi', 'Membuat desain kasar tata letak', 'Menguji aplikasi', 'Mempromosikan aplikasi', 'B'),
(44, 3, 1, 'Apa yang dimaksud dengan Prototype dalam UX?', 'Desain akhir aplikasi', 'Model interaktif untuk pengujian', 'Kode sumber aplikasi', 'Dokumentasi aplikasi', 'B'),
(45, 3, 1, 'Apa kegunaan User Testing?', 'Mendesain aplikasi', 'Menguji pengalaman pengguna', 'Mempromosikan aplikasi', 'Mengkode aplikasi', 'B'),
(46, 3, 2, 'Apa yang dimaksud dengan Usability?', 'Keindahan desain', 'Kemudahan penggunaan produk', 'Kecepatan aplikasi', 'Keamanan aplikasi', 'B'),
(47, 3, 2, 'Apa itu Persona dalam UX?', 'Pengguna nyata', 'Karakter fiktif yang mewakili pengguna', 'Desainer aplikasi', 'Penguji aplikasi', 'B'),
(48, 3, 2, 'Apa fungsi dari Color Theory dalam UI?', 'Meningkatkan kecepatan aplikasi', 'Memilih warna yang mendukung pengalaman pengguna', 'Membuat animasi', 'Menguji aplikasi', 'B'),
(49, 3, 2, 'Apa yang dimaksud dengan Responsive Design?', 'Desain yang responsif terhadap emosi pengguna', 'Desain yang menyesuaikan dengan ukuran layar', 'Desain yang cepat', 'Desain yang aman', 'B'),
(50, 3, 2, 'Apa kegunaan Typography dalam UI?', 'Meningkatkan kecepatan aplikasi', 'Meningkatkan keterbacaan dan estetika', 'Menguji aplikasi', 'Mempromosikan aplikasi', 'B'),
(51, 3, 3, 'Apa yang dimaksud dengan Accessibility dalam UI/UX?', 'Kecepatan aplikasi', 'Kemudahan akses untuk semua pengguna', 'Keindahan desain', 'Keamanan aplikasi', 'B'),
(52, 3, 3, 'Apa fungsi dari User Flow?', 'Mendesain aplikasi', 'Memetakan perjalanan pengguna', 'Menguji kecepatan', 'Mempromosikan aplikasi', 'B'),
(53, 3, 3, 'Apa itu A/B Testing?', 'Pengujian dua versi untuk membandingkan hasil', 'Pengujian kecepatan aplikasi', 'Pengujian keamanan', 'Pengujian kode', 'A'),
(54, 3, 3, 'Apa yang dimaksud dengan Consistency dalam UI?', 'Penggunaan elemen yang sama secara berulang', 'Kecepatan aplikasi', 'Keindahan desain', 'Keamanan aplikasi', 'A'),
(55, 3, 3, 'Apa kegunaan Feedback dalam UX?', 'Memberikan informasi kepada pengguna tentang tindakan mereka', 'Meningkatkan kecepatan', 'Mendesain aplikasi', 'Mempromosikan aplikasi', 'A'),
(56, 3, 4, 'Apa yang dimaksud dengan Heuristic Evaluation?', 'Pengujian kecepatan aplikasi', 'Evaluasi UI berdasarkan prinsip heuristik', 'Pengujian keamanan', 'Pengujian kode', 'B'),
(57, 3, 4, 'Apa fungsi dari Information Architecture?', 'Meningkatkan kecepatan', 'Menyusun informasi agar mudah dipahami', 'Mendesain aplikasi', 'Menguji aplikasi', 'B'),
(58, 3, 4, 'Apa yang dimaksud dengan Microinteraction?', 'Interaksi besar dalam aplikasi', 'Interaksi kecil yang meningkatkan pengalaman', 'Interaksi keamanan', 'Interaksi kode', 'B'),
(59, 3, 4, 'Apa kegunaan Design System?', 'Meningkatkan kecepatan aplikasi', 'Menyediakan panduan desain yang konsisten', 'Menguji aplikasi', 'Mempromosikan aplikasi', 'B'),
(60, 3, 4, 'Apa yang dimaksud dengan Empathy Map?', 'Peta untuk memahami kebutuhan pengguna', 'Peta kecepatan aplikasi', 'Peta desain aplikasi', 'Peta keamanan aplikasi', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `question_count` int(11) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `icon_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `subtitle`, `description`, `question_count`, `duration`, `icon_path`) VALUES
(1, 'Pemrograman Web', 'Pertanyaan Pilihan Ganda', 'Pemrograman Web untuk melatih jawaban kuis pemrograman web dasar.', 20, '25 Menit', 'assets/images/Web.png'),
(2, 'Struktur Data', 'Pertanyaan Pilihan Ganda', 'Struktur data untuk melatih jawaban kuis Struktur Data dasar.', 20, '25 Menit', 'assets/images/Struktur_Data.png'),
(3, 'UI - UX', 'Pertanyaan Pilihan Ganda', 'UI - UX untuk melatih jawaban kuis UI - UX dasar.', 20, '25 Menit', 'assets/images/UX_design.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `device_id`, `username`) VALUES
(1, 'AE3A.240806.019', 'fian'),
(2, 'TP1A.220624.014', 'yayan');

-- --------------------------------------------------------

--
-- Table structure for table `user_level_completions`
--

CREATE TABLE `user_level_completions` (
  `id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `completed_questions` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_level_completions`
--

INSERT INTO `user_level_completions` (`id`, `device_id`, `quiz_id`, `level`, `completed`, `completed_questions`) VALUES
(1, 'AE3A.240806.019', 1, 1, 1, '1,2,3,4,5'),
(2, 'AE3A.240806.019', 2, 1, 1, '21,22,23,24,25'),
(3, 'AE3A.240806.019', 3, 1, 1, '41,42,43,44,45'),
(4, 'AE3A.240806.019', 1, 2, 1, '6,7,8,9,10'),
(5, 'AE3A.240806.019', 2, 2, 1, '26,27,28,29,30'),
(6, 'AE3A.240806.019', 3, 2, 1, '46,47,48,49,50'),
(7, 'AE3A.240806.019', 1, 3, 1, '11,12,13,14,15'),
(8, 'AE3A.240806.019', 2, 3, 1, '31,32,33,34,35'),
(9, 'AE3A.240806.019', 3, 3, 1, '51,52,53,54,55'),
(11, 'AE3A.240806.019', 1, 4, 1, '16,17,18,19,20'),
(18, 'TP1A.220624.014', 1, 1, 1, '1,2,3,4,5'),
(19, 'AE3A.240806.019', 2, 4, 1, '36,37,38,39,40');

-- --------------------------------------------------------

--
-- Table structure for table `user_question_completions`
--

CREATE TABLE `user_question_completions` (
  `id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_scores`
--

CREATE TABLE `user_scores` (
  `id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_scores`
--

INSERT INTO `user_scores` (`id`, `device_id`, `quiz_id`, `level`, `score`) VALUES
(1, 'AE3A.240806.019', 1, 1, 60),
(2, 'AE3A.240806.019', 2, 1, 100),
(3, 'AE3A.240806.019', 3, 1, 100),
(4, 'AE3A.240806.019', 1, 2, 80),
(5, 'AE3A.240806.019', 2, 2, 100),
(6, 'AE3A.240806.019', 3, 2, 100),
(7, 'AE3A.240806.019', 1, 3, 100),
(8, 'AE3A.240806.019', 2, 3, 60),
(9, 'AE3A.240806.019', 3, 3, 100),
(11, 'AE3A.240806.019', 1, 4, 20),
(18, 'TP1A.220624.014', 1, 1, 80),
(19, 'AE3A.240806.019', 2, 4, 40);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_id` (`device_id`);

--
-- Indexes for table `user_level_completions`
--
ALTER TABLE `user_level_completions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_id` (`device_id`,`quiz_id`,`level`);

--
-- Indexes for table `user_question_completions`
--
ALTER TABLE `user_question_completions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_id` (`device_id`,`quiz_id`,`level`,`question_id`);

--
-- Indexes for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_id` (`device_id`,`quiz_id`,`level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_level_completions`
--
ALTER TABLE `user_level_completions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_question_completions`
--
ALTER TABLE `user_question_completions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_scores`
--
ALTER TABLE `user_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `levels_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_level_completions`
--
ALTER TABLE `user_level_completions`
  ADD CONSTRAINT `user_level_completions_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `users` (`device_id`);

--
-- Constraints for table `user_question_completions`
--
ALTER TABLE `user_question_completions`
  ADD CONSTRAINT `user_question_completions_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `users` (`device_id`);

--
-- Constraints for table `user_scores`
--
ALTER TABLE `user_scores`
  ADD CONSTRAINT `user_scores_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `users` (`device_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
