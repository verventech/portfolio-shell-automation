<?php
// 1. Establish the database connection using Apache's environment variables
$host = getenv('PGHOST');
$db   = getenv('PGDATABASE');
$user = getenv('PGUSER');
$pass = getenv('PGPASSWORD');
$port = getenv('PGPORT') ?: '5432';

$stmt = null;
$db_error = null;

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query the database
    $stmt = $pdo->query("SELECT course_name, session, cgpa, institute FROM education");

} catch (PDOException $e) {
    // Catch any connection errors so they don't crash the whole HTML page
    $db_error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musharaf Portfolio</title>
    <style>
        /* Modern CSS Variables for easy theming */
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
        }

        /* Reset & Base Styles */
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Hero / Header Section */
        header {
            background: linear-gradient(135deg, var(--primary-color), #818cf8);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        header h1 {
            margin: 0 0 0.5rem 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        header p {
            margin: 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Main Content Layout */
        main {
            max-width: 1000px;
            margin: -2rem auto 3rem auto; /* Overlaps the header slightly */
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
        }

        /* Section Styling */
        section {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            text-align: center;
            font-size: 1.75rem;
            color: var(--text-main);
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        /* Table Styling */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            white-space: nowrap;
        }

        th, td {
            padding: 1rem 1.5rem;
        }

        th {
            background-color: #f9fafb;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
        }

        td {
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        /* Styling elements inside the table */
        .course-name {
            font-weight: 600;
            color: var(--primary-color);
        }

        .badge {
            background-color: #e0e7ff;
            color: var(--primary-hover);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Error Message Styling */
        .error-message {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #f87171;
            text-align: center;
        }
    </style>
</head>
<body>

    <header>
        <h1>Musharaf Portfolio</h1>
        <p>Hello, my name is Musharaf. Welcome to my portfolio.</p>
    </header>

    <main>
        <!-- Courses Section -->
        <section id="courses">
            <h2 class="section-title">🎓 Featured AI Learning Paths & Education</h2>
            <p class="section-subtitle">Choose the track that best fits your career goals.</p>
            
            <div class="table-container">
                <?php if ($db_error): ?>
                    <!-- Display database errors gracefully if they occur -->
                    <div class="error-message">
                        <strong>Database error:</strong> <?php echo htmlspecialchars($db_error); ?>
                    </div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Session</th>
                                <th>CGPA</th>
                                <th>Institute</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 3. Loop through each row in the database and generate a <tr>
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td class='course-name'>" . htmlspecialchars($row['course_name']) . "</td>";
                                echo "<td><span class='badge'>" . htmlspecialchars($row['session']) . "</span></td>";
                                echo "<td><strong>" . htmlspecialchars($row["cgpa"]) . "</strong></td>";
                                echo "<td>" . htmlspecialchars($row['institute']) . "</td>";
                                echo "</tr>\n";
                            }
                            ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </main>

</body>
</html>
