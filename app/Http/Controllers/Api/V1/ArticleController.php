<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function index()
    {
        $article = ArticleResource::collection(Article::all());

        return $article;
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), Article::$createRules);

        if ($validated->fails()) {
            return response()->json($validated->messages(), 400);
        }

        $data = $request->all();
        if ($data['slug'] ?? false) {
            $data['slug'] = Str::slug($data['slug']);
        }
        try {
            $article = Article::create($data);
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
        $article = Article::withTrashed()->find($id);

        if (!$article) {
            return response()->json([
                'message' => "Artigo Inexistente"
            ], 404);
        }

        if ($istrashed) {
            $article->restore();
        }

        return response()->json(['article' => $article], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), Article::$updateRules);

        if ($validated->fails()) {
            return response()->json($validated->messages(), 400);
        }

        $data = $request->all();
        if ($data['slug'] ?? false) {
            $data['slug'] = Str::slug($data['slug']);
        }
        try {
            $article = Article::find($id)->update($data);
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
        $article = Article::with('author')->withTrashed()->find($id);

        if (!$article) {
            return response()->json([
                'message' => "Artigo inexistente"
            ], 404);
        }

        if ($istrashed) {
            $article->restore();
        }

        return response()->json(['article' => $article], 200);
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => "Registro inexistente"
            ], 200);
        }
        $article->delete();

        return response()->json(['message' => 'Registro excluido com sucesso'], 200);
    }
}
