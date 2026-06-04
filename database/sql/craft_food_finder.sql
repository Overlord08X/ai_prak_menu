SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS consultation_results;
DROP TABLE IF EXISTS consultation_details;
DROP TABLE IF EXISTS consultations;
DROP TABLE IF EXISTS rule_details;
DROP TABLE IF EXISTS rules;
DROP TABLE IF EXISTS recipes;
DROP TABLE IF EXISTS ingredients;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_bahan VARCHAR(100) NOT NULL UNIQUE,
    deskripsi TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_resep VARCHAR(150) NOT NULL,
    deskripsi TEXT NULL,
    langkah_memasak TEXT NOT NULL,
    gambar VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE rules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    CONSTRAINT fk_rules_recipe FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE rule_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rule_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    CONSTRAINT fk_rule_details_rule FOREIGN KEY (rule_id) REFERENCES rules(id) ON DELETE CASCADE,
    CONSTRAINT fk_rule_details_ingredient FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tanggal DATETIME NOT NULL,
    CONSTRAINT fk_consultations_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE consultation_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultation_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    CONSTRAINT fk_consultation_details_consultation FOREIGN KEY (consultation_id) REFERENCES consultations(id) ON DELETE CASCADE,
    CONSTRAINT fk_consultation_details_ingredient FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE consultation_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consultation_id INT NOT NULL,
    recipe_id INT NOT NULL,
    CONSTRAINT fk_consultation_results_consultation FOREIGN KEY (consultation_id) REFERENCES consultations(id) ON DELETE CASCADE,
    CONSTRAINT fk_consultation_results_recipe FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (nama, email, password, role) VALUES
('Administrator', 'admin@craftfood.com', SHA2('admin123', 256), 'admin');

INSERT INTO ingredients (nama_bahan, deskripsi) VALUES
('Telur', 'Bahan protein serbaguna untuk banyak resep.'),
('Nasi', 'Bahan utama karbohidrat yang mudah diolah.'),
('Mie', 'Mie instan atau mie basah untuk masakan cepat saji.'),
('Tepung', 'Bahan dasar adonan dan kue.'),
('Gula', 'Pemanis untuk makanan dan minuman.'),
('Roti', 'Roti tawar atau roti sandwich.'),
('Ayam', 'Daging ayam segar untuk lauk utama.'),
('Bawang Putih', 'Bumbu dasar yang memberi aroma kuat.'),
('Kecap', 'Pemberi rasa manis dan gurih.'),
('Susu', 'Cairan susu untuk adonan dan minuman.'),
('Mentega', 'Lemak masak untuk aroma dan tekstur.'),
('Garam', 'Penyedap rasa dasar.'),
('Cabai', 'Bahan pedas untuk cita rasa tajam.'),
('Kentang', 'Umbi yang cocok untuk lauk atau camilan.'),
('Daging', 'Daging sapi atau cincang untuk lauk berat.'),
('Keju', 'Produk susu yang gurih dan creamy.'),
('Tomat', 'Sayuran buah segar untuk masakan dan saus.'),
('Saus', 'Pelengkap rasa untuk mie dan sandwich.'),
('Bayam', 'Sayuran hijau bergizi.'),
('Ikan', 'Bahan protein laut untuk bakar atau goreng.');

INSERT INTO recipes (nama_resep, deskripsi, langkah_memasak, gambar) VALUES
('Nasi Goreng Telur', 'Nasi goreng sederhana yang cocok untuk sarapan.', '1. Panaskan wajan dengan sedikit mentega.\n2. Tumis bawang putih hingga harum.\n3. Masukkan telur dan orak-arik.\n4. Tambahkan nasi dan kecap.\n5. Aduk rata lalu sajikan.', NULL),
('Mie Goreng Telur', 'Mie goreng cepat saji dengan telur.', '1. Rebus mie hingga matang.\n2. Tumis bawang putih dan cabai.\n3. Masukkan telur lalu aduk.\n4. Tambahkan mie dan saus.\n5. Aduk rata dan sajikan.', NULL),
('Pancake', 'Kue dadar lembut untuk camilan.', '1. Campur tepung, telur, gula, dan susu.\n2. Aduk sampai adonan halus.\n3. Panaskan wajan dan beri mentega.\n4. Tuang adonan lalu panggang kedua sisi.\n5. Sajikan hangat.', NULL),
('French Toast', 'Roti panggang manis yang lembut.', '1. Kocok telur dengan susu dan gula.\n2. Celupkan roti ke adonan.\n3. Panggang di wajan dengan mentega.\n4. Balik hingga kecokelatan.\n5. Sajikan segera.', NULL),
('Ayam Kecap', 'Lauk ayam manis gurih.', '1. Tumis bawang putih sampai harum.\n2. Masukkan ayam dan masak hingga berubah warna.\n3. Tambahkan kecap dan sedikit garam.\n4. Masak sampai bumbu meresap.\n5. Sajikan hangat.', NULL),
('Omelet Keju', 'Telur dadar lembut dengan keju.', '1. Kocok telur dengan garam.\n2. Tambahkan keju parut.\n3. Panaskan mentega di wajan.\n4. Tuang telur lalu masak hingga matang.\n5. Lipat dan sajikan.', NULL),
('Telur Dadar', 'Olahan telur praktis dengan bawang.', '1. Kocok telur dengan bawang putih dan garam.\n2. Panaskan wajan dengan mentega.\n3. Tuang adonan telur.\n4. Masak hingga matang kedua sisi.\n5. Sajikan.', NULL),
('Kentang Goreng Mentega', 'Kentang gurih untuk camilan atau lauk.', '1. Potong kentang sesuai selera.\n2. Rebus sebentar lalu tiriskan.\n3. Tumis kentang dengan mentega.\n4. Tambahkan garam secukupnya.\n5. Sajikan hangat.', NULL),
('Ayam Goreng Tepung', 'Ayam renyah dengan balutan tepung.', '1. Lumuri ayam dengan garam.\n2. Balur ayam dengan tepung.\n3. Goreng hingga keemasan.\n4. Angkat dan tiriskan.\n5. Sajikan.', NULL),
('Sup Ayam', 'Sup hangat bergizi untuk keluarga.', '1. Rebus ayam dengan bawang putih.\n2. Tambahkan tomat dan garam.\n3. Masak hingga ayam empuk.\n4. Koreksi rasa.\n5. Sajikan selagi hangat.', NULL),
('Sandwich Keju', 'Roti lapis sederhana dan mengenyangkan.', '1. Susun roti dengan keju dan tomat.\n2. Panggang dengan mentega.\n3. Tekan hingga hangat dan renyah.\n4. Potong menjadi dua bagian.\n5. Sajikan.', NULL),
('Mie Saus Tomat', 'Mie sederhana dengan saus tomat.', '1. Rebus mie hingga matang.\n2. Tumis bawang putih.\n3. Tambahkan saus dan tomat.\n4. Masukkan mie lalu aduk rata.\n5. Sajikan.', NULL),
('Tumis Bayam', 'Sayur hijau praktis dan cepat.', '1. Panaskan sedikit mentega.\n2. Tumis bawang putih hingga harum.\n3. Masukkan bayam dan garam.\n4. Aduk cepat hingga layu.\n5. Sajikan.', NULL),
('Ikan Bakar', 'Ikan berbumbu dengan rasa pedas gurih.', '1. Lumuri ikan dengan bawang putih, garam, dan cabai.\n2. Diamkan sebentar.\n3. Bakar ikan hingga matang.\n4. Balik agar tidak gosong.\n5. Sajikan.', NULL),
('Omelet Sayur', 'Omelet sehat dengan bayam dan tomat.', '1. Kocok telur dengan garam.\n2. Tambahkan bayam dan tomat.\n3. Panaskan mentega di wajan.\n4. Tuang adonan dan masak hingga matang.\n5. Sajikan.', NULL),
('Nasi Goreng Ayam', 'Nasi goreng dengan lauk ayam.', '1. Tumis bawang putih hingga harum.\n2. Masukkan ayam dan masak sebentar.\n3. Tambahkan nasi dan kecap.\n4. Aduk rata sampai matang.\n5. Sajikan.', NULL),
('Roti Panggang Keju', 'Roti panggang gurih dengan keju meleleh.', '1. Oleskan mentega pada roti.\n2. Tambahkan keju di atasnya.\n3. Panggang hingga kecokelatan.\n4. Angkat dan sajikan.', NULL),
('Kue Susu', 'Kue sederhana dengan rasa lembut.', '1. Campur tepung, susu, gula, dan mentega.\n2. Aduk hingga rata.\n3. Tuang ke loyang kecil.\n4. Panggang sampai matang.\n5. Dinginkan lalu sajikan.', NULL),
('Bubur Nasi', 'Bubur lembut untuk sarapan.', '1. Masak nasi dengan susu dan air.\n2. Tambahkan garam.\n3. Aduk hingga tekstur lembut.\n4. Sajikan hangat.', NULL),
('Mie Cabai', 'Mie pedas sederhana.', '1. Rebus mie hingga matang.\n2. Tumis bawang putih dan cabai.\n3. Masukkan mie dan sedikit garam.\n4. Aduk rata dan sajikan.', NULL);

INSERT INTO rules (recipe_id) VALUES
(1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20),(1),(4),(5),(6),(10),(11),(1),(2),(13),(14);

INSERT INTO rule_details (rule_id, ingredient_id) VALUES
(1, 1),(1, 2),
(2, 3),(2, 1),
(3, 4),(3, 1),(3, 5),
(4, 6),(4, 1),
(5, 7),(5, 8),(5, 9),
(6, 1),(6, 16),(6, 11),
(7, 1),(7, 8),(7, 12),
(8, 14),(8, 11),(8, 12),
(9, 7),(9, 4),(9, 12),
(10, 7),(10, 8),(10, 12),(10, 17),
(11, 6),(11, 16),(11, 17),
(12, 3),(12, 18),(12, 17),
(13, 19),(13, 8),(13, 12),
(14, 20),(14, 8),(14, 12),(14, 13),
(15, 1),(15, 19),(15, 17),
(16, 2),(16, 7),(16, 8),(16, 9),
(17, 6),(17, 16),(17, 11),
(18, 4),(18, 10),(18, 5),(18, 11),
(19, 2),(19, 10),(19, 12),
(20, 3),(20, 13),(20, 8),
(21, 4),(21, 10),(21, 5),
(22, 6),(22, 10),(22, 1),
(23, 7),(23, 8),(23, 9),(23, 12),
(24, 1),(24, 16),(24, 17),
(25, 10),(25, 7),(25, 17),(25, 8),
(26, 6),(26, 16),(26, 18),(26, 17),
(27, 2),(27, 1),(27, 8),
(28, 3),(28, 1),(28, 8),
(29, 19),(29, 17),(29, 8),
(30, 20),(30, 13),(30, 11);
