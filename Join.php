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
        <h2>Join Kaboop</h2>
        <?php
        $testFile = $_POST['testCode'];
        $username = $_POST['username'];
        //echo var_dump($_POST);
            if(is_string($testFile))
            {
                //creats a form
                echo '<form action="formProsseser.php" method="post">';
                echo "<p>Your test: </p><input readonly type='text' name='testCode' value='$testFile'><br><p>Your name: </p><input readonly type='text' name='username' value='$username'><br>";
                $questionNumber = 0;
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
                            echo "<p>Test code: <strong>".explode('.', $fileName)[0]."</strong></p><br>";
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
                                    //this prints out the question segments
                                    for ($x = 0; $x <= 5; $x++)
                                    {
                                        $line = fgets($fileHandle);
                                        if ($line == "")
                                        {
                                            $notEnd = false;
                                        break;
                                        }
                                        if($x == 0)
                                        {
                                            echo "<p>Question: " . htmlentities($line) . "</p><br>";
                                        }
                                        else if($x <= 4)
                                        {
                                            echo "<p class='answer'>".$x . ": " . htmlentities($line) . "</p><br>";
                                        }
                                        else if($x == 5)
                                        {
                                            echo "<p>The Answer is <select id='$formquestionNumber' name='$formquestionNumber'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option></select></p><br>";
                                            $formquestionNumber++;
                                        }
                                    }
                                    //this removes the extra hr at the bottom when done
                                    if (!$notEnd) {
                                        break;
                                    }
                                    //puts an hr after each question
                                    echo "<hr>";
                                }
                                echo '<button type="submit">Submit</button></form';
                            }
                            //closes the file reader
                            fclose($fileHandle);
                        }
                    }
                }
                //this writes to a file
                if (is_dir($tempGameDir)) {
                    $questionNumber = 0;
                    $userdata = "pending";
                    $saveFileName = "$tempGameDir/$testFile/$username.txt";
                    $fileHandle = fopen($saveFileName, "wb");
                    if ($fileHandle === false) {
                        echo "There was an error creating \"" . htmlentities($saveFileName) . "\".<br>";
                    } else {
                        if (flock($fileHandle, LOCK_EX)) {    
                            if (fwrite($fileHandle, $userdata) > 0){
                                //echo "Successfully wrote to file \"" . htmlentities($saveFileName) . "\".<br>";
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
            //prints out login form if not logged in
            else
            {
                //this reads the files the displays them
                $gamedir ="./data/tests";
                if (is_dir($gamedir)) {
                    $testFiles = scandir($gamedir);
                    foreach ($testFiles as $fileName) {
                        if ($fileName !== "." && $fileName !== "..") {
                            echo "<p>Test Code: <strong>".explode('.', $fileName)[0]."</strong></p>";
                            $fileHandle = fopen($gamedir . "/" . $fileName, "rb");
                            if ($fileHandle === false) {
                                echo "There was an error reading file \"$fileName\"";
                            }
                            else {
                                $from = fgets($fileHandle);
                                echo "<p>questions: " . htmlentities($from) . "</p><br>";
                                fclose($fileHandle);
                            }
    
                        }
                    }
                }
                echo '<h2>Kaboop Hosting</h2><form action="Join.php" method="post"><p>Enter Your Test Code: </p><input type="text" name="testCode"><br><p>Enter Your Username: </p><input type="text" name="username"><br><button type="submit">JOIN</button></form>';
            }
        ?>
    </body>
</html>