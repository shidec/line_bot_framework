<?php
	$db = new mysqli($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_passwd'], $_SESSION['db_database']);
	$db->query('CREATE TABLE IF NOT EXISTS `profiles` (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `user_id` varchar(255) NOT NULL,
		  `display_name` varchar(255) NOT NULL,
		  `picture_url` varchar(255) NOT NULL,
		  `language` varchar(2) NOT NULL DEFAULT \'id\',
		  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `following` int(2) NOT NULL DEFAULT \'1\',
		  `profile_data` TEXT,
		  `session_data` TEXT,
		  `last_active` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `user_id` (`user_id`)
		) ENGINE=InnoDB;');
	
	$db->query('CREATE TABLE IF NOT EXISTS `options` (
		  `id` int(10) NOT NULL AUTO_INCREMENT,
		  `option_name` varchar(100) NOT NULL,
		  `option_value` TEXT,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `option_name` (`option_name`)
		) ENGINE=InnoDB;');
	
	$db->query('INSERT INTO options (`option_name`,`option_value`) VALUES (\'base_url\', \'' . $_SESSION['server_url'] . '\')');
	$db->query('INSERT INTO options (`option_name`,`option_value`) VALUES (\'channel_access_token\', \'' . $_SESSION['ch_token'] . '\')');
	$db->query('INSERT INTO options (`option_name`,`option_value`) VALUES (\'channel_secret\', \'' . $_SESSION['ch_secret'] . '\')');
	$db->query('INSERT INTO options (`option_name`,`option_value`) VALUES (\'admin_name\', \'' . $_SESSION['admin_name'] . '\')');
	$db->query('INSERT INTO options (`option_name`,`option_value`) VALUES (\'admin_passwd\', \'' . md5($_SESSION['admin_passwd']) . '\')');
	$db->query('INSERT INTO options (`option_name`,`option_value`) VALUES (\'active_app\', \'Reverse\')');
	$db->query('INSERT INTO profiles (`id`, `user_id`, `display_name`, `picture_url`) VALUES(1, \'U0000EMU\', \'Emulator\', \'\')');
	$db->close();
	$data = '<?php
	
	define(\'DB_HOST\',\'' . $_SESSION['db_host'] . '\');
	define(\'DB_USER\',\'' . $_SESSION['db_user'] . '\');
	define(\'DB_PASSWD\',\'' . $_SESSION['db_passwd'] . '\');
	define(\'DB_DATABASE\',\'' . $_SESSION['db_database'] . '\');	
';
	
	file_put_contents('includes/config.php', $data);
	
	session_destroy();
	header('Location: install.php');