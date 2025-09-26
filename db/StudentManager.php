<?php


class StudentManager
{
    private $db;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function getAllStudents()
    {
        $students = [];
        $stmt = $this->db->prepare("SELECT * FROM students ORDER BY created_at DESC");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $student = new Student();
                $student->fromArray($row);
                $students[] = $student;
            }
        }

        $stmt->close();
        return $students;
    }

    public function getPaginatedStudents($page = 1, $perPage = 5)
    {
        $students = [];

        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare("SELECT * FROM students ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $perPage, $offset);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $student = new Student();
                $student->fromArray($row);
                $students[] = $student;
            }
        }

        $stmt->close();
        return $students;
    }

    public function getTotalStudentsCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM students");

        $total = 0;

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $total = $row['total'];
        }

        $stmt->close();
        return $total;
    }

    public function getTotalPages($perPage = 5)
    {
        $totalStudents = $this->getTotalStudentsCount();
        return ceil($totalStudents / $perPage);
    }

    public function getRecentStudents($limit = 5)
    {
        $students = [];
        $stmt = $this->db->prepare("SELECT * FROM students ORDER BY created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $student = new Student();
                $student->fromArray($row);
                $students[] = $student;
            }
        }

        $stmt->close();
        return $students;
    }

    public function getStudentById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $student = new Student();
                $student->fromArray($row);
                $stmt->close();
                return $student;
            }
        }

        $stmt->close();
        return null;
    }

    public function addStudent(Student $student)
    {
        $stmt = $this->db->prepare("INSERT INTO students (name, email, phone, course, grade, photo) VALUES (?, ?, ?, ?, ?, ?)");

        $name = $student->getName();
        $email = $student->getEmail();
        $phone = $student->getPhone();
        $course = $student->getCourse();
        $grade = $student->getGrade();
        $photo = $student->getPhoto();

        $stmt->bind_param("ssssds", $name, $email, $phone, $course, $grade, $photo);



        if ($stmt->execute()) {
            $student->setId($stmt->insert_id);
            $stmt->close();
            return true;
        }

        $stmt->close();
        return false;
    }

    public function updateStudent(Student $student)
    {
        $stmt = $this->db->prepare("UPDATE students SET name=?, email=?, phone=?, course=?, grade=?, photo=? WHERE id=?");

        $name = $student->getName();
        $email = $student->getEmail();
        $phone = $student->getPhone();
        $course = $student->getCourse();
        $grade = $student->getGrade();
        $id = $student->getId();
        $photo = $student->getPhoto();

        $stmt->bind_param("ssssdsi", $name, $email, $phone, $course, $grade, $photo, $id);



        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function deleteStudent($id)
    {
        $stmt = $this->db->prepare('DELETE FROM students WHERE id = ?');
        $stmt->bind_param("i", $id);

        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function emailExists($email, $excluseId = null)
    {
        if ($excluseId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM students WHERE email = ? AND id != ?");
            $stmt->bind_param("si", $email, $excluseId);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM students WHERE email = ?");
            $stmt->bind_param("s", $email);
        }

        $count = 0;
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];
        }

        $stmt->close();
        return $count > 0;
    }

    public function getStatistics()
    {
        $stats = [];
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM students");
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stats['total_students'] = $row['total'];
        }
        $stmt->close();

        $stmt = $this->db->prepare('SELECT AVG(grade) as avg_grade FROM students WHERE grade IS NOT NULL');
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stats['avg_grade'] = number_format($row['avg_grade'], 2);
        }
        $stmt->close();

        $stmt = $this->db->prepare('SELECT course, COUNT(*) as count FROM students GROUP BY course');
        $stats['courses'] = [];
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $stats['courses'][] = $row;
            }
        }
        $stmt->close();

        return $stats;
    }

    public function searchStudents($search_term)
    {
        $students = [];
        $search_pattern = "%" . $search_term . "%";

        $stmt = $this->db->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR course LIKE ? ORDER BY name");
        $stmt->bind_param("sss", $search_pattern, $search_pattern, $search_pattern);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $student = new Student();
                $student->fromArray($row);
                $students[] = $student;
            }
        }

        $stmt->close();
        return $students;
    }

    public function getStudentsByCourse()
    {
        $courses = [];
        $stmt = $this->db->prepare("SELECT course, COUNT(*) as count, AVG(grade) as avg_grade FROM students GROUP BY course ORDER BY count DESC");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
        }

        $stmt->close();
        return $courses;
    }
}
