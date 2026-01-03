<?php
// functions.php

/**
 * Tìm số lớn nhất trong 2 số
 */
function max2($a, $b) {
    return ($a > $b) ? $a : $b;
}

/**
 * Tìm số nhỏ nhất trong 2 số
 */
function min2($a, $b) {
    return ($a < $b) ? $a : $b;
}

/**
 * Kiểm tra số nguyên tố
 * Trả về true nếu là số nguyên tố, ngược lại false
 */
function isPrime(int $n): bool {
    if ($n < 2) return false;
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) return false;
    }
    return true;
}

/**
 * Tính giai thừa
 * n >= 0 trả về giai thừa, n < 0 trả về null
 */
function factorial(int $n) {
    if ($n < 0) return null;
    if ($n == 0 || $n == 1) return 1;
    
    $result = 1;
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

/**
 * Tìm ước chung lớn nhất (UCLN) theo thuật toán Euclid
 */
function gcd(int $a, int $b): int {
    $a = abs($a);
    $b = abs($b);
    while ($b != 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}
?>