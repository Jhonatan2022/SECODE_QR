<?php



session_start();
require_once '../models/database/database.php';
require_once '../models/user.php';
if (!isset($_SESSION["user_id"])) {
	header('Location: index.php');
}


function deleteQR($id, $path)
{global $connection;
	global $results;
	$query="SELECT qr.DatosClinicos, qr.FormularioMedicamentos, fr.ArchivoFormulaMedica FROM codigo_qr as qr 
	LEFT OUTER JOIN FormularioMedicamentos as fr 
	ON qr.FormularioMedicamentos = fr.IDFormularioMedicamentos
	WHERE qr.id_codigo = :id";
	$records = $connection->prepare($query);
	$records->bindParam(':id', $id);
	$records->execute();
	$resultsdta = $records->fetch(PDO::FETCH_ASSOC);

	if($resultsdta['DatosClinicos'] == null && $resultsdta['FormularioMedicamentos'] !== null){
		$records = $connection->prepare('DELETE FROM codigo_qr WHERE Id_codigo = :id');
		$records->bindParam(':id', $id);
		if($records->execute()) {
			$message = 1;
		} else {
			$message = 'error';
		}
		$records = $connection->prepare('DELETE FROM FormularioMedicamentos WHERE IDFormularioMedicamentos = :dta');
		$records->bindParam(':dta', $resultsdta['FormularioMedicamentos']);
		if ($records->execute() && unlink('../models/img/' . $resultsdta['ArchivoFormulaMedica']) ) {
			$message = 1;
		} else {
			$message = 'error';
		}

	}else{
		$records = $connection->prepare('DELETE FROM codigo_qr WHERE Id_codigo = :id');
		$records->bindParam(':id', $id);
		if ($records->execute()) {
			$message = 1;
		} else {
			$message = 'error';
		}
		$records = $connection->prepare('DELETE FROM datos_clinicos WHERE datos_clinicos.IDDatosClinicos = :dta');
		$records->bindParam(':dta', $resultsdta['DatosClinicos']);
		if ($records->execute()) {
			$message = 1;
		} else {
			$message = 'error';
		}
	}
	return $message;
}

function editarForm($idQr){
	global $connection;
	if (isset($_POST['QRatributo']) && getSuscription($_SESSION['user_id'])['EditarQR'] == 'SI') {
		$atrib = $_POST['QRatributo'];
	}elseif(!isset($_POST['QRatributo'])) {
		$query = "SELECT Atributo FROM codigo_qr WHERE Id_codigo = :id";
		$records = $connection->prepare($query);
		$records->bindParam(':id', $idQr);
		$records->execute();
		$res= $records->fetch(PDO::FETCH_ASSOC);
		$atrib = $res['Atributo'];
	}else {
		$atrib = '&centerImageUrl=https://programacion3luis.000webhostapp.com/secode/views/assets/img/logo.png&size=300&ecLevel=H&centerImageWidth=120&centerImageHeight=120';
	}
	$ti=ucfirst($_POST['Titulo']);
	$des=ucfirst( $_POST['Descripcion']);
	$query = "UPDATE codigo_qr SET Titulo = :titulo, Descripcion = :descripcion, Atributo = :atr WHERE Id_codigo = :id";
	$records = $connection->prepare($query);
	$records->bindParam(':titulo', $ti);
	$records->bindParam(':descripcion',$des);
	$records->bindParam(':atr', $atrib);
	$records->bindParam(':id', $idQr);
	if ($records->execute()) {
		$message = 'ok';
	} else {
		$message = 'error';
	}
	return $message;
}

if (isset($_POST['action'])) {
	$id = $_POST['id_code'];
	$path = $_POST['path'];
	switch ($_POST['action']) {
		case 'Eliminar':
			header('Location: '.'../views/dashboard.php'.'?ResponseQR='. deleteQR($id, $path));
			break;
		case 'Actualizar':
			header('Location: '.'../views/dashboard.php'.'?Editar='. editarForm($id));
			break;
		default:
			# code...
			break;
	}
}else{
	header('Location: ../views/dashboard.php');
}


?>