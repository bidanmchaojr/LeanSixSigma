<?php
// Start session to store events for the current session
session_start();

// Initialize events array if not already set
if (!isset($_SESSION['events'])) {
    $_SESSION['events'] = [];
}

// Handle form submissions for adding tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task-text']) && isset($_POST['active-day'])) {
        $taskText = htmlspecialchars($_POST['task-text']);
        $activeDay = $_POST['active-day'];
        $_SESSION['events'][$activeDay] = $taskText;
    }
}

// Determine the current month and year
$date = new DateTime();
if (isset($_GET['month']) && isset($_GET['year'])) {
    $date->setDate($_GET['year'], $_GET['month'], 1);
}

// Get the current month and year
$month = $date->format('m');
$year = $date->format('Y');
$monthName = $date->format('F Y');

// Get the first day of the month and the number of days
$firstDay = new DateTime("{$year}-{$month}-01");
$lastDay = new DateTime("{$year}-{$month}-01");
$lastDay->modify('last day of this month');

$daysInMonth = $lastDay->format('d');
$firstDayOfWeek = $firstDay->format('w');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Calendar</title>
    <style>
        /* Same CSS as before */
    </style>
</head>
<body>
    <div class="nav">
        <a href="login.php"><b>LOGIN</b></a>
        <a href="home.php"><b>HOME</b></a>
    </div>
    <div class="calendar">
        <div class="header">
            <button onclick="window.location='?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>'">◀</button>
            <h2><?php echo $monthName; ?></h2>
            <select id="year-select" onchange="window.location='?month=<?php echo $month; ?>&year=' + this.value">
                <?php for ($i = 2025; $i <= date('Y') + 10; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php echo $i == $year ? 'selected' : ''; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <button onclick="window.location='?month=<?php echo $month + 1; ?>&year=<?php echo $year; ?>'">▶</button>
        </div>
        <div class="days" id="calendar-days">
            <?php
            // Empty slots before the first day of the month
            for ($i = 0; $i < $firstDayOfWeek; $i++) {
                echo '<div></div>';
            }

            // Days of the month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDay = "{$year}-{$month}-{$day}";
                $hasEvent = isset($_SESSION['events'][$currentDay]);
                $eventText = $hasEvent ? $_SESSION['events'][$currentDay] : '';
                echo '<div class="day" onclick="openEventPopup(\'' . $currentDay . '\')">
                        ' . $day . 
                        ($hasEvent ? '<div class="has-task">Task</div>' : '') .
                    '</div>';
            }
            ?>
        </div>
    </div>

    <div class="goal-popup" id="goal-popup">
        <p>Would you like to set a goal?</p>
        <input type="text" id="goal-text" placeholder="Enter goal">
        <input type="date" id="goal-date">
        <button onclick="saveGoal()">Save Goal</button>
        <button onclick="closeGoalPopup()">No</button>
    </div>

    <div class="event-popup" id="event-popup">
        <p id="event-details"></p>
        <form method="POST" action="">
            <input type="text" name="task-text" id="task-text" placeholder="Enter task">
            <input type="hidden" name="active-day" id="active-day">
            <button type="submit">Save Task</button>
            <button type="button" onclick="closeEventPopup()">Close</button>
        </form>
    </div>

    <script>
        function openEventPopup(day) {
            document.getElementById('active-day').value = day;
            document.getElementById('event-details').textContent = 'Tasks for ' + day;
            document.getElementById('task-text').value = ''; // Clear existing task
            document.getElementById('event-popup').style.display = 'block';
        }

        function closeEventPopup() {
            document.getElementById('event-popup').style.display = 'none';
        }

        function saveGoal() {
            // Implement saving the goal logic
        }

        function closeGoalPopup() {
            document.getElementById('goal-popup').style.display = 'none';
        }
    </script>
</body>
</html>
