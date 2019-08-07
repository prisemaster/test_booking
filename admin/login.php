<?
// Страница авторизации

// Функция для генерации случайной строки
function generateCode($length = 6)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}

// Соединямся с БД
$link = mysqli_connect("localhost", "mysql", "mysql", "booking_db");
$error = '';
if (isset($_POST['submit'])) {
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link, "SELECT user_id, user_password FROM users WHERE user_login='" . mysqli_real_escape_string($link, $_POST['login']) . "' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Сравниваем пароли
    if ($data['user_password'] === md5(md5($_POST['password']))) {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        $insip = ", user_ip=INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "')";

        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='" . $hash . "' " . $insip . " WHERE user_id='" . $data['user_id'] . "'");

        // Ставим куки
        setcookie("id", $data['user_id'], time() + 60 * 60 * 24 * 30);
        setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, null, null, null, true); // httponly !!!

        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: index.php");
        exit();
    } else {
        $error =  "Вы ввели неправильный логин/пароль";
    }
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
    <section class="booking_main booking_main--admin">
        <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="177" height="75" viewBox="0 0 177 75">
            <g fill="#FFF" fill-rule="nonzero">
                <path d="M175.941 51.014a26.24 26.24 0 0 1-5.513 5.732 3.14 3.14 0 0 1-2.372.735c-.532-.076-1.19-.312-.794-1.41l5.26-14.952a18.202 18.202 0 0 0-3.065-1.055 20.423 20.423 0 0 0-5.015-.557 15.273 15.273 0 0 0-6.256 1.275 16.404 16.404 0 0 0-4.972 3.377c-1.4 1.37-2.52 2.999-3.301 4.795a14.285 14.285 0 0 0-1.073 3.774 23.833 23.833 0 0 1-4.466 3.563l.473-1.326c1.537-4.373 3.681-10.443 4.863-13.812a18.21 18.21 0 0 0-3.082-1.055 20.355 20.355 0 0 0-5.006-.557 15.197 15.197 0 0 0-6.256 1.274 16.438 16.438 0 0 0-4.981 3.377 15.281 15.281 0 0 0-3.293 4.796 13.71 13.71 0 0 0-1.14 4.466 14.141 14.141 0 0 1-9.041 3.715c-2.255.059-4.804-.71-4.922-3.377-.17-3.53 2.144-5.556 3.495-6.56a8.274 8.274 0 0 1 4.272-1.46c.515-.06 2.38-.195 2.66-.195.843 0 2.042-2.862 1.4-2.752-.641.11-1.097.22-1.739.304-.705.098-1.415.154-2.127.168a2.837 2.837 0 0 1-2.795-1.477 6.062 6.062 0 0 1 .136-4.306 7.227 7.227 0 0 1 3.377-4.001 6.965 6.965 0 0 1 6.18-.136 6.045 6.045 0 0 1 2.127 3.048 4.019 4.019 0 0 0 1.73-.751c.595-.405.947-1.08.938-1.798a2.296 2.296 0 0 0-.549-1.343 5.006 5.006 0 0 0-1.579-1.266 10.756 10.756 0 0 0-2.456-.895 12.664 12.664 0 0 0-3.15-.372 18.363 18.363 0 0 0-4.786.608c-1.413.364-2.758.951-3.985 1.74a9.152 9.152 0 0 0-2.744 2.777 6.805 6.805 0 0 0-1.022 3.698c-.048 1.525.55 3 1.647 4.06a17.73 17.73 0 0 0-3.951 1.883 12.664 12.664 0 0 0-2.736 2.466 10.215 10.215 0 0 0-1.722 2.93 8.662 8.662 0 0 0-.608 3.123c-.03 1.084.28 2.15.886 3.048a7.142 7.142 0 0 0 2.271 2.102c.942.566 1.968.976 3.04 1.216 1.034.247 2.094.377 3.157.388 2.301.105 4.6-.26 6.754-1.072a24.602 24.602 0 0 0 5.91-3.554c.076.4.19.793.338 1.173a5.783 5.783 0 0 0 1.165 1.798 5.403 5.403 0 0 0 1.764 1.216c.71.3 1.475.449 2.246.439 1.374 0 2.706-.47 3.774-1.334a17.518 17.518 0 0 0 3.048-3.073s-.456 1.891-1.427 4.618c-2.811 1.292-4.973 2.11-5.142 2.187a30.976 30.976 0 0 0-3.225 1.604c-1.494.844-5.513 3.14-5.513 6.754a3.63 3.63 0 0 0 2.255 3.453c.7.318 1.442.534 2.203.641.5.07 1.006.106 1.511.11 1.636.02 3.253-.356 4.711-1.097a13.06 13.06 0 0 0 3.723-2.964 20.262 20.262 0 0 0 2.913-4.288 42.112 42.112 0 0 0 2.187-5.15l.439-1.275c.152-.43.287-.752.464-1.283a28.46 28.46 0 0 0 5.294-3.952 5.53 5.53 0 0 0 .396 1.596c.267.668.66 1.279 1.157 1.798.504.52 1.107.933 1.773 1.216.71.3 1.475.45 2.246.439a6.003 6.003 0 0 0 3.816-1.334 17.814 17.814 0 0 0 3.047-3.073 4.424 4.424 0 0 0 .27 2.136 4.162 4.162 0 0 0 4.045 2.296c2.46-.03 4.83-.926 6.695-2.532a16.927 16.927 0 0 0 2.38-2.347 25.404 25.404 0 0 0 1.824-2.381 1.46 1.46 0 0 0-.456-1.79zm-39.942 11.608a53.535 53.535 0 0 1-.912 2.069c-.844 1.832-1.578 3.377-2.296 4.567-.718 1.19-2.22 3.496-4.128 3.538a2.845 2.845 0 0 1-1.022-.16c-1.342-.516-1.342-2.179-1.317-2.449a4.272 4.272 0 0 1 1.317-2.778 13.956 13.956 0 0 1 4.221-2.92c1.689-.845 3.31-1.512 4.163-1.875l-.026.008zm3.656-10.907c-.996 1.688-3.782 5.065-6.003 5.158-.61.08-1.215-.18-1.579-.675-.776-1.258-.405-4.12.769-6.543 2.136-4.399 4.61-6.087 6.365-7.041a10.258 10.258 0 0 1 4.348-1.098l-3.9 10.199zm22.795 0c-.996 1.688-3.79 5.065-6.003 5.158-.61.08-1.215-.18-1.579-.675-.785-1.258-.413-4.12.769-6.543 2.136-4.399 4.6-6.087 6.365-7.041a10.258 10.258 0 0 1 4.348-1.098l-3.9 10.199zM80.258 27.887H75.11V56.21h-2.575a2.569 2.569 0 0 1-2.566-2.422h-.008v-25.9h-5.148v24.384c0 4.253 3.458 7.7 7.722 7.7h7.723V27.888M37.128 54.856h5.148v5.125h-5.148zM26.831 54.856V27.904h-5.148V59.99h11.584v-5.134H26.83M13.286 27.904L9.606 46.79 5.923 27.904H.775L7.03 59.99h5.15l6.255-32.086h-5.149M61.588 37.765v-2.16c0-4.253-3.458-7.7-7.723-7.7h-7.722V59.99h5.148V45.504h2.574a2.569 2.569 0 0 1 2.567 2.422h.007V59.99h5.149V49.442a7.672 7.672 0 0 0-2.69-5.839 7.672 7.672 0 0 0 2.69-5.838zm-5.68 2.925a2.56 2.56 0 0 1-2.043 1.013h-2.574V31.667h2.574a2.56 2.56 0 0 1 2.11 1.106c.594.828.989 2.27.989 3.915 0 1.705-.425 3.191-1.056 4.002zM114.065.058a32.052 32.052 0 0 0-17.218 4.991 32.281 32.281 0 0 0-7.764 6.895 25.144 25.144 0 0 0-9.092-4.26 25.33 25.33 0 0 0-8.471-.593 25.1 25.1 0 0 1 8.47 2.384 25.283 25.283 0 0 1 10.08 8.804 31.996 31.996 0 0 1 2.062-3.656 32.265 32.265 0 0 1 9.035-9.136 32.024 32.024 0 0 1 15.4-5.334 32.781 32.781 0 0 0-2.502-.095" />
            </g>
        </svg>
        <div class="login_screen">
            <h2 class="login_screen__title">Авторизация</h2>
            <form method="POST">
                <label for="login" class="input_frame">
                    <input type="text" id="login" name="login" placeholder="&nbsp;" required>
                    <span class="label">Логин</span>
                    <span class="border"></span>
                </label>
                <label for="password" class="input_frame">
                    <input type="password" id="password" name="password" placeholder="&nbsp;" required>
                    <span class="label">Пароль</span>
                    <span class="border"></span>
                </label>
                <p class="error_message"><? echo $error; ?></p>
                <input name="submit" type="submit" value="Войти" class="login_submit">
            </form>
        </div>
    </section>


    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>