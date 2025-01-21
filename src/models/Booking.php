<?php
class Booking {
    public function book() {
        // echo "Booking request received";
        // Jeśli chcesz renderować widok, użyj render() tutaj
        $this->render('findAPetsitter'); // Sprawdź nazwę widoku
    }

    private function render($view) {
        $path = 'views/' . $view . '.php';  // Zaktualizowana ścieżka
        if (file_exists($path)) {
            include $path;
        } else {
            die("View $view not found");
        }
    }
}
?>
