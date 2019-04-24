<?php

namespace App\Commands;

use App\CraftsmanFileSystem;
use LaravelZero\Framework\Commands\Command;

/**
 * Class CraftController
 * @package App\Commands
 */
class CraftResource extends Command
{
    protected $fs;

    protected $signature = 'craft:resource {name : Resource Name} 
                                {--w|overwrite : Overwrite existing controller} 
                                {--c|collection : Create resource collection} 
                                {--t|template= : Template path (override configuration file)} 
                           ';

    protected $description = "Craft Resource";

    protected $help = 'Craft Resource
                     <name>               Controller Name
                     --collection, -c     Use resource collection
                     --template, -t       Template path (override configuration file)
                     --overwrite, -w      Overwrite existing controller
            ';

    public function __construct()
    {
        parent::__construct();

        $this->fs = new CraftsmanFileSystem();

        $this->setHelp($this->help);
    }

    public function handle()
    {
        $controllerName = $this->argument('name');

        $data = [
            "name" => $controllerName,
            "template" => $this->option('template'),
            "overwrite" => $this->option('overwrite'),
            "collection" => $this->option('collection'),
        ];

        $this->fs->createFile('resource-controller', $controllerName, $data);
    }
}