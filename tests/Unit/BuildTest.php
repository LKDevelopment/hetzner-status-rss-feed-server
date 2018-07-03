<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 03.07.18
 * Time: 20:54
 */

namespace Tests\Unit;

use App\Model\App\Build;
use Illuminate\Database\Concerns\ManagesTransactions;
use Tests\TestCase;

/**
 *
 */
class BuildTest extends TestCase
{
    use ManagesTransactions;
    /**
     *
     */
    public function testCreateNewBuildNumber(){
       $tmp =  Build::generateNewBuildNumberFor('1.0.0');
       $this->assertEquals($tmp,'100001');
    }

    /**
     *
     */
    public function testCreateNewBuildWhenOtherBuildAlreadyExistsNumber(){
        Build::generateNewBuildNumberFor('2.0.0');
        $tmp =  Build::generateNewBuildNumberFor('2.0.0');
        $this->assertEquals($tmp,'200002');
    }

    /**
     *
     */
    public function testCreateNewBuildWhenOtherBuildAlreadyExistsNumberWithMinorVersion(){
        Build::generateNewBuildNumberFor('2.3.54');
        $tmp =  Build::generateNewBuildNumberFor('2.3.54');
        $this->assertEquals($tmp,'2003542');
    }
}
