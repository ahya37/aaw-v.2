let start = moment().startOf("month");
let end = moment().endOf("month");
let provinceID = $("#provinceID").val();

$.ajax({
    url:
        "/api/member/province/" +
        start.format("YYYY-MM-DD") +
        "+" +
        end.format("YYYY-MM-DD") +
        "/" +
        +provinceID,
    method: "GET",
    data: { first: self.first, last: self.last },
    dataType: "json",
    cache: false,
    success: function (data) {
        if (data.length === 0) {
        } else {
            var label = [];
            var value = [];

            for (var i in data) {
                label.push(data[i].day);
                value.push(data[i].count);
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
                "/api/member/province/" +
                first.format("YYYY-MM-DD") +
                "+" +
                last.format("YYYY-MM-DD") +
                "/" +
                provinceID,
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

                    for (var i in data) {
                        label.push(data[i].day);
                        value.push(data[i].count);
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

$.ajax({
    url: "/api/member/totalprovince" + "/" + provinceID,
    method: "GET",
    dataType: "json",
    beforeSend: function () {
        $("#total_member").text("loading...");
        $("#total_member_persen").text("loading...");
        $("#target_anggota").text("loading...");
        $("#village_filled").text("loading...");
        $("#village_filled_persen").text("loading...");
        $("#total_village").text("loading...");
    },
    success: function (data) {
        $("#total_member").text(data.total_member);
        $("#total_member_persen").text(data.persentage_target_member);
        $("#target_anggota").text(data.target_member);
        $("#village_filled").text(data.total_village_filled);
        $("#village_filled_persen").text(data.presentage_village_filled);
        $("#total_village").text(data.total_village);
    },
});

// anggota terdaftar
$.ajax({
    url: "/api/member/rergister/province" + "/" + provinceID,
    method: "GET",
    dataType: "json",
    beforeSend: function () {
        $("#loadProvince").removeClass("d-none");
    },
    success: function (data) {
        // member calculate
        Highcharts.chart("districts", {
            credits: {
                enabled: false,
            },
            legend: { enabled: false },

            chart: {
                type: "column",
            },
            title: {
                text: "Anggota Terdaftar",
            },
            xAxis: {
                categories: data.cat_regency,
                crosshair: true,
            },
            yAxis: {
                min: 0,
                title: {
                    text: "Jumlah",
                },
            },
            tooltip: {
                headerFormat:
                    '<span style="font-size:10px">{point.key}</span><table>',
                footerFormat: "</table>",
                shared: true,
                useHTML: true,
            },
            responsive: {
                rules: [
                    {
                        condition: {
                            maxWidth: 1,
                        },
                    },
                ],
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0,
                },
                series: {
                    stacking: "normal",
                    borderRadius: 3,
                    cursor: "pointer",
                    point: {
                        events: {
                            click: function (event) {
                                // console.log(this.url);
                                window.location.assign(this.url);
                            },
                        },
                    },
                },
            },
            series: [
                {
                    colorByPoint: true,
                    name: "",
                    data: data.cat_regency_data,
                },
            ],
        });
    },
    complete: function () {
        $("#loadProvince").addClass("d-none");
    },
});
