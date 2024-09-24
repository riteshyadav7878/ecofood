// Fetch the current admin details from the database
$sql = "SELECT * FROM admin WHERE admin_id='$admin_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();

    // Verify the current password
    if (password_verify($current_password, $admin['password'])) {
        // Check if the new password and confirmation match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password in the database
            $update_sql = "UPDATE admin SET password='$hashed_new_password' WHERE admin_id='$admin_id'";

            if ($conn->query($update_sql) === TRUE) {
                $message = '<div class="alert alert-success" role="alert">Password changed successfully.</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">Error updating password: ' . $conn->error . '</div>';
            }
        } else {
            $message = '<div class="alert alert-warning" role="alert">New password and confirmation do not match.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger" role="alert">Current password is incorrect.</div>';
    }
} else {
    $message = '<div class="alert alert-danger" role="alert">Admin not found.</div>';
}
