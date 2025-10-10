<?php

namespace App\Http\Controllers;

use App\Http\Requests\Performer\StorePerformerRequest;
use App\Http\Requests\Performer\UpdatePerformerRequest;
use App\Http\Resources\PerformerResource;
use App\Models\Performer;
use App\Services\S3FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PerformerController extends Controller
{
    protected $fileUploader;

    public function __construct(S3FileUploaderService $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $performers = Performer::latest()->paginate(10);

        return response()->json([
            'message' => 'Performers retrieved successfully',
            'data' => PerformerResource::collection($performers),
            'pagination' => [
                'current_page' => $performers->currentPage(),
                'last_page' => $performers->lastPage(),
                'per_page' => $performers->perPage(),
                'total' => $performers->total(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerformerRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $this->fileUploader->uploadSingleFile(
                    $request->file('image'),
                    'performers'
                );
                $data['image'] = $imagePath;
            }

            $performer = Performer::create($data);

            return response()->json([
                'message' => 'Performer created successfully',
                'data' => new PerformerResource($performer)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create performer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Performer $performer): JsonResponse
    {
        return response()->json([
            'message' => 'Performer retrieved successfully',
            'data' => new PerformerResource($performer)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerformerRequest $request, Performer $performer): JsonResponse
    {
        try {
            $data = $request->validated();

            // Handle image upload if new image is provided
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($performer->image) {
                    $this->fileUploader->deleteFile($performer->image);
                }

                $imagePath = $this->fileUploader->uploadSingleFile(
                    $request->file('image'),
                    'performers'
                );
                $data['image'] = $imagePath;
            }

            $performer->update($data);

            return response()->json([
                'message' => 'Performer updated successfully',
                'data' => new PerformerResource($performer)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update performer',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Performer $performer): JsonResponse
    {
        try {
            // Delete associated image if exists
            if ($performer->image) {
                $this->fileUploader->deleteFile($performer->image);
            }

            $performer->delete();

            return response()->json([
                'message' => 'Performer deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete performer',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
