<?php

    $link = mysqli_connect("localhost", "root", "", "booking_db");

    $result = 0;
    
    //Время работы и проверка брони на расписание
    $query = mysqli_query($link, "SELECT special_start AS start, special_end AS end FROM special WHERE special_date = '" . $_POST['days'] . "'");
    if ($query->num_rows == 0) {
        $week =date("N", strtotime($_POST['days']));
        $query = mysqli_query($link, "SELECT schedule_start AS start, schedule_end AS end FROM schedule WHERE schedule_week_id = '" . $week . "'");
        $inst = mysqli_fetch_assoc($query);
    } else {
        $inst = mysqli_fetch_assoc($query);
    }

    $work_start = new DateTime();
    $work_start->setTimestamp(strtotime($_POST['days'] . ' ' . $inst['start']));

    $work_end = new DateTime();
    $work_end->setTimestamp(strtotime($_POST['days'] . ' ' . $inst['end']));
    if ($work_end<=$work_start) {
        $work_end->modify('+1 day');
    }

    $book_start = new DateTime();
    $book_start->setTimestamp(strtotime($_POST['days'] . ' ' . $_POST['time']));
    
    $book_end = new DateTime();
    $book_end->setTimestamp(strtotime($_POST['days'] . ' ' . SumTime($_POST['time'],$_POST['duration'])));
    if (($book_end->format('H') >= 0)&&($book_end->format('H')<=6)) {
        $book_end->modify('+1 day');
    }

    // Проверка на время работы
    if (!(($book_start >= $work_start)&&($book_end <= $work_end))) {
        $result = 1;
        $is_day =  new DateTime($_POST['days']);
        echo json_encode(array('error'=> 2, 'start'=>$work_start->format('H:i'), 'end'=>$work_end->format('H:i'), 'day'=>$is_day->format('d.m.Y')));
    } else {
        $query = mysqli_query($link, "SELECT time, duration FROM pre_booking WHERE day='" . $_POST['days'] . "' AND table_id='" . $_POST['table'] . "'");
        if ($query->num_rows > 0) { 
            while ($inst = $query->fetch_assoc()) {
                $busy_start = new DateTime();
                $busy_start->setTimestamp(strtotime($_POST['days'] . ' ' . $inst['time']));
                
                $busy_end = new DateTime();
                $busy_end->setTimestamp(strtotime($_POST['days'] . ' ' . SumTime($inst['time'],$inst['duration'])));
                
                //die(print_r($busy_start->format('Y-m-d H:i:s') . ' ' . $busy_end->format('Y-m-d H:i:s') . '  X  ' . $book_start->format('Y-m-d H:i:s') . ' ' . $book_end->format('Y-m-d H:i:s')));

                if (($busy_end->format('H') >= 0)&&($busy_end->format('H')<=6)) {
                    $busy_end->modify('+1 day');
                }
    
                if (($busy_start <= $book_end)&&($busy_end >= $book_start)) {
                    $result = 1;
                    $books = array();
                    $is_day =  new DateTime($_POST['days']);
                    $query = mysqli_query($link, "SELECT time, duration FROM pre_booking WHERE day='" . $_POST['days'] . "' AND table_id='" . $_POST['table'] . "'");
                    while ($inst = $query->fetch_assoc()) {
                        array_push($books,(object)['start'=>$inst['time'],'end'=>SumTime($inst['time'],$inst['duration'])]);
                    }
                    echo json_encode(array('error'=> 3, 'booking'=>$books, 'day'=>$is_day->format('d.m.Y'), 'table'=>$_POST['table']));   
                    break;
                }
            }
        }
    }


    if ($result == 0) {
        $query = mysqli_query($link, "INSERT INTO `pre_booking`(`booking_id`, `name`, `phone`, `table_id`, `duration`, `time`, `day`) VALUES (NULL,'" . $_POST['name'] . "','" . $_POST['phone'] . "','" . $_POST['table'] . "','" . $_POST['duration'] . "','" . $_POST['time'] . "','" . $_POST['days'] . "')");
        echo json_encode(array('error'=> mysqli_error($link)));
    }
    
    mysqli_close($link); 

    function SumTime($start, $add) {
        $minutes = 0;
        $times = array();
        $times[] = $start;
        $times[] = $add;

        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        
        $minutes -= $hours * 60;
        if ($hours>=24) {
            $hours = $hours - 24;
        }
        return sprintf('%02d:%02d', $hours, $minutes);
    }
?>