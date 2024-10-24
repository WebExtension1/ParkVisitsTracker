<?php include_once("includes/setup.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robert Jenner</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Condensed">
    <style>body { font-family: 'Barlow Condensed', sans-serif; }</style>
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/mobile.css"/>
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/desktop.css" media="only screen and (min-width : 790px)"/>
    <link rel="stylesheet" href="<?php echo $directoryString; ?>css/portfolio.css" defer>
</head>
<body>
    <?php include_once("includes/header.php"); ?>
    <a href="data/Robert Jenner CV.doc" style="position: absolute; right: 160px; top: 75px; color: white; border: solid 2px white; padding: 10px; text-decoration: none;" download>Download CV</a>
    <a href="https://github.com/WebExtension1" style="position: absolute; right: 75px; top: 75px; color: white; border: solid 2px white; padding: 10px; text-decoration: none;" target="_blank">GitHub</a>
    <div style="display: flex; flex-direction: row; gap: 10vw">
        <div>
            <h1 style="margin: calc(50vh - 90px) 0px 5px 45px; color: white; font-size: 50px;" class="slide1 enlarge1">Robert Jenner</h1>
            <h3 style="margin: 5px 0px 0px 65px; color: white; font-size: 29px; font-weight: normal;" class="slide2 enlarge1">19 year-old Software Engineer</h3>
            <h5 style="margin: 7px 0px 0px 85px; color: white; font-size: 19px; font-weight: normal;" class="slide3 enlarge1">Studying Software Engineering at Sheffield Hallam University</h5>
        </div>
        <div>
            <h1 style="margin: calc(50vh - 160px) 0px 5px 75px; font-size: 80px;" class="slide3 enlarge1"><a href="<?php echo $directoryString; ?>portfolio/projects" style="color:lightgray;">Projects</a></h1>
            <h1 style="margin: 5px 0px 5px 135px; font-size: 80px;" class="slide4 enlarge1"><a href="<?php echo $directoryString; ?>portfolio/contact" style="color:lightgray;">Contact</a></h1>
            <h1 style="margin: 5px 0px 5px 215px; font-size: 80px;" class="slide5 enlarge1"><a href="<?php echo $directoryString; ?>portfolio/about" style="color:lightgray;">About Me</a></h1>
        </div>
    </div>
</body>
</html>