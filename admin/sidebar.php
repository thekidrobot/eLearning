<?php if ($_SESSION['idusuario'] == 4){ ?>
<div id="sidebar">
<ul>
    <li>
        <h2>Menu</h2>
        <ul>
            <li class="current_page_item">
            <li><a href="admreporte.php">Reportes por Usuario</a></li>
             <li><a href="admreportevideo.php">Reportes por Video</a></li>
             <li><a href="reportes/index.php" target="_blank">Reportes para Excel</a></li>
            <li><a href="admacceso.php">Acceso</a></li>
			<li><a href="../index.php">Salir</a></li>
        </ul>
    </li>
</ul>
</div>
<!-- end #sidebar -->
<?
}
else
{
 ?>
<div id="sidebar">
<ul>
    <li>
        <h2>Menu</h2>
        <ul>
            <li class="current_page_item"><a href="admdeptos.php">Grupos de Usuarios</a></li>
             <li><a href="admusuarios.php">Usuarios</a></li>
            <li><a href="admCategorias.php">Categorias</a></li>
            <li><a href="reportes/index.php" target="_blank">Reportes para Excel</a></li>
            <li><a href="admreporte.php">Reportes Por Usuario</a></li>
             <li><a href="admreportevideo.php">Reportes Por Video</a></li>
            <li><a href="admacceso.php">Acceso</a></li>
            <li><a href="../apoyos/index.php">Archivos</a></li>
             <li><a href="../index.php">Salir</a></li>
        </ul>
    </li>
</ul>
</div>
<!-- end #sidebar -->

<?
}
?>
