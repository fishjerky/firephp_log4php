<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require_once APPPATH . 'third_party/log4php/Logger.php';
	class Log4php {

		protected $logger;
		protected $initialized = false;

		public function __construct() {

			if ($this->initialized === false) {
				$this->initialized = true;
				$config_file = APPPATH . 'config/log4php.xml';
				if ( defined('ENVIRONMENT') && file_exists( APPPATH . 'config/' . ENVIRONMENT . '/log4php.xml' ) ) {
					$config_file = APPPATH . 'config/' . ENVIRONMENT . '/log4php.xml';
				}
				Logger::configure($config_file);
				
				$ci = & get_instance();
				$config = $ci->config->item('log4php');
				if(isset($config['logger']))
					$this->logger = Logger::getLogger($config['logger']);
				else
					$this->logger = Logger::getRootLogger();
			}
		}

		public function log($level = 'error', $msg, $php_error = FALSE) {

			$level = strtoupper($level);
/*
			if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold) ) {
				return FALSE;
			}*/
			switch ($level) {
				case 'ERROR':
					$this->logger->error($msg);
					break;
				case 'INFO':
					$this->logger->info($msg);
					break;
				case 'DEBUG':
					$this->logger->debug($msg);
					break;
				default:
					$this->logger->debug($msg);
					break;
				}

				return TRUE;
			}
		}
