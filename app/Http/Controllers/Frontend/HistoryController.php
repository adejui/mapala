<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Loan;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function history()
    {
        $guard = auth('web')->check() ? 'web' : 'opa';

        $column = $guard === 'web' ? 'user_id' : 'opa_id';

        $histories = Loan::with(['details.item'])
            ->withSum('details', 'quantity')
            ->where($column, auth($guard)->id())
            ->latest()
            ->paginate(5);

        return view('frontend.history.index', compact('histories', 'guard'));
    }
}
