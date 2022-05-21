<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart</title>
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>

</head>

<body>

    <!-- HTML -->
    <div id="chartdiv"></div>

    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- Chart code -->
    <script>
        am5.ready(function() {

            // Create root element

            let root = am5.Root.new("chartdiv");

            // Set themes

            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create chart

            let chart = root.container.children.push(
                am5percent.PieChart.new(root, {
                    endAngle: 270
                })
            );

            // Create series

            let series = chart.series.push(
                am5percent.PieSeries.new(root, {
                    valueField: "amount",
                    categoryField: "asset_type",
                    endAngle: 270
                })
            );

            series.states.create("hidden", {
                endAngle: -90
            });

            // Set data

            series.data.setAll([
                <?php foreach ($tblData as $val) : ?> {
                        asset_type: `<?= $val['asset_type'] ?>`,
                        amount: <?= $val['amount'] ?>
                    },
                <?php endforeach; ?>
            ]);

            series.appear(1000, 100);

        });
    </script>


</body>

</html>