<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
	<?php // Renderer::printCss();?>
	<?php Renderer::printCompressedCss();?>
	<?php Renderer::printCssCode();?>
</head>
<body class="<?php global $info; echo $info["browserCss"]." ".$info["browserVersionCss"]; if(isset($data["bodyClass"]))echo" ".$data["bodyClass"];?>">
	<?php echo $data["render"];?>
	<?php // Renderer::printJs();?>
	<?php Renderer::printCompressedJs("google_compressor");?>
	<?php // Renderer::printCompressedJs();?>
	<?php Renderer::printJsCode();?>
</body>
</html>