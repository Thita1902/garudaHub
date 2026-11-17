<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    // Developer mengajukan penawaran
    public function store(Request $request, Project $project)
    {
        abort_unless(auth()->user()->role === 'developer', 403);

        if ($project->status !== 'open') {
            return back()->withErrors(['bid' => 'Proyek ini sudah tidak menerima penawaran.']);
        }

        $sudahMenawar = Bid::where('project_id', $project->id)
            ->where('developer_id', auth()->id())
            ->exists();

        if ($sudahMenawar) {
            return back()->withErrors(['bid' => 'Kamu sudah menawar proyek ini.']);
        }

        $data = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'proposal' => ['required', 'string'],
        ]);

        $data['project_id'] = $project->id;
        $data['developer_id'] = auth()->id();
        Bid::create($data);

        return redirect()->route('projects.show', $project)->with('success', 'Penawaran berhasil dikirim.');
    }

    // Klien memilih pemenang
    public function accept(Bid $bid)
    {
        $project = $bid->project;

        abort_unless($project->client_id === auth()->id(), 403);

        if ($project->status !== 'open') {
            return back()->withErrors(['bid' => 'Pemenang untuk proyek ini sudah dipilih.']);
        }

        DB::transaction(function () use ($bid, $project) {
            $project->bids()->where('id', '!=', $bid->id)->update(['status' => 'rejected']);
            $bid->update(['status' => 'accepted']);
            $project->update(['status' => 'awarded']);
        });

        return redirect()->route('projects.show', $project)->with('success', 'Pemenang berhasil dipilih.');
    }
}