<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->initDatabaseMaps(array (
  'default' => 
  array (
    0 => '\\Model\\Map\\CommentTableMap',
    1 => '\\Model\\Map\\PostTableMap',
    2 => '\\Model\\Map\\ThreadTableMap',
    3 => '\\Model\\Map\\UserTableMap',
  ),
));
