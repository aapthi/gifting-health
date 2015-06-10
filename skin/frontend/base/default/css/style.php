
<?php 
$stylesheet = @is_file($_GET['stylesheet'])
 && strtolower(substr(strrchr($file_name,'.'),1)) == 'css' ? $_GET['stylesheet'] : 'custom.css';
 $font_1 = $_GET['font_1'];
 $font_2 = $_GET['font_2'];
 $font_3 = $_GET['font_3'];
 
 $font_weight_1 = $_GET['font_weight_1'];
 $font_weight_2 = $_GET['font_weight_2'];
 $font_weight_3 = $_GET['font_weight_3'];
 
 $font_style_1 = $_GET['font_style_1'];
 $font_style_2 = $_GET['font_style_2'];
 $font_style_3 = $_GET['font_style_3'];
 
 
header('Content-type: text/css');


echo $font_style_1;


$default = array(
  'font_1' => "$font_1",
  'font_2' => "$font_2",
  'font_3' => "$font_3",
  'font_weight_1' => "$font_weight_1",
  'font_weight_2' => "$font_weight_2",
  'font_weight_3' => "$font_weight_3",
  'font_style_1' => "$font_style_1",
  'font_style_2' => "$font_style_2",
  'font_style_3' => "$font_style_3"
);

//extract($_GET['theme'] && ${$_GET['theme']} ? ${$_GET['theme']} : $default);
 
/* load in the stylesheet */
$content = preg_replace('/\$([\w]+)/e','$0',@file_get_contents($stylesheet));

echo $content;
?>
	
