<!DOCTYPE html>
<html>

<head>
    <title>jQuery UI Sortable - Example</title>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- TODO: Lägg till styles -->
    <style>
        .default {
            border: 1px solid gray;
        }

        .items .ui-selected {
            background: red;
            color: white;
            font-weight: bold;
        }

        .items {
            list-style-type: none;
            margin-left: 10px;
            padding: 0;
            width: 100px;
            float: left;
        }

        .items li {
            margin: 2px;
            padding: 2px;
            cursor: pointer;
            border-radius: 3px;
        }

        .b {
            background-color: lightblue;
        }

        .g {
            background-color: lightgreen;
        }

        .o {
            background-color: orange;
        }

        .highlight {
            border: 2px solid red;
            font-weight: bold;
        }
    </style>

    <!-- TODO: lägg till JQuery för att connecta de olika listorna 
   och för att posta id och state till "/api/update_tasks.php" -->
    <script>
         $(function() {
            $("#todo,#doing,#done").sortable({
                connectWith: "#todo,#doing,#done",
                receive: function(event, ui) {
                    //console.log($(event.target).attr("id"));
                    console.log($(event.target).attr('class'));
                    let id = $(ui.item).attr("id");
                    let state = $(event.target).attr("id");
                    $.post("/api/update_tasks.php", {
                        id: id,
                        state: state
                    });
                   location.reload();
                }
            });
            $(".b").tooltip();
            $(".g").tooltip();
            $(".o").tooltip();
        });
    </script>
</head>

<?php
require("includes/conn_mysql.php");
require("includes/tasks_functions.php");

$connection = dbConnect();
$allTodos = getAllTodos($connection);
$allDoing = getAllDoing($connection);
$allDone = getAllDone($connection);

dbDisconnect($connection);
?>

<body>
    <ul id="todo" class="items">
        <h3>Todo-list</h3>
        <?php
        foreach ($allTodos as $item) {
            print('<li class="default b" title = "Drag me!"');
            print('id="');
            print($item['id'] . '">');
            print($item['name']);
            print('</li>');
        }
        ?>
    </ul>
    <ul id="doing" class="items">
        <h3>Doing-list</h3>
        <?php
        foreach ($allDoing as $item) {
            print('<li class="default g" title = "Drag me too."');
            print('id="');
            print($item['id'] . '">');
            print($item['name']);
            print('</li>');
        }
        ?>
    </ul>
    <ul id="done" class="items">
        <h3>Done-list</h3>
        <?php
        foreach ($allDone as $item) {
            print('<li class="default o" title = "Congrats!"');
            print('id="');
            print($item['id'] . '">');
            print($item['name']);
            print('</li>');
        }
        ?>
    </ul>

</body>

</html>

