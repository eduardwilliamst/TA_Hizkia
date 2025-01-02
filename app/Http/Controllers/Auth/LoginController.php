<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PosMesin;
use App\Models\PosSession;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
    
    public function showLoginForm()
    {
        // Ambil data pos_mesin
        $posMesins = PosMesin::all();  // Ambil semua data pos_mesin
    
        return view('auth.login', compact('posMesins'));
    }

    public function login(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'pos_mesin' => 'required|exists:pos_mesins,idpos_mesin', // Ensure valid pos_mesin ID
            ]);

            // Get the credentials for login
            $credentials = $request->only('email', 'password');

            // Attempt login with the credentials
            if (Auth::attempt($credentials)) {

                // Get the selected pos_mesin id
                $posMesinId = $request->input('pos_mesin');
                // dd($posMesinId, Auth::id());
                // Create a new pos_session
                
                $posSession = PosSession::create([
                    'saldo_awal' => 100000,   // Set initial balance, or adjust as needed
                    'tanggal' => now(),    // Use current timestamp
                    'keterangan' => 'Sesi dimulai',  // Default session description
                    'user_iduser' => Auth::id(), // Logged-in user's ID
                    'pos_mesin_idpos_mesin' => $posMesinId, // Selected POS machine ID
                ]);
                // dd($posSession);

                // Store the pos_session ID in the session
                session(['pos_session' => $posSession->idpos_session]);

                // Redirect to the dashboard or intended route
                return view('dashboard');
            }

            // If login fails, return with errors
            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Login failed: ' . $e->getMessage());

            // Return an error message or redirect to a specific page
            return back()->withErrors(['error' => 'Something went wrong, please try again later.']);
        }
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
