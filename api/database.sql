
CREATE TABLE IF NOT EXISTS ad_categories (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100)  NOT NULL,
    slug        VARCHAR(100)  NOT NULL UNIQUE,
    icon        VARCHAR(60)   NOT NULL DEFAULT 'bi-tag',
    description TEXT,
    is_builtin  TINYINT(1)    NOT NULL DEFAULT 0,
    is_enabled  TINYINT(1)    NOT NULL DEFAULT 1,
    sort_order  INT           NOT NULL DEFAULT 0,
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO ad_categories (name, slug, icon, description, is_builtin, sort_order) VALUES
('Property Listing',        'property',     'bi-house-door',       'Houses for rent or sale, land, commercial property.',           1, 1),
('Public Announcement',     'announcement', 'bi-megaphone',        'Public notices, tender notices, official communications.',      1, 2),
('Application & Promotion', 'application',  'bi-file-earmark-text','Job vacancies, training enrolments, service applications.',     1, 3),
('Broadcast Announcement',  'broadcast',    'bi-broadcast-pin',    'Money Radio on-air campaigns and broadcast spots.',             1, 4),
('Promotional Campaign',    'promo',        'bi-tag',              'Discounts, special offers, new service launches.',              1, 5),
('Other',                   'other',        'bi-three-dots',       'Any advertisement that does not fit the above categories.',     1, 6);

-- ── Advertisements table ──────────────────────────────
CREATE TABLE IF NOT EXISTS advertisements (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    -- Core content
    title       VARCHAR(255)  NOT NULL,
    description TEXT,
    category    VARCHAR(100)  NOT NULL DEFAULT 'other',
    image_url   VARCHAR(500),

    -- Status & scheduling
    status      ENUM('draft','active','expired','archived') NOT NULL DEFAULT 'draft',
    start_date  DATE,
    end_date    DATE,
    is_featured TINYINT(1)    NOT NULL DEFAULT 0,

    -- Call to action
    cta_type    ENUM('call','apply','details','website','listen') NOT NULL DEFAULT 'call',
    cta_link    VARCHAR(500),

    -- Property-specific fields (nullable for other categories)
    price       VARCHAR(100),
    bedrooms    TINYINT UNSIGNED,
    location    VARCHAR(200),

    -- Performance tracking
    view_count  INT UNSIGNED  NOT NULL DEFAULT 0,
    click_count INT UNSIGNED  NOT NULL DEFAULT 0,

    -- Timestamps
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Index for common queries
    INDEX idx_status   (status),
    INDEX idx_category (category),
    INDEX idx_featured (is_featured),
    INDEX idx_dates    (start_date, end_date)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE EVENT IF NOT EXISTS expire_old_ads
    ON SCHEDULE EVERY 1 DAY
    STARTS CURRENT_TIMESTAMP
    DO
        UPDATE advertisements
        SET    status = 'expired'
        WHERE  status = 'active'
        AND    end_date IS NOT NULL
        AND    end_date < CURDATE();

-- ── Sample data ─
INSERT INTO advertisements
    (title, description, category, status, cta_type, cta_link, start_date, end_date, is_featured, image_url, price, bedrooms, location, view_count, click_count)
VALUES
(
    '3-Bedroom House For Rent — Rubavu Town Centre',
    'Spacious, newly renovated house with 3 bedrooms, 2 bathrooms, private compound, and ample parking. Walking distance from Rubavu Market. Available immediately.',
    'property', 'active', 'call', 'tel:+250788715657',
    '2025-05-01', '2025-08-01', 1,
    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=700&auto=format&fit=crop&q=80',
    '250,000 RWF/mo', 3, 'Rubavu Town', 312, 48
),
(
    'Job Vacancy: Senior Graphic Designer',
    'Korawigire is seeking an experienced Senior Graphic Designer. Minimum 3 years experience with Adobe Creative Suite. Strong portfolio required.',
    'application', 'active', 'apply', 'mailto:korawigire0@gmail.com',
    '2025-06-01', '2025-06-30', 0, '', NULL, NULL, 'Rubavu', 145, 22
),
(
    'Community Health Awareness Campaign 2025',
    'Tune in to Money Radio for the government Community Health Awareness Campaign. Daily health tips and interviews with medical professionals.',
    'broadcast', 'active', 'listen', '#',
    '2025-05-01', '2025-12-31', 0, '', NULL, NULL, NULL, 421, 63
),
(
    '50% Off All Printing Services — June Only',
    'Celebrate Korawigire''s anniversary with 50% off business cards, flyers, brochures, and banners throughout June 2025.',
    'promo', 'active', 'call', 'tel:+250788715657',
    '2025-06-01', '2025-06-30', 0,
    'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=700&auto=format&fit=crop&q=80',
    NULL, NULL, NULL, 176, 29
);