<?php namespace Leitom\Boilerplate\Repositories;

interface UsersRepositoryInterface {
	
	// Return all users
	public function all();

	// Find one user
	public function find($id);

	// Create user and return a new instance
	public function create(array $attributes = array());

	// Update a user
	public function update($id, array $attributes = array());

	// Delete user
	public function delete($id);

	/**
	 * Relationships
	 * Becuse we use eloquent models sometimes we need to make sure that other
	 * implementations also can provide the same functionality
	 */

	// userprofiles
	public function userprofiles();

	// Attach an instance of UserProfilesInterface to a user
	public function attachUserProfile($id, UserProfilesRepositoryInterface $userProfile);

}