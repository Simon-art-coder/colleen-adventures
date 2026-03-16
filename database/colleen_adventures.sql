-- Create database
CREATE DATABASE IF NOT EXISTS colleen_adventures;
USE colleen_adventures;

-- Tours table
CREATE TABLE IF NOT EXISTS tours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    route_name VARCHAR(100) NOT NULL,
    duration_days INT NOT NULL,
    price_international_usd DECIMAL(10,2),
    price_kenyan_ksh DECIMAL(10,2),
    group_discount_ksh DECIMAL(10,2),
    difficulty VARCHAR(50) NOT NULL,
    description TEXT,
    highlights TEXT,
    itinerary TEXT,
    is_best_seller BOOLEAN DEFAULT FALSE,
    is_beginner_friendly BOOLEAN DEFAULT FALSE,
    route_image VARCHAR(255) DEFAULT 'default-route.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert tour data
INSERT INTO tours (route_name, duration_days, price_international_usd, price_kenyan_ksh, group_discount_ksh, difficulty, description, highlights, is_best_seller, is_beginner_friendly) VALUES
('Chogoria Route', 5, 900.00, 65000.00, 50000.00, 'Moderate', 'The most scenic route on Mount Kenya. Features stunning landscapes including the Gorges Valley, Lake Ellis, and the Temple of the Gods. Perfect for photographers and nature lovers.', 'Lake Ellis, Nithi Falls, Mau Mau Caves, Gorges Valley, Temple of the Gods', TRUE, FALSE),
('Sirimon Route', 5, 900.00, 65000.00, 50000.00, 'Moderate', 'Best route for beginners with gradual acclimatization. Offers beautiful moorlands and excellent views of the northern side of the mountain.', 'Moorlands, Wildlife viewing, Mackinders Valley, Olonana Falls', FALSE, TRUE),
('Naro Moru Route', 3, NULL, 45000.00, 30000.00, 'Easy/Moderate', 'The shortest and most direct route to Point Lenana. Popular for those with limited time but good fitness.', 'Vertical Bog, Teleki Valley, Summit via Point Lenana, Met Station', FALSE, FALSE),
('Burguret Route', 5, 900.00, 65000.00, 50000.00, 'Challenging', 'The wildest and most remote route. Perfect for adventurers seeking solitude and untouched wilderness. Less crowded with challenging terrain.', 'Wilderness experience, Remote campsites, Waterfalls, Rainforest section', FALSE, FALSE);

-- Day trips table
CREATE TABLE IF NOT EXISTS day_trips (
    id INT PRIMARY KEY AUTO_INCREMENT,
    trip_name VARCHAR(100) NOT NULL,
    description TEXT,
    price_ksh DECIMAL(10,2),
    duration_hours INT,
    difficulty VARCHAR(50),
    image VARCHAR(255) DEFAULT 'default-daytrip.jpg'
);

INSERT INTO day_trips (trip_name, description, duration_hours, difficulty) VALUES
('Lake Ellis', 'Beautiful alpine lake on the Chogoria route. Perfect for day hikes and picnics with stunning views of the surrounding peaks.', 6, 'Moderate'),
('Nithi Falls', 'Spectacular waterfall in the Chogoria region. A refreshing hike through bamboo forests leading to powerful cascades.', 5, 'Moderate'),
('Mau Mau Caves', 'Historical caves with significance to the Mau Mau struggle. Learn about Kenyan history while exploring these natural formations.', 4, 'Easy');

-- Team/guides table
CREATE TABLE IF NOT EXISTS team (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    age INT,
    experience_years INT,
    bio TEXT,
    languages TEXT,
    certifications TEXT,
    photo VARCHAR(255) DEFAULT 'default-guide.jpg',
    is_lead BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE
);

INSERT INTO team (name, role, age, experience_years, bio, languages, certifications, is_lead) VALUES
('Collins Mwenda', 'Lead Guide & Founder', 22, 4, 'Collins grew up in the shadows of Mount Kenya and has been guiding since age 18. His passion for the mountain and local knowledge ensures every client has a safe and memorable experience. He is known for his patience with beginners and his incredible storytelling around the campfire.', 'English, Kiswahili, Kimeru', 'Wilderness First Aid, Mountain Guide Certificate, CPR Certified', TRUE);

-- Testimonials table
CREATE TABLE IF NOT EXISTS testimonials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(100),
    client_country VARCHAR(100),
    testimonial_text TEXT NOT NULL,
    tour_route VARCHAR(100),
    rating INT CHECK (rating >= 1 AND rating <= 5),
    date DATE,
    photo VARCHAR(255),
    approved BOOLEAN DEFAULT FALSE
);

INSERT INTO testimonials (client_name, client_country, testimonial_text, tour_route, rating, date, approved) VALUES
('Sarah Johnson', 'United Kingdom', 'Collins made our Mount Kenya trek unforgettable! His knowledge of the mountain and constant encouragement helped our group reach Point Lenana. The Chogoria route is absolutely stunning. Highly recommend Colleen Adventures!', 'Chogoria Route', 5, '2025-12-15', TRUE),
('David Ochieng', 'Kenya', 'Amazing experience with Colleen Adventures. The team was professional, food was great, and we felt safe throughout. Already planning my next trip with them!', 'Sirimon Route', 5, '2026-01-10', TRUE),
('Emma Weber', 'Germany', 'I was nervous about altitude sickness but Collins monitored everyone carefully and we all made it. The Burguret route is wild and beautiful - perfect for adventurous souls.', 'Burguret Route', 5, '2026-02-05', TRUE),
('James Mwangi', 'Kenya', 'Took my family on the Naro Moru route. Collins was patient with my children (12 and 14) and made sure everyone enjoyed the experience. Great value for money!', 'Naro Moru Route', 4, '2026-01-20', TRUE);

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tour_id INT,
    client_name VARCHAR(100) NOT NULL,
    client_email VARCHAR(100) NOT NULL,
    client_phone VARCHAR(20) NOT NULL,
    group_size INT NOT NULL,
    preferred_date DATE NOT NULL,
    special_requests TEXT,
    booking_status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tour_id) REFERENCES tours(id)
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gallery table
CREATE TABLE IF NOT EXISTS gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image_title VARCHAR(100),
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(50),
    description TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site settings table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT
);

INSERT INTO site_settings (setting_key, setting_value) VALUES
('company_name', 'Colleen Adventures'),
('company_tagline', 'Your Local Guide to Mount Kenya''s Peaks'),
('company_email', 'collenadventures@gmail.com'),
('company_phone', '0712490970'),
('company_phone_2', '0734467422'),
('company_address', 'Nairobi, Kenya'),
('facebook', 'collenadventures'),
('instagram', 'collenadventures'),
('tiktok', 'collenadventures'),
('tripadvisor', 'collenadventures'),
('business_reg', 'BN-AYSOE2YW'),
('established_year', '2026'),
('primary_color', '#8B4513'),
('secondary_color', '#2E5C3E'),
('accent_color', '#FFFFFF'),
('whatsapp', '0712490970'),
('map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15955.234567890123!2d37.123456!3d-0.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMMKwMDcnMjQuNCJTIDM3wrAwNic0NS4wIkU!5e0!3m2!1sen!2ske!4v1234567890');