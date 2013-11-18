<?php namespace Leitom\Boilerplate\Account;

use Closure;
use Illuminate\Mail\Mailer;
use Illuminate\Auth\UserProviderInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

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
	 * @var \Illuminate\Auth\UserProviderInterface  $users
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
	 * @param  \Illuminate\Auth\UserProviderInterface  $users
	 * @param  \Illuminate\Mail\Mailer  $mailer
	 * @param  string  $reminderView
	 * @return void
	 */
	public function __construct(AccountActivationRepositoryInterface $accountActivationRepository,
                                UserProviderInterface $users,
                                Mailer $mailer,
                                $accountActivationView)
	{
		$this->accountActivationRepository = $accountActivationRepository;
		$this->users = $users;
		$this->mailer = $mailer;
		$this->accountActivationView = $accountActivationView;
	}

	/**
	 * Send a account activation to a user.
	 *
	 * @param  array    $credentials
	 * @param  Closure  $callback
	 * @return Boolean
	 */
	public function sendActivation(array $credentials, $path = 'app.account.show', Closure $callback = null)
	{
		// First we will check to see if we found a user at the given credentials and
		$user = $this->getUser($credentials);

		if (is_null($user)) {
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
	protected function sendAccountActivation(RemindableInterface $user, $path = 'app.account.show', $token, Closure $callback = null)
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
	 * @param  array    $credentials
	 * @param  Closure  $callback
	 * @return mixed
	 */
	public function activate(array $credentials, Closure $callback)
	{
		// If the responses from the validate method is not a user instance, we will
		// assume that it is a redirect and simply return it from this method and
		// the user is properly redirected having an error message on the post.
		$user = $this->validateActivation($credentials['token']);

		if ( ! $user instanceof RemindableInterface) {
			return $user;
		}

		// Once we have called this callback, we will remove this token row from the
		// table and return the response from this callback so the user gets sent
		// to the destination given by the developers from the callback return.
		$response = call_user_func($callback, $user);

		$this->accountActivationRepository->delete($credentials['token']);

		return $response;
	}

	/**
	 * Validate an activation for the given credentials.
	 *
	 * @param  string  $token
	 * @return \Leitom\Boilerplate\Repositories\UsersRepositoryInterface
	 */
	protected function validateActivation($token)
	{
		$activation = $this->accountActivationRepository->exists($token);

		if ( ! $activation) {
			return false;
		}

		return $this->getUser(array('email' => $activation->email));
	}

	/**
	 * Get the user for the given email.
	 *
	 * @param  array  $credentials
	 * @return \Leitom\Boilerplate\Repositories\UsersRepositoryInterface
	 */
	public function getUser($credentials)
	{
		$user = $this->users->retrieveByCredentials($credentials);

		if ($user and ! $user instanceof RemindableInterface) {
			throw new \UnexpectedValueException("User must implement Remindable interface.");
		}

		return $user;
	}

}
