<?php

namespace App\Http\Controllers;

use App\Models\TeamPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeamPostController extends Controller
{
    // GET /api/teams/{team_id}/posts
    public function index($team_id)
    {
        $posts = TeamPost::where('team_id', $team_id)
            ->with(['team', 'user'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Team posts retrieved successfully',
            'data' => $posts
        ]);
    }

    // GET /api/posts/{id}
    public function show($id)
    {
        $post = TeamPost::with(['team', 'user'])->find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Post retrieved successfully',
            'data' => $post
        ]);
    }

    // POST /api/teams/{team_id}/posts
    public function store(Request $request, $team_id)
    {
        $request->validate([
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('team_posts', 'public');
        }

        $post = TeamPost::create([
            'team_id' => $team_id,
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'file' => $filePath,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post
        ], 201);
    }

    // PUT /api/posts/{id}
    public function update(Request $request, $id)
    {
        $post = TeamPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $request->validate([
            'description' => 'sometimes|required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($post->file && Storage::disk('public')->exists($post->file)) {
                Storage::disk('public')->delete($post->file);
            }
            $post->file = $request->file('file')->store('team_posts', 'public');
        }

        $post->description = $request->description ?? $post->description;
        $post->save();

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    // DELETE /api/posts/{id}
    public function destroy($id)
    {
        $post = TeamPost::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        // Delete file if exists
        if ($post->file && Storage::disk('public')->exists($post->file)) {
            Storage::disk('public')->delete($post->file);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
