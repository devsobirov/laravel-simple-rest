<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Tag;
use App\Http\Requests\CreateArticleRequest as CreateRequest;
use App\Http\Requests\UpdateArticleRequest as UpdateRequest;

class ArticleController extends Controller
{
    /**
     * Возвращает список стаьей с тегами;
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('tags:name')->orderByDesc('id')->get();
        return response()->json($articles);
    }

    /**
     * Создает новую статью и его теги;
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $articleData = $request->except('tags');
    
        /** @var array $tags - Массив с ID для данной статьи */
        $tags = $this->getTags($request->input('tags'));

        $article = Article::create($articleData);

        if ($article && !empty($tags)) {
            $article->tags()->attach($tags);
        }

        if (!$article) {
            return response()->json(['message' => 'Something went wrong'], 422);
        }
        return response()->json(['message' => 'Article successfully created'], 201);
    }

    /**
     * Обновляет существущую статью.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Eloquent|Article  $article
     * @return \Illuminate\Http\Response
     */    

    public function update(UpdateRequest $request, Article $article)
    {
        $articleData = $request->except('tags');
        /** @var array $tags - Массив с ID для данной статьи */
        $tags = $this->getTags($request->input('tags'));

        $updated = $article->update($articleData);

        //Обновляет или стирает теги для статьи;
        if ($updated) {
            $article->tags()->sync($tags);
        }

        /**
         *      АЛЬТЕРНАТИВНЫЕ СЛУЧАИ:
         * 1. Если после редактирования статья должень иметь хотя бы 1 тег - добавляем 
         *   !empty($tags) в условия if()
         * 2. Если после редактирования теги статьи, не введенные (предыдущие) теги не стирались,
         *    добавляем --flag false к методу ->sync()
         
            if($updated && !empty($tags)) {
                $article->tags()->sync($tags);
                //$article->tags()->sync($tags, false);
            }
        */

        if (!$updated) {
            return response()->json(['message' => "Something went wrong", 422]);
        }
        return response()->json(["Article successfully updated"], 204);
    }

    /**
     * Удаляет статью из БД
     *
     * @param  Eloquent|Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $result = $article->delete();
        if (!$result) {
            return response()->json(['message' => "Something went wrong", 422]);
        }
        return response()->json(['message' => "Article successfuly deleted"], 204);
    }

    /**
     * Валидирует полученных тегов, возвращает массив с ID созданных или существующих тегов;
     * 
     * @param string $tags - полученные теги из запроса ввиде : "Тег-1, Тег-2, ..., Тег-n"
     * @return array $tagsId - массив с ID актуальных тегов;
     */

    protected function getTags($tags) : array
    {
        $tagsId = [];
        // Конвертируем строку тегов в массив через ","; удаляем пробелы или переводим символы на uppercase;
        $tagsArray = array_map('strtoupper', array_map('trim', explode(',', $tags)));
        // Предотвращаем дублирования тегов;
        $uniqueTags = array_unique($tagsArray);

        foreach ($uniqueTags as $tagName) {
            //Предотвращаем создания тега с пустой строкой;
            if ($tagName) {
                $tag = Tag::FirstOrCreate([
                    'name' => $tagName
                ]);
                $tagsId[] = $tag->id;
            }
        }

        return $tagsId;
    }
}
