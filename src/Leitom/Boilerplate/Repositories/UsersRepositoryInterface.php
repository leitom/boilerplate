<?php namespace Leitom\Boilerplate\Repositories;

interface UsersRepositoryInterface {
	
	// Return all users
	public function all();

	// Find one user
	public function find($id);

	// Find one user by key value
	public function getBy($key, $value);

	// Create user and return a new instance
	public function create(array $attributes = array());

	// Update a user
	public function update($id, array $attributes = array());

	// Delete user
	public function delete($id);
	
}