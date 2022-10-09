<?php
    class Logic 
    {  
        public static function GetDB()
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

        public static function GetPlayers()
        {
            $db = self::GetDB();
            $res = $db->query('SELECT * FROM players');
            $empty_result = true;
            echo '<table class="center">';
            while ($row = $res->fetchArray())
            {
                echo '<tr>
                <td>'. $row["name"].'</td>
                <td><a href="php/delete_player.php?id='.$row["id"].'">❌</a></td>
                </tr>';
                $empty_result = false;
            }
            // Check if result empty
            if($empty_result) {
                echo '<tr><td id="no-players">No players added</td></tr>';
            }
            echo '</table>';
        }

        public static function GetRandomizedPlayers($team_size)
        {
            $db = self::GetDB();
            $res = $db->query('SELECT * FROM players ORDER BY RANDOM()');
            $arr = [];
            while ($row = $res->fetchArray())
            {
                array_push($arr, $row["name"]);
            }

            // Divide the array into the desired groups and convert it to JSON
            $teams = array_chunk($arr, $team_size);
            $teams_as_json = json_encode($teams, JSON_PRETTY_PRINT);

            // Save randomized team to db as JSON text
            $stmt = $db->prepare('INSERT INTO teams(team_json) VALUES(:team_json)');
            $stmt->bindValue(':team_json', $teams_as_json, SQLITE3_TEXT);
            $result = $stmt->execute();

            echo "<div class='result'>";
            $count = 1;
            foreach($teams as $team)
            {
                echo "<div id=". $count ."><span class='team-name'>Team " . $count . " </span><br>"; 
                foreach($team as $member)
                {
                    echo $member . " ";
                }
                echo "</div>";
                $count++;
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
    }
?>