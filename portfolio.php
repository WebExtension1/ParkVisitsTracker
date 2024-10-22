<?php include_once("includes/setup.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/mobile.css" />
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/desktop.css" media="only screen and (min-width : 790px)"/>
</head>
<body>
<?php include_once("includes/header.php"); ?>
    <h1 id="site-name">Portfolio</h1>
    <?php
    $json = file_get_contents("data/portfolio.json");
    $json_data = json_decode($json, true);

    $num = 0;
    foreach ($json_data as $firstLine) {
        if ($num == 0) {
            echo "<p>" . var_dump($firstLine) . "</p>";
        }
        foreach ($firstLine as $secondLine) {
            if ($num == 0) {
                echo "<p>" . var_dump($secondLine) . "</p>";
            }
            foreach ($secondLine as $thirdLine) {
                if ($num == 0) {
                    echo "<p>" . var_dump($thirdLine) . "</p>";
                }
                $num++;
            }
        }
    }

    echo $json_data[0];
    ?>
</body>
</html>