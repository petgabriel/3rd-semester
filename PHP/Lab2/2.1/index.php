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
</form>

<?php
    $SX=10;
    $SY=10;
    $color="RED";

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

    for( $i = 0; $i < $SY; $i++ )
    {
        echo "<div>";

        for( $j = 0; $j < $SX; $j++ )
        {
            switch($color)
            {
                case "RED":
                    echo "<a class=\"block red\"></a>";
                    break;
                case "BLUE":
                    echo "<a class=\"block blue\"></a>";
                    break;
                case "GREEN":
                    echo "<a class=\"block green\"></a>";
                    break;
                case "GRAY":
                    echo "<a class=\"block gray\"></a>";
                    break;
                case "WHITE":
                    echo "<a class=\"block white\"></a>";
                    break;
            }
        }

        echo "</div>";
    }
?>

</body>
</html>
