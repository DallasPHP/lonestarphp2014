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
        $speakerRepo = $this->get('repository.manager')->factory('Speaker');

        return $this->render("index.html.twig", [
            'speakers' => $speakerRepo->fetchRandom()
        ]);
    }

    /**
     * @Route("/code-of-conduct",methods={"GET"},name="coc")
     */
    public function codeOfConduct() {
        return $this->render("coc.html.twig", []);
    }

    /**
     * @Route("/speakers",methods={"GET"},name="speakers")
     */
    public function speakersAction() {
        $speakerRepo = $this->get('repository.manager')->factory('Speaker');

        return $this->render("speakers.html.twig", ['speakers' => $speakerRepo->fetchAllSelected()]);
    }

    /**
     * @Route("/talks",methods={"GET"},name="talk")
     */
    public function talksAction()
    {
        $talkRepo = $this->get('repository.manager')->factory('Talk');

        return $this->render("talks.html.twig", ['talks' => $talkRepo->fetchAllSelected()]);
    }

    /**
     * @Route("/foundations",methods={"GET"},name="foundation")
     */
    public function foundationAction()
    {
        return $this->render("foundation.html.twig", []);
    }


    /**
     * @Route("/schedule",methods={"GET"},name="schedule")
     */
    public function scheduleAction()
    {
        return $this->render("schedule.html.twig", []);
    }

    /**
     * @Route("/sponsors",methods={"GET"},name="sponsors")
     */
    public function sponsorsAction() {
        return $this->render("sponsors.html.twig", []);
    }

    /**
     * @Route("/venue",methods={"GET"},name="venue")
     */
    public function venueAction()
    {
        return $this->render("venue.html.twig", []);
    }

    /**
     * @Route("/contact",methods={"GET"},name="contact")
     */
    public function contactAction()
    {
        return $this->render("contact.html.twig", []);
    }

    /**
     * @Route("/credits",methods={"GET"},name="credits")
     */
    public function creditsAction() {
        return $this->render("credits.html.twig", []);
    }

    /**
     * @Route("/refund",methods={"GET"},name="refund")
     */
    public function refundAction() {
        return $this->render("refund.html.twig", []);
    }
}