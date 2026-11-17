<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:50'],
            'budget_min' => ['required', 'numeric', 'min:0'],
            'budget_max' => ['required', 'numeric', 'gte:budget_min'],
            'deadline' => ['required', 'date'],
        ];
    }

    public function index()
    {
        $projects = Project::with('client')->latest()->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        abort_unless(auth()->user()->role === 'client', 403);

        return view('projects.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->role === 'client', 403);

        $data = $request->validate($this->rules());
        $data['client_id'] = auth()->id();
        Project::create($data);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $project)
    {
        $project->load('client', 'bids.developer');

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        abort_unless($project->client_id === auth()->id(), 403);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        abort_unless($project->client_id === auth()->id(), 403);

        $project->update($request->validate($this->rules()));

        return redirect()->route('projects.show', $project)->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        abort_unless($project->client_id === auth()->id(), 403);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyek dihapus.');
    }
}