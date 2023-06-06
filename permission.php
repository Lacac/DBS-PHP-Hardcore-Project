<?php

class permission {
    public $username;
    public $password;

    function __construct($u, $p) {
        $this->username = $u;
        $this->password = $p;
    }

    function is_teacher() {
        $teacher = false;
        $conn = $this->connect_to_mssql("DESKTOP-NCJ03T3\MSSQLSERVER02", "php_hardcore_project", "", "");
        $user = $this->username;
        $pass = $this->password;
        $tsql = "SELECT * FROM teacher WHERE username = ? AND password = ?";
        $params = array($user, $pass);
        $stmt = sqlsrv_query($conn, $tsql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_fetch($stmt) === true) {
            $teacher = true;
        }
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        return $teacher;
    }

    function is_student() {
        $student = false;
        $conn = $this->connect_to_mssql("DESKTOP-NCJ03T3\MSSQLSERVER02", "php_hardcore_project", "", "");
        $user = $this->username;
        $pass = $this->password;
        $tsql = "SELECT * FROM student WHERE username = ? AND password = ?";
        $params = array($user, $pass);
        $stmt = sqlsrv_query($conn, $tsql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_fetch($stmt) === true) {
            $student = true;
        }
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        return $student;
    }
    
    function connect_to_mssql() {
		$serverName = "DESKTOP-NCJ03T3\MSSQLSERVER02";
		$database = "php_hardcore_project";
		$uid = "";
		$pass = "";
		$connectionOptions = [
			"Database" => $database,
			"Uid" => $uid,
			"PWD" => $pass
		];
		$conn = sqlsrv_connect($serverName, $connectionOptions);
		if ($conn === false) {
			die(print_r(sqlsrv_errors(), true));
		}
		return $conn;
	}
}
?>
