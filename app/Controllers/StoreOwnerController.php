<?php

namespace App\Controllers;

use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;

class StoreOwnerController extends BaseController
{
    public function login()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getGet('mode') === 'signin') {
            return view('pages/storeOwner_login');
        }

        return view('pages/storeOwner_access');
    }

    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/dashboard');
        }

        return view('pages/storeOwner_register');
    }

    public function authenticate()
    {
        $credentials = [
            'username' => trim((string) $this->request->getPost('username')),
            'password' => (string) $this->request->getPost('password'),
        ];

        $result = auth('session')->getAuthenticator()->attempt($credentials);

        if (! $result->isOK()) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password');
        }

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'name' => 'required|max_length[255]',
            'username' => 'required|min_length[3]|max_length[30]',
            'email' => 'required|valid_email|max_length[254]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $users = new UserModel();

        if ($users->findByCredentials(['username' => $username]) !== null) {
            return redirect()->back()->withInput()->with('errors', [
                'username' => 'That username is already in use.',
            ]);
        }

        if ($users->findByCredentials(['email' => $email]) !== null) {
            return redirect()->back()->withInput()->with('errors', [
                'email' => 'That email address is already registered.',
            ]);
        }

        $user = $users->createNewUser([
            'username' => $username,
            'email' => $email,
            'password' => (string) $this->request->getPost('password'),
        ]);

        try {
            $users->save($user);
        } catch (ValidationException $exception) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        $user = $users->findById($users->getInsertID());

        if ($user === null) {
            return redirect()->back()->withInput()->with('errors', [
                'account' => 'The account could not be loaded after registration.',
            ]);
        }

        $users->addToDefaultGroup($user);
        $user->activate();
        auth('session')->getAuthenticator()->login($user);

        return redirect()->to('/dashboard')->with('success', 'Account created and signed in successfully.');
    }

    public function logout()
    {
        auth('session')->getAuthenticator()->logout();

        return redirect()->to('/login');
    }
}
