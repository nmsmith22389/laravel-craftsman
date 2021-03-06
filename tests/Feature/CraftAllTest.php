<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\TestHelpersTrait;
use App\CraftsmanFileSystem;

/**
 * Class CraftAllTest
 * @package Tests\Feature
 */
class CraftAllTest extends TestCase
{
    use TestHelpersTrait;

    /**
     * @var CraftsmanFileSystem
     */
    protected $fs;

    /**
     *
     */
    function setUp(): void
    {
        parent::setUp();

        $this->fs = new CraftsmanFileSystem();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function should_execute_craft_all_command()
    {
        $this->artisan('craft:all Author --model App/Models/Author --tablename authors --rows 44')
            ->assertExitCode(0);

        $this->fs->rmdir("app/Http");
        $this->fs->rmdir("app/Models");
        $this->fs->rmdir("app/Test");
        $this->fs->rmdir("resources/views/posts");
        $this->fs->rmdir("database");
    }
}
