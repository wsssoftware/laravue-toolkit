<?php

namespace Laravue\Tests\Unit;

use Laravue\Tests\BaseTest;
use Laravue\Utility\Text;

class TextTest extends BaseTest
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_basic_list_check()
    {
        $text = new Text();
        $list = ['a', 'b', 'c'];
        $expected = 'a, b e c';
        $actual = $text->toList($list);
        $this->assertEquals($expected, $actual);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_check_with_custom_and()
    {
        $text = new Text();
        $list = ['a', 'b', 'c'];
        $expected = 'a, b aoao c';
        $actual = $text->toList($list, ['and' => 'aoao']);
        $this->assertEquals($expected, $actual);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_check_with_custom_separator()
    {
        $text = new Text();
        $list = ['a', 'b', 'c'];
        $expected = 'a. b e c';
        $actual = $text->toList($list, ['separator' => '. ']);
        $this->assertEquals($expected, $actual);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_check_with_custom_wrapped()
    {
        $text = new Text();
        $list = ['a', 'b', 'c'];
        $expected = '"a", "b" e "c"';
        $actual = $text->toList($list, ['involve' => '"']);
        $this->assertEquals($expected, $actual);
    }
}
