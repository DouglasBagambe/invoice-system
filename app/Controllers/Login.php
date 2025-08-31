<?php

namespace App\Controllers;

use App\Models\Account_model;
use App\Models\Client_model;
use App\Models\Admin_model; // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

class Login extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        //$this->crudModel = new Account_model(); // Load model
        helper('url');
        helper('navigation');
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
           
    return view('login');
    }

    public function register()
    {
        return view('register');
    }

public function userlogin()
{
    if ($this->request->isAJAX()) {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Debug: Check if data is received
        if (!$username || !$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Username or password missing!']);
        }

        $loginModel = new Admin_model();
        $user = $loginModel->where('username', $username)->first();

        // Debug: Print fetched user data
        if (!$user) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not found!']);
        }

        // Check password (support both hashed and plain text for backward compatibility)
        $isValidPassword = false;
        
        // First check if password is hashed (new users)
        if (password_verify($password, $user['password'])) {
            $isValidPassword = true;
        } 
        // Fall back to plain text comparison (existing users)
        else if ($password === $user['password']) {
            $isValidPassword = true;
            
            // Optionally upgrade to hashed password
            $adminModel = new Admin_model();
            $adminModel->update($user['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }
        
        if (!$isValidPassword) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid password!']);
        }

        // Set session
        $session = session();
        $session->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'user_image' => base_url('public/dist/img/uploads/' . $user['picture']),
            'company_logo' => base_url('public/dist/img/uploads/' . $user['picturelogo']),
            'logged_in' => true
        ]);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Login successful!']);
    }
}

public function userregister()
{
    if ($this->request->isAJAX()) {
        $email = $this->request->getPost('email');
        $firstName = $this->request->getPost('first_name');
        $lastName = $this->request->getPost('last_name');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validation
        if (!$email || !$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email and password are required!']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Please enter a valid email address!']);
        }

        if (strlen($password) < 6) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Password must be at least 6 characters long!']);
        }

        if ($password !== $confirmPassword) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Passwords do not match!']);
        }

        $adminModel = new Admin_model();
        
        // Check if email already exists
        $existingUser = $adminModel->where('email', $email)->first();
        if ($existingUser) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email address is already registered!']);
        }

        // Also check if email exists as username (for compatibility)
        $existingUsername = $adminModel->where('username', $email)->first();
        if ($existingUsername) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email address is already registered!']);
        }

        // Prepare user data
        $fullName = trim($firstName . ' ' . $lastName);
        if (empty($fullName)) {
            $fullName = explode('@', $email)[0]; // Use email prefix as fallback name
        }

        $userData = [
            'username' => $email,  // Use email as username for login compatibility
            'email' => $email,
            'name' => $fullName,
            'password' => password_hash($password, PASSWORD_DEFAULT), // Hash the password for security
            'qualification' => '',
            'location' => '',
            'skills' => '',
            'c_name' => '',
            'c_add' => '',
            'profession' => '',
            'mob' => '',
            'gst' => '',
            'pan' => '',
            'picture' => '',
            'picturelogo' => ''
        ];

        // Insert new user
        $result = $adminModel->insert($userData);
        
        if ($result) {
            // Get the newly created user
            $newUser = $adminModel->where('email', $email)->first();
            
            // Set session (auto-login after registration)
            $session = session();
            $session->set([
                'user_id' => $newUser['id'],
                'username' => $newUser['username'],
                'name' => $newUser['name'],
                'user_image' => base_url('public/dist/img/uploads/' . ($newUser['picture'] ?: 'default-avatar.png')),
                'company_logo' => base_url('public/dist/img/uploads/' . ($newUser['picturelogo'] ?: 'logo.png')),
                'logged_in' => true
            ]);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Registration successful! Redirecting to dashboard...']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Registration failed. Please try again.']);
        }
    }
}

public function logout() {
    $session = session();
    
    // Destroy the session to log the user out
    $session->destroy();
    
    // Redirect to the login page after logout
    return redirect()->to(base_url('/login')); // Corrected here
}


}
?>