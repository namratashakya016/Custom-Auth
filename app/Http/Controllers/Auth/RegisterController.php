<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMailJob;
use Str;

class RegisterController extends Controller
{
    // Show the registration form
    public function index()
    {
        return View::make('auth.register');
    }

    // Handle registration request
    public function register(Request $request)
    {
        
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());    
 
        if ($user) {
            if (is_null($user->email)) {
                \Log::error('User email is null');
            } else {
                SendMailJob::dispatch($user);
            }
            return redirect()->route('login')->with('status', 'Registration successful! Please check your email to verify your account.');

        } else {
            return back()->withErrors(['registration' => 'Failed to create user.']);
        }

    }
    public function verify($token)
    {
       // Find the user by remember_token
       $user = User::where('remember_token', $token)->first();

       if ($user) {
           if (is_null($user->email_verified_at)) {
               $user->email_verified_at = now();
               $user->save();

               return redirect()->route('login')->with('status', 'Email verified successfully!');
           }

           return redirect()->route('login')->with('status', 'Email already verified.');
       }

       return redirect()->route('login')->withErrors(['verification' => 'Invalid verification token.']);

    }

    // Validate registration data
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Create a new user instance
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => null, 
            'remember_token'=> Str::random(40)
        ]);
    }
}
