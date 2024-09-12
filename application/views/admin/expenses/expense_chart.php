

<div id="expense_chart" style="width:100%; height:400px;"></div>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->/
 <?php echo '<script src="' . base_url('modules/project_roadmap/assets/js/plugins/highcharts/highcharts.js') .'"></script>'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Render the chart
        Highcharts.chart('expense_chart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Expense Categories'
            },
            series: [{
                name: 'Expense',
                colorByPoint: true,
                data: <?php echo json_encode($chart_data); ?>
            }]
        });
    });
</script>