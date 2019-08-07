<?php

    $link = mysqli_connect("localhost", "root", "", "booking_db");

    if (isset($_GET['function'])) {
        if ($_GET['function'] == 'getBooking') {
            getBooking($link, $_GET['table_id']);
        } elseif ($_GET['function'] == 'delBooking') {
            delBooking($link, $_GET['booking_id']);
        } elseif ($_GET['function'] == 'getWeekends') {
            getWeekends($link);
        }
    }

    function getBooking($link, $table_id) {
        $query = mysqli_query($link, "SELECT *, ADDTIME(pre_booking.time, pre_booking.duration) AS end FROM pre_booking INNER JOIN tables ON pre_booking.table_id=tables.table_id WHERE pre_booking.table_id='" . $table_id . "' AND day >= NOW() ORDER BY day, time");
        while ($inst = $query->fetch_assoc()) {
            $rows[] = $inst;
        }
        mysqli_free_result($query);
        echo json_encode($rows);
    }

    function delBooking($link, $booking_id) {
        $query = mysqli_query($link, "DELETE FROM pre_booking WHERE booking_id = '" . $booking_id . "'");
    }

    function getWeekends($link) {
        $query = mysqli_query($link, "SELECT special_date FROM special WHERE is_weekend=1");
        while ($inst = $query->fetch_assoc()) {
            $rows[] = $inst;
        }
        mysqli_free_result($query);
        echo json_encode($rows);
    }
?>