<?php
namespace ProjetGestionPedagogique\App\Controllers;
use ProjetGestionPedagogique\App\Models\ProfesseurModel; 
use ProjetGestionPedagogique\App\Models\CourModel; 
use ProjetGestionPedagogique\App\Models\SessionModel; 
class ProfController{

    public function __construct(ProfesseurModel $professeurModel , CourModel $coursModel,SessionModel $sessionModel) {
        $this->professeurModel = $professeurModel;
        $this->coursModel = $coursModel;
        $this->sessionModel = $sessionModel;
        session_start(); // Démarrer la session
    } 

public function add() {

    // $id=$_POST["dette"];
    // $_SESSION['id']=$id;

    $professors=$this->professeurModel->getProfessors();
   
    include '../views/listprof.php';
     
}


public function showCoursesByProfessor() {
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit();
    }

    $utilisateurId = $_SESSION['user']->getId();
 
    $professorId=$this->coursModel->getProfesseurId($utilisateurId);
/*     $courses = $this->coursModel->getCoursesByProfessorId($professorId[0]['id']);
 */   
$filters = [];
    if (isset($_GET['semester']) && !empty($_GET['semester'])) {
        $filters['semester'] = $_GET['semester'];
    } elseif (isset($_GET['module']) && !empty($_GET['module'])) {
        $filters['module'] = $_GET['module'];
    }

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $coursesPerPage = 3;

    $totalCourses = $this->coursModel->getCoursesByProfessorId($professorId[0]['id']);
    $totalPages = ceil(count($totalCourses)/ $coursesPerPage);
    $offset = ($page - 1) * $coursesPerPage;
    $courses = $this->coursModel->getCoursesByProfessorIdWithPagination($professorId[0]['id'], $offset, $coursesPerPage,$filters);

    $modules = $this->coursModel->getAllModulesByProfessorId($professorId[0]['id']);
    $semesters = $this->coursModel->getAllSemestersByProfessorId($professorId[0]['id']);


    include '../views/listcour.php';
}





public function affichersession() {
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit();
    }

    $statusFilter = isset($_GET['status']) ? $_GET['status'] : null;

    $utilisateurId = $_SESSION['user']->getId();
    $professorId = $this->sessionModel->getProfesseurId($utilisateurId);
    $etudiantid = $this->sessionModel-> getEtudiantId($utilisateurId);

/*     $sessionss = $this->sessionModel->getSessionsByEtudiantId ($etudiantid[0]['id'], $statusFilter);
/*  */    
    $sessions = $this->sessionModel->getSessionByProfessorId($professorId[0]['id'], $statusFilter);
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reason']) && isset($_POST['session_id'])) {
        $raison = $_POST['reason'];
        $sessionId = $_POST['session_id'];
        if ($this->sessionModel->addDemandeAnnulation($professorId[0]['id'], $sessionId, $raison)) {
            if ($this->sessionModel->updateSessionStatus($sessionId, 'annulé')) {
                $message = 'Votre demande a été enregistrée et la session a été annulée.';
            } else {
                $message = 'Votre demande a été enregistrée, mais une erreur s\'est produite lors de la mise à jour de l\'état de la session.';
            }
        } else {
            $message = 'Une erreur s\'est produite. Veuillez réessayer.';
        }
    }

    include '../views/sessions.php';
}


public function affichersessionEtudiant() {
    if (!isset($_SESSION['user'])) {
        header('Location: /login');
        exit();
    }

    $utilisateurId = $_SESSION['user']->getId();
    $etudiantId = $this->sessionModel->getEtudiantId($utilisateurId);

    // Assumes that the professor's ID is stored in session or can be retrieved somehow

    // Récupérer les sessions pour l'étudiant pour lesquelles le professeur est responsable
    $sessionss = $this->sessionModel->getSessionsByEtudiantId($etudiantId[0]['id']);
    $message = '';
    
   

    include '../views/sessionEtu.php';
}



}






