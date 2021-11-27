<?php

	// Соединение с БД
	// Автор: NexT
	
	class DataBase {
		var $Connect;
		var $Select;
		
		function DataBase($Host, $Username, $Password, $DataBase) {
            $this->Connect = new mysqli($Host, $Username, $Password, $DataBase);
            if ($this->Connect->connect_errno) {
                    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
					return false;
            }
		}
		function fetchinfo($rowname, $tablename, $finder, $findervalue){
            $select = "SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'";
		    $result3 = $this->Connect->query($select);
			$row3 = $result3->fetch_assoc();
	        return $row3[$rowname];

        }
		
		function FetchRow($Query) {
			return mysql_fetch_row($Query);
		}
		
		function FetchArray($Query) {
			return mysql_fetch_array($Query, MYSQL_ASSOC);
		}
		
		function FetchAssoc($Query) {
			return mysql_fetch_assoc($Query);
		}
		
		function NumRows($Query) {
			return mysql_num_rows($Query);
		}
		
		function Result($Query, $Query1, $Query2) {
			return mysql_result($Query, $Query1, $Query2);
		}
		
		function SafeString($Query) {
			return mysql_real_escape_string($Query);
		}
		
		function GetLastMessage() {
			return mysql_get_last_message();
		}
	
		function AffectedRows() {
			return mysql_affected_rows();
		}
		
		function Close() {
			return mysql_close($this->Connect);
		}
	}
	
	$MYSQL = new DataBase($DB['host'],$DB['user'], $DB['password'], $DB['database']);
	
?>