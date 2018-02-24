<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model'           => 'App\Policies\ModelPolicy',
		'App\Job'             => 'App\Policies\JobPolicy',
		'App\User'            => 'App\Policies\UserPolicy',
		'App\Application'     => 'App\Policies\ApplicationPolicy',
		'App\PaymentsOptions' => 'App\Policies\PaymentsPolicy',
		'App\Calendar'        => 'App\Policies\CalendarPolicy',
		'App\Practice'        => 'App\Policies\PracticePolicy',
		'App\News'            => 'App\Policies\NewsPolicy',
	];
	
	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();
		
		//
	}
}
