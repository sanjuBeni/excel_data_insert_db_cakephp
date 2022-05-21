<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>


    <script>
        am5.ready(function() {

            // Create root element

            let root = am5.Root.new("chartdiv");

            root.numberFormatter.setAll({
                numberFormat: "#,###.00",
                numericFields: ["valueY"]
            });


            // Set themes

            root.setThemes([
                am5themes_Animated.new(root)
            ]);


            // Create chart

            let chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX: true
            }));


            // Add cursor
            let cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);


            // Create axes
            let xRenderer = am5xy.AxisRendererX.new(root, {
                minGridDistance: 30
            });
            xRenderer.labels.template.setAll({
                rotation: -90,
                centerY: am5.p50,
                centerX: am5.p100,
                paddingRight: 15
            });

            let xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "asset_type",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            let yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                // numberFormat: "#.00",
                // tooltipNumberFormat: "#.00",
                maxDeviation: 0.3,
                renderer: am5xy.AxisRendererY.new(root, {})
            }));



            // Create series
            let series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "amount",
                sequencedInterpolation: true,
                categoryXField: "asset_type",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{valueY.formatNumber('#.00')}"
                })
            }));

            series.columns.template.setAll({
                cornerRadiusTL: 5,
                cornerRadiusTR: 5
            });
            series.columns.template.adapters.add("fill", function(fill, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });


            // Set data

            let data = [
                <?php foreach ($tblData as $val) : ?> {
                        asset_type: `<?= $val['asset_type'] ?>`,
                        amount: <?= $val['amount'] ?>
                    },
                <?php endforeach; ?>
            ];

            // let data = myData;


            xAxis.data.setAll(data);
            series.data.setAll(data);


            // Make stuff animate on load

            series.appear(1000);
            chart.appear(1000, 100);

        });
    </script>


</body>

</html>