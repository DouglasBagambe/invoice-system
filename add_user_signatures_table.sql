-- Create user_signatures table for localhost database
-- This table stores user signature information for invoices

CREATE TABLE IF NOT EXISTS `user_signatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `signature_name` varchar(255) NOT NULL,
  `signature_path` varchar(500) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `is_default` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: Add some sample data for testing
-- Replace the user_id with an actual user ID from your users table
INSERT INTO `user_signatures` (`user_id`, `signature_name`, `signature_path`, `is_default`, `created_at`) VALUES
(1, 'Default Signature', 'public/uploads/signatures/default_signature.png', 1, NOW());



