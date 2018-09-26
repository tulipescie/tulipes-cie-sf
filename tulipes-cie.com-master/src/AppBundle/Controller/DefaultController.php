<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Award;
use AppBundle\Entity\Bulbe\AbstractBulbe;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Figure;
use AppBundle\Entity\Filter\AbstractFilter;
use AppBundle\Entity\Filter\ActivityFilter;
use AppBundle\Entity\Filter\AwardFilter;
use AppBundle\Entity\Filter\CustomerFilter;
use AppBundle\Entity\Filter\DirectorFilter;
use AppBundle\Entity\Filter\TechFilter;
use AppBundle\Entity\Filter\ThematicFilter;
use AppBundle\Entity\NewsletterSubscriber;
use AppBundle\Entity\Number;
use AppBundle\Entity\Page\AgencyPage;
use AppBundle\Entity\Page\BulbePage;
use AppBundle\Entity\Page\ContactPage;
use AppBundle\Entity\Page\HomePage;
use AppBundle\Entity\Page\LegalNoticePage;
use AppBundle\Entity\Page\NewsPage;
use AppBundle\Entity\Page\ProjectsPage;
use AppBundle\Entity\Page\TeamPage;
use AppBundle\Entity\Project;
use AppBundle\Entity\TeamMember;
use AppBundle\Entity\Vision;
use AppBundle\Form\ContactType;
use AppBundle\Form\NewsletterSubscriberType;
use AppBundle\Utils\NewsFeed;
use AppBundle\Utils\RecaptchaValidator;
use Happyr\LinkedIn\LinkedIn;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route(
     *  "/{_locale}",
     *  name="homepage",
     *  defaults={"_locale": "%locale%"},
     *  requirements={ "_locale": "%available_locales%" }
     * )
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $homePage = $em->getRepository(HomePage::class)
            ->createQueryBuilder('h')
            ->orderBy("h.createdAt", "DESC")
            ->getQuery()->getResult()[0];

        $videoDesktopNumbers = []; $videosMobileNumbers = [];
        for ($i = 1 ; $i <= 6 ; $i++) {
            $videoDesktop = call_user_func([$homePage, 'getVideoDesktop'.$i]);
            //ajout du numéro de la vidéo s'il y en a une
            if ($videoDesktop !== null)  array_push($videoDesktopNumbers, $i);

            $videosMobile = call_user_func([$homePage, 'getVideoMobileFile'.$i]);
            if ($videosMobile !== null)  array_push($videosMobileNumbers, $i);
        }
        shuffle($videoDesktopNumbers);
        shuffle($videosMobileNumbers);

        $newletterSubscriber = new NewsletterSubscriber();
        $form = $this->createForm(NewsletterSubscriberType::class, $newletterSubscriber);

        return $this->render('index.html.twig', [
            'home_page' => $homePage,
            'videoDesktopNumbers' => $videoDesktopNumbers,
            'videosMobileNumbers' => $videosMobileNumbers,
            'form' => $form->createView(),
        ]);
    }

    private function jsonResponse($data)
    {
        return new Response(
            $this->get('jms_serializer')->serialize($data, 'json'),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @Route("/ajax/newsletter.json", name="ajax_newsletter")
     */
    public function ajaxSendFormNewsletter(Request $request)
    {
        $newletterSubscriber = new NewsletterSubscriber();
        $form = $this->createForm(NewsletterSubscriberType::class, $newletterSubscriber);
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($newletterSubscriber);
                $em->flush();
                return $this->jsonResponse([
                    'message' => true,
                ]);
            }
        }

        return $this->jsonResponse([
            'message' => false,
        ]);
    }

    /**
     * Page of agency's presentation
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_agency",
     *     defaults={"slug": "agence", "_locale": "%locale%" },
     *     requirements={ "slug": "agence|agency", "_locale": "%available_locales%"  }
     * )
     */
    public function agencyAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agencyPage = $em->getRepository(AgencyPage::class)
            ->createQueryBuilder('a')
            ->orderBy("a.createdAt", "DESC")
            ->getQuery()->getResult();

        $visions = $em->getRepository(Vision::class)
            ->createQueryBuilder('v')
            ->orderBy("v.createdAt", "DESC")
            ->getQuery()->getResult();

        $figures = $em->getRepository(Figure::class)
            ->createQueryBuilder('f')
            ->orderBy("f.position", "ASC")
            ->getQuery()->getResult();

        $numbers = $em->getRepository(Number::class)
            ->createQueryBuilder('n')
            ->orderBy("n.createdAt", "DESC")
            ->getQuery()->getResult();

        $awards = $em->getRepository(Award::class)
            ->createQueryBuilder('a')
            ->orderBy("a.createdAt", "DESC")
            ->getQuery()->getResult();

        $customers = $em->getRepository(CustomerFilter::class)
            ->createQueryBuilder('c')
            ->orderBy("c.createdAt", "DESC")
            ->getQuery()->getResult();

        return $this->render('agency.html.twig', [
            'agency_page' => $agencyPage[0],
            'visions' => $visions,
            'figures' => $figures,
            'numbers' => $numbers,
            'awards' => $awards,
            'customers' => $customers,
        ]);
    }

    /**
     * Page of team's presentation
     *
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_team",
     *     defaults={"slug": "equipe", "_locale": "%locale%"},
     *     requirements={ "slug": "equipe|team", "_locale": "%available_locales%" }
     * )
     */
    public function teamAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teamPage = $em->getRepository(TeamPage::class)
            ->createQueryBuilder('tp')
            ->orderBy("tp.createdAt", "DESC")
            ->getQuery()->getResult();

        $team = $em->getRepository(TeamMember::class)
            ->createQueryBuilder('t')
            ->andWhere("t.isActive = :activation")
            ->setParameter('activation', true)
            ->orderBy("t.createdAt", "DESC")
            ->getQuery()->getResult();

        return $this->render('team.html.twig', [
            'team_page' => $teamPage[0],
            'team' => $team,
        ]);
    }

    /**
     * Page of achievements
     *
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_achievements",
     *     defaults={"slug": "realisations", "_locale": "%locale%"},
     *     requirements={ "slug": "realisations|our-work", "_locale": "%available_locales%" }
     * )
     */
    public function achievementsAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            return $this->filterAchievements($request);
        }

        $em = $this->getDoctrine()->getManager();

        $projectsPage = $em->getRepository(ProjectsPage::class)
            ->createQueryBuilder('tp')
            ->orderBy("tp.createdAt", "DESC")
            ->getQuery()->getResult();

        $projects = $em->getRepository(Project::class)
            ->findBy(['isNotShow' => false], ['createdAt' => 'desc']);

        $locale = $request->getLocale();

        $filters = [];
        foreach(Project::$filtersTypes as $type => $class) {
            if($type === "Award") {
                $filters[$type] = $em->getRepository($class)->findAll();
            } else {
                $filters[$type] = $em->getRepository($class)->findBy([], ['name.' . $locale => 'asc']);
            }
        }

        return $this->render('achievements.html.twig', [
            'projects_page' => $projectsPage[0],
            'projects' => $projects,
            'filters' => $filters,
        ]);

    }

    protected function filterAchievements(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filterRepository = $em->getRepository(AbstractFilter::class);

        $filters = []; $filters_id = [];
        foreach(Project::$filtersTypes as $type => $class) {
            $id = $request->get($type, false);
            if (!$id) {
                continue;
            }
            $filters[$type] = $filterRepository->find($id);
            array_push($filters_id, $filters[$type]->getId());
        }

        $projects = $em->getRepository(Project::class)->findAllWithFilters($filters_id);

        $mapped = array_map(function ($project) {
            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            return [
                'id'    => $project->getId(),
                'title' => $project->getTitle(),
                'slug'  => $project->getSlug(),
                'image' => $helper->asset($project->getThumb1Image(), 'imageFile'),
            ];
        }, $projects);

        $message = null;
        $translator = $this->get('translator');
        if (count($mapped) === 0 )   $message = $translator->trans('achievements.no_project_by_filters');

        return $this->jsonResponse([
            'projects' => $mapped,
            'locale' => $request->getLocale(),
            'message' => $message,
        ]);
    }

    /**
     * Page of achievement's details
     *
     * @Route("{_locale}/video/{projectSlug}", options={"expose"=true}, name="app_project")
     */
    public function achievementAction($projectSlug)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Project::class);
        $project = $em->findOneBySlug($projectSlug);

        if(!$project){
            throw $this->createNotFoundException('The project does not exist');
        }

        $projects = $em->findBy(array('isNotShow' => true), array('createdAt' => 'desc'));

        $projectKey = null;
        foreach ($projects as $key => $projectSearch) {
            if ($projectSearch->getId() == $project->getId()){
                $projectKey = $key;
                break;
            }
        }

        $facebookId = $this->container->getParameter('facebook_api_key');

        return $this->render('project.twig', [
            'projects' => $projects,
            'project' => $project,
            'projectKey' => $projectKey,
            'facebookId' => $facebookId,
        ]);

    }

    /**
     * Page of bulbe
     *
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_bulbe",
     *     defaults={"slug": "bulbe", "_locale": "%locale%" },
     *     requirements={ "slug": "bulbe", "_locale": "%available_locales%" }
     * )
     */
    public function bulbeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bulbePage = $em->getRepository(BulbePage::class)
            ->createQueryBuilder('b')
            ->orderBy("b.createdAt", "DESC")
            ->getQuery()->getResult();

        $projects = $em->getRepository(Project::class)->findBy(
            array('isNotShow' => false),
            array('createdAt' => 'desc')
        );

        $bulbes = $em->getRepository(AbstractBulbe::class)
            ->createQueryBuilder('a')
            ->orderBy("a.createdAt", "DESC")
            ->getQuery()->getResult();

        $smallBulbes = []; $mediumBulbes = []; $bigBulbes = [];

        foreach ($bulbes as $bulbe) {
            $size = $bulbe->getBlocSize();
            if ($size == "small") {
                array_push($smallBulbes, $bulbe);
            } elseif ($size == "medium") {
                array_push($mediumBulbes, $bulbe);
            } else {
                array_push($bigBulbes, $bulbe);
            }
        }

        //Ajout des infos de la page Bulbe à l'index 2 de $mediumBulbe
        if (count($mediumBulbes) >=1 ) {
            $tab1 = [$mediumBulbes[0], $bulbePage[0]];
            $tab2 = array_slice($mediumBulbes, 1);
            $mediumBulbes = array_merge($tab1, $tab2);
        } else {
            array_push($mediumBulbes,  $bulbePage[0]);
        }

        return $this->render('bulbe.html.twig', [
            'bulbe_page' => $bulbePage[0],
            'smallBulbes' => $smallBulbes,
            'mediumBulbes' => $mediumBulbes,
            'bigBulbes' => $bigBulbes,
        ]);
    }

    /**
     * Page of news
     *
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_news",
     *     defaults={"slug": "news", "_locale": "%locale%" },
     *     requirements={ "slug": "news|actualites", "_locale": "%available_locales%" }
     * )
     */
    public function newsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $newsPage = $em->getRepository(NewsPage::class)
            ->createQueryBuilder('b')
            ->orderBy("b.createdAt", "DESC")
            ->getQuery()->getResult();

        $newsFeed = new NewsFeed($this->container);
        $appFeed = $newsFeed->getAppFeed();

        return $this->render('news.html.twig', [
            'news_page' => $newsPage[0],
            'appFeed' => $appFeed,
        ]);
    }

    /**
     * Page of contact
     *
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_contact",
     *     defaults={"slug": "contact", "_locale": "%locale%" },
     *     requirements={ "slug": "contact", "_locale": "%available_locales%" }
     * )
     */
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $contactPage = $em->getRepository(ContactPage::class)
            ->createQueryBuilder('b')
            ->orderBy("b.createdAt", "DESC")
            ->getQuery()->getResult();

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $translator = $this->get('translator');

        $recaptcha = [
            'key' => $this->container->getParameter('recaptcha_key'),
        ];

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            $valid = $this->checkRecaptchaResponse($request);

            if ($form->isSubmitted() && $form->isValid() && $valid) {
                $em->persist($contact);
                $em->flush();

                $this->get('app.mailer')->sendContactEmail($contact);

                $success = true;
                $response = $translator->trans('contact.form.response');

            } else if (!$valid){
                $success = false;
                $response = $translator->trans('contact.form.recaptcha_error');
            } else {
                $success = false;
                $response = $translator->trans('contact.form.send_error');
            }

            return $this->jsonResponse([
                'success' => $success,
                'message' => $response,
            ]);
        }


        return $this->render('contact.html.twig', [
            'contact_page' => $contactPage[0],
            'form' => $form->createView(),
            'recaptcha' => $recaptcha,
        ]);
    }

    /**
     * Page of legal mentions's presentation
     *
     * @Route(
     *     "{_locale}/{slug}",
     *     name="app_legal_mentions",
     *     defaults={"slug": "legal-mentions", "_locale": "%locale%" },
         *     requirements={ "slug": "mentions-legal|legal-notice", "_locale": "%available_locales%" }
     * )
     */
    public function legalMentionsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $legalNoticePage = $em->getRepository(LegalNoticePage::class)
            ->createQueryBuilder('b')
            ->orderBy("b.createdAt", "DESC")
            ->getQuery()->getResult();
        return $this->render('legal-mentions.html.twig', [
            'legal_notice_page' => $legalNoticePage[0],
        ]);
    }

    private function checkRecaptchaResponse(Request $request)
    {
        $res = $request->request->get('g-recaptcha-response');
        $key = $this->container->getParameter('recaptcha_key');
        $secret = $this->container->getParameter('recaptcha_secret');
        $ip = $request->getClientIp();

        $validator = new RecaptchaValidator($key, $secret, $res, $ip);

        return $validator->check();
    }
}
