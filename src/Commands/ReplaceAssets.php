<?php
namespace Arrounded\Assets\Commands;

use Arrounded\Assets\AssetsReplacer;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class ReplaceAssets extends Command
{
    /**
     * The console command name.
     *
     * @type string
     */
    protected $name = 'assets:replace';

    /**
     * The console command description.
     *
     * @type string
     */
    protected $description = 'Replace calls to assets collections in the files with their minified version';

    /**
     * @type AssetsReplacer
     */
    protected $replacer;

    /**
     * @param AssetsReplacer $replacer
     */
    public function __construct(AssetsReplacer $replacer)
    {
        parent::__construct();

        $this->replacer = $replacer;
        $this->replacer->setOutput($this->output);
    }

    /**
     * Execute the command.
     */
    public function fire()
    {
        $views = app_path('views');
        $this->replacer->replaceInFolder($views);
    }
}
