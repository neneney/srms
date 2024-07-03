<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sid'] == 0)) {
    header('location:logout.php');
}

// Fetching data for the bar chart (students graduated per year)
$query = mysqli_query($con, "SELECT YEAR(graduated_at) AS year, COUNT(DISTINCT student_id) AS count FROM enrollment_history WHERE status='graduated' AND graduated_at IS NOT NULL GROUP BY YEAR(graduated_at) ORDER BY year ASC");
$data = array();
while ($row = mysqli_fetch_assoc($query)) {
    if (!is_null($row['year'])) {
        $data[] = $row;
    }
}

// Fetching data for the pie chart (students enrolled in each educational level)
$queryPie = mysqli_query($con, "SELECT c.`educ-level` AS educ_level, COUNT(ce.student_id) AS count 
                                FROM class_enrollment ce 
                                JOIN classes c ON ce.class_id = c.code 
                                GROUP BY c.`educ-level`");
$classes = array();
while ($row = mysqli_fetch_assoc($queryPie)) {
    $classes[] = $row;
}

// Fetching data for the line chart (monthly enrollments over the past year)
$queryLine = mysqli_query($con, "SELECT DATE_FORMAT(enrolled_at, '%Y-%m') AS month, COUNT(*) AS count 
                                 FROM class_enrollment 
                                 WHERE enrolled_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR) 
                                 GROUP BY month 
                                 ORDER BY month ASC");
$enrollments = array();
while ($row = mysqli_fetch_assoc($queryLine)) {
    $enrollments[] = $row;
}
?>
<!DOCTYPE html>
<html>
<?php @include("includes/head.php"); ?>

<style>
    .card {
        margin-bottom: 20px;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php @include("includes/header.php"); ?>
        <!-- Main Sidebar Container -->
        <?php @include("includes/sidebar.php"); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <?php $query1 = mysqli_query($con, "Select * from students ");
                                $totalcust = mysqli_num_rows($query1);
                                ?>
                                <div class="inner">
                                    <h3><?php echo $totalcust; ?></h3>
                                    <p>Total Students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="student_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <?php $query2 = mysqli_query($con, "Select * from students where gender='Male'");
                                $totalmale = mysqli_num_rows($query2);
                                ?>
                                <div class="inner">
                                    <h3><?php echo $totalmale; ?></h3>

                                    <p>Total Male students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="student_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <?php $query3 = mysqli_query($con, "Select * from students where gender='Female'");
                                $totalfemale = mysqli_num_rows($query3);
                                ?>
                                <div class="inner">
                                    <h3><?php echo $totalfemale; ?></h3>

                                    <p>Total female students</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="student_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body" style="display: flex; align-items: center; justify-content: center; height: 400px; width:100%;">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="card" style="display: flex; align-items: center; justify-content: center;">
                                <div class="card-body" style="height: 327px; width: 330px;">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body chart-container">
                                    <canvas id="myLineChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
        </div>
        <!-- /.content-wrapper -->
        <?php @include("includes/footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php @include("includes/foot.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');

        // Data fetched from PHP
        const chartData = <?php echo json_encode($data); ?>;

        // Process the data to get labels and values
        const labels = chartData.map(item => item.year);
        const values = chartData.map(item => item.count);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '# of Students Graduated',
                    data: values,
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235)',
                    borderColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        const ctxPie = document.getElementById('myPieChart').getContext('2d');

        // Data fetched from PHP for pie chart
        const pieData = <?php echo json_encode($classes); ?>;

        // Process the data to get labels and values
        const pieLabels = pieData.map(item => item.educ_level);
        const pieValues = pieData.map(item => item.count);

        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: '# of Students by Educational Level',
                    data: pieValues,
                    backgroundColor: [
                        'rgba(255, 99, 132 )',
                        'rgba(54, 162, 235 )',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });

        const ctxLine = document.getElementById('myLineChart').getContext('2d');

        // Data fetched from PHP for line chart
        const lineData = <?php echo json_encode($enrollments); ?>;

        // Process the data to get labels and values
        const lineLabels = lineData.map(item => item.month);
        const lineValues = lineData.map(item => item.count);

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Monthly Enrollments',
                    data: lineValues,
                    borderWidth: 1,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</body>

</html>