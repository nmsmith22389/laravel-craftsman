<?php

namespace App\Commands;

use Illuminate\Support\Str;
use App\CraftsmanFileSystem;
use App\Traits\CommandDebugTrait;
use Illuminate\Support\Facades\Artisan;
use LaravelZero\Framework\Commands\Command;
use Codedungeon\PHPMessenger\Facades\Messenger;

class CraftAll extends Command
{
    use CommandDebugTrait;

    protected $fs;

    protected $signature = 'craft:all
                                {name : Base Entity used by rest of commands}
                                {--m|model= : Associated model}
                                {--t|tablename= : Associated database tablename}
                                {--f|fields= : List of fields used in migration}
                                {--r|rows= : Number of rows created by migration command}
                                {--x|extends= : Views extend block}
                                {--u|resource : Create resource controller}
                                {--l|collection : Create resource collection}
                                {--i|section= : Views section block}

                                {--c|no-controller : Skip crafting controller}
                                {--a|no-factory : Skip crafting factory}
                                {--g|no-migration : Skip crafting migration}
                                {--o|no-model : Skip crafting model}
                                {--s|no-seed : Skip crafting seed}
                                {--e|no-views : Skip crafting resource views}

                                {--w|overwrite : Overwrite existing files}
                            ';

    protected $description = 'Craft All Assets (controller, factory, migration, model, seed, test, views)';

    protected $help = 'Craft All Assets
                     <name>               Base Asset Name
                     --model, -m          Path to model [default: app/]
                     --tablename, -t      Database Tablename
                                           Note: uses --tablename here to remove conflict with other commands
                     --fields, -f         Field List (passed to migration)
                                           eg. --fields "first_name:string,20^nullable^unique, last_name:string,20"
                     --rows, -r           Number of rows for migration [default: 1] (passed to seeder)
                     --extends, -x        View extends block (optional)
                     --section, -i        View section block (optional)
                     --resource, -o       Create resource controller
                     --collection, -l     Create resource collection

                     --no-controller, -c  Do not create controller
                     --no-factory, -f     Do not create factory
                     --no-migration, -g   Do not create migration
                     --no-model, -o       Do not create model
                     --no-seed, -s        Do not create seed
                     --no-views, -e       Do not create resource views

                     --overwrite, -w      Overwrite existing files (WARNING: This can\'t be undone)
            ';

    public function __construct()
    {
        parent::__construct();

        $this->setHelp($this->help);

        $this->fs = new CraftsmanFileSystem();
    }

    public function handle()
    {
        $this->handleDebug();

        // argument
        $name = $this->argument('name');

        // require value
        $model = $this->option('model');
        $tablename = $this->option('tablename');
        $rows = $this->option('rows');
        $fields = $this->option('fields');
        $extends = $this->option('extends');
        $section = $this->option('section');

        // boolean options
        $overwrite = $this->option('overwrite') ? '--overwrite' : '';
        $resource = $this->option('resource') ? '--resource' : '';
        $collection = $this->option('collection') ? '--collection' : '';

        // grab any options to skip assets
        $noController = $this->option('no-controller');
        $noFactory = $this->option('no-factory');
        $noMigration = $this->option('no-migration');
        $noModel = $this->option('no-model');
        $noSeed = $this->option('no-seed');
        $noViews = $this->option('no-views');

        if (strlen($tablename) === 0) {
            $tablename = Str::plural(strtolower($name));
        }
        $this->info("\n");

        if (!$noController) {
            if ($resource) {
                Artisan::call("craft:resource {$name} {$collection} {$overwrite}");
            } else {
                Artisan::call("craft:controller {$name}Controller --model {$model} {$overwrite}");
            }
        } else {
            Messenger::info("▶︎ Controller crafting skipped\n");
        }

        if (!$noFactory) {
            Artisan::call("craft:factory {$name}Factory --model {$model} {$overwrite}");
        } else {
            Messenger::info("▶︎ Factory crafting skipped\n");
        }

        if (!$noMigration) {
            Artisan::call("craft:migration create_{$tablename}_table --model {$model} --table {$tablename} --fields {$fields} {$overwrite}");
        } else {
            Messenger::info("▶︎ Migration crafting skipped\n");
        }

        if (!$noModel) {
            Artisan::call("craft:model {$model} --table {$tablename} {$overwrite}");
        } else {
            Messenger::info("▶︎ Model crafting skipped\n");
        }

        if (!$noSeed) {
            Artisan::call("craft:seed {$name}sTableSeeder --model {$model} --rows {$rows} {$overwrite}");
        } else {
            Messenger::info("▶︎ Seed crafting skipped\n");
        }

        if (!$noViews) {
            Artisan::call("craft:views {$tablename} --extends {$extends} --section {$section} {$overwrite}");
        } else {
            Messenger::info("▶︎ Seed crafting skipped\n");
        }

        $skipAll = false;
        if ($noController && $noFactory && $noMigration && $noModel && $noSeed) {
            $skipAll = true;
        } else {
            Messenger::warning("\nNOTES: The following tasks need to be completed manually:\n");
        }

        if (!$noFactory) {
            Messenger::warning("       ⚈  Complete {$name} factory configuration");
        }

        if (!$noMigration) {
            Messenger::warning("       ⚈  Complete {$name} migrations");
        }

        if (!$noSeed) {
            Messenger::warning("       ⚈  Update 'database/seeds/DatabaseSeed.php' to call {$name}sTableSeeder");
            Messenger::warning("       ⚈  Run 'composer dump-autoload' after you have completed above steps");
        }

        Messenger::info("\n================================================================================\n");

        if ($skipAll) {
            Messenger::warning("You skipped all assets, nothing created", "WARNING");
        } else {
            Messenger::info("Asset Crafting Complete", "COMPLETE");
        }
    }
}
