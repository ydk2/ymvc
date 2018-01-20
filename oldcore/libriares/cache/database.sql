
DROP TABLE IF EXISTS config;

DROP TABLE IF EXISTS users;


DROP TABLE IF EXISTS sitedata;
CREATE TABLE IF NOT EXISTS sitedata (
  id INTEGER NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  string TEXT DEFAULT '',
  access INT DEFAULT 1000,
  groups VARCHAR(255) NOT NULL DEFAULT 'main'
);

INSERT INTO sitedata (name, string) VALUES('page_title_str', 'Ymvc <small>System</small>');
INSERT INTO sitedata (name, string) VALUES('page_subtitle_str', 'Subtitle of this page');
INSERT INTO sitedata (name, string) VALUES('footer_title_str', 'Footer Header');
INSERT INTO sitedata (name, string) VALUES('page_short_title_str', 'Ymvc');
INSERT INTO sitedata (name, string) VALUES('footer_content_str', 'Footer Contents.');
