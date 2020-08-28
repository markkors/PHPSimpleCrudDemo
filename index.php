<?php

require_once ("includes/database.php");
require_once ("includes/functions.php");

$getaction = null;
$postaction = null;
$userid = null;

// alle GET actions
if(isset($_GET['action'])) {
    $getaction = $_GET['action'];
    switch ($getaction) {
        case 'delete':
            // record wissen
            $id = $_GET['id'];
            deleteUser($id);
            break;
        case 'update':
            $userid = $_GET['id'];
        default:
            // ff niks
    }

}


// alle POST actions
if(isset($_POST['action'])) {
    $postaction = $_POST['action'];
    switch ($postaction) {
        case 'add':
            echo "database backend add user";
            $first = htmlspecialchars($_POST['first']);
            $middle = htmlspecialchars($_POST['middle']);
            $last = htmlspecialchars($_POST['last']);

            addUser($first,$middle,$last);
        case "update":
            echo "database backend updated user";
            $first = htmlspecialchars($_POST['first']);
            $middle = htmlspecialchars($_POST['middle']);
            $last = htmlspecialchars($_POST['last']);
            $id = htmlspecialchars($_POST['id']);

            updateUser($id, $first,$middle,$last);

        default:
            // ff niks
    }
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crud demo</title>
    <link href="css/fontawesome/css/all.css" rel="stylesheet"/>
</head>

<style>
    .table {
        display: table;
        width: 100%;

    }

    .row {
        display: table-row;

    }

    .cell {
        display: table-cell;
        border: 1px solid black;
        padding: 1%;
    }

    .cell:nth-child(1),.cell:nth-child(2) {
        width: 5%;
    }

</style>
<body>
    <?=getUsersHTML()?>

    <a href="index.php?action=add"><i class="fas fa-user-plus"></i></a>

    <?=showUserAddHTML($getaction)?>
    <?=showUserEditHTML($getaction,$userid)?>


</body>
</html>






