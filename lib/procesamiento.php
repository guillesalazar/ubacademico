<?php
	include('../lib/conexion.php');

	function nombreMateria($id){
		include('../lib/conexion.php');

		$query = "SELECT des_mat FROM materias WHERE cod_mat = '$id'";
		$rs = mysql_fetch_array(mysql_query($query));
		return $rs["des_mat"];
	}
	
	$dato = $_GET['dato'];
	$tabla = $_GET['tabla'];
	$cond = $_GET['cond'];
	$busqueda = $_GET['busqueda'];
	$caracter   = ',';

	$pos = strpos($busqueda, $caracter);

	$query = "SELECT DISTINCT $busqueda FROM $tabla WHERE $cond = '$dato'";

	$query_count = "SELECT COUNT($busqueda) FROM $tabla WHERE $cond = '$dato'"; 

	if(isset($_GET['lapso'])){
		$query.= " AND lapso=".$_GET['lapso'];
	}

	if(isset($_GET['ced_prof'])){
		$query.= " AND CED_PROF=".$_GET['ced_prof'];
	}

	if(isset($_GET['sec_mat'])){
		$query.= " AND sec_mat=".$_GET['sec_mat'];
	}

	if(isset($_GET['cod_esc'])){
		$query_count.= " AND cod_esc=".$_GET['cod_esc'];
	}

	if(isset($_GET['cod_mat'])){
		$query_count.= " AND cod_mat=".$_GET['cod_mat'];
	}


	$resultado = mysql_query($query) or die(mysql_error());
	if($resultado){
		if(isset($_GET['multiple'])){ ?>

                    <option value ="">Seleccionar...</option>
                    <?php  while($row = mysql_fetch_assoc($resultado)): ?>

    	                <?php if ($pos != false) : ?>
    
							<?php $partes = explode($caracter, $busqueda); ?>

	                    	<option value="<?php echo $row[$partes[0]]?>"><?php echo $row[$partes[1]] ?> </option>
	                    
	                    <?php else: ?>

	                    	<?php if($busqueda == 'cod_mat'): ?>

	                    		<option value="<?php echo $row[$busqueda]?>"><?php echo utf8_encode($row[$busqueda].' - '.nombreMateria($row[$busqueda])); ?></option>

	                   		<?php elseif($busqueda == 'cod_catedra'): ?>

	                    		<option value="<?php echo $row[$busqueda]?>"><?php echo utf8_encode($row[$busqueda].' - '.nombreCatedra($row[$busqueda])); ?></option>

	                    	<?php elseif($busqueda == 'cod_escu'): ?>

	                    		<option value="<?php echo $row[$busqueda]?>"><?php echo utf8_encode(nombreEscuela($row[$busqueda])); ?></option>                                 

	                    	<?php else: ?>

	                    	<option value="<?php echo $row[$busqueda]?>"><?php echo utf8_encode($row[$busqueda]) ?></option>
	                    <?php endif; ?>
                    	
                    	<?php endif; ?>

                    <?php endwhile ?>
		<?php
		}else{
			$row = mysql_fetch_array($resultado);
			echo utf8_encode($row[$busqueda]);	
		}
	}