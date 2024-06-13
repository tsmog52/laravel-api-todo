<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodosRequest;
use Illuminate\Http\Response;
use App\Http\Requests\TodoCreateRequest;
use App\Http\Requests\UpdateTodosRequest;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class TodosController extends Controller
{
    //一覧表示
    public function index()
    {
        $todos = Todo::select('id', 'title')->get(); //titleのみ取得
        return response()->json([
            'todos' => $todos
        ], Response::HTTP_OK);
    }

    //保存処理
    public function store(StoreTodosRequest $request)
    {
        try {
            $todos = $this->_updateOrCreate($request);

            return response()->json(
                [
                    'code' => Response::HTTP_CREATED,
                    'todo' => $todos
                ],
                Response::HTTP_CREATED
            );
        } catch (Throwable $e) {
            Log::error($e);

            return response()->json(
                [
                    'code' => Response::HTTP_INSUFFICIENT_STORAGE,
                    'message' => 'Internal Server Error'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

   //特定のIDのTodoを取得
    public function show($id): JsonResponse
    {
        try {
            $todos = Todo::findOrFail($id);
            return response()->json([
                'todo' => $todos
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error($e);
            return response()->json([
                'code' => Response::HTTP_NOT_FOUND,
                'message' => 'Not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    //更新処理
    public function update(UpdateTodosRequest $request, $id): JsonResponse
    {
        try {
            $todos = Todo::findOrFail($id);
            $todos->update($request->only('title'));
            return response()->json(
                [
                    'code' => Response::HTTP_OK,
                    'todo' => $todos
                ],
                Response::HTTP_OK
            );
        } catch (Throwable $e){
            Log::error($e);

            return response()->json(
                [
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => 'internal Server Error'
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

   //削除処理
    public function destroy($id): JsonResponse
    {
        try {
            $todos = Todo::findOrFail($id);
            $todos ->delete();

                return response()->json([], Response::HTTP_NO_CONTENT);
            } catch (Throwable $e) {
                Log::error($e);

                return response()->json(
                    [
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => 'Internal Server Error'
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }

    private function _updateOrCreate($request, Todo $todo = null)
    {
        $data = [
            'title' => $request->title,
            'create_at' => now(),
            'update_at' =>now()
        ];

        if ($todo) {
            $todo->update($data);
        } else {
            $todo = Todo::create($data);
        }
        return $todo;
    }
}
