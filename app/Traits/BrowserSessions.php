<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use Illuminate\Contracts\Auth\StatefulGuard;
use Jenssegers\Agent\Agent;

trait BrowserSessions
{
    /**
     * Get the current sessions.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collect(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->orderBy('last_activity', 'desc')
            ->get())->map(function ($session) {
                return (object) $this->sessionList($session);
            });
    }

    public function sessionList($session)
    {
        $agent = $this->createAgent($session);

        return [
            'key' => $session->id,
            'agent' => (object) [
                'is_desktop' => $agent->isDesktop(),
                'platform' => $agent->platform(),
                'browser' => $agent->browser(),
            ],
            'ip_address' => $session->ip_address,
            'is_current_device' => $session->id === request()->session()->getId(),
            'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
        ];
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    /**
     * Logout from other browser sessions.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return \Illuminate\Http\Client\Response
     */
    public function destroyBrowserSessions($password)
    {
        /* if (!Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ])->errorBag('password_session_destroy');
        } */
        Auth::logoutOtherDevices($password);

        $this->deleteOtherSessionRecords(request());
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @return void
     */
    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
