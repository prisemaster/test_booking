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
    <section class="booking_main">
        <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="177" height="75" viewBox="0 0 177 75">
            <g fill="#FFF" fill-rule="nonzero">
                <path d="M175.941 51.014a26.24 26.24 0 0 1-5.513 5.732 3.14 3.14 0 0 1-2.372.735c-.532-.076-1.19-.312-.794-1.41l5.26-14.952a18.202 18.202 0 0 0-3.065-1.055 20.423 20.423 0 0 0-5.015-.557 15.273 15.273 0 0 0-6.256 1.275 16.404 16.404 0 0 0-4.972 3.377c-1.4 1.37-2.52 2.999-3.301 4.795a14.285 14.285 0 0 0-1.073 3.774 23.833 23.833 0 0 1-4.466 3.563l.473-1.326c1.537-4.373 3.681-10.443 4.863-13.812a18.21 18.21 0 0 0-3.082-1.055 20.355 20.355 0 0 0-5.006-.557 15.197 15.197 0 0 0-6.256 1.274 16.438 16.438 0 0 0-4.981 3.377 15.281 15.281 0 0 0-3.293 4.796 13.71 13.71 0 0 0-1.14 4.466 14.141 14.141 0 0 1-9.041 3.715c-2.255.059-4.804-.71-4.922-3.377-.17-3.53 2.144-5.556 3.495-6.56a8.274 8.274 0 0 1 4.272-1.46c.515-.06 2.38-.195 2.66-.195.843 0 2.042-2.862 1.4-2.752-.641.11-1.097.22-1.739.304-.705.098-1.415.154-2.127.168a2.837 2.837 0 0 1-2.795-1.477 6.062 6.062 0 0 1 .136-4.306 7.227 7.227 0 0 1 3.377-4.001 6.965 6.965 0 0 1 6.18-.136 6.045 6.045 0 0 1 2.127 3.048 4.019 4.019 0 0 0 1.73-.751c.595-.405.947-1.08.938-1.798a2.296 2.296 0 0 0-.549-1.343 5.006 5.006 0 0 0-1.579-1.266 10.756 10.756 0 0 0-2.456-.895 12.664 12.664 0 0 0-3.15-.372 18.363 18.363 0 0 0-4.786.608c-1.413.364-2.758.951-3.985 1.74a9.152 9.152 0 0 0-2.744 2.777 6.805 6.805 0 0 0-1.022 3.698c-.048 1.525.55 3 1.647 4.06a17.73 17.73 0 0 0-3.951 1.883 12.664 12.664 0 0 0-2.736 2.466 10.215 10.215 0 0 0-1.722 2.93 8.662 8.662 0 0 0-.608 3.123c-.03 1.084.28 2.15.886 3.048a7.142 7.142 0 0 0 2.271 2.102c.942.566 1.968.976 3.04 1.216 1.034.247 2.094.377 3.157.388 2.301.105 4.6-.26 6.754-1.072a24.602 24.602 0 0 0 5.91-3.554c.076.4.19.793.338 1.173a5.783 5.783 0 0 0 1.165 1.798 5.403 5.403 0 0 0 1.764 1.216c.71.3 1.475.449 2.246.439 1.374 0 2.706-.47 3.774-1.334a17.518 17.518 0 0 0 3.048-3.073s-.456 1.891-1.427 4.618c-2.811 1.292-4.973 2.11-5.142 2.187a30.976 30.976 0 0 0-3.225 1.604c-1.494.844-5.513 3.14-5.513 6.754a3.63 3.63 0 0 0 2.255 3.453c.7.318 1.442.534 2.203.641.5.07 1.006.106 1.511.11 1.636.02 3.253-.356 4.711-1.097a13.06 13.06 0 0 0 3.723-2.964 20.262 20.262 0 0 0 2.913-4.288 42.112 42.112 0 0 0 2.187-5.15l.439-1.275c.152-.43.287-.752.464-1.283a28.46 28.46 0 0 0 5.294-3.952 5.53 5.53 0 0 0 .396 1.596c.267.668.66 1.279 1.157 1.798.504.52 1.107.933 1.773 1.216.71.3 1.475.45 2.246.439a6.003 6.003 0 0 0 3.816-1.334 17.814 17.814 0 0 0 3.047-3.073 4.424 4.424 0 0 0 .27 2.136 4.162 4.162 0 0 0 4.045 2.296c2.46-.03 4.83-.926 6.695-2.532a16.927 16.927 0 0 0 2.38-2.347 25.404 25.404 0 0 0 1.824-2.381 1.46 1.46 0 0 0-.456-1.79zm-39.942 11.608a53.535 53.535 0 0 1-.912 2.069c-.844 1.832-1.578 3.377-2.296 4.567-.718 1.19-2.22 3.496-4.128 3.538a2.845 2.845 0 0 1-1.022-.16c-1.342-.516-1.342-2.179-1.317-2.449a4.272 4.272 0 0 1 1.317-2.778 13.956 13.956 0 0 1 4.221-2.92c1.689-.845 3.31-1.512 4.163-1.875l-.026.008zm3.656-10.907c-.996 1.688-3.782 5.065-6.003 5.158-.61.08-1.215-.18-1.579-.675-.776-1.258-.405-4.12.769-6.543 2.136-4.399 4.61-6.087 6.365-7.041a10.258 10.258 0 0 1 4.348-1.098l-3.9 10.199zm22.795 0c-.996 1.688-3.79 5.065-6.003 5.158-.61.08-1.215-.18-1.579-.675-.785-1.258-.413-4.12.769-6.543 2.136-4.399 4.6-6.087 6.365-7.041a10.258 10.258 0 0 1 4.348-1.098l-3.9 10.199zM80.258 27.887H75.11V56.21h-2.575a2.569 2.569 0 0 1-2.566-2.422h-.008v-25.9h-5.148v24.384c0 4.253 3.458 7.7 7.722 7.7h7.723V27.888M37.128 54.856h5.148v5.125h-5.148zM26.831 54.856V27.904h-5.148V59.99h11.584v-5.134H26.83M13.286 27.904L9.606 46.79 5.923 27.904H.775L7.03 59.99h5.15l6.255-32.086h-5.149M61.588 37.765v-2.16c0-4.253-3.458-7.7-7.723-7.7h-7.722V59.99h5.148V45.504h2.574a2.569 2.569 0 0 1 2.567 2.422h.007V59.99h5.149V49.442a7.672 7.672 0 0 0-2.69-5.839 7.672 7.672 0 0 0 2.69-5.838zm-5.68 2.925a2.56 2.56 0 0 1-2.043 1.013h-2.574V31.667h2.574a2.56 2.56 0 0 1 2.11 1.106c.594.828.989 2.27.989 3.915 0 1.705-.425 3.191-1.056 4.002zM114.065.058a32.052 32.052 0 0 0-17.218 4.991 32.281 32.281 0 0 0-7.764 6.895 25.144 25.144 0 0 0-9.092-4.26 25.33 25.33 0 0 0-8.471-.593 25.1 25.1 0 0 1 8.47 2.384 25.283 25.283 0 0 1 10.08 8.804 31.996 31.996 0 0 1 2.062-3.656 32.265 32.265 0 0 1 9.035-9.136 32.024 32.024 0 0 1 15.4-5.334 32.781 32.781 0 0 0-2.502-.095" />
            </g>
        </svg>
        <div class="booking_block">
            <h1 class="booking_main__title">Бронирование стола</h1>
            <form action="" class="booking_main__form">
                <h2 class="booking_main__form_article">Контакты</h2>
                <div class="booking_main__form_input_block booking_main__form_input_block--vertical">
                    <label for="name" class="input_frame">
                        <input type="text" id="name" name="name" placeholder="&nbsp;">
                        <span class="label">Имя</span>
                        <span class="border"></span>
                    </label>
                    <label for="phone" class="input_frame">
                        <input type="text" id="phone" name="phone" placeholder="&nbsp;">
                        <span class="label">Телефон</span>
                        <span class="border"></span>
                    </label>
                </div>
                <h2 class="booking_main__form_article">Стол</h2>
                <div class="booking_main__form_input_block booking_main__form_input_block--horizontal">
                    <select name="table" id="table" class="booking_select">
                        <option value="" hidden disabled selected>Выберите стол</option>
                        <option value="1">Маленький (2)</option>
                        <option value="2">Средний (4)</option>
                        <option value="3">Большой (8)</option>
                        <option value="4">Пати-тайм (16)</option>
                    </select>
                    <select name="duration" id="duration" class="booking_select">
                        <option value="" hidden disabled selected>Длительность</option>
                        <option value="1:00">1 ч</option>
                        <option value="1:30">1,5 ч</option>
                        <option value="2:00">2 ч</option>
                        <option value="2:30">2,5 ч</option>
                    </select>
                </div>
                <h2 class="booking_main__form_article">Время брони</h2>
                <div class="booking_main__form_input_block booking_main__form_input_block--horizontal">
                    <input placeholder="День" id="datepick_day" type="text" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--day">
                    <input placeholder="Время" id="datepick_time" type="text" name="time" class="datepick ui-selectmenu-button ui-button ui-widget ui-selectmenu-button-closed ui-corner-all datepick--time">
                </div>
                <input hidden id="in_day" type="text" name="days">
                <button type="submit" class="submit">
                    <p>Забронировать</p>
                </button>
            </form>
            <div class="booking_main__success">
                <svg xmlns="http://www.w3.org/2000/svg" width="122" height="140"><g fill="none"><path fill="#F072AE" d="M71.076 79.124l-.127.082h.21l-.083-.082z"/><path fill="#FFB655" d="M61.848 137.95l13.35-56.667a7.769 7.769 0 0 1-4.167-2.127h-.082a22.694 22.694 0 0 1-12.413 3.673c-4.455 0-8.61-1.277-12.121-3.485l13.69 58.605h1.743z"/><path fill="#F072AE" d="M107.104 33.676c.227-.829.35-1.701.35-2.602 0-5.442-4.411-9.853-9.853-9.853-.516 0-1.023.04-1.518.117C92.257 10.12 81.629 2.051 69.115 2.051c-12.256 0-22.704 7.74-26.722 18.6a11.353 11.353 0 0 0-5.696-1.525c-6.302 0-11.41 5.109-11.41 11.41l.001.054C12.43 31.415 2.257 42.103 2.257 55.17c0 11.18 7.45 20.621 17.656 23.63a21.246 21.246 0 0 0-1.142 6.893c0 11.75 9.525 21.275 21.275 21.275a21.17 21.17 0 0 0 11.327-3.263c.333.523.695 1.026 1.084 1.505l-6.042-25.866a22.696 22.696 0 0 0 12.12 3.485c4.58 0 8.842-1.35 12.415-3.673l.05-.032.032.032a7.77 7.77 0 0 0 4.166 2.127l-6.947 29.488c6.496-1.396 11.527-6.74 12.456-13.398a13.664 13.664 0 0 0 6.933 1.877c7.58 0 13.726-6.146 13.726-13.727 0-2.229-.531-4.334-1.474-6.195 11.292-2.244 19.804-12.207 19.804-24.159 0-9.23-5.078-17.274-12.592-21.493z"/><path fill="#F072AE" d="M71.076 79.124l-.127.082h.21l-.083-.082zm8.204 0l-.127.082h.21l-.084-.082z"/><path d="M66.739 82.83c2.94 0 5.748-.557 8.328-1.57a7.772 7.772 0 0 1-4.036-2.104h-.082a22.67 22.67 0 0 1-8.312 3.305 22.91 22.91 0 0 0 4.102.368zm-11.358-.217a22.662 22.662 0 0 1-8.966-3.27l13.69 58.606h1.743l3.244-13.769-9.71-41.567z" fill="#FF7956"/><path d="M44.9 19.126c2.075 0 4.02.557 5.696 1.525 3.562-9.625 12.175-16.8 22.621-18.307a28.736 28.736 0 0 0-4.101-.293c-11.74 0-21.82 7.102-26.18 17.244a11.459 11.459 0 0 1 1.964-.169zm44.01 78.247a15.96 15.96 0 0 1-.37 1.848 13.68 13.68 0 0 0 3.201-.594 13.645 13.645 0 0 1-2.83-1.254zM54.618 79.344l.763 3.269a22.988 22.988 0 0 0 7.255-.152 22.67 22.67 0 0 1-8.018-3.117zm28.783 1.939a7.769 7.769 0 0 1-4.166-2.127l-.033-.032-.05.032a22.76 22.76 0 0 1-4.084 2.104l.13.023-6.947 29.488a15.996 15.996 0 0 0 9.727-6.467L83.4 81.283zm-56.426 4.41c0-2.413.401-4.731 1.141-6.893C17.91 75.791 10.46 66.35 10.46 55.17c0-13.067 10.173-23.755 23.031-24.58l-.001-.054c0-4.854 3.032-9 7.305-10.65a11.357 11.357 0 0 0-4.098-.76c-6.302 0-11.41 5.108-11.41 11.41l.001.053C12.43 31.415 2.257 42.103 2.257 55.17c0 11.181 7.45 20.622 17.656 23.63a21.246 21.246 0 0 0-1.142 6.894c0 11.75 9.525 21.274 21.275 21.274a21.38 21.38 0 0 0 4.102-.395c-9.788-1.911-17.173-10.533-17.173-20.88z" fill="#FF3F62"/><path fill="#000" d="M76.051 48.959h4.102v4.102h-4.102zm-6.836 0h4.102v4.102h-4.102zm-6.836 0h4.102v4.102h-4.102zm20.508 0h4.102v4.102h-4.102zm.013 32.105l-2.674-3.11a5.734 5.734 0 0 1-3.736 1.384 5.7 5.7 0 0 1-4.045-1.669l-1.178-1.17-1.39.908a20.67 20.67 0 0 1-11.341 3.371c-6.636 0-12.927-3.216-16.83-8.603l-3.32 2.406a24.883 24.883 0 0 0 6.215 6.013L58.478 140h4.994l13.326-56.565a9.838 9.838 0 0 0 6.101-2.371zm-21.919 51.62L49.41 83.15a24.834 24.834 0 0 0 8.743 1.728h.025l.142.002h.216c4.332 0 8.545-1.116 12.277-3.24.608.432 1.26.79 1.942 1.07l-11.774 49.975z"/><path fill="#000" d="M55.633 76.557l.803-4.023a12.457 12.457 0 0 1-3.311-1.164l-1.891 3.64a16.563 16.563 0 0 0 4.4 1.547zm3.278-3.78h-.14l-.041 4.101h.181c1.506 0 3-.2 4.439-.597l-1.09-3.954c-1.084.299-2.211.45-3.349.45zM45.39 69.969a16.789 16.789 0 0 0 3.228 3.355L51.15 70.1a12.688 12.688 0 0 1-2.44-2.537l-3.322 2.407z"/><path d="M98.124 70.434l.8 4.023a19.505 19.505 0 0 0 10.172-5.514l-2.931-2.87a15.418 15.418 0 0 1-8.04 4.361zm9.593-6.212l3.336 2.387a19.779 19.779 0 0 0 2.21-3.996l-3.794-1.557a15.638 15.638 0 0 1-1.752 3.166zm7.013-9.052h-4.101c0 1.21-.142 2.417-.42 3.59l3.99.95c.352-1.484.532-3.011.532-4.54z" fill="#FFF"/><path fill="#000" d="M11.324 55.17H7.223c0 8.781 5.896 16.569 14.339 18.937l5.468 1.534 1.108-3.948-5.468-1.534c-6.68-1.875-11.346-8.039-11.346-14.99z"/><path d="M89.4 29.836l3.882-1.324-1.9-5.571a23.403 23.403 0 0 0-8.28-11.32l-2.437 3.3a19.317 19.317 0 0 1 6.835 9.343l1.9 5.572zM69.115 7.017v4.101c1.239 0 2.48.119 3.69.352l.777-4.027a23.627 23.627 0 0 0-4.467-.426zm7.365 1.179l-1.283 3.896c1.172.386 2.313.887 3.391 1.49l2-3.582a23.573 23.573 0 0 0-4.108-1.804zM60.539 111.045l4.04.709-.709 4.04-4.04-.709zm1.181-6.735l4.04.71-.708 4.04-4.04-.709zm2.936-16.747l4.04.708-2.465 14.055-4.04-.709z" fill="#FFF"/><path fill="#000" d="M32.764 44.27c0 5.088 1.898 9.951 5.345 13.692l3.016-2.78a16.062 16.062 0 0 1-4.26-10.913c0-8.883 7.228-16.111 16.112-16.111 3.88 0 7.628 1.399 10.555 3.938L66.22 29a20.205 20.205 0 0 0-13.243-4.943c-11.146 0-20.213 9.068-20.213 20.213z"/><path fill="#000" d="M121.747 55.17a26.736 26.736 0 0 0-12.349-22.509c.07-.526.107-1.056.107-1.587 0-6.564-5.34-11.903-11.904-11.903h-.135A30.535 30.535 0 0 0 69.116 0C57.136 0 46.23 7.105 41.312 17.893a13.463 13.463 0 0 0-4.616-.817c-6.806 0-12.45 5.078-13.339 11.644C10.238 30.458.206 41.744.206 55.17c0 5.876 1.873 11.45 5.418 16.12a26.937 26.937 0 0 0 11.77 8.821 23.36 23.36 0 0 0-.673 5.582c0 12.862 10.464 23.325 23.325 23.325 2.605 0 5.163-.426 7.604-1.268l-1.337-3.878a19.187 19.187 0 0 1-6.267 1.045c-10.6 0-19.224-8.624-19.224-19.224 0-2.135.347-4.23 1.031-6.23l.694-2.025-2.054-.605c-9.53-2.81-16.186-11.718-16.186-21.664 0-11.875 9.274-21.773 21.112-22.533l1.934-.124-.014-1.938-.002-.063c.014-5.15 4.207-9.334 9.36-9.334 1.639 0 3.254.432 4.67 1.25l2.105 1.215.844-2.28c3.82-10.324 13.787-17.26 24.8-17.26A26.432 26.432 0 0 1 94.141 22l.555 1.628 1.7-.263a7.89 7.89 0 0 1 1.204-.093c4.302 0 7.802 3.5 7.802 7.802a7.82 7.82 0 0 1-.277 2.062l-.422 1.544 1.396.784a22.628 22.628 0 0 1 11.546 19.705c0 10.743-7.635 20.057-18.154 22.147l-2.652.527 1.222 2.411a11.548 11.548 0 0 1 1.254 5.27c0 6.437-5.238 11.675-11.676 11.675-2.077 0-4.116-.552-5.896-1.595l-2.644-1.55-.424 3.036c-.51 3.65-2.415 6.898-5.365 9.145l2.485 3.264c3.083-2.349 5.284-5.544 6.364-9.178a15.81 15.81 0 0 0 5.48.98c8.7 0 15.777-7.078 15.777-15.778a15.68 15.68 0 0 0-.734-4.776c11.181-3.324 19.064-13.714 19.064-25.578z"/></g></svg>
                <p class="success_text">Стол забронирован</p>
                <p class="success_notice">Отменить бронь можно по телефону:<br>+7(423)999 99 99</p>
            </div>
        </div>
        <div class="modal modal--warning">
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
                    <div class="warning_block">
                    </div>
                    <button class="warning_ok" data-id="">ОК</button>
                </div>
                <p class="error_table"></p>
            </div>
        </div>
    </section>
    
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>