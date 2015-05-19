<?php
	require_once("config/database-opt.inc");
	class Database extends mysqli{
		private static $instance=null;
		protected function __construct(){
			parent::__construct(DATABASE_HOSTNAME,DATABASE_USERNAME,DATABASE_PASSWORD,DATABASE_NAME);
		}
		public static function getInstance(){
			if(!(self::$instance instanceof self))
				self::$instance = new self();
			return self::$instance;
		}
	}

?>