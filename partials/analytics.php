<?php
if ($_SESSION['user_access_level'] == 'Staff' || $_SESSION['user_access_level'] == 'Administrator') {
    /* Load Staff Analytics */

    /* Members */
    $query = "SELECT COUNT(*)  FROM `users` WHERE user_access_level = 'Member' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($members);
    $stmt->fetch();
    $stmt->close();


    /* Staffs  */
    $query = "SELECT COUNT(*)  FROM `users` WHERE user_access_level = 'Staff' || user_access_level = 'Administrator'  ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($staffs);
    $stmt->fetch();
    $stmt->close();


    /* Total Bookings */
    $query = "SELECT COUNT(*)  FROM `reservations`  ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($bookings);
    $stmt->fetch();
    $stmt->close();


    /* Total Revenue */
    $query = "SELECT SUM(payment_amount)  FROM `payments`  ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($revenue);
    $stmt->fetch();
    $stmt->close();
} else {
    $user_id = $_SESSION['user_id'];
    /* Load Member Analytics */

    /* 1. Member Bookings */
    $query = "SELECT COUNT(*)  FROM `reservations`  WHERE reservation_user_id = '$user_id' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($bookings);
    $stmt->fetch();
    $stmt->close();


    /* 2. Open Events */
    $query = "SELECT COUNT(*)  FROM `events`  WHERE event_status = '1' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($events);
    $stmt->fetch();
    $stmt->close();


    /* 3. Tickets */
    $query = "SELECT COUNT(*)  FROM `tickets`  WHERE ticket_user_id  = '$user_id' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($tickets);
    $stmt->fetch();
    $stmt->close();


    /* 4. Expenditure */
    $query = "SELECT SUM(payment_amount)  FROM `payments`  WHERE payment_user_id  = '$user_id' ";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->bind_result($revenue);
    $stmt->fetch();
    $stmt->close();
}
