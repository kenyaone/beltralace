<?php
namespace App\Helpers;
class Dropzone
{
    public function upload () {
        $root = dirname(dirname(__FILE__));
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];
                if (!file_exists($root.'/uploads/dropzone/')) {
                    mkdir($root.'/uploads/dropzone', 0777, true);
                }
                $destination = $root.'/uploads/dropzone/' . $filename;
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                return (object) array(
                    'status' => 1,
                    'message' => 'Success!',
                    'name' => 'uploads/dropzone/' . $filename
                );
            }
            else {
                return (object) array(
                    'status' => 0,
                    'message' => 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error']
                );
            }
        }
    }

    public static function delete ($src) {
        $path_parts = explode('/', $src);
        $filename = end($path_parts);
        if (file_exists('../uploads/dropzone/'.$filename)) {
            unlink('../uploads/dropzone/'.$filename);
        }
    }

    public function getImages()
    {

    }
}
