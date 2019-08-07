<?
    $link = mysqli_connect("localhost", "mysql", "mysql", "booking_db");

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '" . intval($_COOKIE['id']) . "' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if (($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
            or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0"))
        ) {
            setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
            setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
            print "Хм, что-то не получилось";
        } else {
            //Login succesful
        }
    } else {
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html>

<head lang="ru">
    <meta charset="UTF-8">
    <title>Бронирование столов</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/css/jquery.timepicker.min.css">
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>


    <section class="admin_screen">
        <div class="admin_upper_bar">
            <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="177" height="75" viewBox="0 0 177 75">
                <g fill="#FFF" fill-rule="nonzero">
                    <path d="M175.941 51.014a26.24 26.24 0 0 1-5.513 5.732 3.14 3.14 0 0 1-2.372.735c-.532-.076-1.19-.312-.794-1.41l5.26-14.952a18.202 18.202 0 0 0-3.065-1.055 20.423 20.423 0 0 0-5.015-.557 15.273 15.273 0 0 0-6.256 1.275 16.404 16.404 0 0 0-4.972 3.377c-1.4 1.37-2.52 2.999-3.301 4.795a14.285 14.285 0 0 0-1.073 3.774 23.833 23.833 0 0 1-4.466 3.563l.473-1.326c1.537-4.373 3.681-10.443 4.863-13.812a18.21 18.21 0 0 0-3.082-1.055 20.355 20.355 0 0 0-5.006-.557 15.197 15.197 0 0 0-6.256 1.274 16.438 16.438 0 0 0-4.981 3.377 15.281 15.281 0 0 0-3.293 4.796 13.71 13.71 0 0 0-1.14 4.466 14.141 14.141 0 0 1-9.041 3.715c-2.255.059-4.804-.71-4.922-3.377-.17-3.53 2.144-5.556 3.495-6.56a8.274 8.274 0 0 1 4.272-1.46c.515-.06 2.38-.195 2.66-.195.843 0 2.042-2.862 1.4-2.752-.641.11-1.097.22-1.739.304-.705.098-1.415.154-2.127.168a2.837 2.837 0 0 1-2.795-1.477 6.062 6.062 0 0 1 .136-4.306 7.227 7.227 0 0 1 3.377-4.001 6.965 6.965 0 0 1 6.18-.136 6.045 6.045 0 0 1 2.127 3.048 4.019 4.019 0 0 0 1.73-.751c.595-.405.947-1.08.938-1.798a2.296 2.296 0 0 0-.549-1.343 5.006 5.006 0 0 0-1.579-1.266 10.756 10.756 0 0 0-2.456-.895 12.664 12.664 0 0 0-3.15-.372 18.363 18.363 0 0 0-4.786.608c-1.413.364-2.758.951-3.985 1.74a9.152 9.152 0 0 0-2.744 2.777 6.805 6.805 0 0 0-1.022 3.698c-.048 1.525.55 3 1.647 4.06a17.73 17.73 0 0 0-3.951 1.883 12.664 12.664 0 0 0-2.736 2.466 10.215 10.215 0 0 0-1.722 2.93 8.662 8.662 0 0 0-.608 3.123c-.03 1.084.28 2.15.886 3.048a7.142 7.142 0 0 0 2.271 2.102c.942.566 1.968.976 3.04 1.216 1.034.247 2.094.377 3.157.388 2.301.105 4.6-.26 6.754-1.072a24.602 24.602 0 0 0 5.91-3.554c.076.4.19.793.338 1.173a5.783 5.783 0 0 0 1.165 1.798 5.403 5.403 0 0 0 1.764 1.216c.71.3 1.475.449 2.246.439 1.374 0 2.706-.47 3.774-1.334a17.518 17.518 0 0 0 3.048-3.073s-.456 1.891-1.427 4.618c-2.811 1.292-4.973 2.11-5.142 2.187a30.976 30.976 0 0 0-3.225 1.604c-1.494.844-5.513 3.14-5.513 6.754a3.63 3.63 0 0 0 2.255 3.453c.7.318 1.442.534 2.203.641.5.07 1.006.106 1.511.11 1.636.02 3.253-.356 4.711-1.097a13.06 13.06 0 0 0 3.723-2.964 20.262 20.262 0 0 0 2.913-4.288 42.112 42.112 0 0 0 2.187-5.15l.439-1.275c.152-.43.287-.752.464-1.283a28.46 28.46 0 0 0 5.294-3.952 5.53 5.53 0 0 0 .396 1.596c.267.668.66 1.279 1.157 1.798.504.52 1.107.933 1.773 1.216.71.3 1.475.45 2.246.439a6.003 6.003 0 0 0 3.816-1.334 17.814 17.814 0 0 0 3.047-3.073 4.424 4.424 0 0 0 .27 2.136 4.162 4.162 0 0 0 4.045 2.296c2.46-.03 4.83-.926 6.695-2.532a16.927 16.927 0 0 0 2.38-2.347 25.404 25.404 0 0 0 1.824-2.381 1.46 1.46 0 0 0-.456-1.79zm-39.942 11.608a53.535 53.535 0 0 1-.912 2.069c-.844 1.832-1.578 3.377-2.296 4.567-.718 1.19-2.22 3.496-4.128 3.538a2.845 2.845 0 0 1-1.022-.16c-1.342-.516-1.342-2.179-1.317-2.449a4.272 4.272 0 0 1 1.317-2.778 13.956 13.956 0 0 1 4.221-2.92c1.689-.845 3.31-1.512 4.163-1.875l-.026.008zm3.656-10.907c-.996 1.688-3.782 5.065-6.003 5.158-.61.08-1.215-.18-1.579-.675-.776-1.258-.405-4.12.769-6.543 2.136-4.399 4.61-6.087 6.365-7.041a10.258 10.258 0 0 1 4.348-1.098l-3.9 10.199zm22.795 0c-.996 1.688-3.79 5.065-6.003 5.158-.61.08-1.215-.18-1.579-.675-.785-1.258-.413-4.12.769-6.543 2.136-4.399 4.6-6.087 6.365-7.041a10.258 10.258 0 0 1 4.348-1.098l-3.9 10.199zM80.258 27.887H75.11V56.21h-2.575a2.569 2.569 0 0 1-2.566-2.422h-.008v-25.9h-5.148v24.384c0 4.253 3.458 7.7 7.722 7.7h7.723V27.888M37.128 54.856h5.148v5.125h-5.148zM26.831 54.856V27.904h-5.148V59.99h11.584v-5.134H26.83M13.286 27.904L9.606 46.79 5.923 27.904H.775L7.03 59.99h5.15l6.255-32.086h-5.149M61.588 37.765v-2.16c0-4.253-3.458-7.7-7.723-7.7h-7.722V59.99h5.148V45.504h2.574a2.569 2.569 0 0 1 2.567 2.422h.007V59.99h5.149V49.442a7.672 7.672 0 0 0-2.69-5.839 7.672 7.672 0 0 0 2.69-5.838zm-5.68 2.925a2.56 2.56 0 0 1-2.043 1.013h-2.574V31.667h2.574a2.56 2.56 0 0 1 2.11 1.106c.594.828.989 2.27.989 3.915 0 1.705-.425 3.191-1.056 4.002zM114.065.058a32.052 32.052 0 0 0-17.218 4.991 32.281 32.281 0 0 0-7.764 6.895 25.144 25.144 0 0 0-9.092-4.26 25.33 25.33 0 0 0-8.471-.593 25.1 25.1 0 0 1 8.47 2.384 25.283 25.283 0 0 1 10.08 8.804 31.996 31.996 0 0 1 2.062-3.656 32.265 32.265 0 0 1 9.035-9.136 32.024 32.024 0 0 1 15.4-5.334 32.781 32.781 0 0 0-2.502-.095" />
                </g>
            </svg>
            <a href="logout.php" class="admin_logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                    <g fill="#FFF" fill-rule="nonzero">
                        <path d="M6.054 18.97v1.19l-.16 4.89-.32 11.12c-.17 8-.32 17-.43 26.7l-.15 15.1v1.94a8.33 8.33 0 0 0 .08 1.37 6.67 6.67 0 0 0 .42 1.52 6.81 6.81 0 0 0 1.81 2.57 6.65 6.65 0 0 0 1.31.91l1 .48 7.16 3.56 14.66 7.25.93.46.46.23.8.33a6.37 6.37 0 0 0 3.58.15 6.54 6.54 0 0 0 3.02-1.77 6.42 6.42 0 0 0 1.67-3.18 4.88 4.88 0 0 0 .12-.89v-8.02-.38a93.38 93.38 0 0 0 15.52 1.07H58.964a6.23 6.23 0 0 0 5.25-3.47 6 6 0 0 0 .59-2 4.06 4.06 0 0 0 0-.52v-1.04l-.15-2.31a42.43 42.43 0 0 0-1-7.22 2.83 2.83 0 0 0-1.47-.21c-.7 0-1.25.1-1.28.21a42.43 42.43 0 0 0-1 7.22l-.15 2.31v.6a.48.48 0 0 1 0 .16.26.26 0 0 1 0 .08.9.9 0 0 1-.14.3 1.08 1.08 0 0 1-.62.29 1 1 0 0 1-.3.05h-1.16a93.37 93.37 0 0 0-15.54 1.12c0-21-.13-41.78-.36-60.12v-2.91a90.12 90.12 0 0 0 15.9 1.12h1.12a1.05 1.05 0 0 1 .31.05 1.08 1.08 0 0 1 .51.39.9.9 0 0 1 .15.3.28.28 0 0 1 0 .09.49.49 0 0 1 0 .16v.6l.15 2.31a42.16 42.16 0 0 0 1.05 7.22 2.78 2.78 0 0 0 1.44.2c.68 0 1.21-.09 1.24-.2a42.15 42.15 0 0 0 1.05-7.22l.15-2.31v-.6-.44a4.11 4.11 0 0 0 0-.52 6 6 0 0 0-.59-2 6.23 6.23 0 0 0-5.12-3.51H57.564a89.69 89.69 0 0 0-15.97 1.11l-.11-7.89v-.56a4.06 4.06 0 0 0-.08-.65 6 6 0 0 0-.41-1.22 5.83 5.83 0 0 0-6.27-3.39 5.37 5.37 0 0 0-1.18.34l-.55.22-.35.18-1.38.71-2.68 1.37c-7.08 3.66-13.21 6.9-18.07 9.54a1.362 1.362 0 0 0 1.17 2.46c5.07-2.22 11.38-5.09 18.62-8.44l2.76-1.28 1.41-.66.36-.17c.12-.06.13 0 .2-.08a1.28 1.28 0 0 1 .34-.08 1.57 1.57 0 0 1 1.26.43 1.46 1.46 0 0 1 .38.56 1.7 1.7 0 0 1 .08.32.58.58 0 0 1 0 .17 2.29 2.29 0 0 1 0 .28l-.2 14c-.24 19.43-.35 41.65-.36 63.87v7.64a.32.32 0 0 1 0 .14.93.93 0 0 1-.7.72.89.89 0 0 1-.51 0l-.15-.06-.47-.23-.93-.45-14.72-7.17-7.21-3.51-.82-.4a1.46 1.46 0 0 1-.32-.21 1.62 1.62 0 0 1-.45-.61 1.51 1.51 0 0 1-.11-.36 3 3 0 0 1 0-.57v-1.94l-.15-15.01c-.11-9.71-.26-18.73-.43-26.7l-.31-11.13-.16-4.9v-1.1a2.8 2.8 0 0 1 .74-2 1.76 1.76 0 0 0 .09-1.84 1.27 1.27 0 0 0-2-.13 5.59 5.59 0 0 0-1.58 2.4 5.7 5.7 0 0 0-.29 1.5z" />
                        <path d="M30.124 54.44c1.85-1.91 1.83-7.68 0-9.59a9.3 9.3 0 0 0-1.44-.06 7.62 7.62 0 0 0-1.24.06c-1.87 1.91-1.88 7.68 0 9.59a9.48 9.48 0 0 0 1.47.06 7.87 7.87 0 0 0 1.21-.06zM94.194 51.59l.06-.06a2.72 2.72 0 0 0-.09-3.85c-7.06-6.75-13.93-13.23-20-18.87l-.07-.07a2.37 2.37 0 0 0-4 1.79c.07 3.77.14 6.85.23 9.64-7.52.24-12.71.74-16.44 1.06-.44 0-.34.51.23 1a3.43 3.43 0 0 0 1.6.9c4.23.35 9.43.92 16.77 1.13a2 2 0 0 0 2.09-2v-.13c.06-1.86.12-3.83.17-6 4.25 4.32 8.85 8.84 13.61 13.5-4.46 4.28-8.95 8.63-13.36 12.89V56.97a2.46 2.46 0 0 0-2.5-2.42c-5.95.12-11.5.25-16.5.42-.23-4.13-.64-7.83-1-11a3.73 3.73 0 0 0-1-1.82c-.49-.47-.89-.5-.94-.09-.36 3.69-.87 8.87-1.05 15a2 2 0 0 0 1.93 2.05h.06c4.79.16 10.16.3 15.91.4l-.12 9.22a2.64 2.64 0 0 0 4.46 2c6.52-6.16 13.35-12.76 19.93-19.12z" />
                    </g>
                </svg>
            </a>


        </div>
        <div class="admin_lower_part">
            <div class="admin_left_bar">
                <button class="admin_menu_button" data-src="schedule">
                    <svg xmlns="http://www.w3.org/2000/svg" id="svg3835" width="100" height="100" viewBox="0 0 100 100">
                        <g id="g3865" transform="translate(-.53 1.943)">
                            <path id="path3817" d="M92.33 12.857v33.8c-2.6-2.5-5.8-4.5-9.2-5.8v-21.3h-8.2v3.5c0 .2-.1.3-.3.3h-8.2c-.2 0-.3-.1-.3-.3v-3.5h-34.3v3.5c0 .2-.1.3-.3.3h-8.2c-.2 0-.3-.1-.3-.3v-3.5h-8.9v48.2h29.7c0 3.1.5 6.1 1.4 8.9H7.73c-1.2 0-2.2-1-2.2-2.2v-61.5c0-1.3 1-2.2 2.2-2.2h15.1v-5c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v5h34.2v-5c0-.2.1-.3.3-.3h8.4c.2 0 .3.1.3.3v5h15.2c1.3-.1 2.3.9 2.3 2.1z" class="st0" fill="#262626" />
                            <path id="path3819" d="M74.93 32.557v6.4c-.7-.1-1.5-.1-2.3-.1-2.3 0-4.5.3-6.6.7v-7.1c0-.2.1-.3.3-.3h8.2c.3 0 .4.2.4.4z" class="st0" fill="#262626" />
                            <path id="path3821" d="M31.43 58.857h-8.2c-.2 0-.3-.1-.3-.3v-8.2c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v8.2c.1.2-.1.3-.3.3z" class="st0" fill="#262626" />
                            <path id="path3823" d="M31.43 41.057h-8.2c-.2 0-.3-.1-.3-.3v-8.2c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v8.2c.1.2-.1.3-.3.3z" class="st0" fill="#262626" />
                            <path id="path3825" d="M49.93 49.957c-2 2.6-3.7 5.6-4.7 8.9h-.3c-.2 0-.3-.1-.3-.3v-8.2c0-.2.1-.3.3-.3h5z" class="st0" fill="#262626" />
                            <path id="path3827" d="M52.93 41.057h-8.2c-.2 0-.3-.1-.3-.3v-8.2c0-.2.1-.3.3-.3h8.2c.2 0 .3.1.3.3v8.2c.1.2 0 .3-.3.3z" class="st0" fill="#262626" />
                            <path id="path3829" d="M95.53 67.757c0 12.7-10.3 22.9-22.9 22.9-12.6 0-22.9-10.3-22.9-22.9 0-12.6 10.3-22.9 22.9-22.9 12.6 0 22.9 10.3 22.9 22.9zm-14.2 6.7l-7.4-7.5v-10.5c0-1-.9-1.9-1.9-1.9-.5 0-1 .2-1.3.6-.4.3-.6.8-.6 1.3v11.2c0 .3 0 .5.1.7.1.3.2.6.4.8l7.9 8c.4.4.8.6 1.3.6s1-.2 1.3-.6c.3-.4.6-.9.6-1.3.1-.6-.1-1-.4-1.4z" class="st0" fill="#262626" />
                        </g>
                    </svg>Расписание
                </button>
                <button class="admin_menu_button" data-src="booking">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <path d="M93.012 20.417v61.141c0 2.37-1.704 4.266-3.833 4.266H58.66c-.568 2.528-2.697 4.582-5.252 4.582H46.45c-2.555 0-4.684-1.896-5.252-4.582H10.82c-2.13 0-3.833-1.896-3.833-4.266V20.417c0-2.37 1.704-4.266 3.833-4.266h2.555v61.931h73.39V16.151h2.555c1.987 0 3.69 1.896 3.69 4.266zM16.925 71.13V17.099c0-1.422.852-2.686 1.987-3.002 10.079-3.318 21.01-3.476 31.088-.316a40.797 40.797 0 0 1 5.962-1.422v40.603c0 2.528 1.845 4.582 4.117 4.582.993 0 1.987-.474 2.697-1.264l2.271-2.37 2.271 2.37c.71.79 1.704 1.106 2.697 1.106 2.272 0 4.117-2.054 4.117-4.582V12.36c2.13.474 4.4.948 6.388 1.58l.284.158c1.277.316 1.987 1.58 1.987 3.002V71.13a3.44 3.44 0 0 1-1.135 2.528 2.53 2.53 0 0 1-2.556.474h-.142a45.879 45.879 0 0 0-28.39 0h-.142-.142c-.142 0-.284 0-.568.158h-.142-.142-.142c-.142 0-.284 0-.426-.158h-.284a45.879 45.879 0 0 0-28.39 0h-.142c-.284.158-.568.158-.852.158-.568 0-1.136-.158-1.703-.632-.142-.632-.568-1.58-.568-2.528zm9.51-44.395c.285.79.852 1.264 1.562 1.264.142 0 .426 0 .568-.158 4.117-1.58 8.517-1.58 12.634 0 .852.316 1.845-.158 2.13-1.264.283-.948-.143-2.054-1.136-2.37-4.827-1.895-9.937-1.895-14.764 0-.851.474-1.277 1.58-.993 2.528zm0 8.374c.285.79.852 1.264 1.562 1.264.142 0 .426 0 .568-.158 4.117-1.58 8.517-1.58 12.634 0 .852.315 1.845-.158 2.13-1.264.283-.948-.143-2.054-1.136-2.37-4.827-1.896-9.937-1.896-14.764 0-.851.474-1.277 1.58-.993 2.528zm0 8.373c.285.79.852 1.264 1.562 1.264.142 0 .426 0 .568-.158 4.117-1.58 8.517-1.58 12.634 0 .852.316 1.845-.158 2.13-1.264.283-.948-.143-2.054-1.136-2.37-4.827-1.896-9.937-1.896-14.764 0-.851.474-1.277 1.58-.993 2.528zm0 8.373c.285.79.852 1.264 1.562 1.264.142 0 .426 0 .568-.158 4.117-1.58 8.517-1.58 12.634 0 .852.316 1.845-.158 2.13-1.264.283-.948-.143-2.053-1.136-2.37-4.827-1.895-9.937-1.895-14.764 0-.851.475-1.277 1.58-.993 2.528zm0 8.374c.285.79.852 1.264 1.562 1.264.142 0 .426 0 .568-.158 4.117-1.58 8.517-1.58 12.634 0 .852.316 1.845-.158 2.13-1.264.283-.948-.143-2.054-1.136-2.37-4.827-1.896-9.937-1.896-14.764 0-.851.474-1.277 1.422-.993 2.528zM70.442 9.83a58.316 58.316 0 0 0-10.504 0c-.284 0-.568.316-.568.632v42.5c0 .631.71 1.105 1.136.631l4.116-4.107c.284-.316.71-.316.994 0l4.117 4.107c.425.474 1.135.158 1.135-.632V10.463c0-.316-.142-.632-.426-.632z" />
                    </svg>Бронь
                </button>
                <button class="admin_menu_button" data-src="tables">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <path d="M96.685 36.412L83.377 11.628a5.678 5.678 0 0 0-5.003-2.992h-56.75a5.68 5.68 0 0 0-5.002 2.992L3.312 36.416a3.422 3.422 0 0 0-.394 1.919l.245 2.838A2.328 2.328 0 0 0 5.482 43.3H94.52a2.328 2.328 0 0 0 2.319-2.127l.245-2.84a3.457 3.457 0 0 0-.4-1.921zM17.372 88.835c.092 1.419 1.478 2.53 3.157 2.53h1.769c1.746 0 3.162-1.198 3.162-2.677V45.38H13.677zM31.463 57.27c.074 1.137 1.184 2.026 2.529 2.026h1.417c1.399 0 2.533-.96 2.533-2.144V45.38h-7.49zM62.369 57.153c0 1.184 1.134 2.144 2.533 2.144h1.417c1.345 0 2.455-.89 2.529-2.026l1.01-11.89h-7.49zM74.538 88.688c0 1.477 1.416 2.676 3.162 2.676h1.769c1.679 0 3.065-1.11 3.157-2.53l3.696-43.453H74.538z" />
                    </svg>Столики
                </button>
            </div>
            <div class="admin_operative">
                <div data-src="schedule" class="admin_menu_screen admin_menu_screen--schedule active">
                    <h2 class="admin_title">Расписание</h2>
                    <div class="block_wrapper">
                        <div class="schedule_block">
                            <div class="modal modal--schedule">
                                <div class="modal__bg"></div>
                                <div class="modal__window">
                                    <button class="close_modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                                            <switch transform="translate(-.05)">
                                                <g>
                                                    <path d="M62.9 50l31.9-31.9c3.6-3.6 3.6-9.3 0-12.9-3.6-3.6-9.3-3.6-12.9 0L50 37.1 18.1 5.2c-3.6-3.6-9.3-3.6-12.9 0-3.6 3.6-3.6 9.3 0 12.9L37.1 50 5.2 81.9c-3.6 3.6-3.6 9.3 0 12.9 1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7L50 62.9l31.9 31.9c1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7 3.6-3.6 3.6-9.3 0-12.9z" />
                                                </g>
                                            </switch>
                                        </svg>
                                    </button>
                                    <h2 class="week_day"></h2>
                                    <div class="week_day__time_wrapper">
                                        <input value="" id="datepick_start" type="text" name="time_start" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--start">
                                        <input value="" id="datepick_end" type="text" name="time_end" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--end">
                                    </div>
                                    <input type="text" id="week_day_id" hidden>
                                    <button class="week_day__submit">Сохранить</button>
                                </div>
                            </div>
                            <ul class="schedule_list">
                            </ul>
                        </div>
                        <div class="special_block">
                            <h3>Уникальные даты</h3>
                            <ul class="special_list">
                            </ul>
                            <button class="special_add">Добавить новую дату</button>
                        </div>
                        <div class="empty_block"></div>
                    </div>
                </div>
                <div data-src="booking" class="admin_menu_screen admin_menu_screen--booking">
                    <h2 class="admin_title">Бронь столиков</h2>
                    <div class="tables_block">
                        <select name="tables" id="sel_table">
                        </select>
                        <div class="table_name_row">
                            <p class="table_row booking_row--number">Номер столика</p>
                            <p class="table_row booking_row--name">Имя</p>
                            <p class="table_row booking_row--phone">Телефон</p>
                            <p class="table_row booking_row--day">День</p>
                            <p class="table_row booking_row--start">Начало брони</p>
                            <p class="table_row booking_row--end">Конец брони</p>
                            <p class="table_row booking_row--delete">Удалить</p>
                        </div>
                        <ul class="table_list_booking">
                        </ul>
                    </div>
                </div>
                <div data-src="tables" class="admin_menu_screen admin_menu_screen--tables">
                    <h2 class="admin_title">Столики</h2>
                    <div class="tables_block">
                        <div class="table_name_row">
                            <p class="table_row table_row--number">Номер столика</p>
                            <p class="table_row table_row--type">Тип столика</p>
                            <p class="table_row table_row--change">Изменить</p>
                            <p class="table_row table_row--delete">Удалить</p>
                        </div>
                        <ul class="table_list">
                        </ul>
                        <button class="add_table">Добавить новый столик</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="modal modal--add_special">
        <div class="modal__bg"></div>
        <div class="modal__window">
            <button class="close_modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                    <switch transform="translate(-.05)">
                        <g>
                            <path d="M62.9 50l31.9-31.9c3.6-3.6 3.6-9.3 0-12.9-3.6-3.6-9.3-3.6-12.9 0L50 37.1 18.1 5.2c-3.6-3.6-9.3-3.6-12.9 0-3.6 3.6-3.6 9.3 0 12.9L37.1 50 5.2 81.9c-3.6 3.6-3.6 9.3 0 12.9 1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7L50 62.9l31.9 31.9c1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7 3.6-3.6 3.6-9.3 0-12.9z" />
                        </g>
                    </switch>
                </svg>
            </button>
            <h2 class="modal_title">Новая дата</h2>
            <input placeholder="День" id="special_day" type="text" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--day">
            <div class="checkbox_wrapper">
                <input id="is_weekend" type="checkbox"><span class="check_span">Выходной</span>
            </div>
            <div class="week_day__time_wrapper special_time_block">
                <input placeholder="Начало" value="" id="special_start" type="text" name="time_start" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--start">
                <input placeholder="Конец" value="" id="special_end" type="text" name="time_end" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--end">
            </div>
            <input type="text" id="special_id" hidden>
            <button class="special__submit">Сохранить</button>
        </div>
    </div>

    <div class="modal modal--change_special">
        <div class="modal__bg"></div>
        <div class="modal__window">
            <button class="close_modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                    <switch transform="translate(-.05)">
                        <g>
                            <path d="M62.9 50l31.9-31.9c3.6-3.6 3.6-9.3 0-12.9-3.6-3.6-9.3-3.6-12.9 0L50 37.1 18.1 5.2c-3.6-3.6-9.3-3.6-12.9 0-3.6 3.6-3.6 9.3 0 12.9L37.1 50 5.2 81.9c-3.6 3.6-3.6 9.3 0 12.9 1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7L50 62.9l31.9 31.9c1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7 3.6-3.6 3.6-9.3 0-12.9z" />
                        </g>
                    </switch>
                </svg>
            </button>
            <h2 class="modal_title">Изменить дату</h2>
            <input placeholder="День" id="special_day_change" type="text" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--day">
            <div class="checkbox_wrapper">
                <input id="is_weekend_change" type="checkbox"><span class="check_span">Выходной</span>
            </div>
            <div class="week_day__time_wrapper special_time_block">
                <input placeholder="Начало" value="" id="special_start_change" type="text" name="time_start" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--start">
                <input placeholder="Конец" value="" id="special_end_change" type="text" name="time_end" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--end">
            </div>
            <input type="text" id="special_id" hidden>
            <button class="special__change" data-id="">Сохранить</button>
        </div>
    </div>

    <div class="modal modal--add_table">
        <div class="modal__bg"></div>
        <div class="modal__window">
            <div class="modal_wrapper_hor">
                <button class="close_modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <switch transform="translate(-.05)">
                            <g>
                                <path d="M62.9 50l31.9-31.9c3.6-3.6 3.6-9.3 0-12.9-3.6-3.6-9.3-3.6-12.9 0L50 37.1 18.1 5.2c-3.6-3.6-9.3-3.6-12.9 0-3.6 3.6-3.6 9.3 0 12.9L37.1 50 5.2 81.9c-3.6 3.6-3.6 9.3 0 12.9 1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7L50 62.9l31.9 31.9c1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7 3.6-3.6 3.6-9.3 0-12.9z" />
                            </g>
                        </switch>
                    </svg>
                </button>
                <h2 class="modal_title">Новый столик</h2>
                <input type="number" min="1" step="1" placeholder="Номер столика" id="table_number_add" type="text" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--day">
                <select name="table" id="table_type_add" class="booking_select">
                    <option value="" hidden disabled selected>Выберите стол</option>
                    <option value="1">Маленький (2)</option>
                    <option value="2">Средний (4)</option>
                    <option value="3">Большой (8)</option>
                    <option value="4">Пати-тайм (16)</option>
                </select>
                <input type="text" id="table_id_add" hidden>
                <br>
                <button class="table__add" data-id="">Сохранить</button>
            </div>
            <p class="error_table"></p>
        </div>
    </div>

    <div class="modal modal--edit_table">
        <div class="modal__bg"></div>
        <div class="modal__window">
            <div class="modal_wrapper_hor">
                <button class="close_modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <switch transform="translate(-.05)">
                            <g>
                                <path d="M62.9 50l31.9-31.9c3.6-3.6 3.6-9.3 0-12.9-3.6-3.6-9.3-3.6-12.9 0L50 37.1 18.1 5.2c-3.6-3.6-9.3-3.6-12.9 0-3.6 3.6-3.6 9.3 0 12.9L37.1 50 5.2 81.9c-3.6 3.6-3.6 9.3 0 12.9 1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7L50 62.9l31.9 31.9c1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7 3.6-3.6 3.6-9.3 0-12.9z" />
                            </g>
                        </switch>
                    </svg>
                </button>
                <h2 class="modal_title">Изменить столик</h2>
                <input type="number" min="1" step="1" placeholder="Номер столика" id="table_number_edit" type="text" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--day">
                <select name="table" id="table_type_edit" class="booking_select">
                    <option value="" hidden disabled selected>Выберите стол</option>
                    <option value="1">Маленький (2)</option>
                    <option value="2">Средний (4)</option>
                    <option value="3">Большой (8)</option>
                    <option value="4">Пати-тайм (16)</option>
                </select>
                <input type="text" id="table_id_edit" hidden>
                <br>
                <button class="table__edit" data-id="">Сохранить</button>
            </div>
            <p class="error_table"></p>
        </div>
    </div>

    <div class="modal modal--warning_del">
            <div class="modal__bg"></div>
            <div class="modal__window">
                <div class="modal_wrapper_hor">
                    <button class="close_modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                            <switch transform="translate(-.05)">
                                <g>
                                    <path d="M62.9 50l31.9-31.9c3.6-3.6 3.6-9.3 0-12.9-3.6-3.6-9.3-3.6-12.9 0L50 37.1 18.1 5.2c-3.6-3.6-9.3-3.6-12.9 0-3.6 3.6-3.6 9.3 0 12.9L37.1 50 5.2 81.9c-3.6 3.6-3.6 9.3 0 12.9 1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7L50 62.9l31.9 31.9c1.8 1.8 4.1 2.7 6.5 2.7 2.4 0 4.7-.9 6.5-2.7 3.6-3.6 3.6-9.3 0-12.9z" />
                                </g>
                            </switch>
                        </svg>
                    </button>
                    <h2 class="modal_title">Внимание</h2>
                    <div class="warning_block">
                        <p>При удалении столика также будут удалены все оставленные на него заказы!<br>Вы уверены что хотите удалить этот столик?</p>
                    </div>
                    <div class="warning_check">
                        <button class="warning_ok_del" data-id="">Да</button>
                        <button class="warning_ok_del_cancel" data-id="">Нет</button>
                    </div>  
                </div>
                <p class="error_table"></p>
            </div>
        </div>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/jquery.timepicker.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/moment.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>