<?php namespace Leitom\Boilerplate\Repositories;

use Leitom\Boilerplate\User as User;
use Leitom\Boilerplate\UserProfile as UserProfile;

class EloquentUsersRepository implements UsersRepositoryInterface {

	public function all()
	{
		return User::all();
	}

	public function findById($id)
	{
		return User::find($id);
	}

	public function getBy($key, $value)
	{
		return User::where($key, '=', $value)->first();
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
		$user = $this->findById($id);
		$user->fill($attributes);
		return $user->save();
	}

	public function delete($id)
	{
		$user = $this->findById($id);
		return $user->delete();
	}

}