<?php

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Respond with 200 OK status and exit
    http_response_code(200);
    exit();
}

if (!empty($_POST)) {
    $object = isset($_POST['object']) ? $_POST['object'] : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $params = $_POST;
} elseif (!empty($_GET)) {
    $object = isset($_GET['object']) ? $_GET['object'] : null;
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $params = $_GET;
} else {
    $params = json_decode(file_get_contents("php://input"), true);
    $object = isset($params['object']) ? $params['object'] : null;
    $action = isset($params['action']) ? $params['action'] : null;
}

$htaccessFile = __DIR__ . '/.htaccess';

if (!file_exists($htaccessFile)) {
    http_response_code(500);
    throw new Exception("Error: The .htaccess file is missing. Please ensure it is present in the directory.");
}

require_once 'config/config.php';


use App\Models\User;

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\BlogArticleController;
use App\Controllers\EmailQueueController;
use App\Controllers\PageController;
use App\Controllers\WidgetController;
use App\Controllers\EnquiryController;

use App\Helpers\Dropzone;
use App\Helpers\HelperFunctions;
use App\Helpers\ValidationException;

use App\Middleware\EmailMiddleware;

if (isset($params['user_token'])) {
    $author = Functions::decryptData($params['user_token']);
    if (!$author) {
        http_response_code(403);
        echo json_encode(array(
            'status' => 0,
            'message' => "Forbidden. It seems you are trying to access a resource that is beyond your access scope " . $author
        ));
        exit;
    }
    $params['author'] = Functions::decryptData($params['user_token']);
}

try {
    if (isset($object)) {
        if ($object == 'Auth') {
            $controller = new AuthController();
            switch ($action) {
                case 'login':
                    echo json_encode($controller->login(new User($params)), JSON_PRETTY_PRINT);
                    break;

                case 'register':
                    echo json_encode($controller->register(new User($params)), JSON_PRETTY_PRINT);
                    break;

                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }

        if ($object == 'Dropzone') {
            $class_object = new Dropzone();
            switch ($action) {
                case 'upload':
                    echo json_encode($class_object->upload());
                    break;

                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }

        if ($object == 'User') {
            $controller = new UserController($params);
            switch ($action) {
                case 'create':
                    if (!UserController::isValidEmail($params['email'])) {
                        throw new ValidationException('User with this email already exists');
                    }
                    $params['password'] = HelperFunctions::generatePassword();
                    
                    $controller = new UserController($params);
                    $result = $controller->create();
                    echo json_encode($result, JSON_PRETTY_PRINT);

                    if ($result->status) {
                        $email_obj = new EmailQueueController(['recipient_name' => $params['first_name'] . " " .$params['last_name'], 'recipient_email' => $params['email'], 'subject' => 'Welcome to Betralace', 'content_sections' => $controller->getUserCreateEmailMessage()]);
                        $email_obj->enqueue();
                    }

                    break;

                case 'data_table':
                    $class_object = new UserController($params);
                    echo $class_object->dataTable();
                    break;

                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }

        if ($object == 'Page') {
            switch ($action) {
                case 'create':
                    $class_object = new PageController($params);
                    $result = $class_object->create();
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    if ($result->status) {
                        $params['page_id'] = $result->data->id;

                        if (array_key_exists('tempFile', $params) && !empty($params['tempFile'])) {
                            $uploaded_cover_image_data = $class_object->uploadCoverImage();
                            $uploaded_cover_image_data['id'] = $params['page_id'];
                            PageController::updateCoverImage($uploaded_cover_image_data);
                        }

                        if (array_key_exists('tempHeaderFile', $params) && !empty($params['tempHeaderFile'])) {
                            $uploaded_header_image_data = $class_object->uploadHeaderImage();
                            $uploaded_header_image_data['id'] = $params['page_id'];
                            PageController::updateHeaderImage($uploaded_header_image_data);
                        }
                    }
                    break;

                case 'update':
                    $class_object = new PageController($params);
                    $result = $class_object->update();

                    if ($result->status) {
                        $page = PageController::getById($result->data->id);

                        // $file = fopen("debug.log", "a");
                        // fwrite($file, "Page id is ".$result->data->id."\n");
                        // fwrite($file, json_encode($page)."\n");
                        // fclose($file);

                        if (array_key_exists('tempFile', $params) && !empty($params['tempFile'])) {
                            $uploaded_cover_image_data = $class_object->uploadCoverImage();
                            $uploaded_cover_image_data['id'] = $page->id;
                            if (HelperFunctions::deleteFile($page->cover_image) && HelperFunctions::deleteFile($page->cover_image_thumbnail)) {
                                PageController::updateCoverImage($uploaded_cover_image_data);
                            }
                        }

                        if (array_key_exists('tempHeaderFile', $params) && !empty($params['tempHeaderFile'])) {
                            $uploaded_header_image_data = $class_object->uploadHeaderImage();
                            $uploaded_header_image_data['id'] = $page->id;
                            if (HelperFunctions::deleteFile(PageController::getById($result->data->id)->header_image)) {
                                PageController::updateHeaderImage($uploaded_header_image_data);
                            }
                        }
                    }
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    break;

                case 'delete':
                    $class_object = new PageController($params);
                    echo json_encode($class_object->delete(), JSON_PRETTY_PRINT);
                    break;

                case 'publish':
                    $class_object = new PageController($params);
                    echo json_encode($class_object->publish(), JSON_PRETTY_PRINT);
                    break;

                case 'unpublish':
                    $class_object = new PageController($params);
                    echo json_encode($class_object->unpublish(), JSON_PRETTY_PRINT);
                    break;

                case 'get_details':
                    echo json_encode(PageController::getById($params['id']), JSON_PRETTY_PRINT);
                    break;

                case 'get_by_slug':
                    echo json_encode(PageController::getBySlug($params['slug']), JSON_PRETTY_PRINT);
                    break;

                case 'get_by_url':
                    $page = PageController::getByUrl($params['url']);
                    // if(isset($page)){
                    // $page->blog_details = BlogArticleController::getByPage($page->id);
                    // }
                    echo json_encode($page, JSON_PRETTY_PRINT);
                    break;

                case 'check_slug':
                    $page = PageController::getBySlug($params['slug'], array_key_exists('section', $params) ? $params['section'] : null, array_key_exists('current_record', $params) ? $params['current_record'] : null);
                    $response = false;
                    if (!$page) {
                        $response = true;
                    }
                    echo json_encode($response);
                    break;

                case 'data_table':
                    $class_object = new PageController($params);
                    echo $class_object->dataTable();
                    break;

                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }

        if ($object == 'BlogArticle') {
            switch ($action) {
                case 'create':
                    $params['page_type'] = 'blog-article';
                    $pc_object = new PageController($params);
                    $result = $pc_object->create();
                    if ($result->status) {
                        $params['page_id'] = $result->data->id;
                        $class_object = new BlogArticleController($params);
                        $result = $class_object->create();

                        if (array_key_exists('tempFile', $params) && !empty($params['tempFile'])) {
                            $uploaded_cover_image_data = $pc_object->uploadCoverImage();
                            $uploaded_cover_image_data['id'] = $params['page_id'];
                            PageController::updateCoverImage($uploaded_cover_image_data);
                        }
                    }
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    break;

                case 'update':
                    $params['page_type'] = 'blog-article';
                    $page = PageController::getById($params['id']);
                    $pc_object = new PageController($params);
                    $result = $pc_object->update();
                    if ($result->status) {
                        $params['page_id'] = $result->data->id;
                        $class_object = new BlogArticleController($params);
                        $result = $class_object->update();

                        if (array_key_exists('tempFile', $params)) {
                            $uploaded_cover_image_data = $pc_object->uploadCoverImage();
                            $uploaded_cover_image_data['id'] = $params['page_id'];
                            PageController::updateCoverImage($uploaded_cover_image_data);
                        }
                    }
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    break;

                case 'delete':
                    $class_object = new PageController($params);
                    $result = $class_object->delete();
                    if ($result->status) {
                        $result = (object) ['status' => 1, 'message' => 'Article deleted'];
                    }
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    break;

                    // case 'publish':
                    //     $class_object = new BlogArticleController($params);
                    //     echo json_encode($class_object->publish(), JSON_PRETTY_PRINT);
                    //     break;

                    // case 'unpublish':
                    //     $class_object = new BlogArticleController($params);
                    //     echo json_encode($class_object->unpublish(), JSON_PRETTY_PRINT);
                    //     break;

                case 'get_details':
                    echo json_encode(BlogArticleController::getById($params['id']), JSON_PRETTY_PRINT);
                    break;

                case 'get_published':
                    echo json_encode(BlogArticleController::getPublished(), JSON_PRETTY_PRINT);
                    break;

                case 'data_table':
                    $class_object = new BlogArticleController($params);
                    echo $class_object->dataTable();
                    break;

                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }

        if ($object == 'Widget') {
            switch ($action) {
                case 'create':
                    $class_object = new WidgetController($params);
                    $result = $class_object->create();
                    if ($result->status) {
                        $params['widget_id'] = $result->data->id;
                        if (array_key_exists('tempFile', $params)) {
                            $uploaded_image_data = $class_object->uploadImage();
                            $uploaded_image_data['id'] = $params['widget_id'];
                            WidgetController::updateImage($uploaded_image_data);
                        }
                    }
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    break;

                case 'update':
                    $class_object = new WidgetController($params);
                    $result = $class_object->update();
                    if ($result->status) {
                        $params['widget_id'] = $result->data->id;
                        if (array_key_exists('tempFile', $params)) {
                            HelperFunctions::deleteFile(WidgetController::getById($result->data->id)->image);
                            $uploaded_image_data = $class_object->uploadImage();
                            $uploaded_image_data['id'] = $params['widget_id'];
                            WidgetController::updateImage($uploaded_image_data);
                        }
                        else{
                            
                        }
                    }
                    echo json_encode($result, JSON_PRETTY_PRINT);
                    break;

                case 'delete':
                    $class_object = new WidgetController($params);
                    echo json_encode($class_object->delete(), JSON_PRETTY_PRINT);
                    break;

                case 'get_details':
                    echo json_encode(WidgetController::getById($params['id']), JSON_PRETTY_PRINT);
                    break;

                case 'get_by_section':
                    echo json_encode(WidgetController::getBySection($params['section']), JSON_PRETTY_PRINT);
                    break;
                
                case 'get_by_title':
                    echo json_encode(WidgetController::getByTitle($params['title']), JSON_PRETTY_PRINT);
                    break;

                case 'data_table':
                    $class_object = new WidgetController($params);
                    echo $class_object->dataTable();
                    break;

                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }

        if ($object == 'Enquiry') {
            $controller = new EnquiryController($params);
            switch ($action) {
                case 'language_enquiry':
                    $result = $controller->create();
                    echo json_encode($result, JSON_PRETTY_PRINT);

                    if ($result->status) {
                        $enqury_email_obj = new EmailQueueController(['recipient_name' => 'Admin', 'recipient_email' => 'ianmutevu96@gmail.com', 'subject' => 'Language Learning Inquiry From ' . $params['first_name'], 'content_sections' => $controller->getCtaEmailContent()]);
                        $enqury_email_obj->enqueue();

                        $ack_email_obj = new EmailQueueController(['recipient_name' => $params['first_name'], 'recipient_email' => $params['email'], 'subject' => 'Inquiry Received', 'content_sections' => $controller->getAcknowledgmentEmailContent()]);
                        $ack_email_obj->enqueue();
                    }
                    break;

                case 'contact_form_enquiry':
                    $result = $controller->create();
                    echo json_encode($result, JSON_PRETTY_PRINT);

                    if ($result->status) {
                        $enqury_email_obj = new EmailQueueController(['recipient_name' => 'Admin', 'recipient_email' => 'ianmutevu96@gmail.com', 'subject' => 'Website Contact Form Inquiry', 'content_sections' => $controller->getContactFormEmailContent()]);
                        $enqury_email_obj->enqueue();

                        $ack_email_obj = new EmailQueueController(['recipient_name' => $params['name'], 'recipient_email' => $params['email'], 'subject' => 'Inquiry Received', 'content_sections' => $controller->getAcknowledgmentEmailContent()]);
                        $ack_email_obj->enqueue();
                    }
                    break;

                case 'data_table':
                    $class_object = new UserController($params);
                    echo $class_object->dataTable();
                    break;
                default:
                    echo json_encode(array(
                        'status' => 1,
                        'message' => "Endpoint not found"
                    ));
                    break;
            }

            exit;
        }
    }

    http_response_code(404);
    echo json_encode(array(
        'status' => 1,
        'message' => "Endpoint not found here"
    ));
} catch (ValidationException $e) {
    http_response_code(422);
    echo json_encode(array(
        'status' => 0,
        'message' => $e->getMessage()
    ));
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array(
        'status' => 0,
        'message' => DEBUG_MODE ? $e->getMessage() : SERVER_ERROR_MESSAGE
    ));
}
