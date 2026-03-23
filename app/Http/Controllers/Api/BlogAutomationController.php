<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BlogImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BlogAutomationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:125',
            'category' => 'required|integer|exists:blog_categories,id',
            'description' => 'required|string',
            'keyword' => 'required|string',
            'is_popular' => 'sometimes|in:0,1',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first(),
            ], 422);
        }

        $userId = config('services.n8n_blog.user_id');
        if ($userId === null || $userId === '') {
            Log::error('Blog automation: N8N_BLOG_USER_ID is not configured');

            return response()->json([
                'success' => false,
                'error' => 'Service misconfigured',
            ], 500);
        }

        $userId = (string) $userId;

        try {
            $imageFile = $request->file('image');
            if (!$imageFile || !$imageFile->isValid()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid image upload',
                ], 422);
            }

            $imageName = app(BlogImageService::class)->storeProcessed($imageFile);
            if ($imageName === '' || $imageName === null) {
                Log::warning('Blog automation: image processing returned empty filename');

                return response()->json([
                    'success' => false,
                    'error' => 'Image processing failed',
                ], 500);
            }

            $isPopular = in_array($request->input('is_popular', 0), [1, '1'], true) ? 1 : 0;

            $now = Carbon::now();

            try {
                $blogId = DB::table('blogs')->insertGetId([
                    'title' => sanitize($request->title),
                    'image' => $imageName,
                    'user_id' => $userId,
                    'category' => sanitize((string) $request->category),
                    'description' => $request->description,
                    'keyword' => sanitize($request->keyword),
                    'status' => 0,
                    'time' => time(),
                    'is_popular' => $isPopular,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            } catch (\Throwable $dbException) {
                Log::error('Blog automation: database insert failed', [
                    'message' => $dbException->getMessage(),
                ]);
                $diskPath = public_path('uploads/blog-images/' . $imageName);
                if (is_file($diskPath)) {
                    @unlink($diskPath);
                }

                return response()->json([
                    'success' => false,
                    'error' => 'Blog creation failed',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Blog created',
                'blog_id' => $blogId,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Blog automation: create failed', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Blog creation failed',
            ], 500);
        }
    }
}
