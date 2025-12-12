-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Des 2025 pada 03.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `category_id`, `image_path`, `created_at`) VALUES
(1, 'Tutorial naik gunung untuk pemula', '<p data-start=\"98\" data-end=\"423\">Naik gunung bukan cuma soal menaklukkan puncak, tapi juga tentang bagaimana kita menikmati perjalanan, menjaga keselamatan, dan menghormati alam. Buat para pemula, pendakian pertama bisa jadi pengalaman luar biasa &mdash; asal dilakukan dengan cara yang benar. Nah, berikut ini beberapa <strong data-start=\"379\" data-end=\"422\">cara naik gunung yang baik untuk pemula</strong>.</p>\r\n<hr data-start=\"425\" data-end=\"428\">\r\n<h3 data-start=\"430\" data-end=\"471\">1. 🔍 <strong data-start=\"440\" data-end=\"471\">Persiapkan Fisik dan Mental</strong></h3>\r\n<p data-start=\"472\" data-end=\"798\">Sebelum mendaki, pastikan tubuh dalam kondisi prima. Lakukan latihan ringan seperti jogging, bersepeda, atau naik turun tangga beberapa minggu sebelumnya untuk melatih stamina dan pernapasan.<br data-start=\"663\" data-end=\"666\">Selain itu, mental juga penting &mdash; jangan mudah panik atau menyerah di tengah jalan. Gunung bukan tempat buat &ldquo;coba-coba tanpa siap&rdquo;.</p>\r\n<hr data-start=\"800\" data-end=\"803\">\r\n<h3 data-start=\"805\" data-end=\"847\">2. 🎒 <strong data-start=\"815\" data-end=\"847\">Bawa Perlengkapan yang Tepat</strong></h3>\r\n<p data-start=\"848\" data-end=\"981\">Gunung bukan mall, jadi bawa perlengkapan yang benar-benar dibutuhkan aja. Beberapa perlengkapan dasar yang wajib dibawa antara lain:</p>\r\n<ul data-start=\"982\" data-end=\"1205\">\r\n<li data-start=\"982\" data-end=\"1009\">\r\n<p data-start=\"984\" data-end=\"1009\">Carrier atau tas gunung</p>\r\n</li>\r\n<li data-start=\"1010\" data-end=\"1039\">\r\n<p data-start=\"1012\" data-end=\"1039\">Jaket tebal dan jas hujan</p>\r\n</li>\r\n<li data-start=\"1040\" data-end=\"1088\">\r\n<p data-start=\"1042\" data-end=\"1088\">Sepatu gunung atau sepatu olahraga yang kuat</p>\r\n</li>\r\n<li data-start=\"1089\" data-end=\"1116\">\r\n<p data-start=\"1091\" data-end=\"1116\">Sleeping bag dan matras</p>\r\n</li>\r\n<li data-start=\"1117\" data-end=\"1141\">\r\n<p data-start=\"1119\" data-end=\"1141\">Senter atau headlamp</p>\r\n</li>\r\n<li data-start=\"1142\" data-end=\"1180\">\r\n<p data-start=\"1144\" data-end=\"1180\">Alat masak dan logistik secukupnya</p>\r\n</li>\r\n<li data-start=\"1181\" data-end=\"1205\">\r\n<p data-start=\"1183\" data-end=\"1205\">Obat pribadi dan P3K</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1207\" data-end=\"1302\">Pastikan barang-barang dikemas rapi dan tidak berlebihan biar nggak membebani selama pendakian.</p>\r\n<hr data-start=\"1304\" data-end=\"1307\">\r\n<h3 data-start=\"1309\" data-end=\"1353\">3. ⛰️ <strong data-start=\"1319\" data-end=\"1353\">Pilih Gunung yang Sesuai Level</strong></h3>\r\n<p data-start=\"1354\" data-end=\"1469\">Buat pemula, pilih gunung dengan jalur pendakian yang relatif mudah dan fasilitas basecamp yang lengkap. Contohnya:</p>\r\n<ul data-start=\"1470\" data-end=\"1570\">\r\n<li data-start=\"1470\" data-end=\"1491\">\r\n<p data-start=\"1472\" data-end=\"1491\">Gunung Prau (Dieng)</p>\r\n</li>\r\n<li data-start=\"1492\" data-end=\"1519\">\r\n<p data-start=\"1494\" data-end=\"1519\">Gunung Papandayan (Garut)</p>\r\n</li>\r\n<li data-start=\"1520\" data-end=\"1546\">\r\n<p data-start=\"1522\" data-end=\"1546\">Gunung Andong (Magelang)</p>\r\n</li>\r\n<li data-start=\"1547\" data-end=\"1570\">\r\n<p data-start=\"1549\" data-end=\"1570\">Gunung Batur (Bali)</p>\r\n</li>\r\n</ul>\r\n<p data-start=\"1572\" data-end=\"1682\">Naik gunung bukan soal siapa yang lebih tinggi, tapi siapa yang lebih bijak memilih jalur sesuai kemampuannya.</p>\r\n<hr data-start=\"1684\" data-end=\"1687\">\r\n<h3 data-start=\"1689\" data-end=\"1729\">4. 🚶&zwj;♀️ <strong data-start=\"1702\" data-end=\"1729\">Jaga Ritme Saat Mendaki</strong></h3>\r\n<p data-start=\"1730\" data-end=\"1980\">Nggak perlu terburu-buru. Nikmati setiap langkah, atur napas, dan istirahat secukupnya. Kalau mulai pusing, kedinginan, atau sesak napas, jangan dipaksakan.<br data-start=\"1886\" data-end=\"1889\">Gunakan sistem &ldquo;jalan 30 menit, istirahat 5 menit&rdquo; biar stamina tetap stabil sampai puncak.</p>\r\n<hr data-start=\"1982\" data-end=\"1985\">\r\n<h3 data-start=\"1987\" data-end=\"2032\">5. 🗑️ <strong data-start=\"1998\" data-end=\"2032\">Jaga Kebersihan dan Etika Alam</strong></h3>\r\n<p data-start=\"2033\" data-end=\"2326\">Ingat prinsip penting pendaki: <strong data-start=\"2064\" data-end=\"2084\">&ldquo;Leave no trace&rdquo;</strong> &mdash; jangan tinggalkan apa pun selain jejak, jangan ambil apa pun selain foto, dan jangan bunuh apa pun selain waktu.<br data-start=\"2199\" data-end=\"2202\">Bawa kembali sampahmu, jangan buang di jalur pendakian. Hargai alam dan sesama pendaki, jangan berisik atau merusak tanaman.</p>\r\n<hr data-start=\"2328\" data-end=\"2331\">\r\n<h3 data-start=\"2333\" data-end=\"2382\">6. 🧭 <strong data-start=\"2343\" data-end=\"2382\">Ikuti Aturan dan Petunjuk Pendakian</strong></h3>\r\n<p data-start=\"2383\" data-end=\"2684\">Setiap gunung punya peraturan sendiri, termasuk jam buka-tutup jalur dan batas pendakian. Laporkan diri di basecamp, isi buku registrasi, dan dengarkan briefing dari petugas.<br data-start=\"2557\" data-end=\"2560\">Kalau pendakian sudah ditutup karena cuaca buruk, jangan nekat &mdash; keselamatan jauh lebih penting dari sekadar foto di puncak.</p>\r\n<hr data-start=\"2686\" data-end=\"2689\">\r\n<h3 data-start=\"2691\" data-end=\"2737\">7. 🤝 <strong data-start=\"2701\" data-end=\"2737\">Pendakian Lebih Aman Bersama Tim</strong></h3>\r\n<p data-start=\"2738\" data-end=\"2955\">Buat pemula, sebaiknya jangan mendaki sendirian. Ikutlah bersama teman yang sudah berpengalaman atau gabung dengan komunitas pendaki. Dengan begitu, lu bisa belajar banyak hal dan lebih aman kalau terjadi hal darurat.</p>\r\n<hr data-start=\"2957\" data-end=\"2960\">\r\n<h3 data-start=\"2962\" data-end=\"2983\">🌄 <strong data-start=\"2969\" data-end=\"2983\">Kesimpulan</strong></h3>\r\n<p data-start=\"2984\" data-end=\"3206\">Naik gunung adalah aktivitas yang menantang tapi juga menenangkan. Dengan persiapan yang matang, perlengkapan yang pas, serta sikap menghormati alam, pendakian pertama lu bakal jadi pengalaman yang berkesan &mdash; bukan trauma.</p>', 1, 'uploads/68ee46f2a0c3f-Konsep Pendaki Gunung, Lintas Alam, Trekking, Gunung PNG Transparan dan Clipart untuk Unduhan Gratis.jpg', '2025-10-14 12:49:54'),
(2, 'Cara Move on dengan baik', '<h2 data-start=\"239\" data-end=\"290\">Cara Move On dari Crush yang Nggak Kenal Kita</h2>\r\n<p data-start=\"292\" data-end=\"678\">Kadang yang paling susah dilupain bukan mantan, tapi orang yang bahkan <strong data-start=\"363\" data-end=\"395\">nggak pernah jadi milik kita</strong>.<br data-start=\"396\" data-end=\"399\">Rasanya absurd, ya &mdash; suka, mikirin, sampai senyum-senyum sendiri, padahal dia mungkin nggak tahu nama kita siapa. Tapi tenang, bukan lu doang kok yang pernah ngerasain itu. Yuk, kita bahas gimana cara <strong data-start=\"600\" data-end=\"644\">move on dari crush yang nggak kenal kita</strong> dengan cara yang sehat dan waras.</p>\r\n<hr data-start=\"680\" data-end=\"683\">\r\n<h3 data-start=\"685\" data-end=\"737\">1. 🧠 <strong data-start=\"695\" data-end=\"737\">Sadari Kalau yang Lu Rasain Itu Normal</strong></h3>\r\n<p data-start=\"738\" data-end=\"1022\">Pertama-tama, jangan nyalahin diri sendiri. Wajar banget kalau bisa naksir seseorang cuma karena senyumnya, caranya ngomong, atau bahkan vibe-nya.<br data-start=\"884\" data-end=\"887\">Crush itu bentuk kagum &mdash; bukan dosa, bukan kelemahan. Tapi yang penting, lu sadar kalau rasa itu <em data-start=\"984\" data-end=\"996\">hanya rasa</em>, bukan hubungan dua arah.</p>\r\n<hr data-start=\"1024\" data-end=\"1027\">\r\n<h3 data-start=\"1029\" data-end=\"1073\">2. 💭 <strong data-start=\"1039\" data-end=\"1073\">Bedakan Antara Suka dan Obsesi</strong></h3>\r\n<p data-start=\"1074\" data-end=\"1371\">Kadang kita bukan jatuh cinta sama orangnya, tapi sama <strong data-start=\"1129\" data-end=\"1156\">bayangan versi sempurna</strong> yang kita bentuk di kepala.<br data-start=\"1184\" data-end=\"1187\">Padahal, bisa aja kalau kenal beneran, ternyata dia nggak se-&ldquo;wah&rdquo; yang kita pikir.<br data-start=\"1270\" data-end=\"1273\">Jadi, coba pikir: &ldquo;Gue beneran suka sama dia, atau cuma suka sama versi yang gue ciptain di otak?&rdquo;</p>\r\n<hr data-start=\"1373\" data-end=\"1376\">\r\n<h3 data-start=\"1378\" data-end=\"1431\">3. 🧹 <strong data-start=\"1388\" data-end=\"1431\">Kurangi Kontak atau Paparan Tentang Dia</strong></h3>\r\n<p data-start=\"1432\" data-end=\"1729\">Kalau tiap hari masih liatin story-nya, scrolling fotonya, atau sengaja lewat tempat dia nongkrong &mdash; ya susah juga buat move on.<br data-start=\"1560\" data-end=\"1563\">Mulai dari kecil: jangan cari-cari dia di medsos, unfollow kalau perlu.<br data-start=\"1634\" data-end=\"1637\">Bukan buat drama, tapi buat bantu diri sendiri berhenti ngarep hal yang nggak bakal terjadi.</p>\r\n<hr data-start=\"1731\" data-end=\"1734\">\r\n<h3 data-start=\"1736\" data-end=\"1779\">4. 🎯 <strong data-start=\"1746\" data-end=\"1779\">Alihkan Fokus ke Diri Sendiri</strong></h3>\r\n<p data-start=\"1780\" data-end=\"1952\">Daripada buang waktu buat orang yang bahkan nggak tahu lu ada, mending fokus ke sesuatu yang bikin lu berkembang.<br data-start=\"1893\" data-end=\"1896\">Belajar hal baru, asah skill, atau upgrade penampilan.</p>\r\n<blockquote data-start=\"1953\" data-end=\"2053\">\r\n<p data-start=\"1955\" data-end=\"2053\">Siapa tahu nanti, tanpa lu sadari, orang lain malah jatuh cinta ke versi baru lu yang lebih keren.</p>\r\n</blockquote>\r\n<hr data-start=\"2055\" data-end=\"2058\">\r\n<h3 data-start=\"2060\" data-end=\"2110\">5. 💬 <strong data-start=\"2070\" data-end=\"2110\">Curhat ke Teman atau Tulis di Jurnal</strong></h3>\r\n<p data-start=\"2111\" data-end=\"2336\">Kadang rasa itu cuma butuh tempat buat keluar. Cerita ke teman yang bisa dipercaya, atau tulis aja semua unek-uneknya di catatan pribadi.<br data-start=\"2248\" data-end=\"2251\">Lu bakal sadar, setelah dituangkan, perasaan itu pelan-pelan berkurang intensitasnya.</p>\r\n<hr data-start=\"2338\" data-end=\"2341\">\r\n<h3 data-start=\"2343\" data-end=\"2379\">6. ⏳ <strong data-start=\"2352\" data-end=\"2379\">Kasih Waktu Buat Sembuh</strong></h3>\r\n<p data-start=\"2380\" data-end=\"2655\">Nggak ada tombol &ldquo;hapus perasaan&rdquo; dalam semalam. Move on dari crush yang nggak kenal kita butuh waktu &mdash; tapi waktu itu bakal nyembuhin, asal lu nggak terus buka luka lama sendiri.<br data-start=\"2559\" data-end=\"2562\">Pelan-pelan, nanti rasa itu akan berubah jadi hal lucu yang bisa lu kenang tanpa nyesek lagi.</p>\r\n<hr data-start=\"2657\" data-end=\"2660\">\r\n<h3 data-start=\"2662\" data-end=\"2683\">🌈 <strong data-start=\"2669\" data-end=\"2683\">Kesimpulan</strong></h3>\r\n<p data-start=\"2684\" data-end=\"2945\">Move on dari crush yang nggak kenal kita memang bittersweet &mdash; karena nggak ada kenangan untuk dilupakan, tapi juga nggak ada penutup untuk diselesaikan.<br data-start=\"2836\" data-end=\"2839\">Namun, dari situ kita belajar: <strong data-start=\"2870\" data-end=\"2945\">kadang cinta terbaik adalah cinta yang cukup dirasakan, bukan dimiliki.</strong></p>', 3, 'uploads/68ee4b04e3a02-save = follow.jpg', '2025-10-14 13:07:16'),
(3, 'Kenapa Langit itu biru?', '<h2 data-start=\"126\" data-end=\"197\">🌤️ Mengapa Langit Berwarna Biru? (Penjelasan dengan Teori Rayleigh)</h2>\r\n<p data-start=\"199\" data-end=\"430\">Pernah nggak lu liat langit terus mikir, &ldquo;Kenapa sih langit warnanya biru, bukan putih aja?&rdquo; Nah, ternyata jawabannya ada di <strong data-start=\"324\" data-end=\"341\">fisika cahaya</strong>, tepatnya dalam yang namanya <strong data-start=\"371\" data-end=\"427\">teori hamburan Rayleigh (Rayleigh Scattering Theory)</strong>.</p>\r\n<h3 data-start=\"432\" data-end=\"485\">🌈 Asal Mulanya: Cahaya Matahari Bukan Cuma Putih</h3>\r\n<p data-start=\"487\" data-end=\"785\">Pertama-tama, lu harus tahu dulu kalau <strong data-start=\"526\" data-end=\"567\">cahaya matahari itu nggak murni putih</strong>. Warna putih yang kita lihat sebenarnya campuran dari banyak warna &mdash; merah, jingga, kuning, hijau, biru, nila, dan ungu &mdash; alias <strong data-start=\"696\" data-end=\"722\">warna spektrum pelangi</strong>.<br data-start=\"723\" data-end=\"726\">Setiap warna punya <strong data-start=\"745\" data-end=\"766\">panjang gelombang</strong> yang berbeda-beda:</p>\r\n<ul data-start=\"786\" data-end=\"869\">\r\n<li data-start=\"786\" data-end=\"828\">\r\n<p data-start=\"788\" data-end=\"828\">Merah &rarr; panjang gelombang <strong data-start=\"814\" data-end=\"828\">terpanjang</strong></p>\r\n</li>\r\n<li data-start=\"829\" data-end=\"869\">\r\n<p data-start=\"831\" data-end=\"869\">Ungu &rarr; panjang gelombang <strong data-start=\"856\" data-end=\"869\">terpendek</strong></p>\r\n</li>\r\n</ul>\r\n<h3 data-start=\"871\" data-end=\"900\">💨 Masuk ke Atmosfer Bumi</h3>\r\n<p data-start=\"902\" data-end=\"1083\">Begitu cahaya matahari masuk ke atmosfer, dia bakal <strong data-start=\"954\" data-end=\"989\">berinteraksi sama molekul udara</strong> dan partikel kecil (seperti debu atau uap air). Nah, di sinilah teori Rayleigh mulai berlaku.</p>\r\n<p data-start=\"1085\" data-end=\"1403\">Menurut <strong data-start=\"1093\" data-end=\"1110\">Lord Rayleigh</strong>, cahaya akan <strong data-start=\"1124\" data-end=\"1148\">terhambur (tersebar)</strong> oleh partikel kecil di udara. Tapi tingkat hamburannya <strong data-start=\"1204\" data-end=\"1236\">nggak sama untuk semua warna</strong> &mdash; warna dengan <strong data-start=\"1252\" data-end=\"1286\">panjang gelombang lebih pendek</strong> (seperti biru dan ungu) <strong data-start=\"1311\" data-end=\"1336\">lebih mudah terhambur</strong> daripada warna panjang gelombang besar (seperti merah dan kuning).</p>\r\n<h3 data-start=\"1405\" data-end=\"1457\">🔵 Kenapa yang Kelihatan Malah Biru, Bukan Ungu?</h3>\r\n<p data-start=\"1459\" data-end=\"1762\">Secara teori, warna <strong data-start=\"1479\" data-end=\"1487\">ungu</strong> justru lebih kuat hamburannya dari biru. Tapi mata manusia <strong data-start=\"1547\" data-end=\"1586\">kurang sensitif terhadap warna ungu</strong>, dan sebagian besar cahaya ungu diserap oleh lapisan atas atmosfer.<br data-start=\"1654\" data-end=\"1657\">Jadi yang paling dominan di mata kita adalah warna <strong data-start=\"1708\" data-end=\"1716\">biru</strong> &mdash; makanya langit tampak biru saat siang hari.</p>\r\n<h3 data-start=\"1764\" data-end=\"1826\">🌅 Terus, Kenapa Saat Matahari Terbenam Langit Jadi Merah?</h3>\r\n<p data-start=\"1828\" data-end=\"2183\">Waktu matahari terbit atau terbenam, <strong data-start=\"1865\" data-end=\"1933\">cahaya matahari harus menempuh jarak atmosfer yang lebih panjang</strong>. Akibatnya, <strong data-start=\"1946\" data-end=\"2005\">warna biru dan ungu udah keburu tersebar ke segala arah</strong>, tinggal warna merah dan jingga yang masih kuat sampai ke mata kita.<br data-start=\"2074\" data-end=\"2077\">Makanya, langit di sore hari tampak <strong data-start=\"2113\" data-end=\"2131\">merah keemasan</strong> &mdash; fenomena ini juga dijelaskan oleh teori Rayleigh.</p>\r\n<h3 data-start=\"2185\" data-end=\"2210\">📘 Kesimpulan Singkat</h3>\r\n<div class=\"_tableContainer_1rjym_1\">\r\n<div class=\"group _tableWrapper_1rjym_13 flex w-fit flex-col-reverse\" tabindex=\"-1\">\r\n<table class=\"w-fit min-w-(--thread-content-width)\" data-start=\"2212\" data-end=\"2594\">\r\n<thead data-start=\"2212\" data-end=\"2235\">\r\n<tr data-start=\"2212\" data-end=\"2235\">\r\n<th data-start=\"2212\" data-end=\"2221\" data-col-size=\"sm\">Faktor</th>\r\n<th data-start=\"2221\" data-end=\"2235\" data-col-size=\"md\">Penjelasan</th>\r\n</tr>\r\n</thead>\r\n<tbody data-start=\"2261\" data-end=\"2594\">\r\n<tr data-start=\"2261\" data-end=\"2321\">\r\n<td data-start=\"2261\" data-end=\"2278\" data-col-size=\"sm\"><strong data-start=\"2263\" data-end=\"2277\">Nama Teori</strong></td>\r\n<td data-col-size=\"md\" data-start=\"2278\" data-end=\"2321\">Hamburan Rayleigh (Rayleigh Scattering)</td>\r\n</tr>\r\n<tr data-start=\"2322\" data-end=\"2374\">\r\n<td data-start=\"2322\" data-end=\"2335\" data-col-size=\"sm\"><strong data-start=\"2324\" data-end=\"2334\">Penemu</strong></td>\r\n<td data-col-size=\"md\" data-start=\"2335\" data-end=\"2374\">Lord Rayleigh (John William Strutt)</td>\r\n</tr>\r\n<tr data-start=\"2375\" data-end=\"2462\">\r\n<td data-start=\"2375\" data-end=\"2395\" data-col-size=\"sm\"><strong data-start=\"2377\" data-end=\"2394\">Prinsip Dasar</strong></td>\r\n<td data-col-size=\"md\" data-start=\"2395\" data-end=\"2462\">Cahaya dengan panjang gelombang pendek lebih banyak dihamburkan</td>\r\n</tr>\r\n<tr data-start=\"2463\" data-end=\"2519\">\r\n<td data-start=\"2463\" data-end=\"2479\" data-col-size=\"sm\"><strong data-start=\"2465\" data-end=\"2478\">Akibatnya</strong></td>\r\n<td data-start=\"2479\" data-end=\"2519\" data-col-size=\"md\">Warna biru mendominasi di siang hari</td>\r\n</tr>\r\n<tr data-start=\"2520\" data-end=\"2594\">\r\n<td data-start=\"2520\" data-end=\"2537\" data-col-size=\"sm\"><strong data-start=\"2522\" data-end=\"2536\">Saat Senja</strong></td>\r\n<td data-start=\"2537\" data-end=\"2594\" data-col-size=\"md\">Cahaya biru terhambur semua, warna merah yang tersisa</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>\r\n</div>', 2, 'uploads/68eef196b638c-beautiful-skyscape-daytime.jpg', '2025-10-15 00:57:58'),
(4, 'Gunung Terbersih di Indonesia', '# **Gunung Kembang: Gunung Terbersih yang Bikin Kangen untuk Didaki**\r\n\r\nGunung Kembang adalah salah satu permata tersembunyi di Kabupaten Wonosobo, Jawa Tengah. Meski sering disebut sebagai “adiknya Gunung Sindoro,” gunung ini punya pesona sendiri yang bikin banyak pendaki jatuh cinta. Bukan cuma karena pemandangannya yang cantik, tapi juga karena reputasinya sebagai **salah satu gunung terbersih di Jawa Tengah**.\r\n\r\n## **1. Lokasi & Rute Pendakian yang Nyaman**\r\n\r\nGunung Kembang berada di Desa Tambi, Kecamatan Kejajar, Wonosobo. Gunung ini memiliki ketinggian sekitar **2.340 mdpl**, cocok banget buat pendaki pemula sampai menengah. Jalur pendakiannya mayoritas berupa hutan pinus dan semak yang rapi, dengan trek yang jelas dan terawat.\r\n\r\nBasecamp paling terkenal adalah **Basecamp Blembem**. Di sini, pendaki disambut dengan fasilitas yang cukup lengkap, kebersihan lingkungan yang terjaga, serta pengelola yang ramah dan tegas soal aturan kebersihan.\r\n\r\n## **2. Predikat “Gunung Terbersih”: Bukan Sekadar Julukan**\r\n\r\nGunung Kembang sering disebut sebagai salah satu gunung terbersih karena beberapa alasan:\r\n\r\n### **• Kesadaran Pendaki yang Tinggi**\r\n\r\nPara pendaki yang datang ke sini biasanya lebih peduli soal sampah. Hampir setiap pos dijaga rapi tanpa ada jejak botol plastik atau bungkus makanan berserakan.\r\n\r\n### **• Pengelola yang Tegas**\r\n\r\nBasecamp menerapkan peraturan seperti:\r\n\r\n* Wajib bawa trash bag pribadi\r\n* Pemeriksaan barang bawaan saat naik dan turun\r\n* Denda bagi pendaki yang ketahuan buang sampah sembarangan\r\n\r\nAturan ini bikin semua orang lebih disiplin dan sadar.\r\n\r\n### **• Patroli Rutin**\r\n\r\nAda relawan dan pengelola yang rutin menyisir jalur, memastikan tidak ada sampah tertinggal. Hal inilah yang bikin Gunung Kembang selalu tampil bersih dan natural.\r\n\r\n## **3. Pesona Alam yang Beda dari Gunung Lain**\r\n\r\nMeski ketinggiannya tidak terlalu tinggi, Gunung Kembang punya karakter yang unik:\r\n\r\n### **• View Sindoro yang Megah**\r\n\r\nDari puncaknya, gunung ini menawarkan panorama Gunung Sindoro yang gagah banget, jaraknya dekat dan terlihat jelas. Foto-foto di puncak sering kelihatan seperti “face to face” sama Sindoro.\r\n\r\n### **• Hutan Pinus yang Fotogenik**\r\n\r\nJalur awal pendakian melewati hutan pinus yang tenang dan bersih, cocok buat healing.\r\n\r\n### **• Sunrise yang Hangat**\r\n\r\nPuncaknya memang kecil, tapi view sunrise di sini adem banget. Sinar matahari pertama muncul di sela-sela bukit dengan warna keemasan yang lembut.\r\n\r\n## **4. Kenapa Banyak Pendaki Suka Balik Lagi ke Gunung Kembang?**\r\n\r\nKarena gunung ini:\r\n\r\n* Bersih dari sampah\r\n* Jalurnya nyaman\r\n* Tidak terlalu ramai\r\n* Basecamp-nya ramah pendaki\r\n* View puncaknya mantap\r\n\r\nPendaki yang suka ketenangan biasanya milih Gunung Kembang sebagai tempat “kabur sebentar” dari hiruk pikuknya kota.\r\n\r\n## **5. Tips Mendaki Gunung Kembang**\r\n\r\nBiar pendakian makin aman dan nyaman:\r\n\r\n* **Datang pagi hari** biar dapat cahaya yang cukup di jalur.\r\n* **Bawa air yang cukup**, karena sumber air tidak tersedia di jalur.\r\n* **Patuhi aturan kebersihan**, jangan rusak reputasi gunung ini.\r\n* **Gunakan alas kaki yang aman**, jalurnya cenderung licin saat hujan.\r\n\r\n---\r\n\r\n# **Penutup**\r\n\r\nGunung Kembang bukan cuma tempat untuk mendaki, tapi juga tempat untuk belajar menghargai alam. Kebersihan gunung ini adalah hasil kerja keras pengelola dan pendaki yang saling jaga. Kalau lu mau dapat pengalaman mendaki yang tenang, bersih, dan penuh panorama indah—Gunung Kembang adalah jawabannya.', 2, 'uploads/691d1a216211a-Gunung-Kembang-Wonosobo.webp', '2025-11-19 01:15:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(3, 'Kehidupan'),
(2, 'Pengetahuan'),
(1, 'Tutorial');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `contact_info`
--

INSERT INTO `contact_info` (`id`, `name`, `value`) VALUES
(34, 'Alamat', 'Banjarnegara, Jawa Tengah'),
(35, 'Email', 'annisajuliantyid@gmail.com'),
(36, 'Telepon', '+62 878 3093 1380');

-- --------------------------------------------------------

--
-- Struktur dari tabel `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `major` varchar(255) DEFAULT NULL,
  `year` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `education`
--

INSERT INTO `education` (`id`, `institution`, `major`, `year`, `description`) VALUES
(6, 'SDN 3 Kaliurip', '', '2015-2021', ''),
(7, 'SMPN 2 Madukara', '', '2021-2024', ''),
(8, 'SMKN 1 Bawang', 'Pengembangan Perangkat Lunak dan Gim (PPLG)', '2024-sekarang', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `timeline_position` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `experience`
--

INSERT INTO `experience` (`id`, `description`, `sort_order`, `timeline_position`) VALUES
(1, 'Olimpiade Sains Nasional (OSN) IPA (2021)', 1, 'right'),
(2, 'OSIS (Organisasi Siswa Intra Sekolah) (2021-2023)', 2, 'left'),
(3, 'Mengikuti Lomba KKR tingkat kecamatan (2022)', 3, 'right'),
(4, 'Pengurus Lab IPA (2022-2023)', 4, 'left'),
(5, 'Mengikuti lomba MAPSI (2022 dan 2023)', 5, 'right'),
(6, 'Olimpiade Sains Nasional (OSN) Matematika (2022 dan 2023)', 6, 'left'),
(7, 'Mengikuti lomba LCC museum (2023)', 7, 'right'),
(8, 'Mengikuti FTBI (2023)', 8, 'left'),
(9, 'Kader Literasi (2023)', 9, 'right'),
(10, 'Panitia di Kegiatan CKC (Computer Kids Club) (2024)', 10, 'left'),
(11, 'Anggota Organisasi PSPG (2024-sekarang)', 11, 'right'),
(12, 'Panitia Makrab PPLG  SKANZA (2025)', 12, 'left');

-- --------------------------------------------------------

--
-- Struktur dari tabel `home_info`
--

CREATE TABLE `home_info` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `home_info`
--

INSERT INTO `home_info` (`id`, `key`, `value`) VALUES
(1, 'main_title', 'Annisa Julianty'),
(2, 'subtitle', 'Siswi SMK'),
(3, 'about_me', 'Saya seorang siswi SMKN 1 Bawang, Jurusan PPLG (Pengambangan Perangkat Lunak dan Gim), konsentrasi RPL (Rekayasa Perangkat Lunak), kelas XI.'),
(35, 'hobby', 'Membaca, Menulis, dan Mendengarkan Musik'),
(36, 'umur', '16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `image_path`, `created_at`, `link`) VALUES
(1, 'Infografis', 'Infografis wisata Dieng banjarnegara', 'uploads/691d1728dadce-Infografisdiengp51.png', '2025-11-19 01:02:32', ''),
(2, 'Desain Poster', 'Poster untuk demo ekstrakulikuler karate SMKN 1 Bawang 2025', 'uploads/693a8ee0df4f3-WhatsAppImage2025-12-11at16.27.22.jpeg', '2025-12-11 09:29:04', ''),
(3, 'Figma', 'Prorotype aplikasi wisata serulingmas Banjarnegara', 'uploads/693a8fac8248f-figmaanniez.png', '2025-12-11 09:32:28', 'https://www.figma.com/design/OGwTptcA5WoVrRGprUwbHz/PSAS_ANNISA-JULIANTY?node-id=0-1&t=HlP7E9ZIsKPZ6EZE-1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'about_name', 'Annisa Julianty'),
(2, 'about_title', 'Siswi SMKN 1 Bawang'),
(3, 'about_age', '16 tahun'),
(4, 'about_birthdate', '10 Juli 2009'),
(5, 'about_status', 'Pelajar'),
(6, 'about_hobbies', 'Menulis, Mendengarkan musik, berolahraga, mengeksplor sesuatu'),
(7, 'about_description', 'Annisa Julianty siswa SMKN 1 Bawang tahun ajaran 2024, sekarang menduduki kelas XI jurusan PPLG (Pengembangan Perangkat Lunak dan Gim) Konsentrasi RPL (Rekayasa Perangkat Lunak).'),
(8, 'instagram_url', 'https://www.instagram.com/_annisajlnty?igsh=MXJrOTd0bnJicGhscg=='),
(9, 'contact_email', 'annisajuliantyid@gmail.com'),
(10, 'contact_phone', '+62 878 3093 1380'),
(11, 'hard_skills', 'Canva'),
(12, 'soft_skills', 'Mudah beradatasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `skills`
--

INSERT INTO `skills` (`id`, `name`, `category`) VALUES
(1, 'Mudah beradaptasi', 'Soft'),
(2, 'Canva design (dasar)', 'Hard'),
(3, 'figma design (dasar)', 'Hard'),
(4, 'Video editing', 'Hard'),
(5, 'Photo editing (dasar)', 'Hard'),
(6, 'Kreativitas', 'Soft'),
(7, 'Komunikasi yang baik', 'Soft'),
(8, 'Kerja sama tim', 'Soft'),
(9, 'Inisiatif & Kemauan belajar', 'Soft');

-- --------------------------------------------------------

--
-- Struktur dari tabel `social_media`
--

CREATE TABLE `social_media` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `social_media`
--

INSERT INTO `social_media` (`id`, `name`, `url`, `icon_class`, `display_order`) VALUES
(1, 'Instagram', 'https://www.instagram.com/_annisajlnty/', 'fab fa-instagram', 1),
(3, 'github', 'https://github.com/AnnisaJulianty', 'fab fa-github', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeks untuk tabel `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indeks untuk tabel `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `home_info`
--
ALTER TABLE `home_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indeks untuk tabel `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `home_info`
--
ALTER TABLE `home_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
