﻿// *************************************************************************************************************************************************
//	Libreria de scripts de Javascript
// Autor: José Manuel Alonso (E.T.S.I.I.) Universidad de Sevilla

// Fecha Creación:2003-2004
// Fecha Última modificación: Marzo-2005
// Nombre del fichero: Apagar.js
// Descripción : 
//		Este fichero implementa las funciones javascript del fichero Apagar.php (Comandos)
// *************************************************************************************************************************************************
 function confirmar(){
	if (comprobar_datos()){
		var wurl="./gestores/gestor_Apagar.php?" +compone_urlejecucion();
		ifr=document.getElementById("iframes_comodin"); // Toma objeto Iframe
		ifr.src=wurl; // LLama a la página gestora
	}
 }
//________________________________________________________________________________________________________
  function cancelar(){
	alert(CTbMsg[0]);
	location.href="../nada.php"
  }
//________________________________________________________________________________________________________
  function comprobar_datos(){
		return(comprobar_datosejecucion())
}
//________________________________________________________________________________________________________
//	
//	Comprobar retorno
//________________________________________________________________________________________________________
function resultado_apagar(resul){
	if (!resul){
		alert(CTbMsg[1]);	
		return
	}
	alert(CTbMsg[2]);
}
