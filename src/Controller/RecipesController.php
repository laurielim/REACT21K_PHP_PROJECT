<?php

namespace App\Controller;

use App\Entity\Recipes;
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
        //  JSON data
        $rootPath = $this->getParameter('kernel.project_dir');
        $JSONdata = file_get_contents($rootPath.'/resources/recipeList.json');
        $JSONrecipes= json_decode($JSONdata, true);

        // POSTGRES data
        $DBdata = $this->getDoctrine()->getRepository(Recipes::class)->findAll();
        $DBrecipes =[];
        // Get data of each instance of class Recipe
        foreach($DBdata as $recipe) {
          $ingredientStr = "";
            $ingredients = $recipe->getIngredients();
            foreach($ingredients as $ingredient) {
                $ingredientStr .= $ingredient['ingredient'] . " ";
            }

            $DBrecipes [] = array(
                'id'=>$recipe->getId(),
                'name'=>$recipe->getName(),
                'image'=>$recipe->getImageLink(),
                'ingredients'=>$ingredientStr
            );
        }
        $allRecipes = array_merge($DBrecipes, $JSONrecipes['recipes']);

        $resp = array("count"=>count($allRecipes), "result" => $allRecipes);
        return $this->json($resp);
    }

    /**
     * Route for IBA official cocktails only
     * @return Response
     */
    #[Route('/recipes/iba', name: 'iba_recipes', methods: ['GET'])]
    public function ibaRecipes(): Response
    {
        //  JSON data
        $rootPath = $this->getParameter('kernel.project_dir');
        $JSONdata = file_get_contents($rootPath.'/resources/recipeList.json');
        $JSONrecipes= json_decode($JSONdata, true);

        $formatted_recipes = array();

        foreach($JSONrecipes["recipes"] as $i => $recipe) {
            $formatted_recipes[$i] = $recipe;
            $formatted_recipes[$i]['url'] = "https://laurielim-thecocktailapp-api.herokuapp.com/recipes/" . strval($recipe['id']);
        }

        $resp = array("count"=>count($formatted_recipes), "result" => $formatted_recipes);
        return $this->json($resp);
    }

    #[Route('/recipes/{id}', name: 'recipe', methods: ['GET'])]
    public function recipe($id): Response
    {
        if ($id > 100){
        //  JSON data
            $rootPath = $this->getParameter('kernel.project_dir');
            $JSONdata = file_get_contents($rootPath.'/resources/recipes.json');
            $decodedRecipes = json_decode($JSONdata, true);
            foreach ($decodedRecipes['recipes'] as $recipe) {
              if ($recipe['id'] == $id) {
                  return $this->json($recipe);
              }
            }
        } else {
            $DBdata = $this->getDoctrine()->getRepository(Recipes::class)->findAll();
            foreach ($DBdata as $recipe) {
                if ($recipe->getId() == $id) {
                    $response = array(
                        '@context'=>"https://schema.org/",
                        '@type'=> 'Recipe',
                        'id'=>$recipe->getId(),
                        'name'=>$recipe->getName(),
                        'image'=>array(
                            'url'=>$recipe->getImageLink() ? $recipe->getImageLink() : "https://source.unsplash.com/dNgwsE2HRJw/500x320",
                            'source'=>$recipe->getImageLink() ? $recipe->getImageLink() : "https://source.unsplash.com/dNgwsE2HRJw/500x320",
                            'author'=>$recipe->getImageLink() ? $recipe->getImageAuthor() : "Louis Hansel",
                            'license'=>$recipe->getImageLink() ? $recipe->getImageLicense() : "the Unsplash License",
                        ),
                        'recipeCategory'=>'other cocktails',
                        'description'=>$recipe->getDescription(),
                        'recipeIngredient'=>$recipe->getIngredients(),
                        'recipeGarnish'=>$recipe->getGarnish(),
                        'recipeInstructions'=>$recipe->getInstructions()
                    );

                    return $this->json($response);
                }
            }

        }
        return $this->json(['message' => 'recipe not found']);

    }

    #[Route('/recipes/add', name: 'add_new_recipe', methods: ['POST'])]
    public function addRecipe(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $newRecipe = new Recipes();
        $newRecipe->setName($data['name']);
        $newRecipe->setDescription($data['desc']);
        $newRecipe->setImageAuthor($data['imageAuthor']);
        $newRecipe->setImageLicense($data['imageLicense']);
        $newRecipe->setImageLink($data['imageLink']);
        $newRecipe->setIngredients($data['ingredients']);
        $newRecipe->setGarnish($data['garnish']);
        $newRecipe->setInstructions($data['instructions']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($newRecipe);
        $entityManager->flush();

        return new Response('Adding new recipe ' . $newRecipe->getId());
    }
}
