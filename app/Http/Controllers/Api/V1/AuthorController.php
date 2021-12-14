<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{

    public function index()
    {
        $authors = AuthorResource::collection(Author::all());
        return $authors;
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), Author::$createRules);


        if ($validated->fails()) {
            return response()->json($validated->messages(), 400);
        }

        $data = $request->all();
        try {
            $author = Author::create($data);
        } catch (QueryException $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            return response()->json([
                $exception->getMessage()
            ]);
        } catch (MassAssignmentException $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            return response()->json([
                $exception->getMessage()
            ]);
        } catch (\TypeError $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            return response()->json([
                $exception->getMessage()
            ]);
        } finally {
            DB::commit();
        }

        return response()->json([
            'success' => true
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        $validated = Validator::make($request->all(), ['trashed' => 'boolean']);

        if ($validated->fails()) {
            return response()->json($validated->messages(), 400);
        }

        $istrashed = $request->input('trashed') ?? false;
        $author = Author::withTrashed()->find($id);
        if (!$author) {
            return response()->json([
                'message' => "Autor não cadastrado"
            ], 404);
        }

        if ($istrashed) {
            $author->restore();
        }

        return response()->json(['author' => $author], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), Author::$updateRules);

        if ($validated->fails()) {
            return response()->json($validated->messages(), 400);
        }

        $data = $request->all();
        try {
            $author = Author::find($id)->update($data);
        } catch (QueryException $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            return response()->json([
                $exception->getMessage()
            ]);
        } catch (MassAssignmentException $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            return response()->json([
                $exception->getMessage()
            ]);
        } catch (\TypeError $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            return response()->json([
                $exception->getMessage()
            ]);
        } finally {
            DB::commit();
        }

        return response()->json([
            'success' => true
        ], 204);
    }

    public function show(Request $request, $id)
    {
        $validated = Validator::make($request->all(), ['trashed' => 'boolean']);

        if ($validated->fails()) {
            return response()->json($validated->messages(), 400);
        }

        $istrashed = $request->input('trashed') ?? false;
        $author = Author::with('article')->withTrashed()->find($id);
        if (!$author) {
            return response()->json([
                'message' => "Autor não cadastrado"
            ], 404);
        }

        if ($istrashed) {
            $author->restore();
        }


        return response()->json(['author' => $author], 200);
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => "Registro inexistente"
            ], 200);
        }
        $author->delete();
        return response()->json(['message' => 'Registro excluido com sucesso'], 200);
    }
}
