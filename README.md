# NapredniPHP_Parc_Kuzmic

SQL
tablica:
users (id, username, pass)
chat (id, user_id_from, user_id_to, message)


DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id_from` varchar(50) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `user_id_to` varchar(50) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_croatian_ci;
COMMIT;


Korisnici:
user: Marinko101
pass: marinko

user: Testinjo101
pass: testinjo


