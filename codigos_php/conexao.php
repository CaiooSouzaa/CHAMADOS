<?php

function conexao($sql){
	$host = "localhost";
	$root = "root";
	$nomeBanco = "chamados_ite";
	$senha = "";

	$conexao = new mysqli($host, $root, $senha, $nomeBanco);
	
	if($conexao->connect_error){
		die("A conexao falhou " . $conexao->error);
	}	

	$resultado = $conexao->query($sql);

	if($resultado == false){
		echo "Conexao valida";	
	}
	


	$conexao->close();

	return $resultado;

}