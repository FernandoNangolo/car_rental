### Instructions to Setup the PHP Application "Car Rental"

1. *Start XAMPP and Services*
   - Open XAMPP.
   - Click the "Start" button for both Apache and MySQL.

2. *Project Files Placement*
   - Place all project files in the "htdocs" folder within the XAMPP installation directory (e.g., C:\xampp\htdocs).

3. *Setting Up the Database*
   - In the XAMPP control panel, click the "Admin" button for MySQL. This will open phpMyAdmin in the web browser.
   - In phpMyAdmin:
     1. Click on the "Databases" tab.
     2. In the "Create database" field, enter car_rental as the database name.
     3. Click the "Create" button to create the database.
   - With the car_rental database selected:
     1. Click on the "SQL" tab.
     2. Open the project files and locate the car_rental.sql file.
     3. Open the car_rental.sql file and copy the SQL scripts containing the schema and initial data.
     4. Paste the copied SQL scripts into the provided SQL editor in phpMyAdmin.
     5. Click the "Go" button to execute the SQL scripts and set up the database schema and initial data.

4. *Accessing the Website*
   - In the XAMPP control panel, click the "Admin" button for Apache. This will open the web browser.
   - In the browser, navigate to http://localhost/car_rental to access the login page.

5. *Logging In*
   - Use one of the following credentials to log in:
     - *Admin Account:*
       - Username: Admin
       - Password: admin
     - *User Accounts:*
       - Username: Nangolo
       - Password: nan
       - Username: Fernando
       - Password: fer

       6.