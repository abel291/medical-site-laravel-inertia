<?php

namespace App\Http\Middleware;

use App\Models\Specialty;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Cache::flush();
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'specialties' => function () {
                return Cache::remember('services', 3600, function () {
                    return Specialty::select('id', 'name', 'slug')
                        ->with(['surgeries' => function (Builder $query) {
                            $query->select('id', 'specialty_id', 'name', 'slug');
                        }])->get();
                });
            },
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],

        ];
    }
}
