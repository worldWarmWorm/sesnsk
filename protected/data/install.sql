SET NAMES 'utf8';

CREATE TABLE IF NOT EXISTS `order` (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  `comment` VARCHAR(255) DEFAULT NULL,
  products TEXT NOT NULL,
  payment TEXT NOT NULL,
  payment_complete TINYINT(1) NOT NULL DEFAULT 0,
  completed TINYINT(1) NOT NULL DEFAULT 0,
  created DATETIME NOT NULL,
  update_time TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS blog (
  id INT(11) NOT NULL AUTO_INCREMENT,
  alias VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  ordering INT(11) NOT NULL,
  params TEXT NOT NULL,
  update_time TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS event (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  intro TEXT NOT NULL,
  `text` TEXT NOT NULL,
  enable_preview TINYINT(1) NOT NULL DEFAULT 1,
  created DATETIME NOT NULL,
  preview VARCHAR(255) NOT NULL,
  publish TINYINT(1) NOT NULL DEFAULT 1,
  update_time TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS file (
  id INT(11) NOT NULL AUTO_INCREMENT,
  model VARCHAR(20) NOT NULL,
  item_id INT(11) NOT NULL,
  filename VARCHAR(100) NOT NULL,
  description VARCHAR(500) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS image (
  id INT(11) NOT NULL AUTO_INCREMENT,
  model VARCHAR(20) NOT NULL,
  item_id INT(11) NOT NULL,
  filename VARCHAR(100) NOT NULL,
  description VARCHAR(500) NOT NULL,
  ordering INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS link (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  url VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS menu (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL DEFAULT 'model',
  options VARCHAR(255) NOT NULL DEFAULT '',
  seo_a_title VARCHAR(255) NOT NULL DEFAULT '',
  ordering INT(11) NOT NULL DEFAULT 1,
  `default` TINYINT(1) NOT NULL DEFAULT 0,
  hidden TINYINT(1) NOT NULL DEFAULT 0,
  `parent_id` INT(11),
  `system` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (id),
  UNIQUE INDEX id (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS metadata (
  id INT(11) NOT NULL AUTO_INCREMENT,
  owner_name VARCHAR(50) NOT NULL,
  owner_id INT(11) NOT NULL,
  meta_title VARCHAR(255) NOT NULL,
  meta_key TEXT NOT NULL,
  meta_desc TEXT NOT NULL,
  update_time TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE INDEX id (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS page (
  id INT(11) NOT NULL AUTO_INCREMENT,
  parent_id INT(11) NOT NULL DEFAULT 0,
  blog_id INT(11) NOT NULL,
  alias VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  intro TEXT NOT NULL,
  `text` MEDIUMTEXT NOT NULL,
  created DATETIME NOT NULL,
  modified DATETIME NOT NULL,
  update_time TIMESTAMP,
  PRIMARY KEY (id),
  INDEX parent_id (parent_id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS settings (
  id INT(11) NOT NULL AUTO_INCREMENT,
  category VARCHAR(64) NOT NULL DEFAULT 'system',
  `key` VARCHAR(255) NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY (id),
  INDEX category_key (category, `key`)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS question(
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  question TEXT NOT NULL,
  answer TEXT NOT NULL,
  published TINYINT(1) NOT NULL DEFAULT 0,
  created DATETIME NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS slide (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL,
  filename VARCHAR(255) NOT NULL,
  `type` int(11) not null DEFAULT 0,
  ordering INT(11) NOT NULL DEFAULT 1,
  update_time TIMESTAMP,
  PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE `banner` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) not null,
	`type` int(11) not null DEFAULT 0,
	`link` varchar(255) not null,
	`filename` varchar(255) not null,
	`ordering` int(11) not null DEFAULT 1,
	PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE `product_review` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`product_id` int(11) not null,
	`mark` int(11) not null,
	`username` varchar(255) not null,
	`text` mediumtext not null,
	`ts` timestamp not null,
	`ip` int(11) not null,
	`published` tinyint(1) not null,
	PRIMARY KEY (id)
)
ENGINE = INNODB
CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `eav_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` smallint(6) NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `eav_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_attrs` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO event (title,intro,text,created,publish,update_time) VALUES ('Создали сайт', 'Мы создали сайт!', '<p>Мы создали сайт!</p>', now(), 1, now());

INSERT INTO menu (id, title, type, options, ordering, `default`, hidden) VALUES
  (50, 'Главная', 'model', '{"model":"page","id":"1"}', 1, 1, 1),
  (51, 'Новости', 'model', '{"model":"event"}', 2, 0, 0);
INSERT INTO page (alias,title,text,update_time) VALUES ('index', 'Главная', '<p>Сайт находится в разработке</p>', now());

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `preview_id` varchar(255) NOT NULL,
  update_time TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gallery_img` (
  `id` int(11) NOT NULL,
  `image_order` int(11) NOT NULL DEFAULT '1',
  `gallery_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  update_time TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gallery_img`
--
ALTER TABLE `gallery_img`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT для таблицы `gallery_img`
--
ALTER TABLE `gallery_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
