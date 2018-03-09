<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Proarti;
use AppBundle\Entity\Donation;
use AppBundle\Entity\User;
use AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Controller\DefaultController;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class APIController extends Controller
{
	/**
     *@Route("/home")
     *@Method("GET")
     */
	public function amount() {
		$proarti = $this->getDoctrine()
		->getRepository(Proarti::class)
		->findAll();
		$total = 0;
		foreach($proarti as $value) {
			$total += $value->getAmount();
		}
		$rewardByProject = $this->rewardByProject();
		$getProject = $this->getProject();
		return $this->render("home.html.twig", array( 
			"amount" => DefaultController::json_return($total),
			"reward" => $rewardByProject,
			"project" => $getProject,
		));
	}
	/**
	 *@Route("/reward")
	 *@Method("GET")
	 */
	public function rewardByProject() {
		$proarti = $this->getDoctrine()
		->getRepository(Proarti::class)
		->findAll();
		$tab = array();
		foreach($proarti as $value) {
			$val = ["Project name" => $value->getprojectName(), "Total reward" => $value->getrewardQuantity()];
			array_push($tab, $val);
		}
		return DefaultController::json_return($tab);
	}
	/**
	 *@Route("/project")
	 *@Method("GET")
	 */
	public function getProject() {
		$proarti = $this->getDoctrine()
		->getRepository(Project::class)
		->findAll();
		$tab = array();
		foreach($proarti as $value) {
			$val = ["Project name" => $value->getName(), "Content" => $value->getContent()];
			array_push($tab, $val);
		}
		return DefaultController::json_return($tab);
	}
	/**
	 *@Route("/user/{id}")
	 *@Method("GET")
	 */
	public function getUserById($id) {
		$user = $this->getDoctrine()
		->getRepository(User::class)
		->findBy(["id" => $id]);
		if($user == "") {
			return DefaultController::json_return(["404" => 'User not found']);
		}
		else if(!is_int(intval($id))) {
			return DefaultController::json_return(["400" => 'Invalid id supplied']);
		}
		else {
			return DefaultController::json_return([$user, "200" => 'Successful operation']);
		}
	}
	/** 
	 *@Route("/donate")
	 *@Method("POST")
	 */
	public function linkedDonation(Request $request) {
		$diff = ["user_id" => "", "reward_id" => "", "project_id" => "", "amount" => ""];
		$données = $request->getContent();
		$tab = json_decode($request->getContent(), true);
		if(array_diff_key($diff, $tab) == NULL) {
			$em = $this->getDoctrine()->getEntityManager();
			$donation = new Donation();
			$donation->setUserId($tab["user_id"]);
			$donation->setRewardId($tab["reward_id"]);
			$donation->setProjectId($tab["project_id"]);
			$donation->setAmount($tab["amount"]);
			$em->persist($donation);
			$em->flush();
			return DefaultController::json_return(["200" => 'Successful operation']);
		}
		else {
			return DefaultController::json_return(["405" => 'Invalid input']);
		}
	}

	/**
	 *@Route("/register")
	 *@Method("POST")
	 */
	public function register(Request $request) {
		$diff = ["firstname" => "", "lastname" => "", "email" => "", "password" => ""];
		$données = $request->getContent();
		$tab = json_decode($request->getContent(), true);
		$pwd = hash('ripemd160', $tab['password']);
		if(array_diff_key($diff, $tab) == NULL) {
			$date = date("d-m-Y");
			$em = $this->getDoctrine()->getEntityManager();
			$user = new User();
			$user->setFirstname($tab['firstname']);
			$user->setLastname($tab['lastname']);
			$user->setEmail($tab['email']);
			$user->setCreatedAt($date);
			$user->setPassword($pwd);
			$em->persist($user);
			$em->flush();
			return DefaultController::json_return(["200" => 'Successful operation']);
		}
		else {
			return DefaultController::json_return(["405" => 'Invalid input']);
		}
	}
	/**
	 *@Route("project/add")
	 *@Method("POST")
	 */
	public function addProject(Request $request) {
		$diff = ["user_id" => "", "name" => "", "content" => ""];
		$données = $request->getContent();
		$tab = json_decode($request->getContent(), true);
		if(array_diff_key($diff, $tab) == NULL) {
			$em = $this->getDoctrine()->getEntityManager();
			$project = new Project();
			$project->setUserId($tab['user_id']);
			$project->setName($tab['name']);
			$project->setContent($tab['content']);
			$em->persist($project);
			$em->flush();
			return DefaultController::json_return(["200" => 'Successful operation']);
		}
		else {
			return DefaultController::json_return(["405" => 'Invalid input']);
		}
	}
    /**
     *@Route("/user/update/{id}")
     *@Method("PUT")
     */
    public function updateUser($id, Request $request){
    	$diff = ["firstname" => "", "lastname" => "", "email" => "", "password" => ""];
    	$données = $request->getContent();
    	$tab = json_decode($request->getContent(), true);
    	$pwd = hash('ripemd160', $tab['password']);
    	if(array_diff_key($diff, $tab) == NULL) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$user = $this->getDoctrine()
    		->getRepository(User::class)
    		->findBy(["id" => $id]);
    		$user = $user[0];
    		$user->setFirstname($tab["firstname"]);
    		$user->setLastname($tab['lastname']);
    		$user->setEmail($tab['email']);
    		$user->setPassword($pwd);
    		$user->setUpdatedAt(date("d-m-Y"));
    		$em->persist($user);
    		$em->flush();
    		return DefaultController::json_return(["200" => 'Successful operation']);
    	}
    	else if(!is_int($intval($id))){
    		return DefaultController::json_return(["404" => 'Invalid id']);
    	}
    	else if($user == ""){
    		return DefaultController::json_return(["405" => 'User not found']);
    	}
    }
    /**
     *@Route("/donate/update/{id}")
     *@Method("PUT")
     */
    public function updateDonation($id, Request $request){
    	$diff = ["user_id" => "", "reward_id" => "", "project_id" => "", "amount" => ""];
    	$données = $request->getContent();
    	$tab = json_decode($request->getContent(), true);
    	if(array_diff_key($diff, $tab) == NULL) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$donate = $this->getDoctrine()
    		->getRepository(Donation::class)
    		->findBy(["id" => $id]);
    		$donate = $donate[0];
    		$donate->setUserId($tab["user_id"]);
    		$donate->setRewardId($tab['reward_id']);
    		$donate->setProjectId($tab['project_id']);
    		$donate->setAmount($tab["amount"]);
    		$em->persist($donate);
    		$em->flush();
    		return DefaultController::json_return(["200" => 'Successful operation']);
    	}
    	else if(!is_int($intval($id))){
    		return DefaultController::json_return(["404" => 'Invalid id']);
    	}
    	else if($donate == ""){
    		return DefaultController::json_return(["405" => 'Donation not found']);
    	}
    }
    /**
     *@Route("/project/update/{id}")
     *@Method("PUT")
     */
    public function updateProject($id, Request $request){
    	$diff = ["user_id" => "", "name" => "", "content" => ""];
    	$données = $request->getContent();
    	$tab = json_decode($request->getContent(), true);
    	if(array_diff_key($diff, $tab) == NULL) {
    		$em = $this->getDoctrine()->getEntityManager();
    		$project = $this->getDoctrine()
    		->getRepository(Project::class)
    		->findBy(["id" => $id]);
    		$project = $project[0];
    		$project->setUserId($tab["user_id"]);
    		$project->setRewardId($tab['name']);
    		$project->setProjectId($tab['content']);
    		$em->persist($project);
    		$em->flush();
    		return DefaultController::json_return(["200" => 'Successful operation']);
    	}
    	else if(!is_int($intval($id))){
    		return DefaultController::json_return(["404" => 'Invalid id']);
    	}
    	else if($project == ""){
    		return DefaultController::json_return(["405" => 'Project not found']);
    	}
    }
    /**
     *@Route("/user/delete/{id}")
     *@Method("DELETE")
     */
    public function deleteUser($id) {
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->getDoctrine()
    	->getRepository(User::class)
    	->findBy(["id" => $id]);
    	if(!is_int(intval($id))) {
    		return DefaultController::json_return(["404" => 'Invalid id']);
    	}
    	else if($user == "") {
    		return DefaultController::json_return(["405" => 'User not found']);
    	}
    	else {
    		$em->remove($user[0]);
    		$em->flush();
    		return DefaultController::json_return(["200" => 'Successful operation']);
    	}
    }
    /**
     *@Route("project/delete/{id}")
     *@Method("DELETE")
     */
    public function deleteProject($id) {
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->getDoctrine()
    	->getRepository(User::class)
    	->findBy(["id" => $id]);
    	if(!is_int(intval($id))) {
    		return DefaultController::json_return(["404" => 'Invalid id']);
    	}
    	else if($user == "") {
    		return DefaultController::json_return(["405" => 'Project not found']);
    	}
    	else {
    		$em->remove($user[0]);
    		$em->flush();
    		return DefaultController::json_return(["200" => 'Successful operation']);
    	}
    }
}