<?php
// Конфигурация бота
    define('BOT_TOKEN', getenv('BOT_TOKEN') ?: '8717098765:AAG0Wi0VSk3Fm1pi8xPz2018SXbx_hIH87M

');
    define('DEEPSEEK_KEY', getenv('DEEPSEEK_KEY') ?: 'sk-b0a4ceb847fd4eea998a550ae71bcb5d');

// Логирование ошибок
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', 'error.log');
