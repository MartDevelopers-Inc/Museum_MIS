<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <?php
    $user_id = $_SESSION['user_id'];
    $user_rank = $_SESSION['user_access_level'];
    $ret = "SELECT * FROM users WHERE user_id = '$user_id'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($user = $res->fetch_object()) {
        /* Load Default Image If User Has No Profile Pic */
        if ($user->user_profile_pic == '') {
            $url = "assets/images/no-profile.png";
        } else {
            $url = "assets/images/$user->user_profile_pic";
        }
    ?>
        <div class="user-info">
            <div class="image"> <img src="<?php echo $url; ?>" width="48" height="48" alt="User" /> </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown"><?php echo $user->user_name; ?></div>
                <div class="email"><?php echo $user->user_access_level; ?></div>
            </div>
        </div>
    <?php } ?>

    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <?php
        /* Limit This By Using User Access Level */
        if ($user_rank == 'Adminstrator' || $user_rank == 'Staff') {
        ?>
            <ul class="list">
                <li> <a href="dashboard"><i class="zmdi zmdi-home"></i><span>Dashboard</span> </a> </li>
                <li> <a href="modules_hrm"><i class="zmdi zmdi-accounts-add"></i><span>HRM</span> </a> </li>

                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-list"></i><span>Memberships</span> </a>
                    <ul class="ml-menu">
                        <li><a href="modules_memberships_packages">Packages</a></li>
                        <li><a href="modules_memberships_members">Members</a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Bookings</span> </a>
                    <ul class="ml-menu">
                        <li> <a href="modules_bookings_rooms">Rooms</a></li>
                        <li> <a href="modules_bookings_reservations">Reservations</a></li>
                        <li> <a href="modules_bookings_accomodations">Accomodations</a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-alarm-check"></i><span>Events</span> </a>
                    <ul class="ml-menu">
                        <li> <a href="modules_events_manage">Manage Events</a></li>
                        <li> <a href="modules_events_tickets">Tickets</a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-money-box"></i><span>Payments</span> </a>
                    <ul class="ml-menu">
                        <li> <a href="modules_events_tickets">Memberships</a></li>
                        <li> <a href="modules_events_tickets">Accomodations</a></li>
                        <li> <a href="modules_events_tickets">Tickets</a></li>
                    </ul>
                </li>
                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Reports</span> </a>
                    <ul class="ml-menu">
                        <li> <a href="modules_reports_hrm">HRM</a></li>
                        <li> <a href="modules_reports_members">Members</a></li>
                        <li> <a href="modules_reports_reservations">Reservations</a></li>
                        <li> <a href="modules_reports_accomodations">Accomodations</a></li>
                        <li> <a href="modules_reports_events">Events</a></li>
                        <li> <a href="modules_reports_payments">Payments</a></li>
                    </ul>
                </li>
            </ul>
        <?php } else {
        ?>
            <ul class="list">
                <li> <a href="home"><i class="zmdi zmdi-home"></i><span>Dashboard</span> </a> </li>
                <li> <a href="profile"><i class="zmdi zmdi-account-box"></i><span>My Profile</span> </a> </li>
                <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts-list"></i><span>Memberships</span> </a>
                    <ul class="ml-menu">
                        <li><a href="membership_packages">Packages</a></li>
                    </ul>
                </li>
                <li><a href="reservations"><i class="zmdi zmdi-calendar-check"></i><span>Reservations</span> </a> </li>
                <li><a href="events"><i class="zmdi zmdi-alarm-check"></i><span>Events</span> </a> </li>
                <li><a href="payments"><i class="zmdi zmdi-money-box"></i><span>Payments</span> </a> </li>
            </ul>

        <?php } ?>
    </div>
    <!-- #Menu -->
</aside>