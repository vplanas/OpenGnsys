<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>Init menu for OpenGnsys clients</title>

	<style type="text/css">	
	body { background: #fff; font-size: 0.7em; }
	h1, h2 { font-size: 1.5em; }
	br {font-size: 0.2em; }
	a:link, a:visited { text-decoration: none; color:#900; font-weight: bold; }
	a:hover, a:active { color:#d90; }

	h1 {
		font-size: 1.5em;
		width: 100%;
		vertical-align: bottom;	
		color: #555;
		background: transparent url('images/opengnsys.png')  no-repeat top left;
		padding: 2em 0 1.5em 12em;
		margin-bottom: 1em;
	}

	dl {
		background: transparent url('images/xp_peque.png') no-repeat top left;
		padding: 0 0 1em 5em;
		margin: 2em 10em;
	}

	dl.windows {
		background-image: url('images/xp_peque.png');
	}

	dl.linux {
		background-image: url('images/linux_peque.png');
	}

	dl.apagar {
		background-image: url('images/poweroff.png');
	}

	dt { float: left;}
	dd { margin: 1em 10em 1em 20em; }

	div.admin {
		margin: 1em;
		float: right;
	}
	</style>

</head>

   <body>


	<h1>Option Menu</h1>
	<dl class="windows">
		<dt><a href="command:bootOs 1 1" title="Init session Windows, accesskey: 1" accesskey="1">Init session Windows.</a></dt>
			<dd>Normal boot Windows without changes.</dd>
		<dt><a href="command+confirm:restoreImage REPO windows 1 1" title="Format the disk and install the Windows operating system, accesskey: 2" accesskey="2">Install Windows.</a></dt>
			<dd>The installation process takes a few minutes.</dd>
	</dl>

	<dl class="linux">
		<dt><a href="command+output:bootOs 1 2" title="Init session GNU/Linux, accesskey: 3" accesskey="3">Init session GNU/Linux.</a></dt>
			<dd>Normal boot <acronym title="GNU's not Unix">GNU</acronym>/Linux without changes.</dd>
		<dt><a href="command+output+confirm:restoreImage REPO linux 1 2" title="Format the disk and install the GNU/Linux operating system GNU/Linux, accesskey: 4" accesskey="4">Install GNU/Linux.</a></dt>
			<dd>The installation process takes a few minutes.</dd>
	</dl>

	<dl class="apagar">
		<dt><a href="command:poweroff" title="Power-off, accesskey: 0" accesskey="0">Power-off.</a></dt>
			<dd>Power-off computer.</dd>
		<dt><a href="command:reboot" title="Reboot, accesskey: 6" accesskey="6">Reboot.</a></dt>
			<dd>Reboot computer.</dd>
	</dl>

<?php	// Access to private menu.
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
?>
	<div class="admin"><a href="../varios/acceso_operador.php?iph=<?php echo $ip ?>">Admin Menu</a></div>

   </body>
</html>
