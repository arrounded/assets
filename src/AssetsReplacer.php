<?php

/*
 * This file is part of Arrounded
 *
 * (c) Madewithlove <ehtnam6@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arrounded\Assets;

use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class AssetsReplacer
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var AssetsHandler
     */
    protected $handler;

    /**
     * @var string
     */
    protected $matcher = '/({{|<\?=) *Assets[\.:]{1,2}(styles|scripts)\(["\'](.+)["\']\)(\|raw)? *(}}|\?>)/';

    /**
     * AssetsReplacer constructor.
     *
     * @param AssetsHandler        $handler
     * @param OutputInterface|null $output
     */
    public function __construct(AssetsHandler $handler, OutputInterface $output = null)
    {
        $this->handler = $handler;
        $this->output = $output ?: new NullOutput();
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Execute the command.
     *
     * @param string $folder
     */
    public function replaceInFolder($folder)
    {
        // List all views
        $finder = new Finder();
        $files = $finder->files()->in($folder)->getIterator();
        $files = array_keys(iterator_to_array($files));

        // Replace in views
        foreach ($files as $file) {
            $this->output->writeln('<comment>Replacing calls in '.basename($file).'</comment>');
            $contents = file_get_contents($file);
            $contents = $this->replaceIn($contents);
            file_put_contents($file, $contents);
        }
    }

    /**
     * @param string $contents
     *
     * @return string
     */
    public function replaceIn($contents)
    {
        return preg_replace_callback($this->matcher, [$this, 'replaceAssetsCalls'], $contents);
    }

    /**
     * Replace Assets calls in views.
     *
     * @param array $matches
     *
     * @return string
     */
    protected function replaceAssetsCalls($matches)
    {
        list(, , $type, $container) = $matches;

        return $this->handler->$type($container);
    }
}
