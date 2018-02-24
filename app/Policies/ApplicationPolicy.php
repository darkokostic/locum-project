<?php

namespace App\Policies;

use App\Helpers\Constant;
use App\User;
use App\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ApplicationPolicy
 * @package App\Policies
 */
class ApplicationPolicy {
	use HandlesAuthorization;
	
	/**
	 * Determine whether the user can view the application.
	 *
	 * @param  \App\User        $user
	 * @param  \App\Application $application
	 * @return mixed
	 */
	public function view( User $user, Application $application ) {
		//
	}
	
	/**
	 * Determine whether the user can create applications.
	 *
	 * @param  \App\User $user
	 * @return mixed
	 */
	public function create( User $user ) {
		return ($user->role == Constant::ROLE_USER);
    }
	
	/**
	 * Determine whether the user can update the application.
	 *
	 * @param  \App\User        $user
	 * @param  \App\Application $application
	 * @return mixed
	 */
	public function update( User $user, Application $application ) {
		//
	}
	
	/**
	 * Determine whether the user can delete the application.
	 *
	 * @param  \App\User        $user
	 * @param  \App\Application $application
	 * @return mixed
	 */
	public function delete( User $user, Application $application ) {
		return ($user->role == Constant::ROLE_USER);
	}
}
