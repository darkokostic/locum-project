<?php

namespace App\Policies;

use App\Helpers\Constant;
use App\User;
use App\Job;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class JobPolicy
 * @package App\Policies
 */
class JobPolicy {
	use HandlesAuthorization;
	
	/**
	 * Determine whether the user can view the job.
	 *
	 * @param  \App\User $user
	 * @param  \App\Job  $job
	 * @return mixed
	 */
	public function view( User $user, Job $job ) {
		//
	}
	
	/**
	 * Determine whether the user can create jobs.
	 *
	 * @param  \App\User $user
	 * @return mixed
	 */
	public function create( User $user ) {
		return ($user->role == Constant::ROLE_OWNER);
	}
	
	/**
	 * Determine whether the user can update the job.
	 *
	 * @param  \App\User $user
	 * @param  \App\Job  $job
	 * @return mixed
	 */
	public function update( User $user, Job $job ) {
		return ($user->role == Constant::ROLE_OWNER);
	}
	
	/**
	 * Determine whether the user can delete the job.
	 *
	 * @param  \App\User $user
	 * @param  \App\Job  $job
	 * @return mixed
	 */
	public function delete( User $user, Job $job ) {
		return ($user->role == Constant::ROLE_OWNER);
	}
	
	
}
