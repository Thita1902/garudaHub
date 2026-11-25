<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    // Menampilkan halaman rating
    public function create(Project $project)
    {
        abort_unless($project->client_id === Auth::id(), 403);

        $acceptedBid = $project->bids()
            ->where('status', 'accepted')
            ->first();

        if (!$acceptedBid) {
            return redirect()
                ->route('projects.show', $project)
                ->withErrors(['rating' => 'Belum ada developer yang dipilih.']);
        }

        if ($project->rating()->exists()) {
            return redirect()
                ->route('projects.show', $project)
                ->withErrors(['rating' => 'Proyek ini sudah diberi rating.']);
        }

        return view('ratings.create', compact('project'));
    }

    // Menyimpan rating
    public function store(Request $request, Project $project)
    {
        abort_unless($project->client_id === Auth::id(), 403);

        $validated = $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $acceptedBid = $project->bids()
            ->where('status', 'accepted')
            ->first();

        if (!$acceptedBid) {
            return back()->withErrors([
                'rating' => 'Belum ada developer yang dipilih.'
            ]);
        }

        if ($project->rating()->exists()) {
            return redirect()
                ->route('projects.show', $project)
                ->withErrors(['rating' => 'Proyek ini sudah diberi rating.']);
        }

        Rating::create([
            'project_id' => $project->id,
            'client_id' => Auth::id(),
            'developer_id' => $acceptedBid->developer_id,
            'score' => $validated['score'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Rating berhasil diberikan.');
    }
}
