<?php namespace Leitom\Boilerplate\Repositories;

use Leitom\Boilerplate\User as User;
use Leitom\Boilerplate\UserProfile as UserProfile;

class EloquentUsersRepository implements UsersRepositoryInterface {

	public function all()
	{
		return User::all();
	}

	public function find($id)
	{
		return User::find($id);
	}

	public function create(array $attributes = array())
	{
		$user = new User($attributes);
		$profile = new UserProfile($attributes);

		if( ! $user->validate()) return $user;
		if( ! $profile->validate()) return $profile;

		$user->save();
		$user->userProfile()->save($profile);

		return $user;
	}

	public function update($id, array $attributes = array())
	{
		$user = $this->find($id);
		$user->fill($attributes);
		return $user->save();
	}

	public function delete($id)
	{
		$user = $this->find($id);
		return $user->delete();
	}

}