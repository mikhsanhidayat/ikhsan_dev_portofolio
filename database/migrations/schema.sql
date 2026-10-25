-- Database Schema Migration Script
-- Portofolio Mahasiswa Manajemen Informatika

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Drop existing tables if they exist
DROP TABLE IF EXISTS `project_technologies`;
DROP TABLE IF EXISTS `project_media`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `project_categories`;
DROP TABLE IF EXISTS `technologies`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `skills`;
DROP TABLE IF EXISTS `educations`;
DROP TABLE IF EXISTS `experiences`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `documents`;

SET FOREIGN_KEY_CHECKS = 1;

-- 2. Create tables

-- Admins Table
CREATE TABLE `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `last_login_at` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Profiles Table
CREATE TABLE `profiles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(150) NOT NULL,
    `headline` VARCHAR(255) NOT NULL,
    `internship_target` VARCHAR(150) NOT NULL,
    `short_bio` TEXT NOT NULL,
    `about_text` TEXT NOT NULL,
    `profile_photo` VARCHAR(255) NULL,
    `location` VARCHAR(150) NULL,
    `availability_status` TINYINT(1) DEFAULT 1, -- 1: Available, 0: Busy
    `email` VARCHAR(150) NOT NULL,
    `whatsapp` VARCHAR(30) NULL,
    `github_url` VARCHAR(255) NULL,
    `linkedin_url` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Skills Table
CREATE TABLE `skills` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(50) NOT NULL, -- e.g. Backend, Database, Frontend, Tools, Soft Skill
    `icon` VARCHAR(100) NULL, -- FontAwesome/Lucide icon name representation
    `proficiency_level` VARCHAR(50) NULL, -- e.g. Dasar, Menengah, Mahir
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Project Categories Table
CREATE TABLE `project_categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL UNIQUE,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Projects Table
CREATE TABLE `projects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `summary` TEXT NOT NULL,
    `background` TEXT NOT NULL,
    `objective` TEXT NOT NULL,
    `solution` TEXT NOT NULL,
    `role_description` TEXT NOT NULL,
    `process_description` TEXT NOT NULL,
    `feature_description` TEXT NOT NULL,
    `result_description` TEXT NOT NULL,
    `challenge_description` TEXT NULL,
    `cover_image` VARCHAR(255) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NULL, -- NULL means ongoing
    `project_status` VARCHAR(50) NOT NULL, -- e.g. Selesai, Dalam Pengembangan
    `demo_url` VARCHAR(255) NULL,
    `github_url` VARCHAR(255) NULL,
    `video_url` VARCHAR(255) NULL, -- YouTube link
    `publication_status` VARCHAR(20) DEFAULT 'draft', -- draft or published
    `is_featured` TINYINT(1) DEFAULT 0,
    `sort_order` INT DEFAULT 0,
    `published_at` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Technologies Table
CREATE TABLE `technologies` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `icon` VARCHAR(100) NULL,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Project Technologies (Many-to-Many Bridge)
CREATE TABLE `project_technologies` (
    `project_id` INT NOT NULL,
    `technology_id` INT NOT NULL,
    PRIMARY KEY (`project_id`, `technology_id`),
    FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`technology_id`) REFERENCES `technologies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Project Media Table (Multiple Photos per Project)
CREATE TABLE `project_media` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT NOT NULL,
    `media_type` VARCHAR(30) DEFAULT 'image', -- e.g. image, video_url
    `file_path` VARCHAR(255) NULL,
    `external_url` VARCHAR(255) NULL,
    `title` VARCHAR(150) NOT NULL,
    `description` TEXT NOT NULL,
    `alt_text` VARCHAR(255) NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Educations Table
CREATE TABLE `educations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `institution_name` VARCHAR(150) NOT NULL,
    `study_program` VARCHAR(150) NOT NULL,
    `degree` VARCHAR(50) NOT NULL, -- e.g. D3, D4, S1
    `start_year` INT NOT NULL,
    `end_year` INT NULL, -- NULL means current
    `description` TEXT NULL,
    `logo` VARCHAR(255) NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Experiences Table
CREATE TABLE `experiences` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `organization_name` VARCHAR(150) NOT NULL,
    `role` VARCHAR(150) NOT NULL,
    `experience_type` VARCHAR(100) NOT NULL, -- e.g. Kerja Magang, Organisasi, Kepanitiaan
    `start_date` DATE NOT NULL,
    `end_date` DATE NULL, -- NULL means current
    `is_current` TINYINT(1) DEFAULT 0,
    `description` TEXT NOT NULL,
    `sort_order` INT DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Messages Table
CREATE TABLE `messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `status` VARCHAR(20) DEFAULT 'unread', -- unread, read, archived
    `read_at` DATETIME NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Settings Table (Key-Value configuration store)
CREATE TABLE `settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT NULL,
    `type` VARCHAR(30) DEFAULT 'text', -- e.g. text, textarea, select, file
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Documents Table (specifically CV)
CREATE TABLE `documents` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `document_type` VARCHAR(50) DEFAULT 'cv',
    `file_path` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
