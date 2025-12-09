<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PosSession;
use Illuminate\Support\Facades\Auth;

class CheckPosSession
{
    /**
     * Handle an incoming request.
     *
     * Routes that don't require an active POS session
     */
    protected $except = [
        'possession/open',
        'possession/close',
        'possession/check',
        'logout',
        'login',
        'profile',
        'profile/*',
    ];

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for excluded routes
        foreach ($this->except as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return $next($request);
        }

        // Get session ID from Laravel session
        $posSessionId = session('pos_session');

        // Check if session exists and is still active
        if ($posSessionId) {
            $posSession = PosSession::where('idpos_session', $posSessionId)
                ->whereNull('balance_akhir')
                ->first();

            if ($posSession) {
                // Session is active, proceed
                return $next($request);
            }
        }

        // No active session found, redirect to session opening page
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Tidak ada sesi aktif. Silakan buka sesi terlebih dahulu.',
                'redirect' => route('possession.show-open')
            ], 403);
        }

        return redirect()->route('possession.show-open')
            ->with('warning', 'Silakan buka sesi terlebih dahulu untuk melanjutkan.');
    }
}
