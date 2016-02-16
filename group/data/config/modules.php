<?php

$application->registerModules(array(
    'admin' => array(
        'className' => 'Apps\Admin\Module',
        'path' => APP_PATH.'/apps/admin/Module.php'
    ),
    'pc' => array(
        'className' => 'Apps\Pc\Module',
        'path' => APP_PATH.'/apps/pc/Module.php'
    ),
    'phone' => array(
        'className' => 'Apps\Phone\Module',
        'path' => APP_PATH.'/apps/phone/Module.php'
    )
));

