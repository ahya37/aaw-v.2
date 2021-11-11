$(document).ready(function () {
    jQuery("#datetimepicker6").datetimepicker({
        timepicker: false,
        format: "d-m-Y",
    });
    $.datetimepicker.setLocale("id");

    // crop ktp
    var $modal = $("#crop_ktp");
    var crop_image = document.getElementById("sample_image_ktp");
    var cropper;
    $("#upload_image_ktp").change(function (event) {
        var files = event.target.files;
        var done = function (url) {
            crop_image.src = url;
            $modal.modal("show");
        };
        if (files && files.length > 0) {
            reader = new FileReader();
            reader.onload = function (event) {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });
    $modal
        .on("shown.bs.modal", function () {
            cropper = new Cropper(crop_image, {
                viewMode: 3,
                preview: ".preview",
            });
        })
        .on("hidden.bs.modal", function () {
            cropper.destroy();
            cropper.null;
        });
    $("#btn_crop_ktp").click(function () {
        canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
        });
        canvas.toBlob(function (blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                var base64data = reader.result;
                $("#result_ktp").val(base64data);
            };
        });
        $modal.modal("hide");
        $modal.modal({ backdrop: "static", keyboard: false });
    });

    // crop photo
    var $modal_photo = $("#crop_photo");
    var crop_image_photo = document.getElementById("sample_image_photo");
    var cropper_photo;
    $("#upload_image_photo").change(function (event) {
        var files_photo = event.target.files;
        var done = function (url_photo) {
            crop_image_photo.src = url_photo;
            $modal_photo.modal("show");
        };
        if (files_photo && files_photo.length > 0) {
            reader_photo = new FileReader();
            reader_photo.onload = function (event) {
                done(reader_photo.result);
            };
            reader_photo.readAsDataURL(files_photo[0]);
        }
    });
    $modal_photo
        .on("shown.bs.modal", function () {
            cropper_photo = new Cropper(crop_image_photo, {
                viewMode: 3,
                preview: ".previewphoto",
            });
        })
        .on("hidden.bs.modal", function () {
            cropper_photo.destroy();
            cropper_photo.null;
        });
    $("#btn_crop_photo").click(function () {
        canvas_photo = cropper_photo.getCroppedCanvas({
            width: 400,
            height: 400,
        });
        canvas_photo.toBlob(function (blob) {
            url_photo = URL.createObjectURL(blob);
            var reader_photo = new FileReader();
            reader_photo.readAsDataURL(blob);
            reader_photo.onloadend = function () {
                var base64data_photo = reader_photo.result;
                console.log(base64data_photo);
                $("#result_photo").val(base64data_photo);
            };
        });
        $modal_photo.modal("hide");
        $modal_photo.modal({ backdrop: "static", keyboard: false });
    });
});

// mengambil nilai dari detaillnya untuk data regional milik anggota
const provinceId = $("#provinceId").val();
const regencyId = $("#regencyId").val();
const districtId = $("#districtId").val();
const villageId = $("#villageId").val();
const educationId = $("#educationId").val();
const jobId = $("#jobId").val();

Vue.use(Toasted);
var register = new Vue({
    el: "#register",
    mounted() {
        AOS.init();
        this.getProvincesData();
        this.getRegenciesData();
        this.getDistrictsData();
        this.getVillagesData();
        this.getJobsData();
        this.getEducationsData();
    },
    data() {
        return {
            provinces: null,
            regencies: null,
            districts: null,
            villages: null,
            jobs: null,
            educations: null,
            education_id: educationId,
            job_id: jobId,
            provinces_id: provinceId,
            regencies_id: regencyId,
            districts_id: districtId,
            villages_id: villageId,
        };
    },
    methods: {
        getEducationsData() {
            var self = this;
            axios.get("/api/educations").then(function (response) {
                self.educations = response.data;
            });
        },
        getJobsData() {
            var self = this;
            axios.get("/api/jobs").then(function (response) {
                self.jobs = response.data;
            });
        },
        getProvincesData() {
            var self = this;
            axios.get("/api/provinces").then(function (response) {
                self.provinces = response.data;
            });
        },
        getRegenciesData() {
            var self = this;
            axios
                .get("/api/regencies/" + self.provinces_id)
                .then(function (response) {
                    self.regencies = response.data;
                });
        },
        getDistrictsData() {
            var self = this;
            axios
                .get("/api/districts/" + self.regencies_id)
                .then(function (response) {
                    self.districts = response.data;
                });
        },
        getVillagesData() {
            var self = this;
            axios
                .get("/api/villages/" + self.districts_id)
                .then(function (response) {
                    self.villages = response.data;
                });
        },
    },
    watch: {
        provinces_id: function (val, oldval) {
            this.regencies_id = null;
            this.getRegenciesData();
        },
        regencies_id: function (val, oldval) {
            this.districts_id = null;
            this.getDistrictsData();
        },
        districts_id: function (val, oldval) {
            this.villages_id = null;
            this.getVillagesData();
        },
    },
});
