# Sri Lanka Travel Itinerary Planner

A stunning, modern, and fully functional web application designed to help users plan their dream vacation to the tear-drop island of Sri Lanka. Built with HTML, CSS, JavaScript, PHP 8, and MySQL, providing a robust authentication and database-driven itinerary experience.

Theme & Design
The user interface focuses on the rich beauty of Sri Lanka, employing a color palette inspired by its lush jungles (Jungle Green), golden beaches (Warm Golden Yellow), and deep oceans (Ocean Blue). 
- Modern Authentication UI: Seamless Login and Register interfaces with proper form validation.
- Glassmorphism: Elegant semi-transparent overlays on hero sections.
- Bootstrap 5 Card & Grid Layouts: Neat, mobile-first responsive design.
- Dynamic Content: State-aware Navigation bar modifying elements based on secure PHP sessions.

 Backend Features (PHP & MySQL)
1. Secure Authentication System
   - User Registration with `password_hash()` encryption.
   - User Login with `password_verify()` utilizing PHP global `$_SESSION` management.
   - Dedicated `login.html` and `register.html` views receiving dynamic URL-based error/success feedback natively from the server (`auth/` endpoints).
2. Database Integration
   - Secure PDO (PHP Data Objects) execution configured specifically via Port `3307`.
   - Complete SQL Injection prevention using Prepared Statements.
   - Distinct MySQL relational tables for `users`, `messages`, and `itineraries`.
3. Apache `.htaccess` Routing
   - Native HTML pages (`.html`) parse standard PHP commands, natively injecting modular components (like `navbar.php`) without exposing `.php` routing files to the user domain!

 Application Flow
1. Home Page (`index.html`)
   - Striking Hero Section and top destinations carousel.
2. Authentication (`login.html` & `register.html`)
   - Users create accounts and authenticate securely.
3. Plan Trip Dashboard (`plantrip.html` & `dashboard.php`)
   - Private dashboard available only to authenticated users (`is_logged_in()` check).
   - Dynamic itinerary handling capturing data locally to MySQL endpoints (`add_trip.php` and `delete_trip.php`).
4. Contact Page (`contact.html`)
   - Sends user inquiries directly to the secure database via `contact.php` processing.

Installation & Usage Instructions
To view and interact with the full-stack project natively:

1. Setup XAMPP:
   - Install XAMPP and start both the Apache and MySQL modules.
2. Database Import:
   - Open your browser and go to `http://localhost/phpmyadmin` (or `http://localhost:3307/phpmyadmin`).
   - Create a new database named `travel_planner`.
   - Import the provided `database.sql` file to structure your `users`, `itineraries`, and `messages` tables automatically.
3. Deploy Project Directory:
   - Move this entire project folder into your XAMPP's `htdocs` directory (e.g., `C:\xampp\htdocs\sri_lanka_travel_planner`).
4. Launch Application:
   - Open your browser and navigate to:
     `http://localhost/sri_lanka_travel_planner/index.html`


Project Structure
text

├── index.html       
├── login.html       
├── register.html     
├── plantrip.html     
├── contact.html      
├── dashboard.php    
├── auth/
│   ├── login.php     
│   ├── register.php  
│   ├── logout.php    
├── includes/
│   ├── db.php        
│   ├── functions.php 
│   ├── navbar.php    
├── .htaccess         
├── database.sql     
├── css/              
├── js/               
└── images/           


Technologies Used
- Frontend: HTML5, CSS3, Bootstrap 5.3, Vanilla JavaScript, FontAwesome
- Backend: PHP 8+, Local PHP Sessions, Apache Server Configuration
- Database: MariaDB / MySQL (PDO execution)
