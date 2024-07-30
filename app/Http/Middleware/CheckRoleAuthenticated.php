<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $role)
    {
        // Kiểm tra nếu người dùng không có vai trò cần thiết
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // Trả về lỗi 403 nếu không có quyền
            return abort(403, 'Unauthorized action.');
        }

        // Tiếp tục với yêu cầu nếu người dùng có quyền
        return $next($request);
    }
}
