<?php

declare(strict_types=1);

namespace CodeIgniter\Country\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\AdminCI\Commands\Setup\ContentReplacer;
use CodeIgniter\Test\Filters\CITestStreamFilter;
use Config\Autoload as AutoloadConfig;
use Config\Services;

class Setup extends BaseCommand
{
    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'country:setup';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Initial setup for Country List.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'country:setup';

    /**
     * the Command's Arguments
     *
     * @var array<string, string>
     */
    protected $arguments = [];

    /**
     * the Command's Options
     *
     * @var array<string, string>
     */
    protected $options = [
        '-f' => 'Force overwrite ALL existing files in destination.',
    ];

    /**
     * The path to `domProjects\CI-Country\` src directory.
     *
     * @var string
     */
    protected $sourcePath;

    protected $distPath = APPPATH;
    private ContentReplacer $replacer;

    /**
     * Displays the help for the spark cli script itself.
     */
    public function run(array $params): void
    {
        $this->replacer = new ContentReplacer();

        $this->sourcePath = __DIR__ . '/../';

        $this->publishConfig();
    }

    private function publishConfig(): void
    {
        $this->setAutoloadHelpers();
    }

    /**
     * Replace for setupHelper()
     *
     * @param string $file     Relative file path like 'Controllers/BaseController.php'.
     * @param array  $replaces [search => replace]
     */
    private function replace(string $file, array $replaces): bool
    {
        $path      = $this->distPath . $file;
        $cleanPath = clean_path($path);

        $content = file_get_contents($path);

        $output = $this->replacer->replace($content, $replaces);

        if ($output === $content) {
            return false;
        }

        if (write_file($path, $output)) {
            $this->write(CLI::color('  Updated: ', 'green') . $cleanPath);

            return true;
        }

        $this->error("  Error updating {$cleanPath}.");

        return false;
    }

    private function setAutoloadHelpers(): void
    {
        $file = 'Config/Autoload.php';

        $path      = $this->distPath . $file;
        $cleanPath = clean_path($path);

        $config     = new AutoloadConfig();
        $helpers    = $config->helpers;
        $newHelpers = array_unique(array_merge($helpers, ['hello']));

        $pattern = '/^    public \$helpers = \[.*\];/mu';
        $replace = '    public $helpers = [\'' . implode("', '", $newHelpers) . '\'];';
        $content = file_get_contents($path);
        $output  = preg_replace($pattern, $replace, $content);

        // check if the content is updated
        if ($output === $content) {
            $this->write(CLI::color('  Autoload Setup: ', 'green') . 'Everything is fine.');

            return;
        }

        if (write_file($path, $output)) {
            $this->write(CLI::color('  Updated: ', 'green') . $cleanPath);

            $this->removeHelperLoadingInBaseController();
        } else {
            $this->error("  Error updating file '{$cleanPath}'.");
        }
    }

    private function removeHelperLoadingInBaseController(): void
    {
        $file = 'Controllers/BaseController.php';

        $check = '        $this->helpers = array_merge($this->helpers, [\'setting\']);';

        // Replace old helper setup
        $replaces = [
            '$this->helpers = array_merge($this->helpers, [\'hello\']);' => $check,
        ];
        $this->replace($file, $replaces);

        // Remove helper setup
        $replaces = [
            "\n" . $check . "\n" => '',
        ];
        $this->replace($file, $replaces);
    }
}
