<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

use AppBundle\Entity\Skills;
use AppBundle\Entity\Users;
use AppBundle\Validator\SkillsValidator;

class SkillsController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}/skills")
     */
    public function getSkillsAction(Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'Skills not found'], Response::HTTP_NOT_FOUND);
        }

        return $user->getSkills();
    }

    /**
     * @Rest\View()
     * @Rest\Get("/skills/{id}")
     */
    public function getSkillAction(Request $request){

        $skill = $this->getDoctrine()
            ->getRepository(Skills::class)
            ->find($request->get('id'));
        if (empty($skill)){
            return new JsonResponse(['message' => 'Skill not found'], Response::HTTP_NOT_FOUND);
        }
        return $skill;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/skills")
     */
    public function postSkillAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        $skill = new Skills();
        $form = $this->createForm(SkillsValidator::class, $skill);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()){
            $user->addSkill($skill);
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $skill;
        }
        // if error return explication
        return $form;
    }

  /**
     * @Rest\View()
     * @Rest\Put("/skills/{id}")
     */
    public function putSkillsAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        // find skills in list skills of user
        $skills = null;
        for ($i = 0; $i < sizeof($user->getSkills()); $i++) {
            if ($user->getSkills()[$i]->getId() == $request->get('id')) {
                $skills = $user->getSkills()[$i];
            }
        }
        // no skills return 404
        if ($skills == null) {
            return new JsonResponse(['message' => 'Skill not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(SkillsValidator::class, $skills);
        // Validate data
        // Keep last data if no new data is present in request
        $form->submit($request->request->all(), false);

        if ($form->isValid()){
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($skills);
            $em->flush();
            return $skills;
        }
        // if error return explication
        return $form;
    }

    /**
     * @Rest\View()
     * @Rest\Delete("/skills/{id}")
     */
    public function deleteSkillsAction(Request $request){

        $user = $this->get('security.token_storage')
            ->getToken()
            ->getUser();

        // find skills in list skills of user
        $skills = null;
        for ($i = 0; $i < sizeof($user->getSkills()); $i++) {
            if ($user->getSkills()[$i]->getId() == $request->get('id')) {
                $skills = $user->getSkills()[$i];
            }
        }
        // no skills return 404
        if ($skills == null) {
            return new JsonResponse(['message' => 'Skill not found'], Response::HTTP_NOT_FOUND);
        }
        // remove experience in liste of user skills
        $user->removeSkill($skills);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'Success of delete request'], Response::HTTP_OK);
    }

}
