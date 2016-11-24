<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Helper\Apihelper;

class ArticleInfoController extends Controller
{
    /**
     * @Route("/articleinfo", name="articleInfo")
     * @Route("/articleinfo/", name="articleInfoSlash")
     * @Route("/articleinfo/index.php", name="articleInfoIndexPhp")
     * @Route("/articleinfo/get", name="articleInfoGet")
     */
    public function indexAction()
    {
        if (!$this->getParameter("enable.articleinfo")) {
            throw new NotFoundHttpException("This tool is disabled");
        }

        $api = $this->get("app.api_helper");
        $api->test();

        // Grab the request object, grab the values out of it.
        $request = Request::createFromGlobals();

        $project = $request->query->get('project');
        $article = $request->query->get('article');

        if ($project != "" && $article != "") {
            return $this->redirectToRoute("ArticleInfoResult", array('project'=>$project, 'article' => $article));
        }
        else if ($article != "") {
            return $this->redirectToRoute("ArticleInfoProject", array('project'=>$project));
        }

        return $this->render('articleInfo/index.html.twig', [
            'page' => "articleinfo",
            'title' => "tool_articleinfo",
            "pageTitle" => "tool_articleinfo",
            "subtitle" => "tool_articleinfo_desc",
        ]);
    }

    /**
     * @Route("/articleinfo/{project}", name="ArticleInfoProject")
     */
    public function articleInfoProject($project)
    {
        if (!$this->getParameter("enable.articleinfo")) {
            throw new NotFoundHttpException("This tool is disabled");
        }

        return $this->render('articleInfo/index.html.twig', [
            'page' => "articleinfo",
            'title' => "tool_articleinfo",
            "pageTitle" => "tool_articleinfo",
            "subtitle" => "tool_articleinfo_desc",
            "project" => $project,
        ]);

    }

    /**
     * @Route("/articleinfo/{project}/{article}", name="ArticleInfoResult")
     */
    public function articleInfoProjectAction($project, $article)
    {
        if (!$this->getParameter("enable.articleinfo")) {
            throw new NotFoundHttpException("This tool is disabled");
        }
        // replace this example code with whatever you need
        return $this->render('articleInfo/result.html.twig', array(
            'page' => "articleinfo",
            "title" => "tool_articleinfo",
            "pageTitle" => "tool_articleinfo",
            "project" => $project,
            "article_title" => $article,
            "subtitle" => "tool_articleinfo_desc",
        ));
    }
}
