<?php
/**
 * @link https://github.com/phpviet/laravel-validation
 *
 * @copyright (c) PHP Viet
 * @license [MIT](https://opensource.org/licenses/MIT)
 */

namespace PHPViet\Laravel\Validation\Tests\Rules;

use Illuminate\Support\Facades\Lang;
use PHPViet\Laravel\Validation\Rules\LandLineVN;
use PHPViet\Laravel\Validation\Tests\TestCase;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0.0
 */
class LandLineVNTest extends TestCase
{
    public function testValid()
    {
        $rule = new LandLineVN();
        $landLine = '02838574955';
        $this->assertTrue($rule->passes('attribute', $landLine));
        $this->assertTrue($rule('attribute', $landLine, null, null));

        $validLandLine = $this->app['validator']->validate([
            'landLine' => $landLine,
        ], [
            'landLine' => 'land_line_vn',
        ]);
        $this->assertEquals($landLine, array_shift($validLandLine));
    }

    public function testInvalid()
    {
        $rule = new LandLineVN();
        $landLine = '02838574955!@#';
        $this->assertFalse($rule->passes('attribute', $landLine));
        $this->assertFalse($rule('attribute', $landLine, null, null));
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->app['validator']->validate([
            'landLine' => $landLine,
        ], [
            'landLine' => 'land_line_vn',
        ]);
    }

    public function testCanTranslateErrorMessage()
    {
        Lang::setLocale('vi');
        $rule = new LandLineVN();
        $rule->passes('attribute', '02838574955!!!');
        $this->assertEquals(':attribute phải là số điện thoại bàn tại Việt Nam.', $rule->message());
    }
}
