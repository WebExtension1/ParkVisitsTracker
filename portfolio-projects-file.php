<?php include_once("includes/setup.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robert Jenner | Projects</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Condensed">
    <style>body { font-family: 'Barlow Condensed', sans-serif; }</style>
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/mobile.css" />
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/desktop.css" media="only screen and (min-width : 790px)"/>
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/portfolio.css" defer>
</head>
<body>
    <p><a href="<?php echo $directoryString; ?>portfolio" style="position: absolute; color: white; text-decoration: none; margin-left: 20px; margin-top: -20px;"><-- Home --</a></p>
    <h1 style="display:flex; justify-content: center; color: white; font-size: 60px;">Projects</h1>
    <?php
    $json = file_get_contents("data/portfolio.json");
    $json_data = json_decode($json, true);
    $projects = $json_data['projects'];
    $keys = array_column($projects, 'priority');
    array_multisort($keys, SORT_ASC, $projects);

    function description($project) {
        echo "<p style='color: white; font-size: 20px; margin-top: 50px;'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta quasi praesentium quo! Ipsum distinctio consequatur aliquid exercitationem optio libero soluta quidem consectetur repellendus. Quis quam sit sed enim magni consequuntur harum eos nostrum molestias, cum suscipit officia quaerat. Porro vel maiores nostrum corrupti ab facere rerum nobis voluptate nihil libero?</p>";
    }

    function image($project, $directoryString) {
        echo "<img class='enlarge2' style='color: white; border: solid 2px white; margin: 50px;' src='" . $directoryString . "images/" . $project['image'] . "' alt='" . $project['image'] . "'>";
    }

    foreach ($projects as $project) {
        echo "<div class='project'><p style='color: white; font-size: 60px; margin: 10px 0px 5px 20px'>" . $project['name'] . "</p><div class='content' style='display: flex; flex-direction: row;'>";
        if ($project['priority'] % 2 == 0) {
            description($project);
            image($project, $directoryString);
        }
        else {
            image($project, $directoryString);
            description($project);
        }
        echo "</div></div>";
    }
    ?>
</body>
</html>