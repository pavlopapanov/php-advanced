<?php

namespace App\Commands;

use App\Commands\Contract\Command;
use Cli;
use Database\Seeders\Seeder;
use PDOException;

class Seed implements Command
{

    public function __construct(public Cli $cli, public array $args = [])
    {
    }

    public function handle(): void
    {
        try {
            db()->beginTransaction();
            $this->cli->info("Seed process started..");

            $this->runSeeds();

            db()->commit();
            $this->cli->success("Seeding successful.");
        } catch (PDOException $exception) {
            if (db()->inTransaction()) {
                db()->rollback();
            }
            $this->cli->fatal($exception->getMessage());
        } catch (\Exception $exception) {
            $this->cli->fatal($exception->getMessage());
        }
    }

    protected function runSeeds(): void
    {
        if (!empty(Seeder::$seeds)) {
            foreach (Seeder::$seeds as $seedClass) {
                $seed = new $seedClass();
                $seed->run();
            }
        }
    }
}