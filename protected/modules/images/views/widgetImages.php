<div class="image_carousel">
	<div class="carusel">
		<?php
		foreach($this->images as $image)
		{
			if($this->withMain && $image['is_main'] || !$this->withMain && !$image['is_main'] || !$image['is_main'])
			{

				$imgTag = CHtml::image(Images::getThumbUrl($image, 150, 100), Images::getAlt($image));
				echo CHtml::link($imgTag, Images::getFullSizeUrl($image), array(
					'rel' => 'fancybox',
					'title' => Images::getAlt($image),
					));
			}
		}
		?>
	</div>
</div>