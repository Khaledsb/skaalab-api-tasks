<?php

namespace App\Http\Controllers\Api;

use App\Contracts\TaskRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TaskDestroyRequest;
use App\Http\Requests\Api\TaskIndexRequest;
use App\Http\Requests\Api\TaskShowRequest;
use App\Http\Requests\Api\TaskStoreRequest;
use App\Http\Requests\Api\TaskUpdataRequest;
use App\Http\Resources\Api\TaskResource;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(TaskIndexRequest $request)
    {
        try {
            $tasks = $this->taskRepository->findAll();

            return response()->json([
                'tasks' => TaskResource::collection($tasks),
                'code' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $task = $this->taskRepository->store($data);

            return response()->json([
                'message' => 'Task created successfully',
                'task' => new TaskResource($task),
                'code' => Response::HTTP_CREATED
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskShowRequest $request)
    {
        $data = $request->validated();

        try {
            $task = $this->taskRepository->get($data['task']);

            return response()->json([
                'task' => new TaskResource($task),
                'code' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdataRequest $request)
    {
        $data = $request->validated();

        try {
            $this->taskRepository->update($data, $data['task']);
            
            return response()->json([
                'message' => 'Task updated successfully',
                'code' => Response::HTTP_OK
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskDestroyRequest $request)
    {

        $data = $request->validated();

        try {
            $this->taskRepository->delete($data['task']);

            return response()->json([
                'message' => 'Task Delete successfully',
                'code' => Response::HTTP_NO_CONTENT
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_NOT_FOUND
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }
}