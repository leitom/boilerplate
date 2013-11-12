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
	
	// Attach an instance of UserProfilesInterface to a user
	public function attachUserProfile($id, $userProfile);

}