<?php namespace Leitom\Boilerplate\Repositories;

use Leitom\Boilerplate\User as User;

class EloquentUsersRepository implements UsersRepositoryInterface {

	public function all()
	{
		return User::all();
	}	

	public function find($id)
	{
		return User::find($id);
	}

	public function getBy($key, $value, $with = array())
	{
		return User::with($with)->where($key, $value)->get();
	}

	public function getLike($key, $value, $with = array())
	{
		return User::with($with)->where($key, 'like', "%$value%")->get();
	}

	public function create(array $attributes = array())
	{
		return User::create($attributes);
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

	public function attachUserProfile($id, $userProfile)
	{
		$user = $this->find($id);
		$user->userProfile()->associate($userProfile);
		return $user;
	}

}