<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = Auth::user()
        ->ideas()
        ->when($request->status, fn($query, $status) => $query->where('status', $status)) 
        ->get();

        $counts = Auth::user()->ideas()
        ->selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');

        $statusCounts = collect(IdeaStatus::cases())
        ->mapWithKeys(fn($status) => [
            $status->value => $counts->get($status->value, 0),
        ])
        ->put('all', Auth::user()->ideas()->count());

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' =>$statusCounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        //
    }
}
