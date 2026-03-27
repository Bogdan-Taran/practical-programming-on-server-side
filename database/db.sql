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
