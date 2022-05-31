<?php

$arqSenhas="senhas.php";
$arqLogin="login.html";
$arqEmprestarLivro = "emprestarLivro.php";
$arqFazTudo = "fazTudo.php";
$arqSenhasAdmin="senhas_admin.php";
$tabLivros="livros";
$admin = 0;
$funcionario = 1;

require_once("$arqSenhasAdmin");

$usuarioDigitado = $_POST['usuario_login'];
$senhaDigitada = $_POST['senha_login'];
$servidor = 'localhost';
$bd = 'fatec';

if ($usuarioDigitado == "" or $senhaDigitada == ""){
	header("Location: $arqLogin");
	}
else
	{
	$conexão = new mysqli($servidor, $usuario, $senha, $bd);
	if ($conexão->connect_error) die($conexão->connect_error);
		$consulta = "SELECT * FROM usuarios WHERE login='$usuarioDigitado'  AND senha = '$senhaDigitada' LIMIT 1";
		$resultado = $conexão->query($consulta);
	if (!$resultado) 
		die ("Erro de acesso à base de dados: " . $conexão->error);
	if (empty($resultado->data_seek(0)))
		header("Location: $arqLogin");
	else
		{
		$nivel = $resultado->fetch_assoc()['nivel'];
		
	if ($nivel == $admin)
			header("Location: $arqFazTudo");
	else if ($nivel == $funcionario) 
			header("Location: $arqEmprestarLivro");
			//{$arqFazTudo = $arqEmprestarLivro;	mostraLivros($tabLivros, $arqEmprestarLivro, $conexão);}
	else header("Location: $arqLogin");
		}
	}
	$resultado->close();
	$conexão->close();
	
function mostraLivros($tabLivros, $arqFazTudo, $conexão){
		//  ************* Mostrar os livros existentes *************
		$query= "SELECT * FROM $tabLivros";
		$resultado = $conexão->query($query);
		if (!$resultado) die ("Erro de acesso à base de dados: " . $conexão->error);
		
		$linhas = $resultado->num_rows;
		echo "<br>";
		echo "Lista de livros:";
		echo "<br>";
		$_novoId=0;
		for ($j = 0 ; $j < $linhas ; ++$j)
		{
		$resultado->data_seek($j);
		$linha = $resultado->fetch_array(MYSQLI_NUM);
		echo <<<_TEXTO
		<pre>

		Autor	$linha[0]
		Título	$linha[1]
		Área	$linha[2]
		Ano	    $linha[3]
		Tombo	$linha[4]
		</pre>

		<form name = "emprestar" action="$arqFazTudo" method="post">
		<input type="hidden" name="Tombo" value="$linha[4]">
		<input type="submit" value="Emprestar"></form>
_TEXTO;
		}
		
header("Location: $arqFazTudo");

}

?>