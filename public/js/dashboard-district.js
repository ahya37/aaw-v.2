$(document).ready(function () {
    let start = moment().startOf("month");
    let end = moment().endOf("month");
    let districtID = $("#districtID").val();
    $.ajax({
        url:
            "/api/member/district/" +
            start.format("YYYY-MM-DD") +
            "+" +
            end.format("YYYY-MM-DD") +
            "/" +
            districtID,
        method: "GET",
        data: { first: self.first, last: self.last },
        dataType: "json",
        cache: false,
        success: function (data) {
            if (data.length === 0) {
            } else {
                var label = [];
                var value = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };
                for (var i in data) {
                    label.push(data[i].day);
                    value.push(data[i].count);
                    coloR.push(dynamicColors());
                }
                var ctx = document
                    .getElementById("memberPerMonth")
                    .getContext("2d");
                var chart = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: label,
                        datasets: [
                            {
                                label: "",
                                backgroundColor: "rgb(54, 162, 235)",
                                data: value,
                                order: 1,
                            },
                            {
                                label: "",
                                data: value,
                                type: "line",
                                order: 2,
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth: 2,
                                fill: false,
                            },
                        ],
                    },
                    options: {
                        legend: false,
                        responsive: true,
                    },
                });
            }
        },
    });
    $("#created_at").daterangepicker(
        {
            startDate: start,
            endDate: end,
            locale: {
                format: "DD/MM/YYYY",
                separator: " - ",
                customRangeLabel: "Custom",
                daysOfWeek: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                monthNames: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "Mei",
                    "Jun",
                    "Jul",
                    "Agu",
                    "Sep",
                    "Okt",
                    "Nov",
                    "Des",
                ],
                firstDay: 0,
            },
        },
        function (first, last) {
            var self = this;
            $.ajax({
                url:
                    "/api/member/district/" +
                    first.format("YYYY-MM-DD") +
                    "+" +
                    last.format("YYYY-MM-DD") +
                    "/" +
                    districtID,
                method: "GET",
                data: { first: self.first, last: self.last },
                dataType: "json",
                cache: false,
                success: function (data) {
                    if (data.length === 0) {
                        $("#memberPerMonth").remove();
                        $("#divMemberPerMonth").append(
                            '<canvas id="memberPerMonth"></canvas>'
                        );
                        var ctx = document
                            .getElementById("memberPerMonth")
                            .getContext("2d");
                        startDay = first.format("YYYY-MM-DD");
                        lastDay = last.format("YYYY-MM-DD");
                        var chart = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: [startDay, lastDay],
                                datasets: [
                                    {
                                        label: "",
                                        backgroundColor: "rgb(54, 162, 235)",
                                        data: [0, 0],
                                        order: 1,
                                    },
                                    {
                                        label: "",
                                        data: [0, 0],
                                        type: "line",
                                        order: 2,
                                        borderColor: "rgb(255, 99, 132)",
                                        borderWidth: 2,
                                        fill: false,
                                    },
                                ],
                            },
                            options: {
                                legend: false,
                                responsive: true,
                            },
                        });
                    } else {
                        var label = [];
                        var value = [];
                        var coloR = [];
                        var dynamicColors = function () {
                            var r = Math.floor(Math.random() * 255);
                            var g = Math.floor(Math.random() * 255);
                            var b = Math.floor(Math.random() * 255);
                            return "rgb(" + r + "," + g + "," + b + ")";
                        };
                        for (var i in data) {
                            label.push(data[i].day);
                            value.push(data[i].count);
                            coloR.push(dynamicColors());
                        }
                        $("#memberPerMonth").remove();
                        $("#divMemberPerMonth").append(
                            '<canvas id="memberPerMonth"></canvas>'
                        );
                        var ctx = document
                            .getElementById("memberPerMonth")
                            .getContext("2d");
                        var chart = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: label,
                                datasets: [
                                    {
                                        label: "",
                                        backgroundColor: "rgb(54, 162, 235)",
                                        data: value,
                                        order: 1,
                                    },
                                    {
                                        label: "",
                                        data: value,
                                        type: "line",
                                        order: 2,
                                        borderColor: "rgb(255, 99, 132)",
                                        borderWidth: 2,
                                        fill: false,
                                    },
                                ],
                            },
                            options: {
                                legend: false,
                                responsive: true,
                            },
                        });
                    }
                },
            });
        }
    );
});