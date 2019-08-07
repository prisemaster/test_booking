<?php

    $link = mysqli_connect("localhost", "root", "", "booking_db");

    if (isset($_GET['function'])) {
        if ($_GET['function'] == 'fillTables') {
            fillTables($link);
        } elseif ($_GET['function'] == 'delTable') {
            delTable($link, $_GET['id']);
        } elseif ($_GET['function'] == 'addTable') {
            addTable($link, $_GET['table_number'], $_GET['table_type']);
        } elseif ($_GET['function'] == 'getTable') {
            getTable($link, $_GET['table_id']);
        } elseif ($_GET['function'] == 'editTable') {
            editTable($link, $_GET['table_id'], $_GET['table_number'], $_GET['table_type']);
        }
    }

    function fillTables($link) {
        $query = mysqli_query($link, "SELECT * FROM tables INNER JOIN table_type ON tables.table_type_id=table_type.table_type_id ORDER BY tables.table_number");
        while ($inst = $query->fetch_assoc()) {
            $rows[] = $inst;
        }
        mysqli_free_result($query);
        echo json_encode($rows);
    }

    function delTable($link, $table_id) {
        $query = mysqli_query($link, "DELETE FROM `tables` WHERE `tables`.`table_id` = '" . $table_id . "'");
        $query = mysqli_query($link, "DELETE FROM `pre_booking` WHERE table_id = '" . $table_id . "'");
    }

    function addTable($link, $table_number, $table_type) {
        $query = mysqli_query($link, "INSERT INTO `tables` (`table_id`, `table_number`, `table_type_id`) VALUES (NULL, '" . $table_number . "', '" . $table_type . "')");
        echo json_encode(array('error'=> mysqli_error($link)));
    }

    function getTable($link, $id) {
        $query = mysqli_query($link, "SELECT * FROM tables WHERE table_id ='" . $id . "'");
        $inst = mysqli_fetch_assoc($query);
        mysqli_free_result($query);
        echo json_encode($inst);
    }

    function editTable($link, $id, $table_number, $table_type) {
        $query = mysqli_query($link, "UPDATE `tables` SET table_number='" . $table_number . "', table_type_id='" . $table_type . "' WHERE table_id='" . $id . "'"); 
       
    }
?>