<?php

namespace App\Models;
use App\Helpers\Database;
class Enquiry extends Model
{
    // SELECT `id`, `first_name`, `middle_name`, `last_name`, `name`, `phone`, `email`, `address`, `town`, `country`, `nationality`, `native_language`, `language`, `subject`, `message`, `created_at`, `updated_at` FROM `enquiries` WHERE 1
    protected $table = 'enquiries';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'name',
        'phone',
        'email',
        'address',
        'town',
        'country',
        'nationality',
        'native_language',
        'language',
        'subject',
        'message'
    ];
    public $id = null;
    public $first_name = null;
    public $middle_name = null;
    public $last_name = null;
    public $name = null;
    public $phone = null;
    public $email = null;
    public $address = null;
    public $town = null;
    public $country = null;
    public $nationality = null;
    public $native_language = null;
    public $language = null;
    public $subject = null;
    public $message = null;
    public $author = null;

    public function __construct($data = [], $connection = null)
    {
        $this->fill($data);
        // Check if connection is provided and is valid
        $this->connection = $connection ?? Database::getInstance()->getConnection();
    }
    private function fill($data)
    {
        $this->id = $data['id'] ?? null;
        $this->first_name = $data['first_name'] ?? null;
        $this->middle_name = $data['middle_name'] ?? null;
        $this->last_name = $data['last_name'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->town = $data['town'] ?? null;
        $this->country = $data['country'] ?? null;
        $this->nationality = $data['nationality'] ?? null;
        $this->native_language = $data['native_language'] ?? null;
        $this->language = $data['language'] ?? null;
        $this->subject = $data['subject'] ?? null;
        $this->message = $data['message'] ?? null;
    }
}