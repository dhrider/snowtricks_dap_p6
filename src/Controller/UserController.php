<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserController extends AbstractController
{
    /**
     * @Route(path="register", name="register")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param EncoderFactoryInterface $encoder
     * @return RedirectResponse|Response
     */
    public function register(Request $request, EntityManagerInterface $entityManager, EncoderFactoryInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $session = $this->container->get('session');
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder
                ->getEncoder($user)
                ->encodePassword($form->getData()->getPassword(), $user->getSalt());

            $user->setUsername($form->getData()->getUsername());
            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

            // TODO Add photo or default avatar

            $entityManager->persist($user);
            $entityManager->flush();
            $success = true;
            $session
                ->getFlashBag()
                ->set('success', 'You\'ve been successfully registred.')
            ;
            return $this->redirectToRoute('login', array(
                'success' => $success
            ));
        }

        return $this->render('User/registerUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route(path="resetpassword", name="reset_password")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param Swift_Mailer $mailer
     */
    public function resetPassword(Request $request, EntityManagerInterface $entityManager, Swift_Mailer $mailer)
    {

    }

    /**
     * @Route(path="newpassword/{token}", name="new_password")
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     */
    public function newPassword(User $user, Request $request, EntityManagerInterface $entityManager)
    {

    }
}
