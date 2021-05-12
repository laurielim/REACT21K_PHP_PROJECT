<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipesController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route('/recipes', name: 'all_recipes', methods: ['GET'])]
    public function allRecipes(): Response
    {
        $rootPath = $this->getParameter('kernel.project_dir');
        $recipes = file_get_contents($rootPath.'/resources/recipeList.json');
        $decodedRecipes = json_decode($recipes, true);
        $resp = array("count"=>count($decodedRecipes["recipes"]), "result" => $decodedRecipes["recipes"]);
        return $this->json($resp);
    }

    #[Route('/recipes/{id}', name: 'recipe', methods: ['GET'])]
    public function recipe($id): Response
    {
        $rootPath = $this->getParameter('kernel.project_dir');
        $recipes = file_get_contents($rootPath.'/resources/recipes.json');
        $decodedRecipes = json_decode($recipes, true);
        foreach ($decodedRecipes['recipes'] as $recipe) {
          if ($recipe['id'] == $id) {
              return $this->json($recipe);
          }
        }
        return $this->json(['message' => 'recipe not found']);
    }
}
