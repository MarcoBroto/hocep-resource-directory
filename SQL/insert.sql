
-- Resource

INSERT INTO `spr19_team11`.`resource` (`Resource_id`, `Email`, `Title`, `OpHours`, `Street_Address`, `Zipcode`, `Phone`, `Website`, `Description`, `Documents`, `Requirements`, `Insurance`) VALUES ('20', 'recovery@recoveryalliance.net', 'Recover Aliance', 'M-F 8am-5pm', '3501 Hueco Ave.', '79903', '915-775-0505', 'www.recoveryallinace.net', 'Achohol and Drug Rehab', 'YES', '18+', TRUE);

INSERT INTO `spr19_team11`.`resource` (`Resource_id`, `Email`, `Title`, `OpHours`, `Street_Address`, `Zipcode`, `Phone`, `Website`, `Description`, `Documents`, `Requirements`, `Insurance`) VALUES ('21', 'vanessavoss6@yahoo.com', 'Casa de Vida', 'M-F 24/7', '325 Leon', '79912', '915-544-8451', 'www.superpages.com', 'Shelter for Men', 'NO', 'men only', FALSE);

INSERT INTO `spr19_team11`.`resource` (`Resource_id`, `Email`, `Title`, `OpHours`, `Street_Address`, `Zipcode`, `Phone`, `Website`, `Description`, `Documents`, `Requirements`, `Insurance`) VALUES ('22', 'a@yahoo.com', 'Other Service', 'M-F 24/7', '453 Lean', '79907', '915-434-7005', 'www.utep.edu', 'Other shelter ', 'NO', 'women only', TRUE);


-- Category

INSERT INTO `spr19_team11`.`category` (`Category_id`, `Name`, `Description`) VALUES ('0001', 'Substance Abuse', 'This category provides resources to help against Substance Abuse');

INSERT INTO `spr19_team11`.`category` (`Category_id`, `Name`, `Description`) VALUES ('0002', 'Housing', 'Provides resources to provide housing');

INSERT INTO `spr19_team11`.`category` (`Category_id`, `Name`, `Description`) VALUES ('0003', 'Military', 'Useful Resources for military families');

-- belongs_to

INSERT INTO `spr19_team11`.`belongs_to` (`Resource_id`, `Category_id`) VALUES ('20', '1');

INSERT INTO `spr19_team11`.`belongs_to` (`Resource_id`, `Category_id`) VALUES ('21', '2');

INSERT INTO `spr19_team11`.`belongs_to` (`Resource_id`, `Category_id`) VALUES ('22', '3');

-- Contact

INSERT INTO `spr19_team11`.`contact` (`Contact_id`, `Resource_id`, `Title`, `F_Name`, `L_Name`, `Phone`) VALUES ('40', '20', 'Ms.', 'Claudia', 'Renteria', '915-593-0000');

INSERT INTO `spr19_team11`.`contact` (`Contact_id`, `Resource_id`, `Title`, `F_Name`, `L_Name`, `Phone`, `Email`) VALUES ('41', '21', 'Dr.', 'Aurora ', 'Luna', '915-243-8973', 'lajluna@yahoo.com');

INSERT INTO `spr19_team11`.`contact` (`Contact_id`, `Resource_id`, `Title`, `F_Name`, `L_Name`, `Phone`, `Email`) VALUES ('42', '22', 'Ms.', 'Aixa', 'Maldonado', '915-775-0505', 'amaldonado@recoveryalliance.net');

-- Admin

INSERT INTO `spr19_team11`.`admin` (`Admin_id`, `Username`, `Password`, `F_Name`, `L_Name`) VALUES ('10', 'AMaldonado', '1234', 'Aixa', 'Maldonado');

INSERT INTO `spr19_team11`.`admin` (`Admin_id`, `Username`, `Password`, `F_Name`, `L_Name`) VALUES ('11', 'RGarcia', '5678', 'Ruben ', 'Garcia');

INSERT INTO `spr19_team11`.`admin` (`Admin_id`, `Username`, `Password`, `F_Name`, `L_Name`) VALUES ('12', 'SSander', '9101', 'Sonia', 'Sander');


-- Service 

INSERT INTO `spr19_team11`.`service` (`Service_id`, `Name`, `Description`) VALUES ('50', 'Clinical Treatment', 'Helps alchohol and drug disorders');

INSERT INTO `spr19_team11`.`service` (`Service_id`, `Name`, `Description`) VALUES ('51', 'Shelter', 'Helps individuals with long term needs be self sufficient');

INSERT INTO `spr19_team11`.`service` (`Service_id`, `Name`, `Description`) VALUES ('52', 'VA care', 'SM undergoing medical discharge');

-- Updates

INSERT INTO `spr19_team11`.`updates` (`Date`, `Admin_id`, `Resource_id`) VALUES ('2019-04-01', '10', '20');

INSERT INTO `spr19_team11`.`updates` (`Date`, `Admin_id`, `Resource_id`) VALUES ('2018-01-01', '11', '21');

INSERT INTO `spr19_team11`.`updates` (`Date`, `Admin_id`, `Resource_id`) VALUES ('1999-03-18', '12', '22');

-- Provides

INSERT INTO `spr19_team11`.`provides` (`Resource_id`, `Service_id`) VALUES ('20', '50');

INSERT INTO `spr19_team11`.`provides` (`Resource_id`, `Service_id`) VALUES ('21', '51');

INSERT INTO `spr19_team11`.`provides` (`Resource_id`, `Service_id`) VALUES ('22', '52')

















