CREATE DATABASE IF NOT EXISTS `proyectopwci`;

USE `proyectopwci`;

DROP TABLE IF EXISTS `sales`;
DROP TABLE IF EXISTS `enrollments`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `courses`;
DROP TABLE IF EXISTS `course_categories`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `user_id` INT NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(50) NOT NULL,
    `user_last_name` VARCHAR(50) NOT NULL,
    `user_gender` ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
    `user_email` VARCHAR(255) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `user_profile_image` VARCHAR(255),
    `user_role` ENUM('student', 'instructor', 'admin') NOT NULL DEFAULT 'student',
    `user_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `user_active` BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT `users_pk`
        PRIMARY KEY (`user_id`),

    CONSTRAINT `user_email_uniq`
        UNIQUE (`user_email`)
);

CREATE TABLE `course_category` (
    `category_id` INT NOT NULL AUTO_INCREMENT,
    `category_name` VARCHAR(50) NOT NULL,
    `category_description` VARCHAR(255),
    `category_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `category_active` BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT `course_category_pk`
        PRIMARY KEY (`category_id`),

    CONSTRAINT `category_name_uniq`
        UNIQUE (`category_name`)
);

CREATE TABLE `courses` (
    `course_id` INT NOT NULL AUTO_INCREMENT,
    `course_title` VARCHAR(100) NOT NULL,
    `course_description` VARCHAR(255) NOT NULL,
    `course_price` DECIMAL(10,2) NOT NULL,
    `course_image` VARCHAR(255),
    `instructor_id` INT NOT NULL,
    `category_id` INT NOT NULL,
    `course_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `course_active` BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT `courses_pk`
        PRIMARY KEY (`course_id`),

    CONSTRAINT `course_instructor_fk`
        FOREIGN KEY (`instructor_id`)
        REFERENCES `users`(`user_id`),

    CONSTRAINT `course_category_fk`
        FOREIGN KEY (`category_id`)
        REFERENCES `course_category`(`category_id`),

    CONSTRAINT `course_price_chk`
        CHECK (`course_price` >= 0)
);

CREATE TABLE `messages` (
    `message_id` INT NOT NULL AUTO_INCREMENT,
    `sender_id` INT NOT NULL,
    `receiver_id` INT NOT NULL,
    `message_content` VARCHAR(255) NOT NULL,
    `message_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `message_active` BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT `messages_pk`
        PRIMARY KEY (`message_id`),

    CONSTRAINT `message_sender_fk`
        FOREIGN KEY (`sender_id`)
        REFERENCES `users`(`user_id`),

    CONSTRAINT `message_receiver_fk`
        FOREIGN KEY (`receiver_id`)
        REFERENCES `users`(`user_id`)
);

CREATE TABLE `comments` (
    `comment_id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    `comment_content` VARCHAR(255) NOT NULL,
    `comment_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `comment_active` BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT `comments_pk`
        PRIMARY KEY (`comment_id`),

    CONSTRAINT `comment_user_fk`
        FOREIGN KEY (`user_id`)
        REFERENCES `users`(`user_id`),

    CONSTRAINT `comment_course_fk`
        FOREIGN KEY (`course_id`)
        REFERENCES `courses`(`course_id`)
);

CREATE TABLE `enrollments` (
    `enrollment_id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    `enrollment_progress` INT NOT NULL DEFAULT 0,
    `enrollment_finished` BOOLEAN NOT NULL DEFAULT FALSE,
    `enrollment_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT `enrollments_pk`
        PRIMARY KEY (`enrollment_id`),

    CONSTRAINT `enrollment_user_fk`
        FOREIGN KEY (`user_id`)
        REFERENCES `users`(`user_id`),

    CONSTRAINT `enrollment_course_fk`
        FOREIGN KEY (`course_id`)
        REFERENCES `courses`(`course_id`),

    CONSTRAINT `enrollment_progress_chk`
        CHECK (`enrollment_progress` BETWEEN 0 AND 100),

    CONSTRAINT `user_course_uniq`
        UNIQUE (`user_id`, `course_id`)
);

CREATE TABLE `sales` (
    `sale_id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `course_id` INT NOT NULL,
    `sale_amount` DECIMAL(10,2) NOT NULL,
    `sale_payment_method` VARCHAR(50) NOT NULL,
    `sale_status` ENUM('pending', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    `sale_created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT `sales_pk`
        PRIMARY KEY (`sale_id`),

    CONSTRAINT `sale_user_fk`
        FOREIGN KEY (`user_id`)
        REFERENCES `users`(`user_id`),

    CONSTRAINT `sale_course_fk`
        FOREIGN KEY (`course_id`)
        REFERENCES `courses`(`course_id`),

    CONSTRAINT `sale_amount_chk`
        CHECK (`sale_amount` >= 0)
);