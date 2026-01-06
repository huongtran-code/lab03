<?php
class Student {
    private $id;
    private $name;
    private $gpa;

    public function __construct($id, $name, $gpa) {
        $this->id = $id;
        $this->name = $name;
        $this->gpa = floatval($gpa);
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getGpa() { return $this->gpa; }

    // Logic xếp loại
    public function rank() {
        if ($this->gpa >= 3.2) return "Giỏi";
        if ($this->gpa >= 2.5) return "Khá";
        return "Trung bình";
    }
}
?>