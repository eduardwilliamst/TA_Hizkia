<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PosMesin;
use App\Models\PosSession;
use App\Models\CashFlow;
use Illuminate\Support\Facades\DB;

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

                // Store selected POS machine for later use in session opening
                session(['selected_pos_mesin' => $request->input('pos_mesin')]);

                // Check if user already has an active session
                $activeSession = PosSession::where('user_iduser', Auth::id())
                    ->whereNull('balance_akhir')
                    ->first();

                if ($activeSession) {
                    // User has active session, store it and go to dashboard
                    session(['pos_session' => $activeSession->idpos_session]);
                    return redirect('/dashboard');
                }

                // No active session, redirect to session opening page
                return redirect()->route('possession.show-open');
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
        // Get the current POS session before session is invalidated
        $posSessionId = session('pos_session');

        try {
            // Finalize the POS session if exists
            if ($posSessionId) {
                DB::beginTransaction();

                $posSession = PosSession::find($posSessionId);

                if ($posSession) {
                    // Get all cash flows for this session
                    $cashFlows = CashFlow::where('id_pos_session', $posSessionId)->get();

                    // Calculate totals
                    $totalCashIn = $cashFlows->where('tipe', 'cash_in')->sum('jumlah');
                    $totalCashOut = $cashFlows->where('tipe', 'cash_out')->sum('jumlah');

                    // Update session description with summary
                    $posSession->keterangan = sprintf(
                        'Sesi selesai - Cash In: Rp %s, Cash Out: Rp %s',
                        number_format($totalCashIn, 0, ',', '.'),
                        number_format($totalCashOut, 0, ',', '.')
                    );

                    // Ensure balance_akhir is set (should already be updated by transactions)
                    if ($posSession->balance_akhir === null) {
                        $posSession->balance_akhir = $posSession->balance_awal + $totalCashIn - $totalCashOut;
                    }

                    $posSession->save();
                }

                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to close POS session on logout: ' . $e->getMessage());
        }

        // Perform standard logout
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
