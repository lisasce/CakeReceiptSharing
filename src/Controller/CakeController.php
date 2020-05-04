<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Cakes;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/user")
 */
class CakeController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function showAction()
    {
        $cakes = $this->getDoctrine()
            ->getRepository(Cakes::class)
            ->findAll();
        return $this->render('cake/index.html.twig', array("cakes"=>$cakes));
    }

    /**
     * @Route("/create", name="create_page")
     */
    public function createAction(Request $request)
    {
        $cake = new Cakes;
        $form = $this->createFormBuilder($cake)
            ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('recipeLink', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('author', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('category', ChoiceType::class, array('choices'=>array('STANDARD'=>'STANDARD', 'VEGAN'=>'VEGAN', 'VEGAN/GF'=>'VEGAN/GF', 'GF'=>'GF'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
            ->add('language', ChoiceType::class, array('choices'=>array('FR'=>'FR', 'DE'=>'DE', 'EN'=>'EN', 'GR'=>'GR'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
            ->add('calories', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('publishDate', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=> 'Create Recipe', 'attr' => array('class'=> 'btn-primary', 'style'=>'margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $language = $form['language']->getData();
            $description = $form['description']->getData();
            $image = $form['image']->getData();
            $recipeLink = $form['recipeLink']->getData();
            $calories = $form['calories']->getData();
            $author = $form['author']->getData();
            $now = new\DateTime('now');


            $cake->setName($name);
            $cake->setCategory($category);
            $cake->setDescription($description);
            $cake->setLanguage($language);
            $cake->setImage($image);
            $cake->setRecipeLink($recipeLink);
            $cake->setCalories($calories);
            $cake->setAuthor($author);
            $cake->setPublishDate($now);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cake);
            $em->flush();
            $this->addFlash(
                'notice',
                'Cake Added'
            );
            return $this->redirectToRoute('index_page');
        }

        return $this->render('cake/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/edit/{id}", name="edit_page")
     */
    public function editAction( $id, Request $request){

        $cake = $this->getDoctrine()->getRepository('App:Cakes')->find($id);
        $now = new\DateTime('now');

        $cake->setName($cake->getName());
        $cake->setCategory($cake->getCategory());
        $cake->setDescription($cake->getDescription());
        $cake->setLanguage($cake->getLanguage());
        $cake->setImage($cake->getImage());
        $cake->setRecipeLink($cake->getRecipeLink());
        $cake->setCalories($cake->getCalories());
        $cake->setAuthor($cake->getAuthor());
        $cake->setPublishDate($now);

        $form = $this->createFormBuilder($cake)
            ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('recipeLink', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('author', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('category', ChoiceType::class, array('choices'=>array('STANDARD'=>'STANDARD', 'VEGAN'=>'VEGAN', 'VEGAN/GF'=>'VEGAN/GF', 'GF'=>'GF'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
            ->add('language', ChoiceType::class, array('choices'=>array('FR'=>'FR', 'DE'=>'DE', 'EN'=>'EN', 'GR'=>'GR'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
            ->add('calories', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('publishDate', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=> 'Edit Recipe', 'attr' => array('class'=> 'btn-primary', 'style'=>'margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $language = $form['language']->getData();
            $description = $form['description']->getData();
            $image = $form['image']->getData();
            $recipeLink = $form['recipeLink']->getData();
            $calories = $form['calories']->getData();
            $author = $form['author']->getData();
            $now = new\DateTime('now');
            $em = $this->getDoctrine()->getManager();
            $cake = $em->getRepository('App:Cakes')->find($id);
            $cake->setName($name);
            $cake->setCategory($category);
            $cake->setDescription($description);

            $cake->setLanguage($language);
            $cake->setImage($image);
            $cake->setRecipeLink($recipeLink);
            $cake->setCalories($calories);
            $cake->setAuthor($author);
            $cake->setPublishDate($now);

            $em->flush();
            $this->addFlash(
                'notice',
                'Cake Updated'
            );
            return $this->redirectToRoute('index_page');
        }
        return $this->render('cake/edit.html.twig', array('cake' => $cake, 'form' => $form->createView()));
    }

    /**
     * @Route("/details/{id}", name="details_page")
     */
    public function detailsAction($id)
    {
        $cake = $this->getDoctrine()->getRepository('App:Cakes')->find($id);
       return $this->render('cake/details.html.twig', array('cake' => $cake));
    }

    /**
     * @Route("/delete/{id}", name="delete_page")
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $cake = $em->getRepository('App:Cakes')->find($id);
        $em->remove($cake);
        $em->flush();
        $this->addFlash(
            'notice',
            'Cake Removed'
        );
        return $this->redirectToRoute('index_page');
    }
}
?>
