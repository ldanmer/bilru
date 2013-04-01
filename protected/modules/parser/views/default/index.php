<?php 
// Find all images
		foreach($html->find('a') as $element)
       echo $element->src . '<br>';

 ?>