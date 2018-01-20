BEGIN TRANSACTION;
CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY,
  name varchar(20) NOT NULL UNIQUE,
  email varchar(20) NOT NULL UNIQUE,
  password char(99) NOT NULL,
  role varchar(11) DEFAULT 'user',
  role_id int(11) NOT NULL DEFAULT 10,
  first_name varchar(1010) DEFAULT '',
  last_name varchar(1010) DEFAULT '',
  address varchar(1010) DEFAULT '',
  phone varchar(20) DEFAULT '',
  description TEXT DEFAULT '',
  lang varchar(11) DEFAULT 'en'
);
INSERT INTO `users` (id,name,email,password,role,role_id,first_name,last_name,address,phone,description,lang) VALUES (1,'admin','admin@localhost.to','d033e22ae348aeb5660fc2140aec35850c4da997','admin',1,'','','','','','en');
INSERT INTO `users` (id,name,email,password,role,role_id,first_name,last_name,address,phone,description,lang) VALUES (2,'me','me@be.mu','40bd001563085fc351653210ea1ff5c5ecbdbbeef','editor',3,'','','','','','en');
INSERT INTO `users` (id,name,email,password,role,role_id,first_name,last_name,address,phone,description,lang) VALUES (3,'kupa','kupa@kibel.tu','36a32e106cbfd11fd108e8c108e38d10ad10b41f57f1a','user',5,'','','','','','en');
CREATE TABLE test (
  id int(115) NOT NULL,
  title varchar(115) NOT NULL,
  parent int(115) NOT NULL,
  link varchar(115) NOT NULL,
  content text NOT NULL
);
INSERT INTO `test` (id,title,parent,link,content) VALUES (1,'a',0,'a','a');
INSERT INTO `test` (id,title,parent,link,content) VALUES (4,'b',0,'b','a');
INSERT INTO `test` (id,title,parent,link,content) VALUES (5,'c',0,'c','a chuj');
INSERT INTO `test` (id,title,parent,link,content) VALUES (6,'d',0,'d','a');
INSERT INTO `test` (id,title,parent,link,content) VALUES (7,'e',0,'e','a');
INSERT INTO `test` (id,title,parent,link,content) VALUES (8,'f',4,'f','a dupa');
INSERT INTO `test` (id,title,parent,link,content) VALUES (2,'x',0,'x','a');
INSERT INTO `test` (id,title,parent,link,content) VALUES (10,'z',0,'z','a');
CREATE TABLE strings (
  id INTEGER NOT NULL PRIMARY KEY,
  name TEXT DEFAULT '',
  string TEXT DEFAULT '',
  access int(11) DEFAULT 10,
  groups varchar(255) NOT NULL DEFAULT 'main',
  lang varchar(11) DEFAULT 'en'
);
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (1,'Footer Contents.','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (2,'Ymvc <small>System</small>','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (3,'Ymvc','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (4,'Subtitle of this page','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (5,'Footer Header','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (6,'Start','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (7,'About Us','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (8,'Contact','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (9,'Table','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (10,'New','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (11,'Old','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (12,'File','',10,'main','en');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (13,'Footer Contents.','Zawartość Stopki.',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (14,'Ymvc <small>System</small>','Ymvc <small>System</small>',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (15,'Ymvc','',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (16,'Subtitle of this page','Podtytuł strony',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (17,'Footer Header','Nagłówek stopki',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (18,'Start','Start',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (19,'About Us','O Nas',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (20,'Contact','Kontakt',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (21,'Table','Tabela',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (22,'New','Nowy',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (23,'Old','Stary',10,'main','pl');
INSERT INTO `strings` (id,name,string,access,groups,lang) VALUES (24,'File','Plik',10,'main','pl');
CREATE TABLE "sitedata" (
  id INTEGER NOT NULL PRIMARY KEY,
  name varchar(255) NOT NULL,
  string TEXT DEFAULT '',
  access int(11) DEFAULT 10,
  groups varchar(255) NOT NULL DEFAULT 'main'
);
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (1,'page_title_str','Ymvc <small>System</small>',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (2,'page_subtitle_str','Subtitle of this page',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (3,'footer_title_str','Footer Header',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (4,'page_short_title_str','Ymvc',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (5,'menu','a:30:{i:0;a:6:{s:5:"title";s:3:"xxx";s:4:"link";s:3:"xxx";s:5:"group";s:4:"test";s:2:"id";s:2:"15";s:3:"pos";i:1;s:6:"parent";s:0:"";}i:1;a:6:{s:3:"pos";i:1;s:5:"title";s:13:"Administracja";s:4:"link";s:14:"?manage-manage";s:6:"parent";s:2:"12";s:2:"id";s:2:"11";s:5:"group";s:7:"modules";}i:2;a:6:{s:3:"pos";i:2;s:5:"title";s:8:"Programy";s:4:"link";s:5:"?apps";s:6:"parent";s:2:"11";s:2:"id";s:2:"12";s:5:"group";s:7:"modules";}i:3;a:6:{s:5:"title";s:5:"konta";s:4:"link";s:29:"?accounts-users=accounts-list";s:5:"group";s:5:"ledit";s:2:"id";s:2:"16";s:3:"pos";i:1;s:6:"parent";s:0:"";}i:4;a:6:{s:3:"pos";i:1;s:5:"title";s:7:"Account";s:4:"link";s:29:"?manage-manage=manage-account";s:6:"parent";s:0:"";s:2:"id";s:1:"8";s:5:"group";s:7:"default";}i:5;a:6:{s:3:"pos";i:2;s:5:"title";s:4:"Menu";s:4:"link";s:27:"?manage-manage=manage-menus";s:6:"parent";s:0:"";s:2:"id";s:1:"9";s:5:"group";s:7:"default";}i:6;a:6:{s:3:"pos";i:3;s:5:"title";s:6:"Layout";s:4:"link";s:29:"?manage-manage=manage-layouts";s:6:"parent";s:0:"";s:2:"id";s:2:"10";s:5:"group";s:7:"default";}i:7;a:6:{s:3:"pos";i:4;s:5:"title";s:6:"Manage";s:4:"link";s:28:"?manage-manage=manage-manage";s:6:"parent";s:0:"";s:2:"id";s:2:"16";s:5:"group";s:7:"default";}i:8;a:6:{s:3:"pos";i:1;s:5:"title";s:7:"Account";s:4:"link";s:29:"?accounts-users=accounts-list";s:6:"parent";s:0:"";s:2:"id";s:1:"9";s:5:"group";s:6:"manage";}i:9;a:6:{s:3:"pos";i:2;s:5:"title";s:9:"Typy kont";s:4:"link";s:30:"?accounts-users=accounts-roles";s:6:"parent";s:1:"9";s:2:"id";s:2:"10";s:5:"group";s:6:"manage";}i:10;a:6:{s:3:"pos";i:3;s:5:"title";s:6:"Layout";s:4:"link";s:29:"?manage-manage=manage-layouts";s:6:"parent";s:2:"15";s:2:"id";s:2:"11";s:5:"group";s:6:"manage";}i:11;a:6:{s:3:"pos";i:4;s:5:"title";s:7:"Modules";s:4:"link";s:29:"?manage-manage=manage-modules";s:6:"parent";s:2:"15";s:2:"id";s:2:"12";s:5:"group";s:6:"manage";}i:12;a:6:{s:3:"pos";i:5;s:5:"title";s:5:"Grupy";s:4:"link";s:28:"?manage-manage=manage-groups";s:6:"parent";s:2:"15";s:2:"id";s:2:"13";s:5:"group";s:6:"manage";}i:13;a:6:{s:3:"pos";i:6;s:5:"title";s:4:"Menu";s:4:"link";s:27:"?manage-manage=manage-menus";s:6:"parent";s:2:"15";s:2:"id";s:2:"14";s:5:"group";s:6:"manage";}i:14;a:6:{s:3:"pos";i:7;s:5:"title";s:13:"Administracja";s:4:"link";s:28:"?manage-manage=manage-manage";s:6:"parent";s:0:"";s:2:"id";s:2:"15";s:5:"group";s:6:"manage";}i:15;a:6:{s:3:"pos";i:1;s:5:"title";s:4:"test";s:4:"link";s:29:"?accounts-users=accounts-list";s:6:"parent";s:0:"";s:2:"id";s:2:"18";s:5:"group";s:5:"mains";}i:16;a:6:{s:5:"title";s:5:"Konta";s:4:"link";s:29:"?accounts-users=accounts-list";s:5:"group";s:6:"editor";s:2:"id";s:2:"17";s:3:"pos";i:1;s:6:"parent";s:0:"";}i:17;a:6:{s:5:"title";s:10:"Nowe Konto";s:4:"link";s:27:"?accounts-user=accounts-new";s:5:"group";s:6:"editor";s:2:"id";s:2:"18";s:3:"pos";i:2;s:6:"parent";s:0:"";}i:18;a:6:{s:5:"title";s:4:"Home";s:4:"link";s:11:"?page=index";s:5:"group";s:8:"pages-en";s:2:"id";s:2:"20";s:3:"pos";i:1;s:6:"parent";s:0:"";}i:19;a:6:{s:5:"title";s:7:"Contact";s:4:"link";s:13:"?page=contact";s:5:"group";s:8:"pages-en";s:2:"id";s:2:"21";s:3:"pos";i:2;s:6:"parent";s:0:"";}i:20;a:6:{s:5:"title";s:5:"About";s:4:"link";s:11:"?page=about";s:5:"group";s:8:"pages-en";s:2:"id";s:2:"22";s:3:"pos";i:3;s:6:"parent";s:0:"";}i:21;a:6:{s:3:"pos";i:1;s:5:"title";s:5:"Konta";s:4:"link";s:29:"?accounts-users=accounts-list";s:6:"parent";s:0:"";s:2:"id";s:1:"7";s:5:"group";s:5:"admin";}i:22;a:6:{s:5:"title";s:10:"Nowe Konto";s:4:"link";s:27:"?accounts-user=accounts-new";s:5:"group";s:5:"admin";s:2:"id";s:2:"19";s:3:"pos";i:2;s:6:"parent";s:0:"";}i:23;a:6:{s:5:"title";s:5:"Pages";s:4:"link";s:11:"?pages-edit";s:5:"group";s:5:"admin";s:2:"id";s:2:"23";s:3:"pos";i:3;s:6:"parent";s:0:"";}i:24;a:6:{s:5:"title";s:4:"Home";s:4:"link";s:19:"?lang=pl&page=index";s:5:"group";s:8:"pages-pl";s:2:"id";s:2:"24";s:3:"pos";i:1;s:6:"parent";s:0:"";}i:25;a:6:{s:5:"title";s:7:"Kontakt";s:4:"link";s:21:"?lang=pl&page=contact";s:5:"group";s:8:"pages-pl";s:2:"id";s:2:"25";s:3:"pos";i:2;s:6:"parent";s:0:"";}i:26;a:6:{s:5:"title";s:5:"O Nas";s:4:"link";s:19:"?lang=pl&page=about";s:5:"group";s:8:"pages-pl";s:2:"id";s:2:"26";s:3:"pos";i:3;s:6:"parent";s:0:"";}i:27;a:6:{s:5:"title";s:6:"Polski";s:4:"link";s:8:"?lang=pl";s:5:"group";s:10:"pages-lang";s:2:"id";s:2:"27";s:3:"pos";i:1;s:6:"parent";s:0:"";}i:28;a:6:{s:5:"title";s:7:"English";s:4:"link";s:8:"?lang=en";s:5:"group";s:10:"pages-lang";s:2:"id";s:2:"28";s:3:"pos";i:2;s:6:"parent";s:0:"";}i:29;a:6:{s:5:"title";s:5:"Login";s:4:"link";s:11:"?login-form";s:5:"group";s:10:"pages-lang";s:2:"id";s:2:"29";s:3:"pos";i:3;s:6:"parent";s:0:"";}}',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (6,'layout','a:20:{i:0;a:9:{s:3:"pos";i:1;s:4:"name";s:4:"menu";s:6:"module";s:13:"elements-menu";s:4:"view";s:15:"elements-navbar";s:5:"class";s:24:"navbar navbar-static-top";s:4:"attr";s:0:"";s:4:"mode";s:4:"hide";s:2:"id";s:1:"1";s:5:"group";s:5:"admin";}i:1;a:9:{s:3:"pos";i:2;s:4:"name";s:10:"admin menu";s:6:"module";s:20:"admin-administration";s:4:"view";s:0:"";s:5:"class";s:8:"col-sm-2";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:2:"13";s:5:"group";s:5:"admin";}i:2;a:9:{s:3:"pos";i:3;s:4:"name";s:4:"main";s:6:"module";s:6:"layout";s:4:"view";s:0:"";s:5:"class";s:27:"col-sm-10 panel  panel-info";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:1:"3";s:5:"group";s:5:"admin";}i:3;a:9:{s:3:"pos";i:4;s:4:"name";s:4:"time";s:6:"module";s:13:"check-gettime";s:4:"view";s:10:"check-time";s:5:"class";s:20:"col-sm-12 blockquote";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:1:"4";s:5:"group";s:5:"admin";}i:4;a:9:{s:3:"pos";i:1;s:4:"name";s:4:"menu";s:6:"module";s:13:"elements-menu";s:4:"view";s:12:"elements-nav";s:5:"class";s:9:"col-sm-12";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:1:"6";s:5:"group";s:7:"default";}i:5;a:9:{s:3:"pos";i:2;s:4:"name";s:8:"accounts";s:6:"module";s:13:"manage-manage";s:4:"view";s:13:"manage-manage";s:5:"class";s:9:"col-sm-12";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:1:"7";s:5:"group";s:7:"default";}i:6;a:9:{s:4:"name";s:13:"editordefault";s:6:"module";s:13:"elements-menu";s:4:"view";s:12:"elements-nav";s:5:"class";s:3:"nav";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:5:"group";s:8:"ldefault";s:2:"id";s:2:"15";s:3:"pos";i:1;}i:7;a:9:{s:4:"name";s:5:"konta";s:6:"module";s:14:"accounts-users";s:4:"view";s:13:"accounts-list";s:5:"class";s:17:"panel  panel-info";s:4:"attr";s:0:"";s:4:"mode";s:0:"";s:5:"group";s:8:"ldefault";s:2:"id";s:2:"16";s:3:"pos";i:2;}i:8;a:9:{s:3:"pos";i:1;s:4:"name";s:5:"konta";s:6:"module";s:14:"accounts-users";s:4:"view";s:13:"accounts-list";s:5:"class";s:17:"panel  panel-info";s:4:"attr";s:0:"";s:4:"mode";s:0:"";s:2:"id";s:2:"13";s:5:"group";s:7:"reditor";}i:9;a:9:{s:3:"pos";i:1;s:4:"name";s:7:"meditor";s:6:"module";s:13:"elements-menu";s:4:"view";s:12:"elements-nav";s:5:"class";s:12:"nav nav-tabs";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:2:"14";s:5:"group";s:5:"ledit";}i:10;a:9:{s:3:"pos";i:1;s:4:"name";s:13:"Administracja";s:6:"module";s:20:"admin-administration";s:4:"view";s:0:"";s:5:"class";s:8:"col-sm-2";s:4:"attr";s:0:"";s:4:"mode";s:0:"";s:2:"id";s:2:"14";s:5:"group";s:6:"editor";}i:11;a:9:{s:3:"pos";i:2;s:4:"name";s:4:"main";s:6:"module";s:6:"layout";s:4:"view";s:0:"";s:5:"class";s:30:"col-sm-10 panel  panel-primary";s:4:"attr";s:0:"";s:4:"mode";s:0:"";s:2:"id";s:2:"11";s:5:"group";s:6:"editor";}i:12;a:9:{s:3:"pos";i:1;s:4:"name";s:6:"manage";s:6:"module";s:5:"route";s:4:"view";s:7:"default";s:5:"class";s:9:"col-sm-12";s:4:"attr";s:1:"1";s:4:"mode";s:3:"sys";s:2:"id";s:1:"5";s:5:"group";s:4:"main";}i:13;a:9:{s:3:"pos";i:1;s:4:"name";s:3:"nav";s:6:"module";s:13:"elements-menu";s:4:"view";s:12:"elements-nav";s:5:"class";s:9:"col-sm-12";s:4:"attr";s:6:"manage";s:4:"mode";s:3:"sys";s:2:"id";s:2:"10";s:5:"group";s:6:"manage";}i:14;a:9:{s:4:"name";s:8:"register";s:6:"module";s:15:"register-signin";s:4:"view";s:13:"register-form";s:5:"class";s:0:"";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:5:"group";s:6:"signin";s:2:"id";s:2:"16";s:3:"pos";i:1;}i:15;a:9:{s:3:"pos";i:1;s:4:"name";s:5:"konto";s:6:"module";s:13:"accounts-user";s:4:"view";s:9:"user-edit";s:5:"class";s:7:"section";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:2:"18";s:5:"group";s:6:"normal";}i:16;a:9:{s:3:"pos";i:1;s:4:"name";s:9:"userlogin";s:6:"module";s:10:"login-form";s:4:"view";s:10:"login-form";s:5:"class";s:0:"";s:4:"attr";s:0:"";s:4:"mode";s:3:"sys";s:2:"id";s:2:"18";s:5:"group";s:5:"login";}i:17;a:9:{s:4:"name";s:6:"UAppid";s:6:"module";s:5:"appid";s:4:"view";s:0:"";s:5:"class";s:0:"";s:4:"attr";s:0:"";s:4:"mode";s:3:"app";s:5:"group";s:5:"appid";s:2:"id";s:2:"19";s:3:"pos";i:1;}i:18;a:9:{s:3:"pos";i:1;s:4:"name";s:3:"Any";s:6:"module";s:3:"any";s:4:"view";s:8:"any-view";s:5:"class";s:9:"container";s:4:"attr";s:0:"";s:4:"mode";s:3:"app";s:2:"id";s:2:"16";s:5:"group";s:3:"any";}i:19;a:9:{s:3:"pos";i:1;s:4:"name";s:3:"App";s:6:"module";s:10:"user-start";s:4:"view";s:10:"user-start";s:5:"class";s:9:"container";s:4:"attr";s:0:"";s:4:"mode";s:7:"system/";s:2:"id";s:2:"14";s:5:"group";s:4:"user";}}',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (7,'modules','a:26:{i:0;a:5:{s:4:"path";s:33:"system/controllers/accounts/users";s:5:"title";s:12:"Login Module";s:5:"group";s:6:"editor";s:2:"id";s:1:"9";s:13:"access_groups";s:0:"";}i:1;a:5:{s:4:"path";s:32:"system/controllers/elements/menu";s:5:"title";s:10:"menus show";s:5:"group";s:6:"editor";s:2:"id";s:2:"10";s:13:"access_groups";s:0:"";}i:2;a:5:{s:4:"path";s:39:"system/controllers/admin/administration";s:5:"title";s:26:"Main Administration Manage";s:5:"group";s:6:"editor";s:2:"id";s:2:"11";s:13:"access_groups";s:12:"admin,editor";}i:3;a:5:{s:4:"path";s:32:"system/controllers/check/gettime";s:5:"title";s:11:"Empty title";s:5:"group";s:6:"editor";s:2:"id";s:2:"12";s:13:"access_groups";s:0:"";}i:4;a:5:{s:4:"path";s:32:"system/controllers/manage/manage";s:5:"title";s:21:"Administration Module";s:5:"group";s:6:"editor";s:2:"id";s:2:"13";s:13:"access_groups";s:12:"admin,editor";}i:5;a:5:{s:4:"path";s:32:"system/controllers/accounts/user";s:5:"title";s:12:"Login Module";s:5:"group";s:6:"editor";s:2:"id";s:2:"14";s:13:"access_groups";s:0:"";}i:6;a:5:{s:4:"path";s:34:"system/controllers/register/signin";s:5:"title";s:15:"Register Module";s:5:"group";s:6:"signin";s:2:"id";s:2:"19";s:13:"access_groups";s:0:"";}i:7;a:5:{s:4:"path";s:29:"system/controllers/login/form";s:5:"title";s:12:"Login Module";s:5:"group";s:3:"any";s:2:"id";s:1:"2";s:13:"access_groups";s:0:"";}i:8;a:5:{s:4:"path";s:32:"system/controllers/check/gettime";s:5:"title";s:11:"Empty title";s:5:"group";s:3:"any";s:2:"id";s:1:"7";s:13:"access_groups";s:0:"";}i:9;a:5:{s:4:"path";s:32:"system/controllers/register/form";s:5:"title";s:15:"Register Module";s:5:"group";s:3:"any";s:2:"id";s:2:"16";s:13:"access_groups";s:0:"";}i:10;a:5:{s:4:"path";s:19:"app/controllers/any";s:5:"title";s:10:"Empty user";s:5:"group";s:3:"any";s:2:"id";s:2:"21";s:13:"access_groups";s:0:"";}i:11;a:5:{s:4:"path";s:29:"system/controllers/login/form";s:5:"title";s:12:"Login Module";s:5:"group";s:5:"login";s:2:"id";s:2:"22";s:13:"access_groups";s:0:"";}i:12;a:5:{s:4:"path";s:21:"app/controllers/appid";s:5:"title";s:15:"Register Module";s:5:"group";s:5:"appid";s:2:"id";s:2:"23";s:13:"access_groups";s:0:"";}i:13;a:5:{s:4:"path";s:29:"system/controllers/login/form";s:5:"title";s:12:"Login Module";s:5:"group";s:4:"user";s:2:"id";s:2:"18";s:13:"access_groups";s:0:"";}i:14;a:5:{s:4:"path";s:32:"system/controllers/accounts/user";s:5:"title";s:19:"account edit Module";s:5:"group";s:4:"user";s:2:"id";s:2:"19";s:13:"access_groups";s:0:"";}i:15;a:5:{s:4:"path";s:21:"app/controllers/appid";s:5:"title";s:15:"Register Module";s:5:"group";s:4:"user";s:2:"id";s:2:"20";s:13:"access_groups";s:0:"";}i:16;a:5:{s:4:"path";s:29:"system/controllers/user/start";s:5:"title";s:10:"Empty user";s:5:"group";s:4:"user";s:2:"id";s:2:"24";s:13:"access_groups";s:0:"";}i:17;a:5:{s:4:"path";s:39:"system/controllers/admin/administration";s:5:"title";s:26:"Main Administration Manage";s:5:"group";s:5:"admin";s:2:"id";s:1:"2";s:13:"access_groups";s:12:"admin,editor";}i:18;a:5:{s:4:"path";s:32:"system/controllers/elements/menu";s:5:"title";s:10:"menus show";s:5:"group";s:5:"admin";s:2:"id";s:1:"3";s:13:"access_groups";s:0:"";}i:19;a:5:{s:4:"path";s:32:"system/controllers/check/gettime";s:5:"title";s:11:"Empty title";s:5:"group";s:5:"admin";s:2:"id";s:1:"4";s:13:"access_groups";s:0:"";}i:20;a:5:{s:4:"path";s:32:"system/controllers/manage/manage";s:5:"title";s:21:"Administration Module";s:5:"group";s:5:"admin";s:2:"id";s:1:"5";s:13:"access_groups";s:12:"admin,editor";}i:21;a:5:{s:4:"path";s:30:"system/controllers/other/admin";s:5:"title";s:11:"Empty title";s:5:"group";s:5:"admin";s:2:"id";s:1:"8";s:13:"access_groups";s:0:"";}i:22;a:5:{s:4:"path";s:32:"system/controllers/accounts/user";s:5:"title";s:12:"Login Module";s:5:"group";s:5:"admin";s:2:"id";s:2:"15";s:13:"access_groups";s:0:"";}i:23;a:5:{s:4:"path";s:34:"system/controllers/register/signin";s:5:"title";s:15:"Register Module";s:5:"group";s:5:"admin";s:2:"id";s:2:"17";s:13:"access_groups";s:0:"";}i:24;a:5:{s:4:"path";s:33:"system/controllers/accounts/users";s:5:"title";s:12:"Namage users";s:5:"group";s:5:"admin";s:2:"id";s:2:"17";s:13:"access_groups";s:12:"admin,editor";}i:25;a:5:{s:4:"path";s:29:"system/controllers/pages/edit";s:5:"title";s:10:"Empty user";s:5:"group";s:5:"admin";s:2:"id";s:2:"25";s:13:"access_groups";s:0:"";}}',10,'main');
INSERT INTO `sitedata` (id,name,string,access,groups) VALUES (8,'pagehead','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->',10,'main');
CREATE TABLE "pages1" (
  id INTEGER NOT NULL PRIMARY KEY,
  title varchar(255) DEFAULT '',
  access int(11) DEFAULT 10,
  groups varchar(255) DEFAULT 'main',
  link varchar(255) DEFAULT '',
  content TEXT DEFAULT '',
  lang varchar(11) DEFAULT 'en',
  ctime int(11) DEFAULT 0,
  mtime int(11) DEFAULT 0
);
INSERT INTO `pages1` (id,title,access,groups,link,content,lang,ctime,mtime) VALUES (1,'Start',10,'main','start','the start page','en',1464551025,0);
INSERT INTO `pages1` (id,title,access,groups,link,content,lang,ctime,mtime) VALUES (2,'About Us',10,'main','about','About Us','en',1464551025,0);
INSERT INTO `pages1` (id,title,access,groups,link,content,lang,ctime,mtime) VALUES (3,'Contact',10,'main','contact','Contact with Us','en',1464551025,0);
INSERT INTO `pages1` (id,title,access,groups,link,content,lang,ctime,mtime) VALUES (4,'Start',10,'main','start','Strona startowa','pl',1464551025,0);
INSERT INTO `pages1` (id,title,access,groups,link,content,lang,ctime,mtime) VALUES (5,'O Nas',10,'main','about','Hej to o Nas','pl',1464551025,0);
INSERT INTO `pages1` (id,title,access,groups,link,content,lang,ctime,mtime) VALUES (6,'Kontakt',10,'main','contact','Napisz do nas','pl',1464551025,0);
CREATE TABLE "pages" (
	`title`	varchar(99) DEFAULT 'Default Header',
	`header`	TEXT DEFAULT '<header>header</header>',
	`footer`	TEXT DEFAULT '<section>Body Content</section>',
	`body`	TEXT DEFAULT '<footer>footer</footer>',
	`lang`	varchar(5) DEFAULT 'en',
	`head`	TEXT DEFAULT '<head></head>',
	`theme`	varchar(40) DEFAULT 'default',
	`pagelink`	varchar(99)
);
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('Witamy','<h1>xxxx<br></h1><p><br></p>','<p>fghjjk ffhkl<br></p><p><a href="http://?appid">dfghjkl</a><br></p>',' <div class="cover">
      {{menu}}
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">A Subs</h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h1 class="text-primary">A title</h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
            {{langmenu}} 
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','pl','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','empty','index');
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('Start','<header>header</header>','<section>Body Content</section>',' <div class="cover">
      <div class="navbar">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>Brand</span></a>
          </div>
          <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="active">
                <a href="#">Home</a>
              </li>
              <li>
                <a href="#">Contacts</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">A Subs<br></h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h1 class="text-primary">A title</h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','ru','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','default','index');
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('Welcome','<header>header</header>','<section>Body Content</section>',' <div class="cover">
      {{menu}}
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">A Subs</h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h1 class="text-primary">A title</h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
            {{langmenu}}
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','en','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','default','index');
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('Contact','<header>header</header>','<section>Body Content</section>',' <div class="cover">
      {{menu}}
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">A Contact<br></h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6"><br></div>
          <div class="col-md-6">
            {{header}}
          </div><div class="col-md-6" align="center">{{head}}
          <br></div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
            {{langmenu}} 
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','en','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','default','contact');
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('Kontakt','<header>header</header>','<section>Body Content</section>',' <div class="cover">
      {{menu}}
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">Kontakt<br></h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6"><br></div>
          <div class="col-md-6">
            
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
            {{langmenu}} 
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','pl','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','default','contact');
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('About Us','<header>header</header>','<section>Body Content</section>',' <div class="cover">
      {{menu}}
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">About Us<br></h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
            {{langmenu}} 
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','en','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','default','about');
INSERT INTO `pages` (title,header,footer,body,lang,head,theme,pagelink) VALUES ('O nas','<header>header</header>','<section>Body Content</section>',' <div class="cover">
      {{menu}}
      <div class="cover-image" style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25"></div>
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-inverse">Heading</h1>
            <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
            <br>
            <br>
            <a class="btn btn-lg btn-primary">Click me</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
          </div>
          <div class="col-md-6">
            <h1 class="text-primary">O nas<br></h1>
            <h3>A subtitle</h3>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
              ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
              dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
              nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
              Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
              enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
              felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
              elementum semper nisi.</p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-primary">Team</h1>
            <p class="text-center">We are a group of skilled individuals.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
          <div class="col-md-4">
            <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png" class="center-block img-circle img-responsive">
            <h3 class="text-center">John Doe</h3>
            <p class="text-center">Developer</p>
          </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <h1>Footer header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
              <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
              <br>Ut enim ad minim veniam, quis nostrud</p>
            {{langmenu}} 
          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>','pl','  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="libriares/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-combobox/bootstrap-combobox.js"></script>
	<script type="text/javascript" src="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.js"></script>
	<link href="libriares/libs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="libriares/libs/bootstrap-toggle/2.2.2/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libriares/libs/bootstrap-combobox/bootstrap-combobox.css">
    <link href="libriares/libs/theme/css/bs-style-nice.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="libriares/libs/theme/js/script.js"></script>
    <link href="libriares/libs/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script type="text/javascript" src="libriares/libs/datepicker/js/bootstrap-datepicker.min.js"></script>    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->','default','about');
CREATE TABLE msgs_ignored (id INTEGER NOT NULL PRIMARY KEY,msgid varchar(99) not null,appid varchar(99) not null,for_account integer not null,code integer not null,lat varchar(99) not null,lon varchar(99) not null,itime integer not null,atime integer,ctime integer not null,mtime integer,dtime integer);
CREATE TABLE msgs_history (id INTEGER NOT NULL PRIMARY KEY,msgid varchar(99) not null,appid varchar(99) not null,for_account integer not null,code integer not null,lat varchar(99) not null,lon varchar(99) not null,atime integer,itime integer,ctime integer not null,mtime integer,dtime integer not null);
CREATE TABLE msgs_confirm (id INTEGER NOT NULL PRIMARY KEY,msgid varchar(99) not null,appid varchar(99) not null,for_account integer not null,code integer not null,lat varchar(99) not null,lon varchar(99) not null,atime integer not null,itime integer,ctime integer not null,mtime integer,dtime integer);
CREATE TABLE msgs (id INTEGER NOT NULL PRIMARY KEY,msgid varchar(99) not null,appid varchar(99) not null,for_account integer not null,code integer not null,lat varchar(99) not null,lon varchar(99) not null,answers TEXT,ctime integer not null,mtime integer,dtime integer);
CREATE TABLE menus (
  id INTEGER NOT NULL PRIMARY KEY,
  pos int(11) NOT NULL,
  title varchar(255) NOT NULL,
  link varchar(255) NOT NULL,
  parent varchar(255) NOT NULL DEFAULT '',
  access int(11) DEFAULT 10,
  groups varchar(255) NOT NULL DEFAULT 'main',
  lang varchar(11) DEFAULT 'en'
);
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (1,1,'Start','start','',10,'main','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (2,4,'About Us','about','',10,'main','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (3,3,'Contact','contact','',10,'main','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (4,2,'Table','?table=table','1',10,'main','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (5,1,'Start','start','',10,'main','pl');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (6,2,'O nas','about','',10,'main','pl');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (7,3,'Kontakt','contact','',10,'main','pl');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (8,4,'Tabela','?table=table','1',10,'main','pl');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (9,2,'Menu','?admin:menus&data=sec','',10,'sec','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (10,3,'Account','?admin:account','',10,'sec','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (11,1,'Start','?admin','',10,'sec','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (15,1,'Start','?admin','',10,'admin','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (16,2,'Account','?admin-mngaccount','1',10,'admin','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (17,3,'Menu','?admin-mngmenus&data=admin','1',10,'admin','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (18,4,'Logout','?login-form&action=logout','',10,'admin','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (19,1,'Login','?admin-mngaccount','',10,'any','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (20,2,'One','?other-one=other-one','',10,'any','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (22,1,'Menu','?admin-mngmenus','',10,'manage','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (24,2,'Account','?admin-mngaccount','',10,'manage','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (25,4,'Testing','?test-test','',10,'manage','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (26,2,'Menu','?admin-mngmenus','',10,'default','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (27,2,'Layout','?admin-mnglayout','',10,'default','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (28,3,'Account','?admin-mngaccount','',10,'default','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (29,4,'Testing','?test-test','',10,'default','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (30,5,'Layouts','?layout-mnglayouts','1',10,'admin','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (31,3,'Layouts','?layout-mnglayouts','',10,'manage','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (32,2,'Menu','?admin-mngmenus','',10,'menus','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (33,2,'Account','?admin-mngaccount','',10,'menus','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (34,3,'Layout','?layout-mnglayouts','',10,'menus','en');
INSERT INTO `menus` (id,pos,title,link,parent,access,groups,lang) VALUES (35,4,'Testing','?test-test','',10,'menus','en');
CREATE TABLE mainsettings (id INTEGER NOT NULL PRIMARY KEY,name varchar(255) NOT NULL,value TEXT DEFAULT '',idx int(99) DEFAULT 1,gprx varchar(255) NOT NULL DEFAULT 'main');
INSERT INTO `mainsettings` (id,name,value,idx,gprx) VALUES (1,'?admin','Ustawienia Główne',2,'main');
INSERT INTO `mainsettings` (id,name,value,idx,gprx) VALUES (2,'?admin-mngaccounts','Zarządzaj Profilami',2,'main');
INSERT INTO `mainsettings` (id,name,value,idx,gprx) VALUES (3,'?layout-mnglayouts','Zarządzaj Rozkładem Strony',2,'main');
INSERT INTO `mainsettings` (id,name,value,idx,gprx) VALUES (4,'?admin-mngmenus','Zarządzaj Menu',2,'main');
INSERT INTO `mainsettings` (id,name,value,idx,gprx) VALUES (5,'?test-test','Test',2,'main');
CREATE TABLE loginusers (id INTEGER NOT NULL PRIMARY KEY,name varchar(255) NOT NULL,value TEXT DEFAULT '',idx int(99) DEFAULT 1,gprx varchar(255) NOT NULL DEFAULT 'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (1,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (2,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (3,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (4,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (5,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (6,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (7,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (8,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (9,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (10,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (11,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (12,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (13,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (14,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (15,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (16,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (17,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (18,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (19,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (20,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (21,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (22,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (23,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (24,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (25,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (26,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (27,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (28,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (29,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (30,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (31,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (32,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (33,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (34,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (35,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (36,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (37,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (38,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (39,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (40,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (41,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (42,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (43,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (44,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (45,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (46,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (47,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (48,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (49,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (50,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (51,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (52,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (53,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (54,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (55,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (56,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (57,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (58,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (59,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (60,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (61,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (62,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (63,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (64,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (65,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (66,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (67,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (68,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (69,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (70,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (71,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (72,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (73,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (74,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (75,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (76,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (77,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (78,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (79,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (80,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (81,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (82,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (83,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (84,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (85,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (86,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (87,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (88,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (89,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (90,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (91,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (92,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (93,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (94,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (95,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (96,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (97,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (98,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (99,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (100,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (101,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (102,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (103,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (104,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (105,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (106,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (107,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (108,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (109,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (110,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (111,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (112,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (113,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (114,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (115,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (116,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (117,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (118,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (119,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (120,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (121,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (122,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (123,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (124,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (125,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (126,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (127,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (128,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (129,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (130,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (131,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (132,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (133,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (134,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (135,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (136,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (137,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (138,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (139,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (140,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (141,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (142,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (143,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (144,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (145,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (146,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (147,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (148,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (149,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (150,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (151,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (152,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (153,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (154,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (155,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (156,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (157,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (158,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (159,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (160,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (161,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (162,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (163,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (164,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (165,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (166,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (167,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (168,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (169,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (170,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (171,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (172,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (173,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (174,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (175,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (176,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (177,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (178,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (179,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (180,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (181,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (182,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (183,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (184,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (185,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (186,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (187,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (188,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (189,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (190,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (191,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (192,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (193,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (194,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (195,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (196,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (197,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (198,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (199,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (200,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (201,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (202,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (203,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (204,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (205,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (206,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (207,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (208,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (209,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (210,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (211,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (212,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (213,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (214,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (215,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (216,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (217,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (218,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (219,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (220,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (221,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (222,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (223,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (224,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (225,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (226,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (227,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (228,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (229,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (230,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (231,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (232,'can_login','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (233,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (234,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (235,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (236,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (237,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (238,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (239,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (240,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (241,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (242,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (243,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (244,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (245,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (246,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (247,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (248,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (249,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (250,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (251,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (252,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (253,'can_login','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (254,'active','yes',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (255,'account_role','editor',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (256,'account_login','editor',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (257,'account_pass','ab41949825606da179db7c89ddcedcc167b64847',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (258,'account_name','user',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (259,'account_email','user@localhost.to',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (260,'www','ert!eśri!',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (261,'mail','aaz@sdfghjk.oo',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (262,'address','a:1:{i:0;a:7:{s:4:"city";s:7:"Słupsk";s:6:"street";s:5:"Pusta";s:10:"apartament";s:2:"13";s:6:"number";s:3:"442";s:11:"postal_code";s:6:"76-200";s:11:"postal_city";s:7:"Słupsk";s:7:"country";s:6:"Polska";}}',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (263,'adnotation','<p>ghjkl <b>fghjklm</b> rtuiomó<br></p>',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (264,'files','',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (265,'role_id','5',1,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (266,'active','yes',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (267,'account_role','admin',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (268,'account_login','admin',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (269,'account_pass','d033e22ae348aeb5660fc2140aec35850c4da997',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (270,'account_name','admin',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (271,'account_email','admin@localhost.to',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (272,'adnotation','',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (273,'files','',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (274,'role_id','5',0,'login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (275,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (276,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (277,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (278,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (279,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (280,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (281,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (282,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (283,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (284,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (285,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (286,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (287,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (288,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (289,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (290,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (291,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (292,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (293,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (294,'can_login','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (295,'active','yes','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (296,'account_role','user','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (297,'account_login','','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (298,'account_pass',NULL,'','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (299,'account_name','','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (300,'account_email','','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (301,'account_born','11-02-2017','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (302,'adnotation','','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (303,'files','','','login');
INSERT INTO `loginusers` (id,name,value,idx,gprx) VALUES (304,'role_id','5','','login');
CREATE TABLE layouts (id INTEGER NOT NULL PRIMARY KEY,name varchar(255) NOT NULL,value TEXT DEFAULT '',idx int(99) DEFAULT 1,gprx varchar(255) NOT NULL DEFAULT 'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (1,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (2,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (3,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (4,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (5,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (6,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (7,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (8,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (9,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (10,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (11,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (12,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (13,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (14,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (15,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (16,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (17,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (18,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (19,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (20,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (21,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (22,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (23,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (24,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (25,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (26,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (27,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (28,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (29,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (30,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (31,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (32,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (33,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (34,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (35,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (36,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (37,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (38,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (39,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (40,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (41,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (42,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (43,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (44,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (45,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (46,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (47,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (48,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (49,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (50,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (51,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (52,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (53,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (54,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (55,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (56,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (57,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (58,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (59,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (60,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (61,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (62,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (63,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (64,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (65,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (66,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (67,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (68,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (69,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (70,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (71,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (72,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (73,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (74,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (75,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (76,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (77,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (78,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (79,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (80,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (81,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (82,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (83,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (84,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (85,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (86,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (87,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (88,'pos','1',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (89,'name','login',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (90,'module','login-form',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (91,'view','',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (92,'class','',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (93,'attrid','',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (94,'mode','',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (95,'group','any',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (96,'id','8',8,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (97,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (98,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (99,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (100,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (101,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (102,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (103,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (104,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (105,'pos','1',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (106,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (107,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (108,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (109,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (110,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (111,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (112,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (113,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (114,'pos','2',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (115,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (116,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (117,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (118,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (119,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (120,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (121,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (122,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (123,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (124,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (125,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (126,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (127,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (128,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (129,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (130,'pos','1',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (131,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (132,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (133,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (134,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (135,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (136,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (137,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (138,'pos','2',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (139,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (140,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (141,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (142,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (143,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (144,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (145,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (146,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (147,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (148,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (149,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (150,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (151,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (152,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (153,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (154,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (155,'pos','1',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (156,'name','route menu',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (157,'module','elements-menu',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (158,'view','elements-nav',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (159,'class','col-sm-12',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (160,'attrid','',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (161,'mode','sys',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (162,'group','manage',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (163,'id','11',11,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (164,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (165,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (166,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (167,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (168,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (169,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (170,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (171,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (181,'name','menus',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (182,'module','elements-menu',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (183,'view','elements-nav',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (184,'class','col-sm-12',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (185,'attrid','',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (186,'mode','sys',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (187,'group','default',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (188,'id','6',6,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (189,'name','account',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (190,'module','admin-mngaccount',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (191,'view','',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (192,'class','col-sm-12',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (193,'attrid','',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (194,'mode','sys',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (195,'group','default',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (196,'id','7',7,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (197,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (198,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (199,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (200,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (201,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (202,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (203,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (204,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (205,'pos','3',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (206,'name','usermenu',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (207,'module','elements-menu',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (208,'view','elements-nav',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (209,'class','nav navbar',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (210,'attrid','',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (211,'mode','',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (212,'group','user',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (213,'id','9',9,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (214,'name','loginuser',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (215,'module','login-form',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (216,'view','login-welcome',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (217,'class','col-sm-12',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (218,'attrid','',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (219,'mode','',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (220,'group','user',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (221,'id','10',10,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (222,'name','times',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (223,'module','check-gettime',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (224,'view','check-time',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (225,'class','row',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (226,'attrid','',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (227,'mode','',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (228,'group','user',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (229,'id','12',12,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (239,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (240,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (241,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (242,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (243,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (244,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (245,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (246,'pos','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (255,'name','manage',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (256,'module','route',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (257,'view','default',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (258,'class','col-sm-12',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (259,'attrid','1',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (260,'mode','sys',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (261,'group','main',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (262,'id','5',5,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (263,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (264,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (265,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (266,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (267,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (268,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (269,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (270,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (271,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (272,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (273,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (274,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (275,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (276,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (277,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (278,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (279,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (280,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (281,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (282,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (283,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (284,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (285,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (286,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (287,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (288,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (289,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (290,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (291,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (292,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (293,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (294,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (295,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (296,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (297,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (298,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (299,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (300,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (301,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (302,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (303,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (304,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (305,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (306,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (307,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (308,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (309,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (310,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (311,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (312,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (313,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (314,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (315,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (316,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (317,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (318,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (319,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (320,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (321,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (322,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (323,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (324,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (325,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (326,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (327,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (328,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (329,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (330,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (331,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (332,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (333,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (334,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (335,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (336,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (337,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (338,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (339,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (340,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (341,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (342,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (343,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (344,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (345,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (346,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (347,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (348,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (349,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (350,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (351,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (352,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (353,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (354,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (355,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (356,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (357,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (358,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (359,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (360,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (361,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (362,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (363,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (364,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (365,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (366,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (367,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (368,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (369,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (370,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (371,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (372,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (373,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (374,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (375,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (376,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (377,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (378,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (379,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (380,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (381,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (382,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (383,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (384,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (385,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (386,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (387,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (388,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (389,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (390,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (391,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (392,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (393,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (394,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (395,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (396,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (397,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (398,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (399,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (400,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (401,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (402,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (403,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (404,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (405,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (406,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (407,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (408,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (409,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (410,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (411,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (412,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (413,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (414,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (415,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (416,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (417,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (418,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (419,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (420,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (421,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (422,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (423,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (424,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (425,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (426,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (427,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (428,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (429,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (430,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (431,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (432,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (433,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (434,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (435,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (436,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (437,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (438,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (439,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (440,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (441,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (442,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (443,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (444,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (445,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (446,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (447,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (448,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (449,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (450,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (451,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (452,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (453,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (454,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (455,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (456,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (457,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (458,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (459,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (460,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (461,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (462,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (463,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (464,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (465,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (466,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (467,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (468,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (469,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (470,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (471,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (472,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (473,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (474,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (475,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (476,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (477,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (478,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (479,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (480,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (481,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (482,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (483,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (484,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (485,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (486,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (487,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (488,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (489,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (490,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (491,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (492,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (493,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (494,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (495,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (496,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (497,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (498,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (499,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (500,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (501,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (502,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (503,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (504,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (505,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (506,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (507,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (508,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (509,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (510,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (511,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (512,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (513,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (514,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (515,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (516,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (517,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (518,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (519,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (520,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (521,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (522,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (523,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (524,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (525,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (526,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (527,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (528,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (529,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (530,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (531,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (532,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (533,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (534,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (535,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (536,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (537,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (538,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (539,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (540,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (541,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (542,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (543,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (544,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (545,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (546,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (547,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (548,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (549,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (550,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (551,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (552,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (553,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (554,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (555,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (556,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (557,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (558,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (559,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (560,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (561,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (562,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (563,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (564,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (565,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (566,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (567,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (568,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (569,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (570,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (571,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (572,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (573,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (574,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (575,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (576,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (577,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (578,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (579,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (580,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (581,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (582,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (583,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (584,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (585,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (586,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (587,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (588,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (589,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (590,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (591,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (592,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (593,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (594,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (595,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (596,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (597,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (598,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (599,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (600,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (601,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (602,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (603,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (604,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (605,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (606,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (607,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (608,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (609,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (610,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (611,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (612,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (613,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (614,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (615,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (616,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (617,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (618,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (619,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (620,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (621,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (622,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (623,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (624,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (625,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (626,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (627,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (628,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (629,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (630,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (631,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (632,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (633,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (634,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (635,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (636,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (637,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (638,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (639,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (640,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (641,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (642,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (643,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (644,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (645,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (646,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (647,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (648,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (649,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (650,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (651,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (652,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (653,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (654,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (655,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (656,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (657,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (658,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (659,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (660,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (661,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (662,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (663,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (664,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (665,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (666,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (667,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (668,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (669,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (670,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (671,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (672,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (673,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (674,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (675,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (676,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (677,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (678,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (679,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (680,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (681,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (682,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (683,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (684,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (685,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (686,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (687,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (688,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (689,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (690,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (691,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (692,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (693,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (694,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (695,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (696,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (697,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (698,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (699,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (700,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (701,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (702,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (703,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (704,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (705,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (706,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (707,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (708,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (709,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (710,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (711,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (712,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (713,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (714,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (715,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (716,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (717,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (718,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (719,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (720,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (721,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (722,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (723,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (724,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (725,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (726,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (727,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (728,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (729,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (730,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (731,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (732,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (733,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (734,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (735,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (736,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (737,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (738,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (739,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (740,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (741,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (742,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (743,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (744,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (745,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (746,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (747,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (748,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (749,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (750,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (751,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (752,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (753,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (754,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (755,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (756,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (757,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (758,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (759,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (760,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (761,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (762,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (763,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (764,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (765,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (766,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (767,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (768,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (769,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (770,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (771,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (772,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (773,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (774,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (775,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (776,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (777,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (778,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (779,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (780,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (781,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (782,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (783,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (784,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (785,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (786,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (787,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (788,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (789,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (790,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (791,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (792,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (793,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (794,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (795,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (796,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (797,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (798,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (799,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (800,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (801,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (802,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (803,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (804,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (805,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (806,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (807,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (808,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (809,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (810,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (811,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (812,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (813,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (814,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (815,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (816,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (817,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (818,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (819,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (820,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (821,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (822,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (823,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (824,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (825,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (826,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (827,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (828,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (829,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (830,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (831,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (832,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (833,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (834,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (835,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (836,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (837,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (838,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (839,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (840,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (841,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (842,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (843,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (844,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (845,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (846,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (847,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (848,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (849,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (850,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (851,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (852,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (853,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (854,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (855,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (856,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (857,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (858,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (859,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (860,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (861,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (862,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (863,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (864,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (865,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (866,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (867,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (868,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (869,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (870,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (871,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (872,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (873,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (874,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (875,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (876,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (877,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (878,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (879,'pos','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (880,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (881,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (882,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (883,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (884,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (885,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (886,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (887,'pos','2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (888,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (889,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (890,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (891,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (892,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (893,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (894,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (895,'pos','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (896,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (897,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (898,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (899,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (900,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (901,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (902,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (903,'pos','4',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (904,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (905,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (906,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (907,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (908,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (909,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (910,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (911,'pos','5',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (912,'name','menu',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (913,'module','elements-menu',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (914,'view','elements-navright',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (915,'class','navbar navbar-default navbar-fixed-top',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (916,'attrid','',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (917,'mode','app',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (918,'group','admin',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (919,'id','1',1,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (920,'name','admin menu',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (921,'module','admin-administration',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (922,'view','',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (923,'class','col-sm-2',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (924,'attrid','',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (925,'mode','sys',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (926,'group','admin',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (927,'id','13',13,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (928,'name','main',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (929,'module','layout',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (930,'view','',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (931,'class','col-sm-10',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (932,'attrid','',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (933,'mode','',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (934,'group','admin',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (935,'id','3',3,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (936,'name','two',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (937,'module','other-two',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (938,'view','other-two',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (939,'class','col-sm-12',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (940,'attrid','',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (941,'mode','',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (942,'group','admin',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (943,'id','2',2,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (944,'name','time',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (945,'module','check-gettime',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (946,'view','check-time',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (947,'class','col-sm-12',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (948,'attrid','',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (949,'mode','',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (950,'group','admin',4,'layout');
INSERT INTO `layouts` (id,name,value,idx,gprx) VALUES (951,'id','4',4,'layout');
CREATE TABLE cars (id INTEGER NOT NULL PRIMARY KEY,color varchar(99),marka varchar(99),typ varchar(99),rejestracja varchar(20),rodzaj integer not null,rok integer,opis TEXT,for_account integer not null,in_use integer,ctime integer not null,mtime integer not null);
CREATE TABLE appids (id INTEGER NOT NULL PRIMARY KEY,appid varchar(99) not null,for_account integer not null,in_use integer,ctime integer not null,mtime integer,dtime integer);
INSERT INTO `appids` (id,appid,for_account,in_use,ctime,mtime,dtime) VALUES (1,'1a399c4a-b836-cb47-3583-420601604588',9,NULL,1489560684,NULL,NULL);
INSERT INTO `appids` (id,appid,for_account,in_use,ctime,mtime,dtime) VALUES (2,'1a399c4a-b836-cb47-3583-420601604588',12,NULL,1489993636,NULL,NULL);
INSERT INTO `appids` (id,appid,for_account,in_use,ctime,mtime,dtime) VALUES (3,'0bfbf968-6b17-6b8e-1353-089053774515',9,NULL,1490042319,NULL,NULL);
INSERT INTO `appids` (id,appid,for_account,in_use,ctime,mtime,dtime) VALUES (4,'1a399c4a-b836-cb47-3583-420601604588',10,NULL,1490043167,NULL,NULL);
INSERT INTO `appids` (id,appid,for_account,in_use,ctime,mtime,dtime) VALUES (5,'',9,NULL,1490045378,NULL,NULL);
INSERT INTO `appids` (id,appid,for_account,in_use,ctime,mtime,dtime) VALUES (6,'',15,NULL,1490115740,NULL,NULL);
CREATE TABLE accounts_www (id INTEGER NOT NULL PRIMARY KEY,www varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE accounts_tel (id INTEGER NOT NULL PRIMARY KEY,tel varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE `accounts_settings` (
	`for_id`	INTEGER,
	`sharedata`	varchar(199) DEFAULT '["login","name","born"]',
	`settings`	TEXT
);
CREATE TABLE accounts_regon (id INTEGER NOT NULL PRIMARY KEY,regon integer not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE accounts_other (id INTEGER NOT NULL PRIMARY KEY,other varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE accounts_nip (id INTEGER NOT NULL PRIMARY KEY,nip integer not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE "accounts_msg" (
	`id`	INTEGER NOT NULL,
	`msgid`	varchar(99) NOT NULL,
	`appid`	varchar(99) NOT NULL,
	`for_id`	integer NOT NULL,
	`from_id`	integer NOT NULL,
	`code`	integer NOT NULL,
	`lat`	varchar(99) NOT NULL,
	`lon`	varchar(99) NOT NULL,
	`status`	integer DEFAULT 0,
	`car`	integer DEFAULT 1,
	`answers`	TEXT,
	`ctime`	integer,
	`atime`	integer,
	`itime`	integer,
	`mtime`	integer,
	`dtime`	integer,
	`by_id`	INTEGER,
	PRIMARY KEY(`id`)
);
CREATE TABLE accounts_mail (id INTEGER NOT NULL PRIMARY KEY,mail varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE accounts_finance (id INTEGER NOT NULL PRIMARY KEY,finance varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE accounts_fax (id INTEGER NOT NULL PRIMARY KEY,fax varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE "accounts_cars" (
	`id`	INTEGER NOT NULL,
	`color`	varchar(99) NOT NULL,
	`mark`	varchar(99) NOT NULL,
	`number`	varchar(20) NOT NULL,
	`type`	integer NOT NULL DEFAULT 1,
	`year`	integer,
	`description`	TEXT,
	`foto`	varchar(99) DEFAULT '',
	`for_id`	integer NOT NULL,
	`in_use`	integer,
	`ctime`	integer NOT NULL,
	`mtime`	integer NOT NULL,
	`model`	TEXT NOT NULL,
	PRIMARY KEY(`id`)
);
INSERT INTO `accounts_cars` (id,color,mark,number,type,year,description,foto,for_id,in_use,ctime,mtime,model) VALUES (1,'#ff5e00','nysa','ty 1234',2,NULL,NULL,'',9,NULL,1492482626,1492482626,'520');
INSERT INTO `accounts_cars` (id,color,mark,number,type,year,description,foto,for_id,in_use,ctime,mtime,model) VALUES (2,'#fff1ee','syrena','ty 9900',1,NULL,NULL,'',12,NULL,1492486159,1492486159,'102');
INSERT INTO `accounts_cars` (id,color,mark,number,type,year,description,foto,for_id,in_use,ctime,mtime,model) VALUES (3,'#fff1ee','syrena','ty 9900',1,NULL,NULL,'',1,NULL,1492486566,1492486566,'102');
CREATE TABLE accounts_bank (id INTEGER NOT NULL PRIMARY KEY,bank integer not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
CREATE TABLE accounts_address (id INTEGER NOT NULL PRIMARY KEY,city varchar(99) not null,street varchar(99) not null,apartament varchar(9) not null,number varchar(9) not null,postal_code varchar(9) not null,postal_city varchar(99) not null,country varchar(99) not null,for_account integer not null,in_pos integer not null,ctime integer not null,mtime integer not null);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (1,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223397,1488223397);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (2,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223558,1488223558);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (3,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223680,1488223680);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (4,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223699,1488223699);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (5,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223790,1488223790);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (6,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223871,1488223871);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (7,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488223980,1488223980);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (8,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488224081,1488224081);
INSERT INTO `accounts_address` (id,city,street,apartament,number,postal_code,postal_city,country,for_account,in_pos,ctime,mtime) VALUES (9,'sdfghj','sdfghj','1414','1333','22-111','zerty','fghjk',8,0,1488224090,1488224090);
CREATE TABLE "accounts" (
	`id`	INTEGER NOT NULL,
	`account_name`	varchar(99),
	`account_login`	varchar(99) NOT NULL UNIQUE,
	`account_email`	varchar(99) NOT NULL UNIQUE,
	`account_pass`	varchar(199) NOT NULL,
	`account_role`	varchar(32) NOT NULL DEFAULT 'user',
	`account_born`	INTEGER,
	`account_can_login`	varchar(4) DEFAULT 'yes',
	`account_active`	varchar(4) DEFAULT 'yes',
	`account_adnotation`	TEXT,
	`account_role_id`	integer DEFAULT 10,
	`account_ctime`	integer NOT NULL,
	`account_mtime`	integer,
	`account_pin`	INTEGER,
	`account_car`	INTEGER,
	`account_country`	varchar(200),
	`account_phone`	INTEGER,
	`account_lang`	INTEGER,
	`account_ice`	INTEGER,
	`account_share`	INTEGER DEFAULT '["name"]',
	PRIMARY KEY(`id`)
);
INSERT INTO `accounts` (id,account_name,account_login,account_email,account_pass,account_role,account_born,account_can_login,account_active,account_adnotation,account_role_id,account_ctime,account_mtime,account_pin,account_car,account_country,account_phone,account_lang,account_ice,account_share) VALUES (1,'Administrator','admin','admin@admin.ui','d033e22ae348aeb5660fc2140aec35850c4da997','admin',-161830800,'yes','yes','<p><br></p>',10,1488189962,1488189962,NULL,3,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `accounts` (id,account_name,account_login,account_email,account_pass,account_role,account_born,account_can_login,account_active,account_adnotation,account_role_id,account_ctime,account_mtime,account_pin,account_car,account_country,account_phone,account_lang,account_ice,account_share) VALUES (2,'Edytor','editor','editor@editor.ui','b5a09edd458ff8b2390ebd52744fa5fd61a70a92','user',1488150000,'yes','yes',' ',10,1488193582,1488193582,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `accounts` (id,account_name,account_login,account_email,account_pass,account_role,account_born,account_can_login,account_active,account_adnotation,account_role_id,account_ctime,account_mtime,account_pin,account_car,account_country,account_phone,account_lang,account_ice,account_share) VALUES (9,'Doo Mechoo','bbb','bbb@bbb.bb','68413fb4ed973e62a1f45819569915d3adf53e53','user','1994-11-14','yes','yes',NULL,10,1489516696,1489516696,NULL,1,NULL,666111222,NULL,555999888,'["name","phone"]');
INSERT INTO `accounts` (id,account_name,account_login,account_email,account_pass,account_role,account_born,account_can_login,account_active,account_adnotation,account_role_id,account_ctime,account_mtime,account_pin,account_car,account_country,account_phone,account_lang,account_ice,account_share) VALUES (12,'Chh Ho','chh','chh@c.c','213d377d83756ed72e9a4f6bde51df31a8dfffe0','user','1997-12-13','yes','yes',NULL,10,1492354366,1492354366,NULL,2,NULL,888123456,NULL,NULL,'["name","born"]');
COMMIT;
