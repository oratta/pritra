<?php

namespace Tests\Unit\Model\UserData;

use App\Model\Master\MenuMaster;
use App\Model\UserData\WorkoutSet;
use Tests\SeedingDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkoutSetTest extends TestCase
{
    use RefreshDatabase;
    use SeedingDatabase;

   public function testGetNextLevel()
   {
       $userId = 1;
       $menuId = 1;
       $firstStepMasterId = MenuMaster::getFirstStepMasterId($menuId);
       //ワークアウトが初期値の時
       $workoutSet = new WorkoutSet(
           [
               'user_id' => $userId,
               'menu_master_id' => $menuId,
               'min_step_master_id' => $firstStepMasterId,
               'min_rep_count' => 0,
               'end_time' => now(),
               'start_time' => now(),
               'set_count' => 0,
               'level' => 0,
               'step_level' => 0
           ]
       );

       $nextLevel = $workoutSet->getNextLevel();

       $this->assertEquals($firstStepMasterId, $nextLevel->min_step_master_id);
       $this->assertEquals(1, $nextLevel->level);
       $this->assertEquals($firstStepMasterId*100+1, $nextLevel->step_level);
       $this->assertEquals($nextLevel->step->level1_rep_count, $nextLevel->min_rep_count);
       $this->assertEquals($nextLevel->step->level1_set_count, $nextLevel->set_count);
   }
}
