<?php
class Product {
    public $id;
    public $name;
    public $price;
    public $qty;

    public function __construct($id, $name, $price, $qty) {
        $this->id = $id;
        $this->name = $name;
        $this->price = floatval($price);
        $this->qty = intval($qty);
    }

    public function getAmount() {
        // Chỉ tính tiền nếu số lượng hợp lệ (>0)
        return ($this->qty > 0) ? ($this->price * $this->qty) : 0;
    }
}
?>