<?php

namespace App\Policies;

use App\Helpers\Constant;
use App\User;
use App\Practice;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PracticePolicy
 * @package App\Policies
 */
class PracticePolicy {
	use HandlesAuthorization;
	
	/**
	 * Determine whether the user can view the practice.
	 *
	 * @param  \App\User     $user
	 * @param  \App\Practice $practice
	 * @return mixed
	 */
	public function view( User $user, Practice $practice ) {
		//
	}
	
	/**
	 * Determine whether the user can create practices.
	 *
	 * @param  \App\User $user
	 * @return mixed
	 */
	public function create( User $user ) {
		return ($user->role == Constant::ROLE_OWNER);
	}
	
	/**
	 * Determine whether the user can update the practice.
	 *
	 * @param  \App\User     $user
	 * @param  \App\Practice $practice
	 * @return mixed
	 */
	public function update( User $user, Practice $practice ) {
		return ($user->role == Constant::ROLE_OWNER) && ($practice->user_id == $user->id);
	}
	
	/**
	 * Determine whether the user can delete the practice.
	 *
	 * @param  \App\User     $user
	 * @param  \App\Practice $practice
	 * @return mixed
	 */
	public function delete( User $user, Practice $practice ) {
		return ($user->role == Constant::ROLE_OWNER);
	}
	
	/**
	 * Determine whether the user can delete the practice.
	 *
	 * @param  \App\User    $user
	 * @param \App\Practice $practice
	 * @return bool
	 */
	public function dashboard( User $user, Practice $practice ) {
		return ($user->role == Constant::ROLE_OWNER) && ($practice->user_id == $user->id);
	}
}
