<?php

/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'sasha' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`#FtC{4)6H#O%#bw.t/~@cPNdXg)E&t!|k.g/m3Qcdqt<+f@6H`A.q0s#/VVB$9|' );
define( 'SECURE_AUTH_KEY',  'z*}b/@$j7`n6H#g(|NG-XRhwRoA5tV(6P)4(-/BT0bQH&YCE`9yQ0kY}_3JC#R#V' );
define( 'LOGGED_IN_KEY',    'MFj9{xt#4V)yW}]?2DvV@v^aoGmbf]`YV:=(4gb_*bx(CgG]DTh>M,oh4 AjrZ93' );
define( 'NONCE_KEY',        'Jq<:qlG0uNs|^ZOKQ|+lW#R?GqY(s]8[,^66>=K#[wuCt))k+SbW~7cb-u*61_tV' );
define( 'AUTH_SALT',        '8fzQ(8SQ3{3DQ}S%rp$(HR7X#-LEIB};.:HZBKk~ +7LY5nM?,1})L2`4Qn0gg o' );
define( 'SECURE_AUTH_SALT', 'Q,R@zdl+D$Qa1!uQv1pV8*}>IPq%!dpp[zL*C>]/U5x+]HE[M(9=Xt-31e[v2Mc ' );
define( 'LOGGED_IN_SALT',   'c H]pC <Vx;[GW&>DdN+.[{|y*EL.Ly>1c{%DE XEmr*XAMK}=;e}r}d>)w2ebxf' );
define( 'NONCE_SALT',       't}G+~UokLRJ)j>9?1sRTpu!y[k5DO[i%/brL&e`LH;PFvp}Qha5P4PW|wV3YY|u{' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

define( 'PLL_COOKIE', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
