<?php
header('Content-Type: text/html; charset=utf-8');
$arqSenhas="senhas.php";
$arqSair="sair.php";
$arqRegistraEmprDevol="registraEmprDevol.php";

require_once("$arqSenhas");

echo <<<_TEXTO1
<form name = "emprestaDevolve" action="$arqRegistraEmprDevol" method="post">
	<fieldset>
		<legend>Registro de Empréstimo / Devolução:</legend>
		Usuario:	<input type="text" name="usuario"><br>
		<br>
		Tombo   :	<input type="text"name="tombo"><br>
		<br><br>
		Data Emprestimo: <input type="date" name="dataEmp">
		<br><br>		
		Data Devolução: <input type="date" name="dataDev">
		<br><br>		
		<input type = "submit" value="Registrar" onclick="alert('Registrando no BD')">
	</fieldset>
</form>
<br>
<form name = "Sair" action="$arqSair" method="post">
<input type="submit" value="Sair"></form>
_TEXTO1;
 
echo "<br>";

if (isset ($_POST['usuario'])
	&&
	isset ($_POST['tombo'])
	&&
	(isset (($_POST['dataEmp'])) or
	isset ($_POST['dataDev'])
	)
	)
{
$usr = $_POST['usuario'];
$tombo = $_POST['tombo'];
$dataEmp = $_POST['dataEmp'];
$dataDev = $_POST['dataDev'];


echo "registro incluído no BD:<br>";
echo "Usuário: $usr<br>";
echo "Tombo: $tombo<br>";
echo "Data Empréstimo: $dataEmp<br>";
echo "Data Devolução: $dataDev<br>";
}
?>
