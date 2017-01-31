<?php
//------------------------------------------------------------------------------------------
//  Definiciones


	//  Conexión con la Base de Datos.
	
	$db_name			= "club"; 
	$db_username		= "root"; 
	$db_password		= "TtGa2TJEL7qm4QMZ"; 

	//  Nombre del archivo.

	$filename 			= "Club_".date('d-m-Y').".sql";

//------------------------------------------------------------------------------------------
//  No tocar
	error_reporting( E_ALL & ~E_NOTICE );
	define( 'Str_VERS', "1.1.1" );
	define( 'Str_DATE', "18 de Marzo de 2005" );
//------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------
//  Funciones

	error_reporting( E_ALL & ~E_NOTICE );

	function fetch_table_dump_sql($table, $fp = 0) {
		$tabledump = "--\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	
		$tabledump = "-- Table structure for table `$table`\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	
		$tabledump = "--\n\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	

		$tabledump = query_first("SHOW CREATE TABLE $table");
		strip_backticks($tabledump['Create Table']);
		$tabledump = "DROP TABLE IF EXISTS $table;\n" . $tabledump['Create Table'] . ";\n\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	

		$tabledump = "--\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	
		$tabledump = "-- Dumping data for table `$table`\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	
		$tabledump = "--\n\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	

		$tabledump = "LOCK TABLES $table WRITE;\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	

		$rows = query("SELECT * FROM $table");
		$numfields=mysql_num_fields($rows);
		while ($row = fetch_array($rows, DBARRAY_NUM)) {
			$tabledump = "INSERT INTO $table VALUES(";
			$fieldcounter = -1;
			$firstfield = 1;
			// campos
			while (++$fieldcounter < $numfields) {
				if( !$firstfield) {
					$tabledump .= ', ';
				}
				else {
					$firstfield = 0;
				}
				if( !isset($row["$fieldcounter"])) {
					$tabledump .= 'NULL';
				}
				else {
					$tabledump .= "'" . mysql_escape_string($row["$fieldcounter"]) . "'";
				}
			}
			$tabledump .= ");\n";
			if( !$hay_Zlib ) 
				fwrite($fp, $tabledump);
			else
				gzwrite($fp, $tabledump);	
		}
		free_result($rows);
		$tabledump = "UNLOCK TABLES;\n";
		if( !$hay_Zlib ) 
			fwrite($fp, $tabledump);
		else
			gzwrite($fp, $tabledump);	
	}

	function strip_backticks(&$text) {
		return $text;
	}

	function fetch_array($query_id=-1) {
		if( $query_id!=-1) {
			$query_id=$query_id;
		}
		$record = mysql_fetch_array($query_id);
		return $record;
	}

	function problemas($msg) {
		$errdesc = mysql_error();
    $errno = mysql_errno();
    $message  = "<br>";
    $message .= "- Ha habido un problema accediendo a la Base de Datos<br>";
    $message .= "- Error $appname: $msg<br>";
    $message .= "- Error mysql: $errdesc<br>";
    $message .= "- Error número mysql: $errno<br>";
    $message .= "- Script: ".getenv("REQUEST_URI")."<br>";
    $message .= "- Referer: ".getenv("HTTP_REFERER")."<br>";

		echo( "</strong><br><br><hr><center><small>" );
		setlocale( LC_TIME,"spanish" );
		echo strftime( "%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time() );
		echo( "</small></center>" );
		echo( "</BODY>" );
		echo( "</HTML>" );
		die("");
  }

	function free_result($query_id=-1) {
    if( $query_id!=-1) {
      $query_id=$query_id;
    }
    return @mysql_free_result($query_id);
  }

  function query_first($query_string) {
    $res = query($query_string);
    $returnarray = fetch_array($res);
    free_result($res);
    return $returnarray;
  }

	function query($query_string) {
    $query_id = mysql_query($query_string);
    if( !$query_id) {
      problemas("Invalid SQL: ".$query_string);
    }
    return $query_id;
  }


//------------------------------------------------------------------------------------------
//  Main
?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
  <HTML>
  <HEAD>

		<script  type='text/javascript' src='Validar.js' ></script>	
		<link href='../../Include/css/tablas.css' rel='stylesheet' type='text/css' media='screen' />
	    </head>    
	    <form id='FormRespaldo' action='?href=Respaldo' method='post'>
	     <body>
	    <h1>Respaldo de  la Base de Datos</h1>    
	    <hr />
	    <br>
  
	<!-- no cache headers -->
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="no-cache">
	<meta http-equiv="Expires" content="-1">
	<meta http-equiv="Cache-Control" content="no-store">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Cache-Control" content="must-revalidate">
	<!-- end no cache headers --> 
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../estilos/general.css" rel="stylesheet" type="text/css">	
 </HEAD>
<body OnContextMenu="return false">

<br>
<strong>
<?php
	@set_time_limit( 0 );

	echo( "- Base de Datos: '$db_name'.<br>" );
	$error = false;
	$tablas = 0;

	if( !@function_exists( 'gzopen' ) ) {
		$hay_Zlib = false;
		echo( "- Base de Datos sin comprimir, como '$filename'<br>" );
	}
	else {
		$filename = $filename . ".gz";
		$hay_Zlib = true;
		echo( "- Base de Datos comprimida, como '$filename'<br>" );
	}
	
	if( !$error ) { 
	    $dbconnection = @mysql_connect( $db_server, $db_username, $db_password ); 
	    if( $dbconnection) 
	        $db = mysql_select_db( $db_name );
	    if( !$dbconnection || !$db ) { 
	        echo( "<br>" );
	        echo( "- La conexion con la Base de datos ha fallado: ".mysql_error()."<br>" );
	        $error = true;
	    }
	    else {
	        echo( "<br>" );
	        echo( "- Se estableció conexion con la Base de datos.<br>" );
	    }
	}

	if( !$error ) { 
		//  MySQL versión
		$result = mysql_query( 'SELECT VERSION() AS version' );
		if( $result != FALSE && @mysql_num_rows($result) > 0 ) {
			$row   = mysql_fetch_array($result);
		} else {
			$result = @mysql_query( 'SHOW VARIABLES LIKE \'version\'' );
			if( $result != FALSE && @mysql_num_rows($result) > 0 ){
				$row   = mysql_fetch_row( $result );
			}
		}
		if(! isset($row) ) {
			$row['version'] = '3.21.0';
		}
	}

	if( !$error ) { 
		$el_path = getenv("REQUEST_URI");
		$el_path = substr($el_path, strpos($el_path, "/"), strrpos($el_path, "/"));
error_reporting(0);
		$result = mysql_list_tables( $db_name );
		if( !$result ) {
			print "- Error, no se puede obtener la lista de las tablas.<br>";
			print '- MySQL Error: ' . mysql_error(). '<br><br>';
			$error = true;
		}
		else {
			$t_start = time();
			
			if( !$hay_Zlib ) 
				$filehandle = fopen( $filename, 'w' );
			else
				$filehandle = gzopen( $filename, 'w6' );	//  nivel de compresión
				
			if( !$filehandle ) {
				$el_path = getenv("REQUEST_URI");
				$el_path = substr($el_path, strpos($el_path, "/"), strrpos($el_path, "/"));
				echo( "<br>" );
				echo( "- No se pudo crear '$filename' en '$el_path/'. Por favor, asegúrese de<br>" );
				echo( "&nbsp;&nbsp;que dispone de privilegios de escritura.<br>" );
			}
			else {					
				$tabledump = "-- Respaldo de la Base de Datos\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				setlocale( LC_TIME,"spanish" );
				$tabledump = "-- Fecha: " . strftime( "%A %d %B %Y - %H:%M:%S", time() ) . "\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				$tabledump = "--\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				$tabledump = "--\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				$tabledump = "-- Host: `$db_server`    Database: `$db_name`\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				$tabledump = "-- ------------------------------------------------------\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				$tabledump = "-- Server version	". $row['version'] . "\n\n";
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	

				$result = query( 'SHOW tables' );
				while( $currow = fetch_array($result, DBARRAY_NUM) ) {
					fetch_table_dump_sql( $currow[0], $filehandle );
					fwrite( $filehandle, "\n" );
					if( !$hay_Zlib ) 
						fwrite( $filehandle, "\n" );
					else
						gzwrite( $filehandle, "\n" );
						$tablas++;
				}
				$tabledump = "\n-- Respaldo de la Base de Datos Completo.";

				if( !$hay_Zlib ) //----------- grabamos los UPDATES
				{
					fwrite($filehandle,$s1);
					fwrite($filehandle,$s2);
					fwrite($filehandle,$s3);
					fwrite($filehandle,$s4);
					fwrite($filehandle,$s5);
					fwrite($filehandle,$s6);
					fwrite($filehandle,$s7);
					fwrite($filehandle,$s8);
					fwrite($filehandle,$s9);
				}
				else
				{
					gzwrite($filehandle,$s1);
					gzwrite($filehandle,$s2);
					gzwrite($filehandle,$s3);
					gzwrite($filehandle,$s4);
					gzwrite($filehandle,$s5);
					gzwrite($filehandle,$s6);
					gzwrite($filehandle,$s7);
					gzwrite($filehandle,$s8);
					gzwrite($filehandle,$s9);
				}				//-------------------

		//------------------------------------------------------------------------------

						
				if( !$hay_Zlib ) 
					fwrite( $filehandle, $tabledump );
				else
					gzwrite( $filehandle, $tabledump );	
				if( !$hay_Zlib ) 
					fclose( $filehandle );
				else
					gzclose( $filehandle );
	
				$t_now = time();
				$t_delta = $t_now - $t_start;
				if( !$t_delta )
					$t_delta = 1;
				$t_delta = floor(($t_delta-(floor($t_delta/3600)*3600))/60)." minutos y "
				.floor($t_delta-(floor($t_delta/60))*60)." segundos.";
				echo( "- Se guardaron las $tablas tablas en $t_delta<br>" );
				echo( "<br>" );
				echo( "- El Respaldo de la Base de Datos está completo.<br>" );
				echo( "- Se guardó la Base de Datos en: $el_path/$filename<br>" );
				echo( "<br>" );
				echo( "- Puede bajársela directamente: </strong><a href=\"$filename\">$filename</a>" );
				$size = filesize($filename);
				$size = number_format( $size );
				$size = str_replace( ",",".",$size );
				echo( "&nbsp;&nbsp;&nbsp;<small>($size bytes)</small><br>" );
			}
		}
	}

	
	if( $dbconnection )
	    mysql_close();

	
	echo( "</body>" );
	echo( "</HTML>" );

//------------------------------------------------------------------------------------------
//  END
///////  El área protegida acaba ANTES de la ANTERIOR línea  /////
?>
<?php 	//-------------  VOLVEMOS LOS AUTO_INCREMENT DE LAS TABLAS 
/*
	$dbm=mysql_connect($db_server,$db_username,$db_password);
		$res=mysql_db_query($db_name,"ALTER TABLE `departamento` CHANGE `id_departamento` `id_departamento` INT( 11 ) NOT NULL AUTO_INCREMENT",$dbm);
		$res=mysql_db_query($db_name,"ALTER TABLE `deposito` CHANGE `id_deposito` `id_deposito` INT( 11 ) NOT NULL AUTO_INCREMENT",$dbm);
		$res=mysql_db_query($db_name,"ALTER TABLE `localidad` CHANGE `id_localidad` `id_localidad` INT( 11 ) NOT NULL AUTO_INCREMENT",$dbm);
		$res=mysql_db_query($db_name,"ALTER TABLE `provincia` CHANGE `id_provincia` `id_provincia` INT( 11 ) NOT NULL AUTO_INCREMENT",$dbm);
		$res=mysql_db_query($db_name,"ALTER TABLE `sucursal` CHANGE `id_sucursal` `id_sucursal` INT( 11 ) NOT NULL AUTO_INCREMENT",$dbm);
		$res=mysql_db_query($db_name,"ALTER TABLE `tipo_doc` CHANGE `id_tipodoc` `id_tipodoc` INT( 11 ) NOT NULL AUTO_INCREMENT",$dbm);
*/
		//------------------------------------------------------------------------------
?>
