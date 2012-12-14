<?php

/**
* Map the classes with the autoloader.
*/

Autoloader::map(array(
    'Presentable'           => Bundle::path('presentable') . 'presentable.php',
    'PresentableCollection' => Bundle::path('presentable') . 'presentablecollection.php',
));