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

class AssetsReplacerTest extends AssetsTestCase
{
    /**
     * @var AssetsHandler
     */
    protected $assets;

    public function setUp()
    {
        $this->assets = new AssetsHandler([
            'global' => [
                'css' => [
                    'foo.css',
                    'bar.css',
                ],
                'js' => [
                    'foo.js',
                    'bar.js',
                ],
            ],
        ]);
    }

    public function testCanReplaceCallsInTwigViews()
    {
        $replacer = new AssetsReplacer($this->assets);

        $twig = file_get_contents(__DIR__.'/../views/foo.twig');
        $replaced = $replacer->replaceIn($twig);
        $matcher = <<<EOF
<!-- build:css builds/css/global.css -->
<link rel="stylesheet" href="foo.css">
<link rel="stylesheet" href="bar.css">
<!-- endbuild -->
<!-- build:css builds/css/global.css -->
<link rel="stylesheet" href="foo.css">
<link rel="stylesheet" href="bar.css">
<!-- endbuild -->

<!-- build:js builds/js/global.js -->
<script src="foo.js"></script>
<script src="bar.js"></script>
<!-- endbuild -->

EOF;

        $this->assertEquals($matcher, $replaced);
    }

    public function testCanReplaceCallsInBladeViews()
    {
        $replacer = new AssetsReplacer($this->assets);

        $twig = file_get_contents(__DIR__.'/../views/bar.blade.php');
        $replaced = $replacer->replaceIn($twig);
        $matcher = <<<EOF
<!-- build:css builds/css/global.css -->
<link rel="stylesheet" href="foo.css">
<link rel="stylesheet" href="bar.css">
<!-- endbuild -->

<!-- build:js builds/js/global.js -->
<script src="foo.js"></script>
<script src="bar.js"></script>
<!-- endbuild -->

EOF;

        $this->assertEquals($matcher, $replaced);
    }

    public function testCanReplaceCallsInPhpViews()
    {
        $replacer = new AssetsReplacer($this->assets);

        $twig = file_get_contents(__DIR__.'/../views/baz.php');
        $replaced = $replacer->replaceIn($twig);
        $matcher = <<<EOF
<!-- build:css builds/css/global.css -->
<link rel="stylesheet" href="foo.css">
<link rel="stylesheet" href="bar.css">
<!-- endbuild -->

<!-- build:js builds/js/global.js -->
<script src="foo.js"></script>
<script src="bar.js"></script>
<!-- endbuild -->

EOF;

        $this->assertEquals($matcher, $replaced);
    }
}
