<?php

class WormCheck implements themecheck {

	protected $error = array();



	function check( $php_files, $css_files, $other_files ) {

		$ret = true;

		$php_files = array_merge( $php_files, $other_files );

		$checks = array(

			'/wshell\.php/'=> __( 'This may be a script used by hackers to get control of your server!', 'theme-check' ),

			'/ShellBOT/' => __( 'This may be a script used by hackers to get control of your server', 'theme-check' ),

			'/uname -a/' => __( 'Tells a hacker what operating system your server is running', 'theme-check' ),

			'/php \$[a-zA-Z]*=\'as\';/' => __( 'Symptom of the "Pharma Hack" <a href="http://blog.sucuri.net/2010/07/understanding-and-cleaning-the-pharma-hack-on-wordpress.html">[1]</a>', 'theme-check' ),

			'/defined?\(\'wp_class_support/' => __( 'Symptom of the "Pharma Hack" <a href="http://blog.sucuri.net/2010/07/understanding-and-cleaning-the-pharma-hack-on-wordpress.html">[1]</a>', 'theme-check' ),

			);



		foreach ( $php_files as $php_key => $phpfile ) {

			foreach ( $checks as $key => $check ) {

				checkcount();

				if ( preg_match( $key, $phpfile, $matches ) ) {

					$filename = tc_filename( $php_key );

					$error = $matches[0];

					$grep = tc_grep( $error, $php_key );

					$this->error[] = sprintf('<span class="tc-lead tc-warning">'. __( 'WARNING', 'theme-check') . '</span>: <strong>%1$s</strong> %2$s%3$s', $filename, $check, $grep );

					$ret = false;

				}

			}

		}

		return $ret;

	}



	function getError() { return $this->error; }

}

$themechecks[] = new WormCheck;

