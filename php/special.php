<?php

    $link = mysqli_connect("localhost", "root", "", "booking_db");

    if (isset($_GET['function'])) {
        if ($_GET['function'] == 'getSpecial') {
            getSpecial($link);
        } elseif ($_GET['function'] == 'setSpecial') {
            setSpecial($link, $_GET['date'], $_GET['start'], $_GET['end'], $_GET['is_weekend']);
        } elseif ($_GET['function'] == 'delSpecial') {
            delSpecial($link, $_GET['id']);
        } elseif ($_GET['function'] == 'pickSpecial') {
            pickSpecial($link, $_GET['id']);
        } elseif ($_GET['function'] == 'editSpecial') {
            editSpecial($link, $_GET['id'], $_GET['date'], $_GET['start'], $_GET['end'], $_GET['is_weekend']);
        }
    }

    function getSpecial($link) {
        $query = mysqli_query($link, "SELECT * FROM special");
        
        while ($inst = $query->fetch_assoc()) {
            $rows[] = $inst;
        }

        mysqli_free_result($query);

        echo json_encode($rows);
    }

    function setSpecial($link, $date, $start, $end, $is_weekend) {
        if ($is_weekend == 'true') {
            $start = '0';
            $end = '0';
            $is_weekend = 1;
        } else {
            $is_weekend = 0;
        }
        $query = mysqli_query($link, "INSERT INTO `special` (`special_id`, `special_date`, `special_start`, `special_end`, `is_weekend`) VALUES (NULL, '" . $date . "', '" . $start . "', '" . $end . "', '" .$is_weekend . "')");
    }

    function delSpecial($link, $id) {
        $query = mysqli_query($link, "DELETE FROM `special` WHERE `special`.`special_id` = '" . $id . "'");
    }

    function pickSpecial($link, $id) {
        $query = mysqli_query($link, "SELECT * FROM special WHERE special_id ='" . $id . "'");
        $inst = mysqli_fetch_assoc($query);
        mysqli_free_result($query);


        echo json_encode($inst);
    }

    function editSpecial($link, $id, $date, $start, $end, $is_weekend) {
        if ($is_weekend == 'true') {
            $start = '0';
            $end = '0';
            $is_weekend = 1;
        } else {
            $is_weekend = 0;
        }
        $query = mysqli_query($link, "UPDATE `special` SET special_date='" . $date . "', special_start='" . $start . "', special_end='" . $end . "', is_weekend='" . $is_weekend . "' WHERE special_id='" . $id . "'");  
    }

?>