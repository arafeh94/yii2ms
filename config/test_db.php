<?php
$config = require __DIR__ . '/config.php';
// test database! Important not to run tests on production or development databases
$config['components']['db']['dsn'] = 'mysql:host=localhost;dbname=yii2_basic_tests';

return $config['components']['db'];
