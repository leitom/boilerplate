<?php namespace Leitom\Boilerplate\Account;

use Closure;
use Illuminate\Mail\Mailer;
use Leitom\Boilerplate\Repositories\UsersRepositoryInterface;

class AccountBroker {

	/**
	 * The password reminder repository.
	 *
	 * @var \Illuminate\Auth\Reminders\ReminderRepositoryInterface  $reminders
	 */
	protected $accountActivationRepository;

	/**
	 * The user provider implementation.
	 *
	 * @var \Illuminate\Auth\UserProviderInterface
	 */
	protected $users;

	/**
	 * The mailer instance.
	 *
	 * @var \Illuminate\Mail\Mailer
	 */
	protected $mailer;

	/**
	 * The view of the password reminder e-mail.
	 *
	 * @var string
	 */
	protected $accountActivationView;

	/**
	 * Create a new password broker instance.
	 *
	 * @param  \Illuminate\Auth\Reminders\ReminderRepositoryInterface  $reminders
	 * @param  \Leitom\Boilerplate\Repositories\UsersRepositoryInterface  $users
	 * @param  \Illuminate\Routing\Redirector  $redirect
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
	 * @return \Illuminate\Http\RedirectResponse
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
	 * @param  \Illuminate\Auth\Reminders\RemindableInterface  $user
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
	public function activate($token = '', Closure $callback)
	{
		// If the responses from the validate method is not a user instance, we will
		// assume that it is a redirect and simply return it from this method and
		// the user is properly redirected having an error message on the post.
		$user = $this->validateActivation($token);

		// Set active flag on the user
		$user = $this->users->update($user->id, array('active' => 1));
		
		// Once we have called this callback, we will remove this token row from the
		// table and return the response from this callback so the user gets sent
		// to the destination given by the developers from the callback return.
		$response = call_user_func($callback, $user);

		$this->accountActivationRepository->delete($token);

		return $response;
	}

	/**
	 * Validate an activation for the given credentials.
	 *
	 * @param  string  $token
	 * @return \Illuminate\Auth\RemindableInterface
	 */
	protected function validateActivation($token)
	{
		if ( ! $activation = $this->accountActivationRepository->exists($token))
		{
			return false;
		}

		return $this->getUser(array('email' => $activation->email));
	}

	/**
	 * Get the user for the given email.
	 *
	 * @param  string  $email
	 * @return \Illuminate\Auth\Reminders\RemindableInterface
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