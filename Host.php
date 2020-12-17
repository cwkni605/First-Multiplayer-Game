<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Host</title>
<style>
    body
    {
        background-color: #9500ff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='968' height='116.2' viewBox='0 0 1000 120'%3E%3Cg fill='none' stroke='%2368008d' stroke-width='10.1' stroke-opacity='0.7'%3E%3Cpath d='M-500 75c0 0 125-30 250-30S0 75 0 75s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 45c0 0 125-30 250-30S0 45 0 45s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 105c0 0 125-30 250-30S0 105 0 105s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 15c0 0 125-30 250-30S0 15 0 15s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500-15c0 0 125-30 250-30S0-15 0-15s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 135c0 0 125-30 250-30S0 135 0 135s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3C/g%3E%3C/svg%3E");
    }
    h2
    {
        background-color: rgb(180, 30, 255);
        border-radius: 5px;
        border-color: rgb(80, 0, 120);
        border-width: 2px;
        border-style: solid;
        padding: 20px;
        width: max-content;
    }
    p
    {
        background-color: rgb(180, 30, 255);
        border-radius: 5px;
        border-color: rgb(80, 0, 120);
        border-width: 2px;
        border-style: solid;
        padding: 5px;
        width: max-content;
        margin: 0px;
        margin-left: 20px;
    }
    p.answer
    {
        background-color: rgb(180, 30, 255);
        border-radius: 5px;
        border-color: rgb(80, 0, 120);
        border-width: 2px;
        border-style: solid;
        padding: 5px;
        width: max-content;
        margin: 0px;
        margin-left: 40px;
    }
    input
    {
        background-color: rgb(180, 30, 255);
        border-radius: 5px;
        border-color: rgb(80, 0, 120);
        border-width: 4px;
        border-style: solid;
        padding: 5px;
        width: 120px;
        margin: 1px;
        margin-left: 20px;
    }
    button
    {
        background-color: rgb(180, 30, 255);
        border-radius: 5px;
        border-color: rgb(80, 0, 120);
        border-width: 2px;
        border-style: solid;
        padding: 5px;
        width: 100px;
        margin: 0px;
        margin-left: 20px;
    }
</style>
</head>
    <body>
        <h1>Kaboop Hosting</h1>
        <hr>
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
                echo "<h2>Participent list:</h2>";
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
                                echo "<p><strong>".explode(".", $fileName)[0]."</strong> scored " . get_user_data($fileName) . "</p><br>";
                            }
                            else
                            {
                                echo "<p><strong>".explode(".", $fileName)[0] . "</strong> scored " . get_user_data($fileName) . " out of " . get_test_data() . " points</p><br>";
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
                            echo "<p>From <strong>" . explode(".", $fileName)[0] . "</strong></p><br>";
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>";
                            }
                            else {
                                $from = fgets($fileHandle);
                                echo "<p>questions: " . htmlentities($from) . "</p><br>";
                                fclose($fileHandle);
                            }
                        }
                    }
                }
                //prints out a form so you can start hosting
                echo '<h2>Kaboop Hosting</h2><form action="Host.php" method="post"><p>Your test: </p><input type="text" name="testCode"><br></form>';
            }
        ?>
    </body>
</html>