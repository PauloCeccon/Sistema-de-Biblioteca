<?php
header('Content-Type: text/html; charset=utf-8');
$arqSenhas="senhas.php";
$arqRegistroEmprestimos = "RegistroDeEmprestimos.txt";
$arqPegaUsr = "pegaUsr.php";
$arqEmprestarLivro = "emprestarLivro.php";
$arqSair="sair.php";
$DateAndTime = date('d-m-Y h:i:s a', time());

require_once("$arqSenhas");

echo <<<_TEXTO1
<form name = "sair" action="$arqSair" method="post">
<input type="submit" value="Sair"></form>
_TEXTO1;

if ($_usuarioDigitado = '' or $senhaDigitada = '')
	header("Location: $arqPegaUsr");
else
{
	$tabLivros="livros";

	$conexão = new mysqli($servidor, $usuario, $senha, $bd);
	if ($conexão->connect_error) die($conexão->connect_error);

	$tombo = mostraLivros($tabLivros, $arqEmprestarLivro, $conexão);

	// $handle ---> modo a+: escrita; cursor no fim; o texto existente não é sobrescrito
	$handle = fopen("$arqRegistroEmprestimos","a+");

	if($tombo!=0) {
		echo "<br> Gravando em arquivo:<br>";
		echo "<br>------------------------------------------------------------------------------";
		
		fwrite($handle,">Livro: $tombo | Emprestado: $DateAndTime | Por: $usuario | \n");
		fclose($handle);

		echo "<br>";
		echo "O livro de tombo $tombo foi emprestado";
		echo "<br>------------------------------------------------------------------------------";
		echo "<br>";
	}

}

function mostraLivros($tabLivros, $arqRegistroEmprestimos, $conexão){
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

		ID	    $linha[0]
		Autor	$linha[1]
		Título	$linha[2]
		Área	$linha[3]
		Ano	    $linha[4]
		Tombo	$linha[5]
		</pre>

		<form name = "emprestar" action="$arqRegistroEmprestimos" method="post">
		<input type ="hidden" name="Tombo" value="$linha[5]">
		<input type ="submit" value="Emprestar"></form>
		---------------------------------------------------------------
_TEXTO;
		}
	if (isset ($_POST['Tombo'])) $tombo = $_POST['Tombo'];
		else $tombo = "0";
	return ($tombo);
}
?>
