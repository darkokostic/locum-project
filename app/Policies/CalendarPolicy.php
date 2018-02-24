<?php

namespace App\Policies;

use App\Helpers\Constant;
use App\User;
use App\Calendar;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class CalendarPolicy
 * @package App\Policies
 */
class CalendarPolicy {
	use HandlesAuthorization;
	
	/**
	 * Determine whether the user can view the calendar.
	 *
	 * @param  \App\User     $user
	 * @param  \App\Calendar $calendar
	 * @return bool
	 */
	public function view( User $user, Calendar $calendar ) {
		return ($user->id == $calendar->user_id) && ($user->role == Constant::ROLE_USER);
	}
	
	/**
	 * Determine whether the user can view the calendars.
	 *
	 * @param  \App\User $user
	 * @return bool
	 * @internal param \App\Calendar $calendar
	 */
	public function userCalendars( User $user ) {
		return ($user->role == Constant::ROLE_USER);
	}
	
	/**
	 * Determine whether the user can create calendars.
	 *
	 * @param  \App\User $user
	 * @return bool
	 */
	public function create( User $user ) {
		return ($user->role == Constant::ROLE_USER);
	}
	
	/**
	 * Determine whether the user can update the calendar.
	 *
	 * @param  \App\User     $user
	 * @param  \App\Calendar $calendar
	 * @return bool
	 */
	public function update( User $user, Calendar $calendar ) {
		return ($user->role == Constant::ROLE_USER || $user->role == Constant::ROLE_OWNER);
	}
	
	/**
	 * Determine whether the user can delete the calendar.
	 *
	 * @param  \App\User     $user
	 * @param  \App\Calendar $calendar
	 * @return mixed
	 */
	public function delete( User $user, Calendar $calendar ) {
		return ($user->role == Constant::ROLE_USER || $user->role == Constant::ROLE_OWNER);
	}
}
