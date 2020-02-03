<?php

return [

    /*
     |-----------------------------------------------------------------------------
     | Craftsman Paths
     |------------------------------------------------------------------------------
     |
     | This value determines the "paths" which will be used when crafting assets
     | In most cases, these are the sensible defaults used by Laravel.
     | You might want to adjust the `models` path to something like `app/Models`.
     */

    'paths' => [
        'class' => 'app',
        'controllers' => 'app/Http/Controllers',
        'commands' => 'app/Console/Commands',
        'events' => 'app/Events',
        'listeners' => 'app/Listeners',
        'resources' => 'app/Http/Resources',
        'factories' => 'database/factories',
        'migrations' => 'database/migrations',
        'models' => 'app',
        'requests' => 'app/Http/Requests',
        'seeds' => 'database/seeds',
        'templates' => 'templates',
        'tests' => 'tests',
        'views' => 'resources/views',
    ],

    /*
     |-----------------------------------------------------------------------------
     | Templates
     |------------------------------------------------------------------------------
     |
     | This value determines the default template paths for each asset
     | If you wish to override any of these templates, you should create them
     | in using the following naming convention `templates/class.mustache.user.php`
     | accordingly. You should not modify the default templates directly as they
     | will be overwritten during any updates..
     */

    'templates' => [
        'base' => 'templates',
        'class' => 'templates/class.mustache',
        'command' => 'templates/command.mustache',
        'api-controller' => 'templates/api-controller.mustache',
        'binding-controller' => 'templates/binding-controller.mustache',
        'empty-controller' => 'templates/empty-controller.mustache',
        'resource-controller' => 'templates/resource-controller.mustache',
        'controller' => 'templates/controller.mustache',
        'event' => 'templates/event.mustache',
        'listener' => 'templates/listeners.mustache',
        'factory' => 'templates/factory.mustache',
        'migration' => 'templates/migration.mustache',
        'model' => 'templates/model.mustache',
        'request' => 'templates/form-request.mustache',
        'seed' => 'templates/seed.mustache',
        'test' => 'templates/test.mustache',
        'view-create' => 'templates/view-create.mustache',
        'view-edit' => 'templates/view-edit.mustache',
        'view-index' => 'templates/view-index.mustache',
        'view-show' => 'templates/view-show.mustache',
    ],

    /*
     |-----------------------------------------------------------------------------
     | Miscellaneous
     |------------------------------------------------------------------------------
     |
     | Miscellaneous crafting options:
     | useCurrentDefault - determines how migrations define timestamps
     */

    "miscellaneous" => [
        "useCurrentDefault" => true,
    ],
];
