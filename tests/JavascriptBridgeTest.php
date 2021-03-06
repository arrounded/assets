<?php

/*
 * This file is part of Arrounded
 *
 * (c) Madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Arrounded\Assets;

use Illuminate\Support\Fluent;

class JavascriptBridgeTest extends AssetsTestCase
{
    public function setUp()
    {
        JavascriptBridge::purge();
    }

    public function testCanAddData()
    {
        JavascriptBridge::add(['foo' => 'bar']);
        JavascriptBridge::add(['baz' => 'qux']);

        $data = JavascriptBridge::getData();
        $this->assertEquals(['foo' => 'bar', 'baz' => 'qux'], $data);
    }

    public function testCanPurgeData()
    {
        JavascriptBridge::add(['foo' => 'bar']);
        JavascriptBridge::purge();

        $this->assertEmpty(JavascriptBridge::getData());
    }

    public function testCanRenderComplexStructures()
    {
        JavascriptBridge::add([
            'foo' => [
                ['foo' => 'bar'],
            ],
            'baz' => 'qux',
        ]);

        $rendered = JavascriptBridge::render();
        $matcher = <<<EOF
\tvar foo = [{"foo":"bar"}];
\tvar baz = "qux";

EOF;

        $this->assertEquals($matcher, $rendered);
    }

    public function testCanRenderJsonableEntities()
    {
        $model = new Fluent(['foo' => 'bar']);
        JavascriptBridge::add(['model' => $model]);

        $rendered = JavascriptBridge::render();
        $matcher = <<<EOF
\tvar model = {"foo":"bar"};

EOF;

        $this->assertEquals($matcher, $rendered);
    }

    public function testCanNamespaceVariables()
    {
        JavascriptBridge::setNamespace('Arrounded');
        JavascriptBridge::add(['foo' => 'bar']);

        $rendered = JavascriptBridge::render();
        $matcher = <<<EOF
\tvar Arrounded = {};
\tArrounded.foo = "bar";

EOF;

        $this->assertEquals($matcher, $rendered);
    }
}
