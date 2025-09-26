<?php

class Student
{
    private $id;
    private $name;
    private $email;
    private $phone;
    private $course;
    private $grade;
    private $createdAt;
    private $updatedAt;
    private $photo;

    public function __construct($id = null, $name = '', $email = '', $phone = '', $course = '', $grade = null, $photo = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->course = $course;
        $this->grade = $grade;
        $this->photo = $photo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }

    public function getGrade()
    {
        return $this->grade;
    }

    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function fromArray($data)
    {
        // foreach ($data as $key => $value) {
        //     if (property_exists($this, $key)) {
        //         $this->$key = $value;
        //     }
        // }
        $this->id = $data['id'] ?? $this->id;
        $this->name = $data['name'] ?? $this->name;
        $this->email = $data['email'] ?? $this->email;
        $this->phone = $data['phone'] ?? $this->phone;
        $this->course = $data['course'] ?? $this->course;
        $this->grade = $data['grade'] ?? $this->grade;
        $this->createdAt = $data['created_at'] ?? $this->createdAt;
        $this->updatedAt = $data['updated_at'] ?? $this->updatedAt;
        $this->photo = $data['photo'] ?? $this->photo;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'course' => $this->course,
            'grade' => $this->grade,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'photo' => $this->photo
        ];
    }
}
