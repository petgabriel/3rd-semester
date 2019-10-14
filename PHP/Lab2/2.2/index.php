<?php
error_reporting(-1);
ini_set("display_errors", "On");
session_start();
?>
<html>
<head>
    <title>Superglobals</title>

    <style type="text/css">
        .block {
            display: inline-block;
            width: 30px;
            height: 30px;
            padding: 0px;
            margin: 0px;
        }
        .block:hover {
            background-color: lightgray;
        }
        .red {
            background-color: red;
        }
        .blue {
            background-color: blue;
        }
        .green {
            background-color: green;
        }
        .gray {
            background-color: gray;
        }
        .white {
            background-color: white;
        }
    </style>
</head>
<body>

<form action="index.php" method="post">
    COLUMN:
    <input type="text" name="COLUMN"><br>
    ROW:
    <input type="text" name="ROW"><br>
    COLOR:
    <select name="COLOR">
        <option value="RED">red</option>
        <option value="GREEN">green</option>
        <option value="BLUE">blue</option>
        <option value="GRAY">gray</option>
        <option value="WHITE">white</option>
    </select><br>
    <input type="submit" value="Submit">
    <input type="submit" value="Reset canvas">
</form>

<?php

    function draw_line($x1, $y1, $x2, $y2)
    {
        $dx = $x2 - $x1;
        $dy = $y2 - $y1;

        $dx1 = abs($dx);
        $dy1 = abs($dy);

        $px = 2 * $dy1 - $dx1;
        $py = 2 * $dx1 - $dy1;

        global $table;

        if ($dy1 <= $dx1) {

            if ($dx >= 0) {
                $x = $x1; $y = $y1; $xe = $x2;
            } else {
                $x = $x2; $y = $y2; $xe = $x1;
            }

            $table[$x][$y] = "white";

            for ($i = 0; $x < $xe; $i++) {
                $x = $x + 1;

                if ($px < 0) {
                    $px = $px + 2 * $dy1;
                } else {
                    if (($dx < 0 && $dy < 0) || ($dx > 0 && $dy > 0)) {
                        $y = $y + 1;
                    } else {
                        $y = $y - 1;
                    }
                    $px = $px + 2 * ($dy1 - $dx1);
                }

                $table[$x][$y] = "white";

            }

        } else {

            if ($dy >= 0) {
                $x = $x1; $y = $y1; $ye = $y2;
            } else {
                $x = $x2; $y = $y2; $ye = $y1;
            }

            $table[$x][$y] = "white";

            for ($i = 0; $y < $ye; $i++) {
                $y = $y + 1;

                if ($py <= 0) {
                    $py = $py + 2 * $dx1;
                } else {
                    if (($dx < 0 && $dy<0) || ($dx > 0 && $dy > 0)) {
                        $x = $x + 1;
                    } else {
                        $x = $x - 1;
                    }
                    $py = $py + 2 * ($dx1 - $dy1);
                }

                $table[$x][$y] = "white";
            }
        }
    }

    $SX=10;
    $SY=10;
    $color="RED";
    $count = -1;

    if(isset($_COOKIE["COLOR"]))
    {
        $color = $_COOKIE["COLOR"];
    }

    if(isset($_POST["COLOR"])) {
        $color = $_POST["COLOR"];
        setcookie("COLOR", $color);
    }

    if(isset($_POST["COLUMN"]) and $_POST["COLUMN"] != "") {
        $SX = $_POST["COLUMN"];
        $_SESSION["COLUMN"] = $SX;
    }
    else if(isset($_SESSION["COLUMN"])){
        $SX = $_SESSION["COLUMN"];
    }

    if(isset($_POST["ROW"]) and $_POST["ROW"] != "") {
        $SY = $_POST["ROW"];
        $_SESSION["ROW"] = $SY;
    }
    else if(isset($_SESSION["ROW"])) {
        $SY = $_SESSION["ROW"];
    }

    $table = array();

    if(isset($_SESSION['tab']))
    {
        $table = $_SESSION['tab'];
    }

    if(isset($_SESSION['count']))
    {
        $count = $_SESSION['count'];
    }

    if(isset($_POST["ROW"]) || isset($_POST["COLUMN"]) || isset($_POST["COLOR"]))
    {
        $table = array();
        $count = -1;
        $_SESSION['count'] = -1;
    }

    if(isset($_GET['x']) && isset($_GET['y'])) {
        $j = $_GET['x'];
        $i = $_GET['y'];

        $table[$j][$i] = "white";
        $count++;
        $_SESSION['count'] = $count;

        if( $count % 2 == 0 )
        {
            $_SESSION['xy1'] = ["x" => $j, "y" => $i];
        }

        if( $count % 2 == 1 )
        {
            $_SESSION['xy2'] = ["x" => $j, "y" => $i];
            draw_line($_SESSION['xy1']["x"], $_SESSION['xy1']["y"], $_SESSION['xy2']["x"], $_SESSION['xy2']["y"]);
        }
    }

    for( $i = 0; $i < $SY; $i++ )
    {
        echo "<div>";
        $table2 = array();

        for( $j = 0; $j < $SX; $j++ )
        {
            if(isset($table[$j][$i]) && $table[$j][$i] == "white")
            {
                echo "<a href=\"./index.php?x=$j&y=$i\" class=\"block white\"></a>";
                continue;
            }

            array_push($table2, "$color");
            echo "<a href=\"./index.php?x=$j&y=$i\" class=\"block $color\"></a>";
        }

        array_push($table, $table2);

        echo "</div>";
    }

    $_SESSION['tab'] = $table;
?>

</body>
</html>
