
USE `oc_db`;

INSERT INTO admin (username, password, f_name, l_name)
SELECT 'root', 'root', '', ''
WHERE (SELECT COUNT(*) FROM admin WHERE username = 'root') < 1;

INSERT INTO admin (username, password, f_name, l_name)
SELECT 'test', 'test', 'test first name', 'test last name'
WHERE (SELECT COUNT(*) FROM admin WHERE username = 'test') < 1;
