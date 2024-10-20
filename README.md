# rule-engine-ast

**Description**
This project implements a Rule Engine that allows users to define, store, and evaluate rules dynamically using an Abstract Syntax Tree (AST). The rules are stored in a MySQL database and evaluated against user input (e.g., age, department). The system uses PHP for the backend, MySQL for data storage, and HTML/JavaScript for the frontend interface.

**Features:**
Define rules such as age > 30 AND department == 'Sales'.
Store rules in a MySQL database.
Evaluate rules dynamically based on user input.
Display the list of existing rules.


**Technologies:**
      Backend: PHP
      Database: MySQL (via phpMyAdmin in XAMPP)
      Frontend: HTML/CSS, JavaScript
      Local Server: XAMPP (Apache, MySQL)

      
**Prerequisites:**
XAMPP: Make sure XAMPP is installed and running on your local machine.
MySQL: The MySQL database should be set up through phpMyAdmin.
Browser: A modern web browser to access the frontend.


**Setup Instructions:**

**1. Clone the Repository**

      git clone https://github.com/puri19/rule-engine-ast.git

**3. Database Setup**
Open phpMyAdmin (http://localhost/phpmyadmin).
Create a new database called rule_engine_db.
Run the following SQL scripts in phpMyAdmin to create the necessary tables:

      CREATE TABLE Rules (
          id INT AUTO_INCREMENT PRIMARY KEY,
          rule_string VARCHAR(255) NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );

      CREATE TABLE Nodes (
          id INT AUTO_INCREMENT PRIMARY KEY,
          rule_id INT,
          type ENUM('operator', 'operand') NOT NULL,
          value VARCHAR(255),
          left_id INT,
          right_id INT,
          FOREIGN KEY (rule_id) REFERENCES Rules(id)
      );


**3. Configure XAMPP**
Place the entire project folder inside the xampp/htdocs directory.
Start Apache and MySQL from the XAMPP Control Panel.

**4. Run the Application**
In your browser, go to http://localhost/rule-engine-ast/index.html.
You can now create and evaluate rules.
**API Endpoints:**

**Create a Rule:** Adds a rule to the database.

    URL: api.php
    Method: POST
    Parameters: rule_string

**Evaluate a Rule:** Evaluates the rule against user data.

    URL: api.php
    Method: POST
    Parameters: rule_id, age, department

**Fetch Rules:** Fetches all the stored rules.

    URL: api.php 
    Method: GET

**Bonus Features:**
**Security:** Input validation is added to prevent SQL injection attacks.

**Error Handling:** Catches any PHP errors during evaluation and returns them as JSON responses.

**Testing:** You can create rules such as age > 30 AND department == 'Sales' and test them against user input.

**Notes:**
Ensure that the eval() function handles the correct input formats (e.g., quotes around string values).

