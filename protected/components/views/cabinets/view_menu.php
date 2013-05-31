<?php 
$items = array(
  array(
    'name'=>'Найти заказ',
    'link'=>array('/materialBuy/search'),
    'icon' => 'search',
    'sub'=>array(
      array('name'=>'Строительные материалы', 'link'=>array('/materialBuy/search')),
      array('name'=>'Отделочные материалы','link'=>array('/materialBuy/search')),
      array('name'=>'Инженерное оборудование','link'=>array('/materialBuy/search')),
      ),
    'visible'=>$role == 3,
    ),
  array(
    'name'=>'Найти подряд',
    'link'=>array('/orders/search'),
    'icon' => 'search',
    'visible'=>$role == 2,
    ),
  array(
    'name'=>'Найти подрядчика',
    'link'=>array('/orders/create'),
    'icon' => 'home',
    'sub'=>array(
      array('name'=>'Проектирование', 'link'=>array('/orders/create')),
      array('name'=>'Архитектура','link'=>array('/orders/create')),
      array('name'=>'Дизайн','link'=>array('/orders/create')),
      array('name'=>'Строительные компании','link'=>array('/orders/create')),
      array('name'=>'Бригады','link'=>array('/orders/create')),
      array('name'=>'Мастера','link'=>array('/orders/create')),
      ),
    ),
  array(
    'name'=>'Купить',
    'link'=>array('/materialBuy/create'),
    'icon'=>'shopping-cart',
    'sub'=>array(
      array('name'=>'Строительные материалы', 'link'=>array('/materialBuy/create')),
      array('name'=>'Отделочные материалы','link'=>array('/materialBuy/create')),
      array('name'=>'Инженерное оборудование','link'=>array('/materialBuy/create')),
      ),
    ),
  array(
    'name'=>'Форум',
    'link'=>'#',
    'icon'=>'question-sign',
    ),

  );
$this->widget('ext.menu.EMenu', array('items' => $items)); ?>

