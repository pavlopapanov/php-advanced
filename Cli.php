<?php

const BASE_DIR = __DIR__;
require_once BASE_DIR . '/vendor/autoload.php';

use Dotenv\Dotenv;
use \splitbrain\phpcli\CLI as BaseCli;
use \splitbrain\phpcli\Options;

class Cli extends BaseCli
{
    public const string COMMANDS_PATH = BASE_DIR . '/Core/commands.php';

    protected function setup(Options $options)
    {
        $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
        $dotenv->load();

        $commands = require_once static::COMMANDS_PATH;

        for ($i = 0; $i < count($commands); $i++) {
            $options->registerCommand($commands[$i]['command'], $commands[$i]['description'] ?? '');

            if (!empty($commands[$i]['arguments'])) {
                foreach ($commands[$i]['arguments'] as $argument) {
                    $options->registerArgument(
                        $argument['name'],
                        $argument['description'] ?? '',
                        $argument['required'] ?? false,
                        $commands[$i]['command']
                    );
                }
            }
        }
    }

    protected function main(Options $options)
    {
        echo $options->help();
    }
}

$cli = new Cli();
$cli->run();