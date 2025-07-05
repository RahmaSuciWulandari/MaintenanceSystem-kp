<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the login request
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('username', 'remember'));
        }

        // Check if user exists and is activated
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            // Debug: Log the attempted username
            \Log::info('Login attempt with username: ' . $request->username);
            
            return redirect()->back()
                ->withErrors(['username' => 'Username tidak ditemukan.'])
                ->withInput($request->only('username', 'remember'));
        }

        if (!$user->activated) {
            return redirect()->back()
                ->withErrors(['username' => 'Akun Anda belum diaktivasi. Silakan hubungi administrator.'])
                ->withInput($request->only('username', 'remember'));
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                ->withInput($request->only('username', 'remember'));
        }

        // Login the user
        Auth::login($user, $request->has('remember'));

        // Update last login timestamp
        $user->update(['last_login' => Carbon::now()]);

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Set success message
        Session::flash('success', 'Selamat datang, ' . $user->first_name . ' ' . $user->last_name . '!');

        // Redirect based on user role
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Validate login request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:191'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 191 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);
    }

    /**
     * Redirect user based on their role.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnRole($user)
    {
        // Check if user has role relation
        if ($user->role) {
            switch ($user->role->name) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'manager_it':
                    return redirect()->route('manager.dashboard');
                case 'pic_unit':
                    return redirect()->route('pic.dashboard');
                case 'pelaksana':
                    return redirect()->route('pelaksana.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
        }

        // Fallback: redirect to general dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Check if user has specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }

        // Check role-based permission
        if ($user->role && method_exists($user->role, 'hasPermission')) {
            return $user->role->hasPermission($permission);
        }

        // Check user-specific permissions (if stored in permissions column)
        if ($user->permissions) {
            $userPermissions = json_decode($user->permissions, true);
            return in_array($permission, $userPermissions);
        }

        return false;
    }

    /**
     * Log out the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        
        // Log the logout activity (optional)
        $this->logActivity('logout', Auth::user());

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Session::flash('success', 'Anda telah berhasil logout. Sampai jumpa, ' . $userName . '!');

        return redirect()->route('login');
    }

    /**
     * Show user profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update user profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email,' . $user->id],
            'work_email' => ['nullable', 'email', 'max:191'],
            'jobtitle' => ['nullable', 'string', 'max:191'],
            'country' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string'],
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($request->only([
            'first_name', 'last_name', 'email', 'work_email', 
            'jobtitle', 'country', 'notes'
        ]));

        Session::flash('success', 'Profile berhasil diperbarui!');

        return redirect()->back();
    }

    /**
     * Change password form.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Change user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password lama tidak benar.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        Session::flash('success', 'Password berhasil diubah!');

        return redirect()->back();
    }

    /**
     * Log user activity (optional method for audit trail).
     *
     * @param string $action
     * @param User $user
     * @return void
     */
    protected function logActivity($action, $user)
    {
        // You can implement activity logging here
        // For example, create an ActivityLog model and store login/logout activities
        
        /*
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'description' => ucfirst($action) . ' by ' . $user->username,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'created_at' => Carbon::now(),
        ]);
        */
    }

    /**
     * Get user dashboard data.
     *
     * @return array
     */
    public function getDashboardData()
    {
        $user = Auth::user();
        
        return [
            'user' => $user,
            'role' => $user->role ? $user->role->name : 'No Role',
            'permissions' => $user->permissions ? json_decode($user->permissions, true) : [],
            'last_login' => $user->last_login ? $user->last_login->format('d/m/Y H:i:s') : 'Belum pernah login',
            'company' => $user->company_id, // You might want to load company relationship
            'manager' => $user->manager_id, // You might want to load manager relationship
        ];
    }
}