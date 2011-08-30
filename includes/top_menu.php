	<?php $class = "class='first'"; ?>
	<div id="menu">
	 <ul>
	  <li ><a href="usexamen.php" <?php if ($curr_page == 'usexamen.php') echo $class; ?>>Catalog</a></li>
		<li><a href="ushistorial.php" <?php if ($curr_page == 'ushistorial.php') echo $class; ?>>My Progress</a></li>
		<li><a href="usacceso.php" <?php if ($curr_page == 'usacceso.php') echo $class; ?>>Settings</a></li>
	 </ul>
	</div>