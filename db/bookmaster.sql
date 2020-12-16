-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2020 at 03:37 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmaster`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `address`, `email`, `phone`, `image`, `publish`, `created_at`, `updated_at`) VALUES
(1, 'test author', 'tset add', 'test@gmail.com', '33434', 'noimage.jpg', 1, '2020-11-30 02:58:01', '2020-12-09 01:51:30'),
(2, 'ganesh khatri', 'ktm', 'kh6ganesh@gmail.com', '897987987', 'noimage.jpg', 1, '2020-12-08 02:20:23', '2020-12-08 02:20:23'),
(3, 'hridaya kandel', 'ktm', 'hridaya@gmail.com', '988987978', 'noimage.jpg', 1, '2020-12-08 02:20:40', '2020-12-08 02:20:40'),
(4, 'ganesh thaa', 'ktm', 'ganesh123@gmail.com', '9879898', 'noimage.jpg', 1, '2020-12-08 02:22:52', '2020-12-08 02:22:52'),
(5, 'ramesh Shahi', 'ktm', 'ramesh@gmail.com', '787978', 'noimage.jpg', 1, '2020-12-08 02:37:04', '2020-12-08 02:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publishedYear` smallint(6) NOT NULL,
  `publishedMonth` smallint(6) DEFAULT NULL,
  `noOfPages` int(11) NOT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ddcCallNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bookCategory` bigint(20) UNSIGNED NOT NULL,
  `bookPublisher` bigint(20) UNSIGNED NOT NULL,
  `bookPDF` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured` int(10) UNSIGNED NOT NULL,
  `publish` int(10) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `isbn`, `publishedYear`, `publishedMonth`, `noOfPages`, `edition`, `ddcCallNumber`, `bookCategory`, `bookPublisher`, `bookPDF`, `image`, `keywords`, `featured`, `publish`, `userId`, `created_at`, `updated_at`) VALUES
(2, 'test book', '656', 2065, 4, 444, 'second', '1234', 3, 1, 'pratinidhi_new_1572854000_1608048869.pdf', 'nepalconstitutionnepal_1573225394_1608048869.jpg', NULL, 1, 1, 1, '2020-12-15 10:29:29', '2020-12-16 05:39:18'),
(3, 'Constitution of Nepal', '4581', 2068, 7, 4321, 'third', '673', 2, 3, 'pratinidhi_sabha_niyamawali_1572855953_1608117819.pdf', 'pratinidhi_sabha_chautho_adhibesan_details_all_notices_cover_1572851633_1608117819.png', NULL, 1, 1, 1, '2020-12-16 05:38:39', '2020-12-16 05:38:39'),
(4, 'test book for normal user', '1234', 2072, NULL, 345, 'first', '2345', 2, 1, 'pratinidhi_new_1573225394_1608124762.pdf', 'nepalconstitutionnepal_1573225394_1608048869_1608049634_1608124762.jpg', NULL, 1, 1, 2, '2020-12-16 07:34:22', '2020-12-16 07:34:22'),
(5, 'book with keywords', '34', 2064, NULL, 554, 'fourth', '445', 2, 1, 'pratinidhi_new_1572955722_1608127112.pdf', 'nepalconstitutionnepal_1572855804_1608127112.jpg', 'constitution, Nepal, Government', 0, 1, 1, '2020-12-16 08:13:32', '2020-12-16 08:13:32');

-- --------------------------------------------------------

--
-- Table structure for table `books_archive`
--

CREATE TABLE `books_archive` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publishedYear` smallint(6) NOT NULL,
  `publishedMonth` smallint(6) DEFAULT NULL,
  `noOfPages` int(11) NOT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ddcCallNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bookPDF` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mainBookId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books_archive`
--

INSERT INTO `books_archive` (`id`, `isbn`, `publishedYear`, `publishedMonth`, `noOfPages`, `edition`, `ddcCallNumber`, `bookPDF`, `image`, `mainBookId`, `created_at`, `updated_at`) VALUES
(1, '656777', 2065, 3, 443, 'first', '234', 'pratinidhi_sabha_niyamawali_1572855953_1608049706.pdf', 'nepalconstitutionnepal_1573225394_1608048869_1608049706.jpg', 2, '2020-12-15 10:43:26', '2020-12-15 10:44:44');

-- --------------------------------------------------------

--
-- Table structure for table `books_authors_relation`
--

CREATE TABLE `books_authors_relation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bookId` bigint(20) UNSIGNED NOT NULL,
  `authorId` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books_authors_relation`
--

INSERT INTO `books_authors_relation` (`id`, `bookId`, `authorId`, `created_at`, `updated_at`) VALUES
(2, 2, 2, '2020-12-15 10:29:29', '2020-12-15 10:29:29'),
(3, 3, 3, '2020-12-16 05:38:39', '2020-12-16 05:38:39'),
(4, 3, 5, '2020-12-16 05:38:40', '2020-12-16 05:38:40'),
(5, 4, 3, '2020-12-16 07:34:22', '2020-12-16 07:34:22'),
(6, 5, 5, '2020-12-16 08:13:33', '2020-12-16 08:13:33'),
(7, 5, 2, '2020-12-16 08:13:33', '2020-12-16 08:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE `book_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_categories`
--

INSERT INTO `book_categories` (`id`, `name`, `publish`, `created_at`, `updated_at`) VALUES
(1, 'test cat', 1, '2020-11-30 02:57:40', '2020-11-30 02:57:40'),
(2, 'Constitution', 1, '2020-12-08 02:32:18', '2020-12-08 02:32:18'),
(3, 'Report', 1, '2020-12-08 02:32:31', '2020-12-08 02:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `book_publishers`
--

CREATE TABLE `book_publishers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_publishers`
--

INSERT INTO `book_publishers` (`id`, `name`, `publish`, `created_at`, `updated_at`) VALUES
(1, 'Ekata Publication', 1, '2020-12-15 10:11:38', '2020-12-15 10:13:32'),
(3, 'Simrik Publication', 1, '2020-12-15 10:14:32', '2020-12-15 10:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_05_102427_create_book_categories_table', 1),
(4, '2019_10_05_102752_create_authors_table', 1),
(5, '2019_10_10_064133_create_books_table', 1),
(6, '2019_10_16_143406_create_books_authors_relation_table', 1),
(7, '2019_10_25_061921_create_books_archive_table', 1),
(8, '2020_12_15_153342_create_book_publishers_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ganesh Khatri', 'kh6ganesh@gmail.com', NULL, '$2y$10$6whY0vjrRfRUAUt6X9D.Ieo0Kv07x2lBjBq1bI5S0/9rEZN1DVo2G', 'admin', NULL, NULL, '2020-12-16 07:52:12'),
(2, 'Normal User', 'normal@gmail.com', NULL, '$2y$10$vtqJV6Dnwf9s2qniKEajsuwX44TAPz3cfA6lvHzrvcrKSfgurzZoK', 'normal', NULL, '2020-11-30 02:15:34', '2020-12-16 07:52:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_bookcategory_foreign` (`bookCategory`),
  ADD KEY `books_userid_foreign` (`userId`),
  ADD KEY `books_bookpublisher_foreign` (`bookPublisher`);

--
-- Indexes for table `books_archive`
--
ALTER TABLE `books_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_archive_mainbookid_foreign` (`mainBookId`);

--
-- Indexes for table `books_authors_relation`
--
ALTER TABLE `books_authors_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_authors_relation_bookid_foreign` (`bookId`),
  ADD KEY `books_authors_relation_authorid_foreign` (`authorId`);

--
-- Indexes for table `book_categories`
--
ALTER TABLE `book_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_publishers`
--
ALTER TABLE `book_publishers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `books_archive`
--
ALTER TABLE `books_archive`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books_authors_relation`
--
ALTER TABLE `books_authors_relation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `book_categories`
--
ALTER TABLE `book_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `book_publishers`
--
ALTER TABLE `book_publishers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_bookcategory_foreign` FOREIGN KEY (`bookCategory`) REFERENCES `book_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_bookpublisher_foreign` FOREIGN KEY (`bookPublisher`) REFERENCES `book_publishers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `books_archive`
--
ALTER TABLE `books_archive`
  ADD CONSTRAINT `books_archive_mainbookid_foreign` FOREIGN KEY (`mainBookId`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `books_authors_relation`
--
ALTER TABLE `books_authors_relation`
  ADD CONSTRAINT `books_authors_relation_authorid_foreign` FOREIGN KEY (`authorId`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_authors_relation_bookid_foreign` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
