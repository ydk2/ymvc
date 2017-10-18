IF OBJECT_ID ('sitedata', 'U') IS NOT NULL
DROP TABLE  sitedata;
CREATE TABLE  sitedata (
  id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),
  name varchar(255),
  string TEXT DEFAULT '',
  access INTEGER DEFAULT 10,
  groups varchar(255) DEFAULT 'main'
); 

--SET IDENTITY_INSERT sitedata ON;
INSERT INTO sitedata (name, string) VALUES('page_title_str', 'Ymvc <small>System</small>');
INSERT INTO sitedata (name, string) VALUES('page_subtitle_str', 'Subtitle of this page');
INSERT INTO sitedata (name, string) VALUES('footer_title_str', 'Footer Header');
INSERT INTO sitedata (name, string) VALUES('page_short_title_str', 'Ymvc');
INSERT INTO sitedata (name, string) VALUES('footer_content_str', 'Footer Contents.');
--SET IDENTITY_INSERT sitedata OFF;

IF OBJECT_ID ('translatedstrings', 'U') IS NOT NULL
DROP TABLE  translatedstrings;
CREATE TABLE  translatedstrings (
  id INTEGER  NOT NULL PRIMARY KEY  IDENTITY(1,1),
  name TEXT DEFAULT '',
  string TEXT DEFAULT '',
  access INTEGER DEFAULT 10,
  groups varchar(255) DEFAULT 'main',
  lang varchar(11) DEFAULT 'en'
); 

INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Contents.', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc <small>System</small>', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Subtitle of this page','', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Header', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Start', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('About Us', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Contact', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Table', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('New', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('Old', '', 'en');
INSERT INTO translatedstrings (name, string, lang) VALUES('File', '', 'en');

INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Contents.', 'Zawartość Stopki.', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc <small>System</small>', 'Ymvc <small>System</small>', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Ymvc', '', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Subtitle of this page', 'Podtytuł strony', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Footer Header', 'Nagłówek stopki', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Start', 'Start', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('About Us', 'O Nas', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Contact', 'Kontakt', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Table', 'Tabela', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('New', 'Nowy', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('Old', 'Stary', 'pl');
INSERT INTO translatedstrings (name, string, lang) VALUES('File', 'Plik', 'pl');

IF OBJECT_ID ('menus', 'U') IS NOT NULL
DROP TABLE  menus;
CREATE TABLE  menus (
  id INTEGER NOT NULL PRIMARY KEY  IDENTITY(1,1),
  pos INTEGER  NOT NULL,
  title varchar(255),
  link varchar(255),
  parent varchar(255) DEFAULT '',
  access INTEGER DEFAULT 10,
  groups varchar(255) DEFAULT 'main',
  lang varchar(11) DEFAULT 'en'
);  

INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(1, 'Start', 'start', '',10,'en');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(2, 'About Us', 'about', '',10,'en');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(3, 'Contact', 'contact', '',10,'en');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(4, 'Table', 'http://localhost/ymvc/?table=table', '1',10,'en');

INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(1, 'Start', 'start', '',10,'pl');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(2, 'O nas', 'about', '',10,'pl');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(3, 'Kontakt', 'contact', '',10,'pl');
INSERT INTO menus (pos, title, link, parent, access, lang) VALUES(4, 'Tabela', 'http://localhost/ymvc/?table=table', '1',10,'pl');

IF OBJECT_ID ('pages', 'U') IS NOT NULL
DROP TABLE  pages;
CREATE TABLE  pages (
  id INTEGER NOT NULL PRIMARY KEY  IDENTITY(1,1),
  title varchar(255) DEFAULT '',
  access INTEGER DEFAULT 10,
  groups varchar(255) DEFAULT 'main',
  link varchar(255) DEFAULT '',
  content TEXT DEFAULT '',
  lang varchar(11) DEFAULT 'en',
  ctime INTEGER DEFAULT 0,
  mtime INTEGER DEFAULT 0
); 

INSERT INTO pages (title, access, groups, link, content, lang, ctime) VALUES('Start', 10,'main', 'start', 'the start page','en',1464551025);
INSERT INTO pages (title, access, groups, link, content, lang, ctime) VALUES('About Us',10, 'main', 'about', 'About Us','en',1464551025);
INSERT INTO pages (title, access, groups, link, content, lang, ctime) VALUES('Contact',10, 'main', 'contact', 'Contact with Us','en',1464551025);

INSERT INTO pages (title, access, groups, link, content, lang, ctime) VALUES('Start', 10,'main', 'start', 'Strona startowa','pl',1464551025);
INSERT INTO pages (title, access, groups, link, content, lang, ctime) VALUES('O Nas',10, 'main', 'about', 'Hej to o Nas','pl',1464551025);
INSERT INTO pages (title, access, groups, link, content, lang, ctime) VALUES('Kontakt',10, 'main', 'contact', 'Napisz do nas','pl',1464551025);



DROP TABLE  users;
CREATE TABLE  users (
  id INTEGER NOT NULL PRIMARY KEY IDENTITY(1,1),
  name varchar(20) UNIQUE,
  email varchar(20) UNIQUE,
  password varchar(99),
  role varchar(11) DEFAULT 'user',
  role_id INTEGER DEFAULT 5,
  first_name varchar(1010) DEFAULT '',
  last_name varchar(1010) DEFAULT '',
  address varchar(1010) DEFAULT '',
  phone varchar(20) DEFAULT '',
  description TEXT DEFAULT '',
  lang varchar(11) DEFAULT 'en'
); 

INSERT INTO users (id, name, email, password, role, role_id) VALUES(1, 'admin', 'admin@localhost.to', '40bd001563085fc351653210ea1ff5c5ecbdbbeef', 'admin',1);
INSERT INTO users (id, name, email, password, role, role_id) VALUES(2, 'me', 'me@be.mu', '40bd001563085fc351653210ea1ff5c5ecbdbbeef', 'editor',3);
INSERT INTO users (id, name, email, password, role, role_id) VALUES(3, 'kupa', 'kupa@kibel.tu', '36a32e106cbfd11fd108e8c108e38d10ad10b41f57f1a', 'user',5);