<?php

/*
 * This file is part of Arrounded
 *
 * (c) Madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arrounded\Assets\Commands;

use Arrounded\Assets\AssetsReplacer;
use Illuminate\Console\Command;

class ReplaceAssets extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'assets:replace';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace calls to assets collections in the files with their minified version';

    /**
     * @var AssetsReplacer
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
