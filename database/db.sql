CREATE TABLE academic_degrees(
	academic_degree_id INT AUTO_INCREMENT PRIMARY KEY,
	academic_degree_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE users_roles(
	user_role_id INT AUTO_INCREMENT PRIMARY KEY,
	role_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE groups_names(
	group_name_id INT AUTO_INCREMENT PRIMARY KEY,
	group_name VARCHAR(15) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE student_specializations(
	specialization_id INT AUTO_INCREMENT PRIMARY KEY,
	specialization_name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE bak_speciality(
	bak_speciality_id INT AUTO_INCREMENT PRIMARY KEY,
	bak_speciality_name VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE dissertation_status(
	dissertation_status_id INT AUTO_INCREMENT PRIMARY KEY,
	dissertation_status_name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;


CREATE TABLE indexes(
	index_id INT AUTO_INCREMENT PRIMARY KEY,
	index_name VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE editions(
	edition_id INT AUTO_INCREMENT PRIMARY KEY,
	edition_name VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE users(
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(255) NOT NULL,
	lastname VARCHAR(255) NOT NULL,
	patronymic VARCHAR(255) NOT NULL,
	login VARCHAR(255) NOT NULL UNIQUE,
	password_hash VARCHAR(255) NOT NULL,
	role_id INT NOT NULL,
	academic_degree_id INT,

	CONSTRAINT users_role_id_fk
	FOREIGN KEY (role_id)
	REFERENCES users_roles(user_role_id)
	ON DELETE RESTRICT,

	CONSTRAINT users_academic_degree_id_fk
	FOREIGN KEY (academic_degree_id)
	REFERENCES academic_degrees(academic_degree_id)
	ON DELETE RESTRICT
) ENGINE=InnoDB;


CREATE TABLE students(
	student_id INT AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(100) NOT NULL,
	lastname VARCHAR(100) NOT NULL,
	patronymic VARCHAR(100) NOT NULL,
	specialization_id INT,
	group_id INT NOT NULL,
	scientific_supervisor_id INT,

	CONSTRAINT students_specialization_id_fk
	FOREIGN KEY (specialization_id)
	REFERENCES student_specializations(specialization_id)
	ON DELETE RESTRICT,

	CONSTRAINT students_group_id_fk
	FOREIGN KEY (group_id)
	REFERENCES groups_names(group_name_id)
	ON DELETE RESTRICT,

	CONSTRAINT students_scientific_supervisor_id_fk
	FOREIGN KEY (scientific_supervisor_id)
	REFERENCES users(user_id)
	ON DELETE RESTRICT
) ENGINE=InnoDB;



CREATE TABLE dissertations(
	dissertation_id INT AUTO_INCREMENT PRIMARY KEY,
	theme VARCHAR(255) NOT NULL,
	approval_date DATE NOT NULL,
	status_id INT NOT NULL,
	bak_speciality_id INT NOT NULL,
	student_id INT NOT NULL UNIQUE,

	CONSTRAINT dissertations_status_fk
	FOREIGN KEY (status_id)
	REFERENCES dissertation_status(dissertation_status_id)
	ON DELETE RESTRICT,

	CONSTRAINT dissertations_bak_speciality_fk
	FOREIGN KEY (bak_speciality_id)
	REFERENCES bak_speciality(bak_speciality_id)
	ON DELETE RESTRICT,

	CONSTRAINT dissertations_student_fk
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE RESTRICT
) ENGINE=InnoDB;



CREATE TABLE scientific_publications(
	scientific_publication_id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	edition_id INT NOT NULL,
	publication_date DATE NOT NULL,
	index_id INT NOT NULL,
	student_id INT NOT NULL,

	CONSTRAINT pub_edition_fk
	FOREIGN KEY (edition_id)
	REFERENCES editions(edition_id)
	ON DELETE RESTRICT,

	CONSTRAINT pub_index_fk
	FOREIGN KEY (index_id)
	REFERENCES indexes(index_id)
	ON DELETE RESTRICT,

	CONSTRAINT pub_student_fk
	FOREIGN KEY (student_id)
	REFERENCES students(student_id)
	ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO `academic_degrees` (`academic_degree_id`, `academic_degree_name`) VALUES ('1', 'Кандидат наук');
INSERT INTO `academic_degrees` (`academic_degree_id`, `academic_degree_name`) VALUES ('2', 'Доктор наук');
INSERT INTO `academic_degrees` (`academic_degree_id`, `academic_degree_name`) VALUES ('3', 'Доцент');
INSERT INTO `academic_degrees` (`academic_degree_id`, `academic_degree_name`) VALUES ('4', 'Профессор');
INSERT INTO `academic_degrees` (`academic_degree_id`, `academic_degree_name`) VALUES ('5', 'Нет учёной степени');

INSERT INTO `users_roles` (`user_role_id`, `role_name`) VALUES ('1', 'Научный руководитель');
INSERT INTO `users_roles` (`user_role_id`, `role_name`) VALUES ('2', 'Научный сотрудник');
INSERT INTO `users_roles` (`user_role_id`, `role_name`) VALUES ('3', 'Администратор');

INSERT INTO `bak_speciality` (`bak_speciality_id`, `bak_speciality_name`) VALUES ('1','Естественные науки');
INSERT INTO `bak_speciality` (`bak_speciality_id`, `bak_speciality_name`) VALUES ('2','Медицинские науки');
INSERT INTO `bak_speciality` (`bak_speciality_id`, `bak_speciality_name`) VALUES ('3','Технические науки');
INSERT INTO `bak_speciality` (`bak_speciality_id`, `bak_speciality_name`) VALUES ('4','Сельскохозяйственные науки');
INSERT INTO `bak_speciality` (`bak_speciality_id`, `bak_speciality_name`) VALUES ('5','Социальные и гуманитарные науки');

INSERT INTO `student_specializations` (`specialization_id`, `specialization_name`) VALUES ('1', 'Математика и механика');
INSERT INTO `student_specializations` (`specialization_id`, `specialization_name`) VALUES ('2', 'Компьютерные и информационные науки');
INSERT INTO `student_specializations` (`specialization_id`, `specialization_name`) VALUES ('3', 'Физика и астрономия');
INSERT INTO `student_specializations` (`specialization_id`, `specialization_name`) VALUES ('4', 'Химические науки');
INSERT INTO `student_specializations` (`specialization_id`, `specialization_name`) VALUES ('5', 'Науки о Земле');
INSERT INTO `student_specializations` (`specialization_id`, `specialization_name`) VALUES ('6', 'Биологические науки');

INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('1', 'к123');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('2', 'м512');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('3', 'а301');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('4', 'б402');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('5', 'и101');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('6', 'ф202');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('7', 'х303');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('8', 'б404');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('9', 'м505');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('10', 'т606');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('11', 'э707');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('12', 'ю808');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('13', 'л909');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('14', 'п111');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('15', 'с222');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('16', 'д333');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('17', 'к444');
INSERT INTO `groups_names` (`group_name_id`, `group_name`) VALUES ('18', 'в555');


INSERT INTO `dissertation_status` (`dissertation_status_id`, `dissertation_status_name`) VALUES ('1', 'Пишется');
INSERT INTO `dissertation_status` (`dissertation_status_id`, `dissertation_status_name`) VALUES ('2', 'Предзащита');
INSERT INTO `dissertation_status` (`dissertation_status_id`, `dissertation_status_name`) VALUES ('3', 'Защищена');

INSERT INTO `indexes` (`index_id`, `index_name`) VALUES ('1',  'РИНЦ');
INSERT INTO `indexes` (`index_id`, `index_name`) VALUES ('2',  'Scopus');

INSERT INTO `editions` (`edition_id`, `edition_name`) VALUES ('1', 'Журнал');
INSERT INTO `editions` (`edition_id`, `edition_name`) VALUES ('2', 'Сборник');