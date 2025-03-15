-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2025 at 08:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(8, 'جدید', '2025-03-09 03:55:15', '0000-00-00 00:00:00'),
(9, 'ورزشی', '2025-03-09 03:55:35', '0000-00-00 00:00:00'),
(10, 'تکنولوژی', '2025-03-09 03:55:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `text`, `created_at`, `post_id`) VALUES
(1, 9, 'ssdsdd', '2025-03-09 21:55:27', 18),
(2, 9, 'سلام سایت خوبی دارید', '2025-03-09 21:56:19', 18),
(3, 9, 'سلام سایت خوبی دارید', '2025-03-09 21:59:43', 18),
(4, 10, 'سلام ساااااایت خوبه', '2025-03-09 22:50:45', 18),
(5, 2, 'salam', '2025-03-13 01:56:44', 18),
(6, 2, 'salam', '2025-03-13 01:58:25', 18),
(7, 2, 'salam', '2025-03-13 01:59:18', 18),
(8, 2, 'salam', '2025-03-13 01:59:56', 18);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 10,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `cat_id`, `status`, `image`, `created_at`, `updated_at`) VALUES
(18, 'اولین گزارش رسمی از کشف لیتیوم در ایران', 'به گزارش مشرق، وزارت صمت در گزارشی با جزئیات بی‌سابقه، نتایج یک سال نمونه‌برداری علمی از شورابه‌های نمکی سه استان را منتشر کرده است.\r\n\r\nاین پروژه که با همکاری کارشناسان روسیه و استفاده از فناوری‌های پیشرفته مانند ICP-OES انجام شد، وجود ذخایر لیتیوم با غلظت‌های رقابتی در سطح جهانی را تأیید می‌کند.\r\n\r\nجزئیات فنی: مهندسی دقیق اکتشاف\r\n\r\nبرای دسترسی به شورابه‌های زیرسطحی، چاهک‌هایی به عمق ۱ تا ۲ متر در کفه‌های نمکی حفر شد. نمونه‌ها پیش از انتقال به آزمایشگاه‌های مرجع، با اسید نیتریک تثبیت شدند تا ترکیب شیمیایی آنها پایدار بماند.\r\n\r\nآنالیز نمونه‌ها در مرکز تحقیقات فرآوری مواد معدنی ایران و یک آزمایشگاه معتبر روسی انجام شد. این پژوهش علاوه بر لیتیوم، عناصر راهبردی مانند بُر، منیزیم و پتاسیم را نیز برای ارزیابی امکان فرآوری بررسی کرد.\r\n\r\nنقاط داغ لیتیوم در ایران\r\n\r\nدریاچه نمک قم: بیشترین غلظت لیتیوم (۸۱.۴ ppm) در ۵ ایستگاه نمونه‌برداری با عمق ۲.۵ متر ثبت شد.\r\n\r\nخور: میزان ۴۱.۷۱ ppm لیتیوم در شورابه‌های ورودی به کارخانه پتاس خور شناسایی شد.\r\n\r\nطرود: در مرز استان سمنان، چاهک‌های حفرشده غلظت ۱۸.۲۵ ppm لیتیوم را نشان دادند.\r\n\r\nاین یافته‌ها می‌توانند ایران را به یکی از بازیگران مهم در صنعت استخراج لیتیوم تبدیل کنند و زمینه را برای توسعه فرآوری این فلز استراتژیک فراهم سازند.\r\n\r\nلیتیوم ایرانی؛ موتور محرکه اقتصاد سبز\r\n\r\nاین اکتشافات در شرایطی انجام شده که بر اساس گزارش آژانس بین‌المللی انرژی (IEA)، تقاضای جهانی لیتیوم تا ۲۰۳۰ به ۲.۴ میلیون تن خواهد رسید.\r\n\r\nایران با داشتن ذخایر نمکی ۱۰ میلیون هکتاری در حوضه‌های مرکزی، شدت تابش خورشیدی ۳۰۰ روزه سالانه مناسب برای روش‌های تبخیری، زیرساخت‌های موجود مانند مجتمع پتاس خور می‌تواند به یکی از کم‌هزینه‌ترین تولیدکنندگان لیتیوم سبز در جهان تبدیل شود.\r\n\r\nاکتشاف لیتیوم در ایران، پیام استراتژیک به جهان\r\n\r\nاین گزارش تنها یک دستاورد علمی نیست، بلکه سندی دیپلماتیک است که ظرفیت ایران را برای مشارکت در زنجیره تأمین انرژی‌های پاک نشان می‌دهد.\r\n\r\nبا توجه به تنش‌های ژئوپلیتیک بر سر لیتیوم، ایران فرصت دارد تا تجربه توسعه نفتی خود را این بار با لیتیوم امتحان کند.\r\n\r\nاین کشف در حالی رخ می‌دهد که جهان به دنبال تنوع‌بخشی به زنجیره تأمین لیتیوم است. کارشناسان معتقدند ذخایر ایران می‌تواند به کاهش فشار بر معادن سنتی و تسریع گذار جهانی به سمت انرژی‌های پاک کمک کند.', 10, 10, '/assets/images/posts/20250312231748.jpg', '2025-02-07 15:39:10', '2025-03-13 01:47:48'),
(21, 'قابل توجه مشتاقان مذاکره!', 'به گزارش مشرق، یک کاربر فضای مجازی در توئیتر نوشت:\r\n\r\nترامپ در واکنش به افزایش قیمت برق صادراتی کانادا به آمریکا رسما اعلام کرده: چنان تاوانی بدهید که در کتاب های تاریخ بنویسند.\r\n\r\nپ ن: کانادا دوست اسرائیل است، مرگ بر آمریکا نمی گوید وبرنامه هسته ای هم ندارد؛ روی موشک هایش هم تا آنجایی که یادم هست شعار نمی نوشت؛ قابل توجه مشتاقان مذاکره.', 8, 10, '/assets/images/posts/20250312231841.jpg', '2025-02-13 21:06:39', '2025-03-13 01:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `admin`, `email`, `password`, `first_name`, `last_name`, `age`, `phone`, `created_at`) VALUES
(13, 0, 'ali@gmail.com', '$2y$10$ok8oL5zVQJa3itLzv2OncONy2IKCWrNB72iMbowhJXvPwELS0s4VG', 'علی', 'محمدی', 18, '09031344366', '2025-03-13 03:21:50'),
(14, 0, 'admin@gmail.com', '$2y$10$KwXlx6r2TFprXRGyflVZOOeHzJNOhl.PMwIBf9QeYj.GehfQSXYpG', 'محمدرضا', 'جبارزاده', NULL, NULL, '2025-03-13 03:22:30'),
(15, 0, 'javad@g.com', '$2y$10$eywSF9DNb5vf7.vxiPLtIuax7NbBO7Gur7v45qqiNvndzLLjl9kvO', 'جواد', 'موسوی', 10, '09031344366', '2025-03-13 03:35:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
