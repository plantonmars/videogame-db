
<?php

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

  //*************************************************************************************************
  //Query that creates the videogames table, where all records pertaining to the application will be
  //held and also creates a user table where the users for this website will be stored.
  //*************************************************************************************************
  $query = "DROP TABLE IF EXISTS videogames;
            CREATE TABLE videogames (
            Title VARCHAR(200) NOT NULL PRIMARY KEY,
            Platform VARCHAR(150),
            Year CHAR(4),
            Genre VARCHAR(150),
            Publisher VARCHAR(200),
            Rating VARCHAR(8)); INSERT INTO videogames (Title, Platform, Year, Genre, Publisher, Rating) VALUES
            ('Wii Sports', 'Wii', '2006', 'Sports', 'Nintendo', 'Everyone'),
            ('Nintendogs', 'DS', '2005', 'Simulation', 'Nintendo', 'Everyone'),
            ('Grand Theft Auto V', 'X360', '2013', 'Action', 'Take-Two Interactive', 'Mature'),
            ('Halo 3', 'X360', '2007', 'Shooter', 'Microsoft Game Studios', 'Mature'),
            ('Super Smash Bros. Brawl', 'Wii', '2008', 'Fighting', 'Nintendo', 'Teen'),
            ('Pokemon Emerald Version', 'GBA', '2004', 'Role-Playing', 'Nintendo', 'Everyone'),
            ('Destiny', 'PS4', '2014', 'Shooter', 'Activision', 'Mature'),
            ('Tetris', 'NES', '1988', 'Puzzle', 'Nintendo', 'Everyone'),
            ('Super Mario Bros. 3', 'GBA', '2003', 'Platform', 'Nintendo', 'Everyone'),
            ('Guitar Hero II', 'PS2', '2006', 'Misc', 'RedOctane', 'Teen'),
            ('Super Mario Sunshine', 'GC', '2002', 'Platform', 'Nintendo', 'Everyone'),
            ('Tomodachi Life', '3DS', '2013', 'Simulation', 'Nintendo', 'Everyone'),
            ('Sypro The Dragon', 'PS', '1998', 'Platform', 'Sony Computer Entertainment', 'Everyone'),
            ('FIFA 15', 'PS3', '2014', 'Sports', 'Electronic Arts', 'Everyone'),
            ('Animal Crossing: Wild World', 'DS', '2005', 'Simulation', 'Nintendo', 'Everyone'),
            ('Super Mario 64', 'N64', '1996', 'Platform', 'Nintendo', 'Everyone'),
            ('Animal Crossing: New Leaf', '3DS', '2012', 'Simulation', 'Nintendo', 'Everyone'),
            ('Pac-Man', '2600', '1982', 'Puzzle', 'Atari', 'Everyone'),
            ('Kingdom Hearts', 'PS2', '2002', 'Role-Playing', 'Sony Computer Entertainment', 'Teen'),
            ('Cooking Mama', 'DS', '2006', 'Simulation', '505 Games', 'Everyone');
            DROP TABLE IF EXISTS users;
            CREATE TABLE users (
            Username VARCHAR(50) PRIMARY KEY NOT NULL,
            Email VARCHAR(200) NOT NULL,
            Password VARCHAR(255) NOT NULL)";


  $result = $conn->multi_query($query);
  if (!$result) die ("Database access failed");
  else echo "Tables created successfully.";


 ?>
