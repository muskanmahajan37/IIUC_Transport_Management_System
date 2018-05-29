<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Auth\Events\Registered;
use App\Jobs\SendVerificationEmail;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'userrole' => 'required|integer',
            'gender' => 'required|boolean',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'userrole' => $data['userrole'],
            'gender' => $data['gender'],
            'token' => base64_encode($data['email']).str_random(5),
        ]);
    }
    // Account activation process


    /* protected function register(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);

        if($validator->passes())
        {
            $data = $this->create($input)->toArray();
            //$data['token'] = str_random(25);
            $user = User::find($data['id']);
            //$user->token = $data['token'];
            $user->save();

            Mail::send('mails.confirmation', $data, function($message) use($data){
                $message->to($data['email']);
                $message->subject('Registration Confirmation');

            });
            return redirect(route('login'))->with('status', 'Registration is complete. A confirmation email has been sent. Please check your email.');
        }
        return redirect(route('register'))->with('error', 'This email has been taken!');
    }

    public function confirmation ($token)
    {
        $user = User:: where('token', $token) -> first();
        if(!is_null($user))
        {
            $user->confirmation = 1;
            $user->token = null;
            $user->save();
            return redirect(route('login'))->with('status-success', 'Your account is activated! You can now login.');
        }
        return redirect(route('login'))->with('status-error', 'Something wrong. Please contact with administration.');
    } */


    // Activation email and confirmation
    /**
    * Handle a registration request for the application.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    /* public function register(Request $request)

    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        dispatch(new SendVerificationEmail($user));
        return view('mails.verification');
    } */

    /**
    * Handle a registration request for the application.
    *
    * @param $token
    * @return \Illuminate\Http\Response
    */

    /* public function verify($token)
    {
        $user = User::where('token',$token)->first();
        $user->confirmation = true;
        if($user->save())
        {
            return view('mails.emailconfirm',['user'=>$user]);
        }

    } */
}