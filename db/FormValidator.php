<?php

class FormValidator
{
    private $errors = [];
    private $data;

    public function __construct($postData)
    {
        $this->data = $postData;
    }

    public function validateRequired($field, $message = "This field is required")
    {
        if (empty(trim($this->data[$field]))) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function validateEmail($field, $message = "Invalid email format")
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function validateNumeric($field, $message = "Must be a numeric value")
    {
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = $message;
        }
        return $this;
    }

    public function validateRange($field, $min, $max, $message = "Value is out of range")
    {
        if (!empty($this->data[$field]) && ($this->data[$field] < $min || $this->data[$field] > $max)) {
            $this->errors[$field] = $message;
        }

        return $this;
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static function sanitizeInput($data)
    {
        $database = Database::getInstance();

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeInput($value);
            }
            return $data;
        }
        return $database->sanitize($data);
    }
}
