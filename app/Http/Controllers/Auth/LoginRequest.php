public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    $credentials = $this->only('email', 'password');

    if (! Auth::attempt($credentials, $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    if (!auth()->user()->active) {
        Auth::logout();

        throw ValidationException::withMessages([
            'email' => 'Account disabled by admin.',
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}
