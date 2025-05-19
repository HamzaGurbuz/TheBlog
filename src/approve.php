<?php
session_start();
include('db.php');

// Onayla işlemi için gelen veri
if (isset($_POST['approve']) && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    
    // Veritabanında onayla işlemi
    $query = "UPDATE posts SET approved = 1 WHERE id = $post_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        echo "Yazı onaylandı!";
    } else {
        echo "Onaylama işlemi başarısız: " . mysqli_error($conn);
    }
}

// Yönlendirme
header("Location: admin.php");  // Onaylandıktan sonra browse.php'ye yönlendiriyoruz.
exit();
?>
