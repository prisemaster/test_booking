<?php

    $link = mysqli_connect("localhost", "root", "", "booking_db");

    if (isset($_GET['function'])) {
        if ($_GET['function'] == 'getSchedule') {
            getSchedule($link);
        } elseif ($_GET['function'] == 'getWeekDay') {
            getWeekDay($link,$_GET['week']);
        } elseif ($_GET['function'] == 'setWeekDay') {
            setWeekDay($link,$_GET['week'],$_GET['start'],$_GET['end']);
        } elseif ($_GET['function'] == 'getSpecial') {
            getSpecial($link);
        }
    }

    function getSchedule($link) {
        $query = mysqli_query($link, "SELECT * FROM schedule");
        
        while ($inst = $query->fetch_assoc()) {
            $rows[] = $inst;
        }

        mysqli_free_result($query);

        echo json_encode($rows);
    }

    function getWeekDay($link,$week) {

        $query = mysqli_query($link, "SELECT * FROM schedule WHERE schedule_week_id = " . $week . "");
        $inst = mysqli_fetch_assoc($query);
        
        mysqli_free_result($query);
        $time_start = strtotime($inst['schedule_start']);
        $time_start = date("H:i", $time_start);
        $time_end = strtotime($inst['schedule_end']);
        $time_end = date("H:i", $time_end);

        echo json_encode(array('id' => $inst['schedule_week_id'], 'week_day' => $inst['schedule_week_name'], 'time_start' => $time_start, 'time_end' => $time_end));
    }

    function setWeekDay($link,$week,$start,$end) {
        $query = mysqli_query($link, "UPDATE schedule SET schedule_start='" . $start . "', schedule_end='" . $end . "' WHERE schedule_week_id=" . $week . "");
    }
?>