<?php
/**
 * Plugin Name: Rus Package
 * Description: Snippets for Russian-language blog. Cyrillic to Latin converation in slugs and declension of nouns on dates.
 * Version: 1.3
 * Author: Anton Lukin
 * Author URI: https://lukin.me/
 * Plugin URI: https://github.com/antonlukin/rus-package
 * Text Domain: rus-package
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'init', function() {
 	load_plugin_textdomain( 'rus-package', false, basename(__DIR__) . '/lang' );

	new Rus_Transliteration;
} );

class Rus_Transliteration {
	/**
	 * Set public actions and filters
	 */
	public function __construct()
	{
		add_action( 'sanitize_title',        array( $this, 'replace_latin' ), 9 );
		add_action( 'sanitize_file_name',    array( $this, 'replace_latin' ), 9 );

		add_filter( 'the_date',              array( $this, 'update_date' ) );
		add_filter( 'the_time',              array( $this, 'update_date' ) );
		add_filter( 'get_the_time',          array( $this, 'update_date' ) );
		add_filter( 'get_the_date',          array( $this, 'update_date' ) );
		add_filter( 'get_post_time',         array( $this, 'update_date' ) );
		add_filter( 'get_comment_date',      array( $this, 'update_date' ) );
		add_filter( 'the_modified_time',     array( $this, 'update_date' ) );
		add_filter( 'get_the_modified_date', array( $this, 'update_date' ) );
	}


	/**
	 * Replace latin with cyrillic using ISO 9
	 */
	public function replace_latin( $name )
	{
		$replace = array(
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
			'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
			'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
			'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
			'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'CZ', 'Ч' => 'CH',
			'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
			'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',

			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
			'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
			'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
			'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'cz', 'ч' => 'ch',
			'ш' => 'sh', 'щ' => 'shh', 'ъ' => '', 'ы' => 'y', 'ь' => '',
			'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
		);

		$name = strtr( $name, $replace );

		if ( seems_utf8( $name ) ) {
			$name = urldecode( $name );
		}

		return $name;
	}


	/**
	 * Replace english dates with russian names
	 */
	public function update_date( $date = '' )
	{
		$replace = array(
			"Январь"    => "января",
			"Февраль"   => "февраля",
			"Март"      => "марта",
			"Апрель"    => "апреля",
			"Май"       => "мая",
			"Июнь"      => "июня",
			"Июль"      => "июля",
			"Август"    => "августа",
			"Сентябрь"  => "сентября",
			"Октябрь"   => "октября",
			"Ноябрь"    => "ноября",
			"Декабрь"   => "декабря",

			"January"   => "января",
			"February"  => "февраля",
			"March"     => "марта",
			"April"     => "апреля",
			"May"       => "мая",
			"June"      => "июня",
			"July"      => "июля",
			"August"    => "августа",
			"September" => "сентября",
			"October"   => "октября",
			"November"  => "ноября",
			"December"  => "декабря",

			"Sunday"    => "воскресенье",
			"Monday"    => "понедельник",
			"Tuesday"   => "вторник",
			"Wednesday" => "среда",
			"Thursday"  => "четверг",
			"Friday"    => "пятница",
			"Saturday"  => "суббота",

			"Sun" => "воскресенье",
			"Mon" => "понедельник",
			"Tue" => "вторник",
			"Wed" => "среда",
			"Thu" => "четверг",
			"Fri" => "пятница",
			"Sat" => "суббота",

			"th" => "",
			"st" => "",
			"nd" => "",
			"rd" => ""
		);

		$date = strtr( $date, $replace );

		return $date;
	}
}
