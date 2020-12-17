<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Join</title>
<style>
    body
    {
        background-color: #9500ff;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='968' height='116.2' viewBox='0 0 1000 120'%3E%3Cg fill='none' stroke='%2368008d' stroke-width='10.1' stroke-opacity='0.7'%3E%3Cpath d='M-500 75c0 0 125-30 250-30S0 75 0 75s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 45c0 0 125-30 250-30S0 45 0 45s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 105c0 0 125-30 250-30S0 105 0 105s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 15c0 0 125-30 250-30S0 15 0 15s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500-15c0 0 125-30 250-30S0-15 0-15s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3Cpath d='M-500 135c0 0 125-30 250-30S0 135 0 135s125 30 250 30s250-30 250-30s125-30 250-30s250 30 250 30s125 30 250 30s250-30 250-30'/%3E%3C/g%3E%3C/svg%3E");
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
    h1
    {
        background-color: rgb(180, 30, 255);
        border-radius: 5px;
        border-color: rgb(80, 0, 120);
        border-width: 2px;
        border-style: solid;
        padding: 20px;
        width: max-content;
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
</style>
</head>
    <body>
    <center><h1>Great Job</h1></center>
        <h2>Finished Kaboop</h2>
        <?php
        $testFile = $_POST['testCode'];
        $username = $_POST['username'];
        $testData = $_POST;
        $questionsCorrect = 0;
        $testAnswers = [];
            if(is_string($testFile))
            {
                //sets uniform directorys
                $gamedir ="./data/tests";
                $tempGameDir ="./data/gameStates";
                //checks to see if the dir is real
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        //checks to see if the file is the right one
                        if ($fileName == $testFile.".txt") {
                            //prints file name
                            echo "<p>Test code: <strong>".explode('.', $fileName)[0]."</strong><p><br>";
                            //opens file reader
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                            //error handler
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\".<br>";
                            }
                            else {
                                //prepares variables
                                $questionNumber = fgets($fileHandle);
                                $notEnd = true;
                                $formquestionNumber = 0;
                                //loops untill all of the questions are looped through
                                while($notEnd)
                                {
                                    //this assembles the answers
                                    for ($x = 0; $x <= 5; $x++)
                                    {
                                        $line = fgets($fileHandle);
                                        if ($line == "")
                                        {
                                            $notEnd = false;
                                        break;
                                        }
                                        else if($x == 5)
                                        {
                                            array_push($testAnswers, htmlentities($line));
                                        }
                                    }
                                    //this removes extra code when done
                                    if (!$notEnd) {
                                        break;
                                    }
                                }
                            }
                            //closes the file reader
                            fclose($fileHandle);
                        }
                    }
                }
                //this writes to a file
                for ($i=0; $i < (count($_POST)-2); $i++) { 
                    $out = $_POST[$i];
                    if ($out == $testAnswers[$i]) {
                        $questionsCorrect++;
                    }
                }
                if (is_dir($tempGameDir)) {
                    $userdata = $questionsCorrect;
                    $saveFileName = "$tempGameDir/$testFile/$username.txt";
                    //echo $saveFileName."<br>";
                    $fileHandle = fopen($saveFileName, "wb");
                    if ($fileHandle === false) {
                        echo "There was an error creating \"" . htmlentities($saveFileName) . "\".<br>";
                    } else {
                        if (flock($fileHandle, LOCK_EX)) {    
                            if (fwrite($fileHandle, $userdata) > 0){
                                echo "<p>Successfully saved your test, ask your test host for your score!</p>";
                            } else {
                                echo "There was an error writing to \"" .
                                htmlentities($saveFileName) . "\".<br>";
                            }
                            flock($fileHandle, LOCK_UN);
                        } else {
                            echo "There was an error locking file \"" .
                            htmlentities($saveFileName) . "\" for writing.<br>";
                        }
                        fclose($fileHandle);
                    }
                }
            }
        ?>
    </body>
</html>