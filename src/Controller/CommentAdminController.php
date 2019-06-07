<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/comment")
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/", name="comment_admin")
     */
    public function index(CommentRepository $commentRepository)
    {
        return $this->render('comment_admin/index.html.twig', [
            'controller_name' => 'CommentAdminController',
            'comments'=>$commentRepository->findAll()
        ]);
    }

    /**
     * @Route("/show/{id}",name="comment_admin_show")
     */
    public function show(Comment $comment){
        return $this->render('comment_admin/show.html.twig',[
            'comment' => $comment
        ]);

    }
    /**
     * @Route("/edit/{id}",name="comment_admin_edit",methods={"GET","POST"})
     */
     public function edit(Comment $comment){
        return $this->render('comment_admin/edit.html.twig',[
            'comment'=>$comment
        ]);
     }
}
