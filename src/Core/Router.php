<?php

namespace LawFirmManagement\Core;

use LawFirmManagement\Controllers\AppointmentController;
use LawFirmManagement\Controllers\AuthController;
use LawFirmManagement\Controllers\CaseController;
use LawFirmManagement\Controllers\ClientController;
use LawFirmManagement\Controllers\DashboardController;
use LawFirmManagement\Controllers\DocumentController;
use LawFirmManagement\Controllers\HearingController;
use LawFirmManagement\Controllers\UsersController;
use LawFirmManagement\Middleware\AuthMiddleware;
use LawFirmManagement\Middleware\RoleMiddleware;

class Router
{
    public function __construct(
        private AuthController $authController,
        private DashboardController $dashboardController,
        private UsersController $usersController,
        private ClientController $clientController,
        private CaseController $caseController,
        private HearingController $hearingController,
        private AppointmentController $appointmentController,
        private DocumentController $documentController,
        private AuthMiddleware $authMiddleware,
        private RoleMiddleware $roleMiddleware
    ) {
    }

    public function dispatch(string $route): void
    {
          try {

        switch ($route) {

            case 'login':

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->authController->login();
                } else {
                    $this->authController->showLogin();
                }

                break;
            

            case 'users':
                $this->authMiddleware->handle();

                $this->roleMiddleware->handle('admin');

                $this->usersController->index();
                break;


            case 'users/create':
                $this->authMiddleware->handle();

                $this->roleMiddleware->handle('admin');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->usersController->store();
                } else {
                    $this->usersController->create();
                }

                break;


            case 'users/edit':
            $this->authMiddleware->handle();
            $this->roleMiddleware->handle('admin');
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->usersController->update();
            } else {
                $this->usersController->edit();
            }
            break;



        case 'cases/edit':

            $this->authMiddleware->handle();
            $this->roleMiddleware->handle('admin', 'lawyer', 'staff');

            $id = filter_input(
                INPUT_GET,
                'id',
                FILTER_VALIDATE_INT
            );

            if ($id === false || $id === null) {
                http_response_code(400);
                echo 'Invalid case ID';
                break;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->caseController->update($id);
            } else {
                $this->caseController->edit($id);
            }

        break;



        case 'cases/show':
        $this->authMiddleware->handle();
        $this->caseController->show((int) ($_GET['id'] ?? 0));
        break;


            case 'dashboard':
                $this->authMiddleware->handle();

                $this->dashboardController->index();
                break;

            case 'clients':

                $this->authMiddleware->handle();

                $this->roleMiddleware->handle('admin', 'staff');

                $this->clientController->index();

                break;
            
            

            case 'hearings/create':
            $this->authMiddleware->handle();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->hearingController->store(
                    (int) ($_GET['case_id'] ?? 0)
                );
            } else {
                $this->hearingController->create(
                    (int) ($_GET['case_id'] ?? 0)
                );
            }

            break;

            case 'clients/create':

                $this->authMiddleware->handle();
                $this->roleMiddleware->handle('admin');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->clientController->store();
                } else {
                    $this->clientController->create();
                }

            break;
                
            case 'clients/edit':

            $this->authMiddleware->handle();
            $this->roleMiddleware->handle('admin');

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->clientController->update();
            } else {
                $this->clientController->edit();
            }

            break;


            case 'cases':

            $this->authMiddleware->handle();

            $this->caseController->index();

            break;

            case 'cases/search':

            $this->authMiddleware->handle();

            $this->caseController->search();

            break;


            case 'cases/create':

                $this->authMiddleware->handle();
                $this->roleMiddleware->handle('admin');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->caseController->store();
                } else {
                    $this->caseController->create();
                }

            break;


            case 'hearings/edit':
            $this->authMiddleware->handle();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->hearingController->update(
                    (int) ($_GET['id'] ?? 0)
                );
            } else {
                $this->hearingController->edit(
                    (int) ($_GET['id'] ?? 0)
                );
            }

            break;



            case 'appointments':
            $this->authMiddleware->handle();
            $this->appointmentController->index();

            break;


            case 'appointments/create':
            $this->authMiddleware->handle();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->appointmentController->store();
            } else {
                $this->appointmentController->create();
            }

            break;


        case 'appointments/edit':
            $this->authMiddleware->handle();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->appointmentController->update(
                    (int) ($_GET['id'] ?? 0)
                );
            } else {
                $this->appointmentController->edit(
                    (int) ($_GET['id'] ?? 0)
                );
            }

            break;
                    


            case 'cases/documents':
            $this->authMiddleware->handle();

            $caseId = filter_input(
                INPUT_GET,
                'id',
                FILTER_VALIDATE_INT
            );

            if ($caseId === false || $caseId === null) {
                http_response_code(404);
                echo 'القضية غير موجودة.';
                break;
            }

            $this->documentController->index($caseId);
            
            break;
            
            

                
        case 'documents/create':
            $this->authMiddleware->handle();

            $caseId = filter_input(
                INPUT_GET,
                'case_id',
                FILTER_VALIDATE_INT
            );

            if ($caseId === false || $caseId === null) {
                http_response_code(404);
                echo 'رقم القضية غير صالح.';
                break;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->documentController->store($caseId);
            } else {
                $this->documentController->create($caseId);
            }

        break;



        case 'documents/download':
        $this->authMiddleware->handle();

        $documentId = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if ($documentId === false || $documentId === null) {
            http_response_code(404);
            echo 'المستند غير موجود.';
            break;
        }

        $this->documentController->download($documentId);

        break;



        case 'documents/edit':
            $this->authMiddleware->handle();

            $documentId = filter_input(
                INPUT_GET,
                'id',
                FILTER_VALIDATE_INT
            );

            if ($documentId === false || $documentId === null) {
                http_response_code(404);
                echo 'المستند غير موجود.';
                break;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $this->documentController->update($documentId);

                break;
            }

            $this->documentController->edit($documentId);

        break;




        case 'documents/delete':
            $this->authMiddleware->handle();

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo 'Method Not Allowed';
                break;
            }

            $documentId = filter_input(
                INPUT_GET,
                'id',
                FILTER_VALIDATE_INT
            );

            if ($documentId === false || $documentId === null) {
                http_response_code(404);
                echo 'المستند غير موجود.';
                break;
            }

            $this->documentController->delete($documentId);

        break;

    
        case 'logout':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo 'Method Not Allowed';
                break;
            }

            $this->authController->logout();
            break;


            
            default:
                http_response_code(404);
                echo '404 - Page Not Found';
        }


        } catch (ValidationException $exception) {
        http_response_code(422);

        $errors = $exception->errors();

        echo '<h3>حدث خطأ:</h3>';

        foreach ($errors as $error) {
            echo '<p>' . htmlspecialchars($error) . '</p>';
        }
        }
    }
}