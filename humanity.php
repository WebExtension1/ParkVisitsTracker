<?php
include_once("includes/setup.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards Against Humanity</title>
    <link rel="stylesheet" href="css/mobile.css" />
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width : 790px)"/>
</head>
<body>
    <?php
    include_once("includes/header.php");
    $packs = $mysqli->query("SELECT * FROM Packs");
    while ($pack = $packs->fetch_object()) {
        echo "<h1>$pack->packName</h1>";
        $prompts = $mysqli->query("SELECT count(Cards.cardID) as prompts FROM Cards, Packs, CardInPack WHERE Cards.cardID = CardInPack.cardID AND CardInPack.packID = $pack->packID AND cards.prompt = 1");
        $promptsAmount = $prompts->fetch_object();
        echo "<p>Prompts: $promptsAmount->prompts</p>";
        $prompts = $mysqli->query("SELECT count(Cards.cardID) as prompts FROM Cards, Packs, CardInPack WHERE Cards.cardID = CardInPack.cardID AND CardInPack.packID = $pack->packID AND cards.prompt = 0");
        $promptsAmount = $prompts->fetch_object();
        echo "<p>Responses: $promptsAmount->prompts</p>";
    }
    ?>
</body>
</html>