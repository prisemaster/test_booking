//Datepicker Locale
(function(factory) {
    if (typeof define === "function" && define.amd) {

        // AMD. Register as an anonymous module.
        define(["../widgets/datepicker"], factory);
    } else {

        // Browser globals
        factory(jQuery.datepicker);
    }
}(function(datepicker) {

    datepicker.regional.ru = {
        closeText: "Закрыть",
        prevText: "&#x3C;Пред",
        nextText: "След&#x3E;",
        currentText: "Сегодня",
        monthNames: ["января", "февраля", "марта", "апреля", "мая", "июня",
            "июля", "августа", "сентября", "октября", "ноября", "декабря"
        ],
        monthNamesShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн",
            "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"
        ],
        dayNames: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"],
        dayNamesShort: ["вск", "пнд", "втр", "срд", "чтв", "птн", "сбт"],
        dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
        weekHeader: "Нед",
        dateFormat: "d MM",
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ""
    };
    datepicker.setDefaults(datepicker.regional.ru);

    return datepicker.regional.ru;
}));

var weekends = new Array();

if ($(".booking_block").length > 0) {
    $(document).ready(function() {
        fillSelTables_Front();


        $.ajax({
            type: "POST",
            url: '/php/booking.php?function=getWeekends',
            success: function(response) {
                var jsonData = JSON.parse(response);
                for (var item of jsonData) {
                    weekends.push(item['special_date']);
                }
                console.log(weekends);
            }
        });
    });


}



//Datepicker
var today = new Date();
$("#datepick_day").datepicker({
    changeYear: false,
    minDate: today,
    onSelect: function(dateText) {
        var check = $("#datepick_day").datepicker('getDate');
        if (today.toDateString() === check.toDateString()) {
            $(this).val('(Сегодня) ' + $(this).val());
        }
        var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
        if (tomorrow.toDateString() === check.toDateString()) {
            $(this).val('(Завтра) ' + $(this).val());
        }
        $('#datepick_day').trigger('change');
    },
    beforeShowDay: function(date) {
        var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
        return [weekends.indexOf(string) == -1];
    }
});


function fillSelTables_Front() {
    $.ajax({
        type: "POST",
        url: '/php/tables.php?function=fillTables',
        success: function(response) {
            var jsonData = JSON.parse(response);
            var elem = $('#table');
            elem.empty();
            var html_in;
            html_in = '<option value="" hidden disabled selected>Выберите стол</option>';
            for (var item of jsonData) {
                html_in += '<option value="' + item['table_id'] + '">#' + item['table_number'] + ': ' + item['table_name'] + ' (' + item['table_size'] + ')</option>';
            }
            elem.append(html_in);
        }
    });
}

//Timepicker
$("#datepick_time").timepicker({
    timeFormat: 'H:i',
    'minTime': '9:00',
    'maxTime': '0:00'
});

//Selectmenu
$("#table").selectmenu({
    select: Validate()
});

$("#duration").selectmenu({
    select: Validate()
});

//Validate button
$('.booking_main__form input').on('change', function() {
    Validate();
    console.log(Validate());
});

$('#table, #duration').on('selectmenuchange', function() {
    Validate();
    console.log(Validate());
});

function Validate() {
    var timer = 1;
    if (($('#table').val()) && ($('#duration').val()) && ($('#datepick_day').val()) && ($('#datepick_time').val())) {

    } else {
        timer = 0;
    }
    if (($('#name').val()) && ($('#phone').val())) {
        if (timer == 1) {
            $('.submit').addClass('active');
            return 1;
        } else {
            $('.submit').removeClass('active');
            return 0;
        }
    } else {
        $('.submit').removeClass('active');
        return -1;
    }
}

//Submit event
$('.booking_main__form').on('submit', function(e) {
    e.preventDefault();
    var special_date = $("#datepick_day").datepicker('getDate');
    special_date = new Date(special_date.setMonth(special_date.getMonth() + 1))
    special_date = special_date.getFullYear() + '-' + special_date.getMonth() + '-' + special_date.getDate();
    $('#in_day').val(special_date);
    $.ajax({
        type: "POST",
        url: '/php/days.php',
        data: $(this).serialize(),
        success: function(response) {
            var jsonData = JSON.parse(response);
            if (!jsonData['error']) {
                $('.booking_main__form').addClass('hidden');
                $('.booking_main__success').addClass('active');
            } else {
                if (jsonData['error'] == 2) {
                    var html_in = '<p>Извините, но указанное время брони не совпадает с графиком работы ресторана в этот день.</p><br>';
                    html_in += '<p>График работы на ' + jsonData['day'] + '</p>';
                    html_in += '<p>С ' + jsonData['start'] + ' по ' + jsonData['end'] + '</p>';
                    $('.warning_block').html(html_in);
                    $('.modal--warning').addClass('active');
                }
                if (jsonData['error'] == 3) {

                    var html_in = '<p>Извините, но на указанное время уже указана бронь.</p><br>';
                    html_in += '<p>Занятая бронь на столик №' + jsonData['table'] + ' (' + jsonData['day'] + ')</p>';
                    for (var item in jsonData['booking']) {
                        console.log(item);
                        html_in += '<p>С ' + jsonData['booking'][item]['start'].slice(0, -3) + ' по ' + jsonData['booking'][item]['end'] + '</p>';
                    }
                    $('.warning_block').html(html_in);
                    $('.modal--warning').addClass('active');
                }
            }
        }
    });
});

$('.warning_ok').on('click', function() {
    $('.modal').removeClass('active');
});

//Admin OnReady
if ($(".admin_screen").length > 0) {
    $(document).ready(function() {
        fillSchedule();
        fillSpecial();
        fillTables();
        fillSelTables();
        showBooking($('#sel_table').value);
    });
}

$('.admin_menu_button').on('click', function() {
    var src = $(this).data('src');
    if (src != $('.admin_menu_screen.active').data('src')) {
        $('.admin_menu_screen').removeClass('active');
        $('.admin_menu_screen[data-src="' + src + '"]').addClass('active');
    }
    fillSchedule();
    fillSpecial();
    fillTables();
    fillSelTables();
    showBooking($('#sel_table').value);
});

//Admin_Schedule
$("#datepick_start").timepicker({
    timeFormat: 'H:i'
});

$("#datepick_end").timepicker({
    timeFormat: 'H:i'
});

function fillSchedule() {
    $.ajax({
        type: "POST",
        url: '/php/schedule.php?function=getSchedule',
        success: function(response) {
            var jsonData = JSON.parse(response);
            var elem = $('.schedule_list');
            elem.empty();
            for (var item of jsonData) {
                var html_in;
                html_in = '<li class="schedule_li">';
                html_in += '<div class="schedule_cell schedule_cell--weekday">';
                html_in += '<p class="schedule_text">' + item['schedule_week_name'] + '</p>';
                html_in += '</div>';
                html_in += '<div class="schedule_cell schedule_cell--start">';
                html_in += '<p class="schedule_text">' + item['schedule_start'].slice(0, -3) + ' - ' + item['schedule_end'].slice(0, -3) + '</p>';
                html_in += '</div>';
                html_in += '<div class="schedule_cell schedule_cell--change schedule_cell--hidden">';
                html_in += '<button class="schedule_change" data-week="' + item['schedule_week_id'] + '">Изменить</button>';
                html_in += '</div>';
                html_in += '</li>';
                elem.append(html_in);
            }
        }
    });
}

//Admin_Special
function fillSpecial() {
    $.ajax({
        type: "POST",
        url: '/php/special.php?function=getSpecial',
        success: function(response) {
            var jsonData = JSON.parse(response);
            var elem = $('.special_list');
            elem.empty();
            for (var item of jsonData) {
                var html_in;
                var special_date = item['special_date'].split("-");
                html_in = '<li class="schedule_li">';
                html_in += '<div class="schedule_cell special_cell--date">';
                html_in += '<p class="schedule_text">' + moment(special_date).subtract(1, 'months').format("DD-MM") + '</p>';
                html_in += '</div>';
                if (item['is_weekend'] == 0) {
                    html_in += '<div class="schedule_cell special_cell--start">';
                    html_in += '<p class="schedule_text">' + item['special_start'].slice(0, -3) + ' - ' + item['special_end'].slice(0, -3) + '</p>';
                    html_in += '</div>';
                } else {
                    html_in += '<div class="schedule_cell special_cell--start">';
                    html_in += '<p class="schedule_text">Выходной</p>';
                    html_in += '</div>';
                }
                html_in += '<div class="schedule_cell special_cell--change schedule_cell--hidden">';
                html_in += '<button class="special_change" data-id="' + item['special_id'] + '">Изменить</button>';
                html_in += '<button class="special_delete" data-id="' + item['special_id'] + '">Удалить</button>';
                html_in += '</div>';
                html_in += '</li>';
                elem.append(html_in);
            }
        }
    });
}

//Modal handlers
$('body').on('click', '.schedule_change', function() {
    var week = $(this).data('week');
    $('.modal--schedule').addClass('active');
    $.ajax({
        type: "POST",
        url: '/php/schedule.php?function=getWeekDay&week=' + week + '',
        success: function(response) {
            var jsonData = JSON.parse(response);
            $('.week_day').html(jsonData['week_day']);
            $('#week_day_id').val(jsonData['id']);
            $('#datepick_start').val(jsonData['time_start']);
            $('#datepick_end').val(jsonData['time_end']);
        }
    });
});

$('.week_day__submit').on('click', function() {
    var week_id = $('#week_day_id').val();
    var time_start = $("#datepick_start").val();
    var time_end = $("#datepick_end").val();

    $.ajax({
        type: "POST",
        url: '/php/schedule.php?function=setWeekDay&week=' + week_id + '&start=' + time_start + '&end=' + time_end + '',
        success: function() {
            $('.modal').removeClass('active');
            fillSchedule();
        }
    });
});

$('.special_add').on('click', function() {
    $('.modal--add_special').addClass('active');
});

$("#special_day").datepicker({
    changeYear: false
});

$("#special_day_change").datepicker({
    changeYear: false
});

function clearSpecialModal() {
    $("#is_weekend").prop("checked", false);
    $('.special_time_block').removeClass('hidden');
    $('.special_time_block input').val('');
    $('#special_day').val('');
    $("#is_weekend_change").prop("checked", false);
    $('#special_day_change').val('');
    $('.special__change').data('id', '');
}

$('.modal__bg, .close_modal').on('click', function() {
    $('.modal').removeClass('active');
    clearSpecialModal();
});

$('#is_weekend, #is_weekend_change').on('click', function() {
    $('.special_time_block').toggleClass('hidden');
});

$("#special_start").timepicker({
    timeFormat: 'H:i'
});

$("#special_end").timepicker({
    timeFormat: 'H:i'
});

$("#special_start_change").timepicker({
    timeFormat: 'H:i'
});

$("#special_end_change").timepicker({
    timeFormat: 'H:i'
});

$('.special__submit').on('click', function() {
    var special_date = $('#special_day').datepicker('getDate');
    var is_weekend = $("#is_weekend").prop('checked');
    var date_start = $("#special_start").val();
    var date_end = $("#special_end").val();
    special_date = new Date(special_date.setMonth(special_date.getMonth() + 1))
    special_date = special_date.getFullYear() + '-' + special_date.getMonth() + '-' + special_date.getDate();
    console.log(special_date + ' ' + is_weekend + ' ' + date_start + ' ' + date_end);
    $.ajax({
        type: "POST",
        url: '/php/special.php?function=setSpecial&date=' + special_date + '&start=' + date_start + '&end=' + date_end + '&is_weekend=' + is_weekend + '',
        success: function() {
            $('.modal').removeClass('active');
            fillSpecial();
        }
    });
    clearSpecialModal();
});

$('body').on('click', '.special_delete', function() {
    $.ajax({
        type: "POST",
        url: '/php/special.php?function=delSpecial&id=' + $(this).data('id') + '',
        success: function() {
            $('.modal--add_special').removeClass('active');
            fillSpecial();
        }
    });
});

$('body').on('click', '.special_change', function() {
    $.ajax({
        type: "POST",
        url: '/php/special.php?function=pickSpecial&id=' + $(this).data('id') + '',
        success: function(response) {
            var jsonData = JSON.parse(response);

            var special_date = jsonData['special_date'].split("-");
            console.log(special_date);
            special_date = new Date(special_date[0], special_date[1] - 1, special_date[2]);
            $('#special_day_change').datepicker('setDate', special_date);
            console.log(jsonData['is_weekend']);
            if (jsonData['is_weekend'] == 1) {
                $('#is_weekend_change').prop('checked', 1);
                $('.special_time_block').addClass('hidden');
            } else {
                $('#is_weekend_change').prop('checked', 0);
                $('#special_start_change').val(jsonData['special_start'].slice(0, -3));
                $('#special_end_change').val(jsonData['special_end'].slice(0, -3));
            }
            $('.special__change').data('id', jsonData['special_id']);
            $('.modal--change_special').addClass('active');
        }
    });
});

$('.special__change').on('click', function() {
    var special_id = $(this).data('id');
    var special_date = $('#special_day_change').datepicker('getDate');
    var is_weekend = $("#is_weekend_change").prop('checked');
    var date_start = $("#special_start_change").val();
    var date_end = $("#special_end_change").val();
    special_date = new Date(special_date.setMonth(special_date.getMonth() + 1))
    special_date = special_date.getFullYear() + '-' + special_date.getMonth() + '-' + special_date.getDate();
    $.ajax({
        type: "POST",
        url: '/php/special.php?function=editSpecial&id=' + special_id + '&date=' + special_date + '&start=' + date_start + '&end=' + date_end + '&is_weekend=' + is_weekend + '',
        success: function() {
            $('.modal').removeClass('active');
            fillSpecial();
        }
    });
    clearSpecialModal();
});

function fillTables() {
    $.ajax({
        type: "POST",
        url: '/php/tables.php?function=fillTables',
        success: function(response) {
            var jsonData = JSON.parse(response);
            var elem = $('.table_list');
            elem.empty();
            for (var item of jsonData) {
                var html_in;
                html_in = '<li class="table_li">';
                html_in += '<p class="table_row table_row--number">' + item['table_number'] + '</p>';
                html_in += '<p class="table_row table_row--type">' + item['table_name'] + ' (' + item['table_size'] + ')</p>';
                html_in += '<div class="table_row table_row--change">';
                html_in += '<button class="table_change" data-id="' + item['table_id'] + '" data-table_type_id="' + item['table_type_id'] + '">Изменить</button>';
                html_in += '</div>';
                html_in += '<div class="table_row table_row--delete">';
                html_in += '<button class="table_delete" data-id="' + item['table_id'] + '">Удалить</button>';
                html_in += '</div>';
                html_in += '</li>';
                elem.append(html_in);
            }

        }
    });
}

$('body').on('click', '.table_delete', function() {
    var table_id = $(this).data('id');
    $('.modal--warning_del').addClass('active');
    $('.warning_ok_del').data('id', table_id);
});

$('.warning_ok_del_cancel').on('click', function() {
    $('.modal').removeClass('active');
});

$('.warning_ok_del').on('click', function() {
    var table_id = $(this).data('id');
    console.log(table_id);
    $.ajax({
        type: "POST",
        url: '/php/tables.php?function=delTable&id=' + table_id + '',
        success: function() {
            fillTables();
            $('.modal').removeClass('active');
        }
    });
});

function clearAddTable() {
    $('#table_number_add').val('');
    $('#table__add').data('id', '');
    $('#table_type_add').prop('selected', true);
    $('.error_table').text('');
    $('#table_number_edit').val('');
    $('#table__edit').data('id', '');
    $('#table_type_edit').prop('selected', true);
}

$('.add_table').on('click', function() {
    clearAddTable();
    $('.modal--add_table').addClass('active');
});

$('.table__add').on('click', function() {
    var table_number = $('#table_number_add').val();
    var table_type = $('#table_type_add').val();
    if (table_number != '' && table_type != '') {
        $.ajax({
            type: "POST",
            url: '/php/tables.php?function=addTable&table_number=' + table_number + '&table_type=' + table_type + '',
            success: function(response) {
                var jsonData = JSON.parse(response);
                if (jsonData['error']) {
                    $('.error_table').text('Столик с данным номером уже существует!');
                } else {
                    fillTables();
                    $('.modal').removeClass('active');
                }
            }
        });
    }
});

$('body').on('click', '.table_change', function() {
    var table_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: '/php/tables.php?function=getTable&table_id=' + table_id + '',
        success: function(response) {
            var jsonData = JSON.parse(response);
            $('#table_number_edit').val(jsonData['table_number']);
            $('#table_type_edit').prop('selectedIndex', jsonData['table_type_id']);
            $('.table__edit').data('id', table_id);
        }
    });

    $('.modal--edit_table').addClass('active');
});

$('.table__edit').on('click', function() {
    var table_number = $('#table_number_edit').val();
    var table_type = $('#table_type_edit').val();
    var table_id = $(this).data('id');
    if (table_number != '' && table_type != '') {
        $.ajax({
            type: "POST",
            url: '/php/tables.php?function=editTable&table_id=' + table_id + '&table_number=' + table_number + '&table_type=' + table_type + '',
            success: function() {
                $('.modal').removeClass('active');
                fillTables();
            }
        });
    }
});

function fillSelTables() {
    $.ajax({
        type: "POST",
        url: '/php/tables.php?function=fillTables',
        success: function(response) {
            var jsonData = JSON.parse(response);
            var elem = $('#sel_table');
            elem.empty();
            var html_in;
            html_in = '<option value="" hidden disabled selected>Выберите стол</option>';
            for (var item of jsonData) {
                html_in += '<option value="' + item['table_id'] + '">#' + item['table_number'] + ': ' + item['table_name'] + ' (' + item['table_size'] + ')</option>';
            }
            elem.append(html_in);
        }
    });
}

$('#sel_table').on('change', function() {
    var table_id = this.value;
    showBooking(table_id);
});

function showBooking(table_id) {
    $.ajax({
        type: "POST",
        url: '/php/booking.php?function=getBooking&table_id=' + table_id + '',
        success: function(response) {
            var jsonData = JSON.parse(response);
            var elem = $('.table_list_booking');
            elem.empty();

            for (var item of jsonData) {
                var html_in;
                html_in = '<li class="table_list_booking__li">';
                html_in += '<p class="table_row booking_row--number">' + item['table_number'] + '</p>';
                html_in += '<p class="table_row booking_row--name">' + item['name'] + '</p>';
                html_in += '<p class="table_row booking_row--phone">' + item['phone'] + '</p>';
                html_in += '<p class="table_row booking_row--day">' + item['day'] + '</p>';
                html_in += '<p class="table_row booking_row--start">' + item['time'] + '</p>';
                html_in += '<p class="table_row booking_row--end">' + item['end'] + '</p>';
                html_in += '<div class="table_row booking_row--delete">';
                html_in += '<button class="style_link_like booking_delete" data-id="' + item['booking_id'] + '">Удалить</button>';
                html_in += '</div>';
                html_in += '</li">';
                elem.append(html_in);
            }
        }
    });
}

$('body').on('click', '.booking_delete', function() {
    var booking_id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: '/php/booking.php?function=delBooking&booking_id=' + booking_id + '',
        success: function() {
            showBooking($('#sel_table').val());
        }
    });
});

// ПРОВЕРЯТЬ ЗАКАЗЫ ПЕРЕД УДАЛЕНИЕМ СТОЛИКА !