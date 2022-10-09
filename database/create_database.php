<?php
    // create new SQLite3-object
    $db = new SQLite3("database.db");

    // create new table named as "players"
    $db->exec("CREATE TABLE players(id INTEGER PRIMARY KEY, name TEXT)");
    $db->exec("CREATE TABLE teams(id INTEGER PRIMARY KEY, team_json TEXT)");

    // add sample data
    $db->exec("INSERT INTO players(name) VALUES('Nissan')");
    $db->exec("INSERT INTO players(name) VALUES('Toyota')");
    $db->exec("INSERT INTO players(name) VALUES('Skoda')");
?>