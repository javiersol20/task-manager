<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\TaskType;

class TaskController extends AbstractController
{

    public function index(): Response
    {
        /**
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findBy([], ["id" => 'DESC']);

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'tasks' => $tasks
        ]);
         * Metodo deprecated
         */
    }
    public function detail(Task $task)
    {
        if(!$task)
        {
            return $this->redirectToRoute('task');
        }

        return $this->render('task/detalle.html.twig',
        [
            'task' => $task
        ]);
    }
    public function creation(Request $request, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
              $this->generateUrl('taks_detail', ["id" => $task->getId()])
            );
        }
        return $this->render('task/creation.html.twig',
        [
            'form' => $form->createView()
        ]);
    }
    public function myTask(UserInterface $user)
    {
        $tasks = $user->getTasks();

        return $this->render('task/my-task.html.twig',
        [
            'tasks' => $tasks
        ]);
    }
    public function edit(Request $request, Task $task, UserInterface  $user)
    {
        if(!$user || $user->getId() != $task->getUser()->getId())
        {
            return $this->redirectToRoute('task');
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {


            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect(
                $this->generateUrl('taks_detail', ["id" => $task->getId()])
            );
        }
        return $this->render('task/creation.html.twig',
        [
            'edit' => true,
            'form' => $form->createView()
        ]);
    }

    public function delete(UserInterface $user, Task $task)
    {
        if(!$user || $user->getId() != $task->getUser()->getId())
        {
            return $this->redirectToRoute('task');

        }

            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        return $this->redirectToRoute('task');


    }
}
