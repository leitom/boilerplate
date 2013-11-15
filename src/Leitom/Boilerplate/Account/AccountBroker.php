<?php namespace Leitom\Boilerplate\Account;

use Closure;
use Illuminate\Mail\Mailer;
use Leitom\Boilerplate\Repositories\UsersRepositoryInterface;

class AccountBroker {

	/**
	 * The account activation repository.
	 *
	 * @var \Leitom\Boilerplate\Account\AccountActivationRepositoryInterface  $accountActivationRepository
	 */
	protected $accountActivationRepository;

	/**
	 * The user provider implementation.
	 *
	 * @var \Leitom\Boilerplate\Repositories\UsersRepositoryInterface
	 */
	protected $users;

	/**
	 * The mailer instance.
	 *
	 * @var \Illuminate\Mail\Mailer
	 */
	protected $mailer;

	/**
	 * The view of the account activation e-mail.
	 *
	 * @var string
	 */
	protected $accountActivationView;

	/**
	 * Create a new password broker instance.
	 *
	 * @param  \Leitom\Boilerplate\Account\AccountActivationRepositoryInterface  $accountActivationRepository
	 * @param  \Leitom\Boilerplate\Repositories\UsersRepositoryInterface  $users
	 * @param  \Illuminate\Mail\Mailer  $mailer
	 * @param  string  $reminderView
	 * @return void
	 */
	public function __construct(AccountActivationRepositoryInterface $accountActivationRepository,
                                UsersRepositoryInterface $users,
                                Mailer $mailer,
                                $accountActivationView)
	{
		$this->users = $users;
		$this->mailer = $mailer;
		$this->accountActivationRepository = $accountActivationRepository;
		$this->accountActivationView = $accountActivationView;
	}

	/**
	 * Send a account activation to a user.
	 *
	 * @param  string   $email
	 * @param  Closure  $callback
	 * @return Boolean
	 */
	public function sendActivation($email, $path, Closure $callback = null)
	{
		// First we will check to see if we found a user at the given credentials and
		$user = $this->getUser($email);

		if (is_null($user))
		{
			// Trow some kind of exception etc.
			return false;
		}

		// Once we have the account activation token, we are ready to send a message out to the
		// user with a link to activation logic. We will then redirect back to
		// the current URI having nothing set in the session to indicate errors.
		$token = $this->accountActivationRepository->create($user);

		$this->sendAccountActivation($user, $path, $token, $callback);

		return true;
	}

	/**
	 * Send the account activation e-mail.
	 *
	 * @param  \Leitom\Boilerplate\Repositories\UsersRepositoryInterface  $user
	 * @param  string   $token
	 * @param  Closure  $callback
	 * @return void
	 */
	public function sendAccountActivation($user, $path, $token, Closure $callback = null)
	{
		// We will use the account activation view that was given to the broker to display the
		// account activation e-mail. We'll pass a "token" variable into the views
		// so that it may be displayed for an user to click for account activation.
		$view = $this->accountActivationView;

		// We need to que the emails!
		return $this->mailer->send($view, compact('token', 'path', 'user'), function($m) use ($user, $callback)
		{
			$m->to($user->getReminderEmail());

			if ( ! is_null($callback)) call_user_func($callback, $m, $user);
		});
	}

	/**
	 * Activate an account based on the provided token.
	 *
	 * @param  string   $token
	 * @param  Closure  $callback
	 * @return mixed
	 */
	public function activate($token = '')
	{
		// If the responses from the validate method is not a user instance, we will
		// assume that it is a redirect and simply return it from this method and
		// the user is properly redirected having an error message on the post.
		$user = $this->validateActivation($token);

		// Set active flag on the user
		$updatedUser = $this->users->update($user->id, array('active' => 1));
		
		// Dont delete the record before we activate the user incase of errors
		if($updatedUser)
		{
			$this->accountActivationRepository->delete($token);

			return $user;
		}	

		return false;
	}

	/**
	 * Validate an activation for the given credentials.
	 *
	 * @param  string  $token
	 * @return \Leitom\Boilerplate\Repositories\UsersRepositoryInterface
	 */
	protected function validateActivation($token)
	{
		if ( ! $activation = $this->accountActivationRepository->exists($token))
		{
			return false;
		}

		return $this->getUser($activation->email);
	}

	/**
	 * Get the user for the given email.
	 *
	 * @param  string  $email
	 * @return \Leitom\Boilerplate\Repositories\UsersRepositoryInterface
	 */
	public function getUser($email)
	{
		$user = $this->users->getBy('email', $email);

		if ($user and ! method_exists($user, 'getReminderEmail'))
		{
			throw new \UnexpectedValueException("User must implement Remindable interface.");
		}

		return $user;
	}

}
