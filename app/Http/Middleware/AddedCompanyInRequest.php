<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddedCompanyInRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Company::where('id', $request->company)->exists()) {
            $request->query->set('company_id', $request->company);
            return $next($request);
        } else {
            return response()->json(
                ['error' => 'Empresa não encontrada.'],
                422
            );
        }
    }
}
