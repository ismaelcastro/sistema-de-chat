<?php
	class BD{
		private static $pdo;
		
		public static function conn(){
				if(is_null(self::$pdo)){
					
					self::$pdo= new PDO('mysql:host='.HOST.';dbname='.BD.'',''.USER.'',''.PASS.'') or die (mysql_error());
					
					return self::$pdo;	
				};
			
			}
	};
	
?>