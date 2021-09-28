let start = moment().startOf("month");
let end = moment().endOf("month");

$.ajax({
    url:
        "/api/member/nation/" +
        start.format("YYYY-MM-DD") +
        "+" +
        end.format("YYYY-MM-DD"),
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
                "/api/member/nation/" +
                first.format("YYYY-MM-DD") +
                "+" +
                last.format("YYYY-MM-DD"),
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

// total member
$(document).ready(function () {
    // jumlah anggota card dashboard
    $.ajax({
        url: "/api/member/totalnational",
        method: "GET",
        dataType: "json",
        cache: false,
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
        url: "/api/member/rergister/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            BeforeSend("loadProvince");
        },
        success: function (data) {
            // member calculate
            Highcharts.chart("province", {
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
                    categories: data.cat_province,
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
                                maxWidth: 500,
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
                        data: data.cat_province_data,
                    },
                ],
            });
        },
        complete: function () {
            Complete("loadProvince");
        },
    });

    // anggota terdaftar vs target
    async function getMemberVsTarget() {
        BeforeSend("LoadmemberRegister");
        try {
            const memberTarget = await getMemberTargetValue();
            ChartMemberTargetUi(memberTarget);
        } catch (err) {
            // console.log(err);
        }
        Complete("LoadmemberRegister");
    }

    getMemberVsTarget();

    function getMemberTargetValue() {
        return fetch("/api/membervsterget/national")
            .then((response) => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then((response) => {
                if (response.Response === "False") {
                    throw new Error(response.Error);
                }
                return response;
            });
    }

    function ChartMemberTargetUi(memberTarget) {
        const label = memberTarget.label;
        const valuePersentage = memberTarget.persentage;
        const valueTarget = memberTarget.value_target;
        const memberRegistered = document.getElementById("memberRegister");
        const dataMemberVsTarget = {
            labels: label,
            datasets: [
                {
                    label: "Terdaftar",
                    data: valuePersentage,
                    backgroundColor: "rgb(126, 252, 101)",
                },
                {
                    label: "Target",
                    data: valueTarget,
                    backgroundColor: "rgb(247, 67, 67)",
                },
            ],
        };
        new Chart(memberRegistered, {
            type: "bar",
            data: dataMemberVsTarget,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                            },
                        },
                    ],
                },
            },
            legend: true,
        });
    }

    // gender
    $.ajax({
        url: "/api/member/gender/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $("#Loadgender").removeClass("d-none");
        },
        success: function (data) {
            const donut_chart = Morris.Donut({
                element: "gender",
                data: data.cat_gender,
                colors: ["#063df7", "#EC407A"],
                resize: true,
                formatter: function (x) {
                    return x + "%";
                },
            });
            $("#totalMaleGender").text(data.total_male_gender);
            $("#totalfemaleGender").text(data.total_female_gender);
        },
        complete: function () {
            $("#Loadgender").addClass("d-none");
        },
    });

    // Jobs
    $.ajax({
        url: "/api/member/jobs/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $("#Loadjobs").removeClass("d-none");
        },
        success: function (data) {
            const label = data.chart_jobs_label;
            const value = data.chart_jobs_data;
            const colorJobs = data.color_jobs;
            const jobs = document.getElementById("jobs");
            const piechart = new Chart(jobs, {
                type: "pie",
                data: {
                    labels: label,
                    datasets: [
                        {
                            data: value,
                            backgroundColor: colorJobs,
                        },
                    ],
                },
                options: {
                    legend: false,
                },
            });
        },
        complete: function () {
            $("#Loadjobs").addClass("d-none");
        },
    });

    // kelompok umur
    $.ajax({
        url: "/api/member/agegroup/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $("#LoadageGroup").removeClass("d-none");
        },
        success: function (data) {
            const ageGroup = document
                .getElementById("ageGroup")
                .getContext("2d");
            const ageGroupChart = new Chart(ageGroup, {
                responsive: true,
                type: "bar",
                data: {
                    labels: data.cat_range_age,
                    datasets: [
                        {
                            data: data.cat_range_age_data,
                            backgroundColor: "rgba(34, 167, 240, 1)",
                            font: function (context) {
                                var width = context.chart.width;
                                var size = Math.round(width / 32);
                                return {
                                    size: size,
                                    weight: 600,
                                };
                            },
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                    legend: false,
                },
            });
        },
        complete: function () {
            $("#LoadageGroup").addClass("d-none");
        },
    });

    //generasi umur
    $.ajax({
        url: "/api/member/genage/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $("#LoadageGen").removeClass("d-none");
        },
        success: function (data) {
            const ageGen = document.getElementById("ageGen");
            const ageGenChart = new Chart(ageGen, {
                responsive: true,
                type: "bar",
                data: {
                    labels: data.cat_gen_age,
                    datasets: [
                        {
                            data: data.cat_gen_age_data,
                            backgroundColor: "rgba(34, 167, 240, 1)",
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                    legend: false,
                },
            });
        },
        complete: function () {
            $("#LoadageGen").addClass("d-none");
        },
    });

    // admin input terbanyak
    $.ajax({
        url: "/api/member/inputer/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $("#Loadinputer").removeClass("d-none");
        },
        success: function (data) {
            const inputer = document.getElementById("inputer").getContext("2d");
            const inputerChart = new Chart(inputer, {
                responsive: true,
                type: "bar",
                data: {
                    labels: data.cat_inputer_label,
                    datasets: [
                        {
                            data: data.cat_inputer_data,
                            backgroundColor: data.color_inputer,
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                    legend: false,
                },
            });
        },
        complete: function () {
            $("#Loadinputer").addClass("d-none");
        },
    });

    // anggota referal terbanyak
    $.ajax({
        url: "/api/member/referal/national",
        method: "GET",
        dataType: "json",
        cache: false,
        beforeSend: function () {
            $("#Loadreferal").removeClass("d-none");
        },
        success: function (data) {
            const referal = document.getElementById("referal");
            const referalChart = new Chart(referal, {
                responsive: true,
                type: "bar",
                data: {
                    labels: data.cat_referal_label,
                    datasets: [
                        {
                            data: data.cat_referal_data,
                            backgroundColor: data.color_referals,
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                    legend: false,
                },
            });
        },
        complete: function () {
            $("#Loadreferal").addClass("d-none");
        },
    });
});

// target pencapaian perhari
$("#achievment").DataTable({
    // processing: true,
    serverSide: true,
    ajax: {
        url: "/api/member/achievment/national",
        method: "GET",
        cache: false,
        beforeSend: function () {
            BeforeSend("Loadachievment");
        },
        success: function (data) {
            var html = "";
            for (var i in data) {
                const persentage =
                    (data[i].realisasi_member / data[i].target_member) * 100;
                const persentageWidth = persen(persentage);

                html +=
                    "<tr>" +
                    "<td>" +
                    data[i].name +
                    "</td>" +
                    "<td class='text-right'>" +
                    data[i].total_district +
                    "</td>" +
                    "<td class='text-right'>" +
                    decimalFormat(data[i].target_member) +
                    "</td>" +
                    "<td class='text-right'>" +
                    data[i].realisasi_member +
                    "</td>" +
                    "<td class='text-right'>" +
                    "<div class='mt-3 progress' style='width:100%'>" +
                    "<span class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width:" +
                    persentageWidth +
                    "%' aria-valuemin='" +
                    persen(persentage) +
                    "' aria-valuenow='" +
                    persen(persentage) +
                    "' aria-valuemax='" +
                    persen(persentage) +
                    "'><strong>" +
                    persen(persentage) +
                    "</strong></span>" +
                    "</div>" +
                    "</td>" +
                    "<td class='text-right'>" +
                    data[i].todays_achievement +
                    "</td>" +
                    "</tr>";
            }
            $("#dataachievment").html(html);
        },
        complete: function () {
            Complete("Loadachievment");
        },
    },
});

function persen(data) {
    return parseFloat(data).toFixed(1) + "%";
}

function decimalFormat(data) {
    return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// funsgsi efect loader
function BeforeSend(idLoader) {
    $("#" + idLoader + "").removeClass("d-none");
}

function Complete(idLoader) {
    $("#" + idLoader + "").addClass("d-none");
}
