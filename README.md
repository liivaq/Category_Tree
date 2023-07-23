## Simple website with user registration and login system. 

Sample website available here: [Category Test Site](https://liiva-test.000webhostapp.com/)

User page has these features:
- create sections with title and description, 
- unlimited amount of subsections for each section (or subsection),
- edit sections,
- delete sections at any level

## Project made with:
- Php 8.1,
- Twig as templating engine,
- Tailwind CSS,
- MySQL 8.0.33

## Prerequisites to run the project:
- PHP 8.1,
- Composer
- MySQL

## To run the project:

1. Clone this project using command `git clone https://github.com/liivaq/Category_Tree.git` in your terminal (or download it as a zip);
2. Open the project in IDE of your choice;
3. Set up the database:
    - If unfamiliar, you can learn about MySQL [here](https://www.w3schools.com/mysql/mysql_create_db.asp),
    - Necessary queries for table generation are available in the file `db_queries.sql`
4. Copy the `.env.example` file, rename to `.env` and add your database information there (host, name, username, password)
5. Run command `composer install` to install the necessary dependencies,
6. Start a local server using the command `php -S localhost:8000 -t public/`,
7. Click on the generated link or open `localhost:8000` in your browser.
8. Enjoy!
