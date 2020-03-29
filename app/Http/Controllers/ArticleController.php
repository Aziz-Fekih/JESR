<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Adresse;
class ArticleController extends Controller
{
    public function createArticle(Request $request){
        $article = new Article();
        $article->nom = $request->nom;
        $article->description = $request->description;
        $article->user_id = $request->userId;
        $article->save();
        return response()->json('Article ajoute!', 200);  
    }
    public function getArticles(Request $request){
        $articles = Article::all()->load('user');
        return response()->json($articles, 200);
    }

    public function getArticle(Request $request, Article $article){
        if($article->id)
            return response()->json($article->load('user'), 200);
        return response()->json('article non trouve!', 400);  
    }

    public function updateArticle(Request $request, Article $article){
      
        if($article->id){
            $article->Update([  'nom' => $request->nom, 'description' => $request->description
                             ]);
  
            return response()->json('Article modifie!', 200); 
        }else{
            return response()->json('Aucun article trouve', 405);
        }
                    
    }
  
    public function deleteArticle(Request $request, Article $article){
        if($article->id){
            $article->delete();
            return response()->json('Article supprime!', 200);    
        }else{
            return response()->json('Aucun article trouve', 405);
        }
    }
}
//delete Update
