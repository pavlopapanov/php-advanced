<?php

namespace App\Commands\Migrations;

use App\Commands\Contract\Command;
use Cli;
use Exception;
use PDO;
use PDOException;

class Down implements Command
{
    public const string MIGRATIONS_DIR = BASE_DIR . "/migrations";

    public function __construct(public Cli $cli, public array $args = [])
    {
    }

    public function handle(): void
    {
        try {
            db()->beginTransaction();
            $this->cli->info('The rollback database migration process has started...');
            $this->downMigrations();
            db()->commit();
            $this->cli->success('The rollback database migration process has ended...');
        } catch (PDOException $exception) {
            if (db()->inTransaction()) {
                db()->rollBack();
            }
            $this->cli->fatal($exception->getMessage());
        } catch (Exception $exception) {
            $this->cli->fatal($exception->getMessage());
        }
    }

    protected function downMigrations(): void
    {
        $this->cli->info("Down migration process...");
        $migrations = $this->retrieveHandledMigrations();

        if (!empty($migrations)) {
            foreach ($migrations as $migration) {
                $name = preg_replace('/[\d]+_/', '', $migration);
                $this->cli->notice("- rollback $name migration");

                $script = $this->getScript($migration);

                if (empty($script)) {
                    $this->cli->fatal("An empty script!");
                    die;
                }
                $query = db()->prepare($script);

                if ($query->execute()) {
                    $this->removeMigrationRecord($migration);
                    $this->cli->success(" - rollback $name done!");
                }
            }
        } else {
            $this->cli->info("No migrations were found!");
        }
    }

    protected function removeMigrationRecord(string $migration): void
    {
        $query = db()->prepare("DELETE FROM migrations WHERE name = :name");
        $query->bindParam('name', $migration);
        $query->execute();
    }

    protected function getScript(string $migrationPath): string
    {
        $obj = null;
        $obj = require static::MIGRATIONS_DIR . "/$migrationPath";
        return $obj?->down() ?? '';
    }

    protected function retrieveHandledMigrations(): array
    {
        $query = db()->prepare("SELECT name FROM migrations ORDER BY id DESC");
        $query->execute();

        return array_map(fn($item) => $item['name'], $query->fetchAll());
    }
}
