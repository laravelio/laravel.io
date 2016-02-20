<?php
namespace Lio\Http\Controllers\Admin;

use Lio\Http\Controllers\Controller;

class OverviewController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function overview()
    {
        return redirect()->route('admin.users');
    }
}
