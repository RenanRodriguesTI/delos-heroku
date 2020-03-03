<?php

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Place;
    use Delos\Dgp\Entities\User;
    use Illuminate\Foundation\Testing\DatabaseTransactions;
    use Illuminate\Support\Facades\Auth;

    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 26/04/18
     * Time: 16:48
     */
    class ActivityServiceTest extends TestCase
    {
        use DatabaseTransactions;

        /**
         * After create activity, test if missing activity is removed
         */
        public function test_create_with_remove_missing_activity()
        {
            //            Arrange
            $user            = User::where('role_id', 1)->first();
            $now             = Carbon::now();
            $project         = $user->projects->last();
            $missingActivity = $this->createMissingActivity($user, $now);

            $data = [
                'project_id'  => $project->id,
                'user_id'     => [$user->id],
                'start_date'  => $now->format('d/m/Y'),
                'finish_date' => $now->format('d/m/Y'),
                'hours'       => 8,
                'task_id'     => $project->tasks->first()->id,
                'place_id'    => Place::all()->first()->id
            ];

            Auth::setUser($user);

            //            Act
            $this->getService()->create($data);

            //            Assert
            $this->assertNull($user->missingActivities()->find($missingActivity->id));
        }

        /**
         * @return \Delos\Dgp\Services\ActivityService
         */
        private function getService()
        {
            return app(\Delos\Dgp\Services\ActivityService::class);
        }

        /**
         * @param $user
         * @param $now
         *
         *
         * @return \Illuminate\Database\Eloquent\Model
         */
        private function createMissingActivity(User $user, Carbon $now)
        {
            return $user->missingActivities()->updateOrCreate(['date' => $now], ['date' => $now, 'hours' => 8]);
        }
    }