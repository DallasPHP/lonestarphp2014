<?php
namespace LSP\Controller;

use Orlex\Annotation\Route;

use Orlex\ContainerAwareTrait;
use Orlex\Controller\TwigTrait;
use Orlex\Controller\FormTrait;
use Orlex\Controller\SessionTrait;
use Orlex\Controller\UrlGeneratorTrait;

use LSP\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController {
    use ContainerAwareTrait;
    use TwigTrait;
    use FormTrait;
    use SessionTrait;
    use UrlGeneratorTrait;

    /**
     * @Route("/",methods={"GET"},name="index")
     */
    public function indexAction() {
        // $form = $this->createBuilder(new Form\LoginForm())->getForm();

        return $this->render("index.html.twig", [
            // 'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/code-of-conduct",methods={"GET"},name="coc")
     */
    public function codeOfConduct() {
        return $this->render("coc.html.twig", []);
    }
}