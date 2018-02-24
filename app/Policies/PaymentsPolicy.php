<?php

namespace App\Policies;

use App\Helpers\Constant;
use App\User;
use App\PaymentsOptions;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PaymentsPolicy
 * @package App\Policies
 */
class PaymentsPolicy {
	use HandlesAuthorization;
	
	/**
	 * Determine whether the user can view the paymentsOptions.
	 *
	 * @param  \App\User           $user
	 * @param \App\PaymentsOptions $payment
	 * @return bool
	 */
	public function view( User $user, PaymentsOptions $payment ) {
		return ($user->id == $payment->user_id);
	}
	
	/**
	 * Determine whether the user can create paymentsOptions.
	 *
	 * @param  \App\User $user
	 * @return bool
	 */
	public function create( User $user ) {
		return ($user->role == Constant::ROLE_OWNER) || ($user->role == Constant::ROLE_USER);
	}
	
	/**
	 * Determine whether the user can update the paymentsOptions.
	 * @param \App\User            $user
	 * @param \App\PaymentsOptions $payment
	 * @return bool
	 */
	public function update( User $user, PaymentsOptions $payment ) {
		return ($user->id == $payment->user_id);
	}
	
	/**
	 * Determine whether the user can delete the paymentsOptions.
	 *
	 * @param  \App\User           $user
	 * @param \App\PaymentsOptions $payment
	 * @return bool
	 */
	public function delete( User $user, PaymentsOptions $payment ) {
		return ($user->id == $payment->user_id);
	}
}
