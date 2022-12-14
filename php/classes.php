<?php
    class Logic 
    {  
        private static function GetDB()
        {
            // Gets absolute path for DB
            $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]) . "/cloud11/RJS2000";
            return new SQLite3($rootDir . '/database/database.db');
        }

        public static function AddPlayer($name)
        {
            $db = self::GetDB();
            $stmt = $db->prepare('INSERT INTO players(name) VALUES(:name)');
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $result = $stmt->execute();
        }

        public static function DeletePlayer($id)
        {
            $db = self::GetDB();
            $stmt = $db->prepare('DELETE FROM players WHERE id = :id');
            $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
            $result = $stmt->execute();
        }

        public static function DeleteAll()
        {
            $db = self::GetDB();
            $stmt = $db->prepare('DELETE FROM players');
            $result = $stmt->execute();
        }

        public static function GetPlayers()
        {
            $db = self::GetDB();
            $res = $db->query('SELECT * FROM players');
            $empty_result = true;
            $players_amount = 0;
            echo '<table class="center">';
            while ($row = $res->fetchArray())
            {
                echo '<tr>
                <td>'. $row["name"].'</td>
                <td><a href="php/delete_player.php?id='.$row["id"].'">❌</a></td>
                </tr>';
                $empty_result = false;
                $players_amount++;
            }
            // Check if result empty
            if($empty_result) {
                echo '<tr><td id="no-players">No players added</td></tr>';
            }
            echo '</table>';
            if(!$empty_result) {
                echo '<p id="players-amount"><span id="amount">'.$players_amount.'</span> players - <a href="php/delete_all.php">Delete all</a></p>';
            }
        }

        public static function GetRandomizedPlayers($size, $type)
        {
            $db = self::GetDB();
            $res = $db->query('SELECT * FROM players ORDER BY RANDOM()');
            $arr = [];
            while ($row = $res->fetchArray())
            {
                array_push($arr, $row["name"]);
            }

            // Depends on whether the user has selected the number of teams or the number of people per team
            if(strpos($type, 'number-of-teams') !== false) {
                $count = ceil(sizeof($arr) / $size);
            } else {
                $count = $size;
            }

            // Divide the array into the desired groups and convert it to JSON
            $teams = array_chunk($arr, $count);
            $teams_as_json = json_encode($teams, JSON_PRETTY_PRINT);

            // Save randomized team to db as JSON text
            $stmt = $db->prepare('INSERT INTO teams(team_json) VALUES(:team_json)');
            $stmt->bindValue(':team_json', $teams_as_json, SQLITE3_TEXT);
            $result = $stmt->execute();

            echo "<div class='result'>";
            $i = 1;
            foreach($teams as $team)
            {
                echo "<div id=". $i ."><span class='team-name'>Team " . $i . " </span><br>"; 
                foreach($team as $member)
                {
                    echo "<span class='player'>".$member.self::randomEmoji()." </span>";
                }
                echo "</div>";
                $i++;
            }
            echo "</div>";
        }
        
        public static function DownloadTeams($type)
        {
            $db = self::GetDB();
            // Select latest team from database
            $res = $db->query('SELECT * FROM teams WHERE id=(SELECT max(id) FROM teams)');
            while ($row = $res->fetchArray())
            {
                $jsonans = json_decode($row["team_json"], true);
            }

            // CSV file name => geeks.csv
            $csv = '../assets/teams.csv';
            
            // File pointer in writable mode
            $file_pointer = fopen($csv, 'w');
            
            // Traverse through the associative
            // array using for each loop
            foreach($jsonans as $i){
                // Write the data to the CSV file
                fputcsv($file_pointer, $i);
            }
            
            // Close the file pointer.
            fclose($file_pointer);

            // Download file
            header("location: ../assets/teams.csv");
        }

        private static function randomEmoji() 
        {
            $emojis = array("&#128512", "&#128513", "&#128521", "&#128525", "&#128526", "&#128531", "&#128545", "&#128553", "&#128563", "&#129300");
            shuffle($emojis);
            return $emojis[0];
        }
    }
?>