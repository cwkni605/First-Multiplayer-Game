<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Host</title>
</head>
    <body>
        <h1>Kaboop Hosting</h1>
        <hr>
        <h2>Participent list:</h2>
        <?php
            $testFile = $_POST['testCode'];
            //echo var_dump($_POST);
            //if the $_POST has the needed data then run the hoster if not run test selector
            if(is_string($testFile))
            {
                $questionNumber = 1;
                //sets uniform directorys
                $gamedir ="./data/tests";
                $tempGameDir ="./data/gameStates/$testFile";
                // a function to retreave data easier
                function get_user_data($nameofFile)
                {
                    $testFile = $_POST['testCode'];
                    $tempGameDir ="./data/gameStates/$testFile";
                    if (is_dir($tempGameDir)) {
                        $testFiles = scandir($tempGameDir);
                        foreach ($testFiles as $fileName) {
                            if ($fileName == $nameofFile) {
                                $fileHandle = fopen($tempGameDir . "/" . $fileName, "rb");
                                if ($fileHandle === false) {
                                    echo "There was an error reading file \"$fileName\".<br>\n";
                                }
                                else {
                                    $line = fgets($fileHandle);
                                    //$questionNumber = htmlentities($number);
                                    return $line;
                                    fclose($fileHandle);
                                }
                            }
                        }
                    }
                }
                function get_test_data()
                {
                    $testFile = $_POST['testCode'];
                    $gamedir ="./data/tests";
                    if (is_dir($gamedir)) {
                        $testFiles = scandir($gamedir);
                        foreach ($testFiles as $fileName) {
                            if ($fileName == $testFile.'.txt') {
                                $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                                if ($fileHandle === false) {
                                    echo "There was an error reading file \"$fileName\".<br>\n";
                                }
                                else {
                                    $line = fgets($fileHandle);
                                    $questionNumber = htmlentities($line);
                                    return $line;
                                    fclose($fileHandle);
                                }
                            }
                        }
                    }
                }
                //checks to see if the dir is real
                if (is_dir($tempGameDir)) {
                    $testFiles = scandir($tempGameDir);
                    foreach ($testFiles as $fileName) {
                        //checks to see if the file is the right one
                        if ($fileName != $testFile.".txt" && $fileName != "." && $fileName != "..") {
                            //prints file name
                            if(get_user_data($fileName) == "pending")
                            {
                                echo "<strong>".explode(".", $fileName)[0]."</strong> scored " . get_user_data($fileName) . "<br>";
                            }
                            else
                            {
                                echo "<strong>".explode(".", $fileName)[0] . "</strong> scored " . get_user_data($fileName) . " out of " . get_test_data() . " points<br>";
                            }
                            //opens file reader
                            $fileHandle = fopen($tempGameDir . "/" . $fileName, "rb");
                            //error handler
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>\n";
                            }
                            else {
                                //prepares variables
                                $userquestionNumber = fgets($fileHandle);
                                $notEnd = true;
                                //reads the the user data and sees if they are finished
                                $line = fgets($fileHandle);
                                //if()
                                
                            }
                            //closes the file reader
                            fclose($fileHandle);
                        }
                    }
                }
                //this writes to the temp game file
                if (is_dir($tempGameDir)) {
                    $saveFileName = "$tempGameDir/$testFile.txt";
                    $tempGameFileString = $questionNumber;
                    $fileHandle = fopen($saveFileName, "wb");
                    if ($fileHandle === false) {
                        echo "There was an error creating \"" . htmlentities($saveFileName) . "\".<br>\n";
                    } else {
                        if (flock($fileHandle, LOCK_EX)) {    
                            if (fwrite($fileHandle, $tempGameFileString) > 0){
                                //echo "Successfully wrote to file \"" . htmlentities($saveFileName) . "\".<br>\n";
                            } else {
                                echo "There was an error writing to \"" .
                                htmlentities($saveFileName) . "\".<br>\n";
                            }
                            flock($fileHandle, LOCK_UN);
                        } else {
                            echo "There was an error locking file \"" .
                            htmlentities($saveFileName) . "\" for writing.<br>\n";
                        }
                        fclose($fileHandle);
                    }
                }
                echo '<script>setTimeout(function(){ location.reload(); }, 500);</script>';
            }
            else
            {
                //this reads the files the displays them
                $gamedir ="./data/tests";
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        if ($fileName !== "." && $fileName !== "..") {
                            echo "From <strong>$fileName</strong><br>";
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>\n";
                            }
                            else {
                                $from = fgets($fileHandle);
                                echo "questions: " . htmlentities($from) . "<br>\n";
                                fclose($fileHandle);
                            }
                        }
                    }
                }
                //prints out a form so you can start hosting
                echo '<h2>Kaboop Hosting</h2><form action="Host.php" method="post">Your test: <input type="text" name="testCode"><br></form>';
            }
        ?>
    </body>
</html>