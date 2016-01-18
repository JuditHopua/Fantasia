<?php

$html = '<option value=”” disabled selected>Seleccione marca...</option>';
$conexion = new mysqli('localhost', 'root', '', 'fantasia');
$id_modelo = $_POST['id_modelo'];
$marcas = $conexion->query("SELECT ma.nombre, ma.id	FROM asignacionmarcamodelo a, marca ma
						WHERE ma.id=a.marca_id and a.modelo_id=".$id_modelo." ORDER BY ma.nombre ASC"); 	
if ($marcas->num_rows > 0) {
	while ($row=$marcas->fetch_assoc()) {                
		$html .= '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
	}
}
echo $html;
?>