# videogamedb
A dynamic website created using PHP to provide video game information stored within the database. Concepts within this project include: database manipulation, sanitization, form handling, data validation, session management, and password hashing.

# Stack
For this dynamic website I was introduced to working with the AMPPS (using Apache, MySQL and PHP) stack.

# Setup
A setupDB.php file is used to create the necessary tables within the database and populate them with initial data.

# Files
login.php – Connects to server as gamemaster, a user who has permissons to the database.

setupDB.php – Sets up both tables and provides initial values to the videogames table.

user_registration.php – Registers a user through JavaScript validation. Uses PHP validation to ensure data is correct and then adds a user the database if data is valid.

user_login.php – Provides the initial form for the user to login. Checks to see if provided information is valid on the server side, determines if user can be logged in or not.

main_menu.php – Provides menu options to the user.

list_records.php – Lists all records within the videogames table.

add_records.php – A form is used to add a record to the database. Attempts to add a record and displays results.

delete_records.php – Displays all records, allowing the user to delete desired records through a simple button click.

search_records.php – Allows users to search for a record through a drop-down menu.
searchRecordsResult.php – Attempts to retrieve the desired record and displays results.

logout.php – Destroys the created sessions (if there is one) and redirects user to login page.
