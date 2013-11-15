<?php namespace Leitom\Boilerplate\Account;

interface AccountActivationRepositoryInterface {

	/**
	 * Create a new activation record and token.
	 *
	 * @param  \Illuminate\Auth\RemindableInterface  $user
	 * @return string
	 */
	public function create($user);

	/**
	 * Determine if a activation record exists and is valid.
	 *
	 * @param  \Illuminate\Auth\RemindableInterface  $user
	 * @param  string  $token
	 * @return bool
	 */
	public function exists($token);

	/**
	 * Delete a activation record by token.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function delete($token);

	/**
	 * Delete expired activations.
	 *
	 * @return void
	 */
	public function deleteExpired();

}
