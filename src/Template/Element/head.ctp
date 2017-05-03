<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
    <?= $this->fetch('title') ?>
</title>

<?php
echo $this->Html->meta('icon');

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');


echo $this->Html->charset();
echo $this->Html->css('base.css');
//echo $this->Html->css('cake.css');

echo $this->Html->css('//api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.css');
echo $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
echo $this->Html->css('//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
echo $this->Html->css('map');

echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
echo $this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
echo $this->Html->script('https://api.tiles.mapbox.com/mapbox.js/v2.1.4/mapbox.js');
?>