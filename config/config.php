<?php
    //define("BASE_URL","http://localhost:8080/tienda_virtual/");
    const BASE_URL = "http://localhost:8080/tienda_virtual";

	
	//Zona horaria
	date_default_timezone_set('America/Costa_Rica');

    	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "db_tiendavirtual";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "charset=utf8";

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "$";
	const CURRENCY = "USD";


//Datos envio de correo
const NOMBRE_REMITENTE = "Tienda Virtual";
const EMAIL_REMITENTE = "no-reply@abelosh.com";
const NOMBRE_EMPESA = "Tienda Virtual";
const WEB_EMPRESA = "www.abelosh.com";

const DESCRIPCION = "La mejor tienda en línea con artículos de moda.";
const SHAREDHASH = "TiendaVirtual";



const CAT_SLIDER = "1,2,3";
const CAT_BANNER = "1,2,3";



?>