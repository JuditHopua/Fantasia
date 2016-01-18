<?php
session_start();

$html = '';
$conexion = new mysqli('localhost', 'root', '', 'fantasia');
$id_modelo = $_POST['id_modelo'];
$id_marca = $_POST['id_marca'];
$datos = $conexion->query("SELECT a.id, a.precioPremarcoML, a.precioContramarcoML, a.precioxML FROM asignacionmarcamodelo a
						WHERE a.marca_id=".$id_marca." and a.modelo_id=".$id_modelo."");
$row=$datos->fetch_assoc();
$_SESSION['asignacion']=$row['id'];					
$html = '<thead>
          <tr>
			
			<th id="datosthtd">Precio metro lineal</th>
			<th id="datosthtd">Precio premarco</th>
            <th id="datosthtd">Precio contramarco</th>
         </tr>
			</thead>
			<tbody>
				<tr>
					
					<td id="datosthtd">$'.$row['precioxML'].'</td>
					<td id="datosthtd">$'.$row['precioPremarcoML'].'</td>
					<td id="datosthtd">$'.$row['precioContramarcoML'].'</td>
				</tr>
			</tbody>';
			

echo $html;
?>