<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        # Crear formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        # Rellenar objeto
        $form->handleRequest($request);

        # Comprobación de envio form
        if($form->isSubmitted() && $form->isValid())
        {
            # Modificando el objeto para guardarlo
            $user->setRol("ROLE_USER");
            $date_now = (new \DateTime('now'));
            $user->setCreatedAt($date_now);
            # Cifrando la password
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            # Guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('task');
        }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
