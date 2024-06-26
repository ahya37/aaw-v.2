// search district
const minlength = 3;
const searchDistrict = document.getElementById("formDistrict");
searchDistrict.addEventListener("keyup", async function () {
    const searchDistrictValue = this.value;
    if (searchDistrictValue === null || searchDistrictValue === "") {
        $("#showDataDistrict").empty();
    } else {
        BeforeSend("LoadDistrict");

        try {
            const district = await getDistrict(searchDistrictValue);
            updateMemberUiDistrict(district);
        } catch (err) {}
        Complete("LoadDistrict");
    }
});

function getDistrict(searchDistrictValue) {
    if (searchDistrictValue.length >= minlength) {
        return fetch(`/api/searchdistricts`, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ data: searchDistrictValue }),
        }).then((response) => {
            return response.json();
        });
    }
}
function updateMemberUiDistrict(district) {
    let divHtml = "";
    district.forEach((m) => {
        divHtml += showDivHtmlDistrict(m);
    });

    const divHtmlContainer = document.getElementById("showDataDistrict");
    divHtmlContainer.innerHTML = divHtml;
}
function showDivHtmlDistrict(m) {
    return `   
                <a    onclick='selectDataDistrict(${m.id})' class="col-12">
                    <div class="card mt-2">
                    <div class="card-body">
                    <i class="fa fa-check"></i> ${m.view}
                    </div>
                    </div>            
                    </a>
            `;
}
async function selectDataDistrict(id) {
    let formDistrict = $("#formDistrict");
    let formDistrictResult = $("#formDistrictResult");
    BeforeSend("LoadDistrict");

    try {
        const district = await getDistrictById(id);
        formDistrict.val(
            `${district.name}, ${district.regency.name}, ${district.regency.province.name}`
        );
        formDistrictResult.val(district.id);
        $("#showDataDistrict").empty();
    } catch (err) {}
    Complete("LoadDistrict");
}
function getDistrictById(id) {
    return fetch(`/api/searchdistrictById`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ data: id }),
    }).then((response) => {
        return response.json();
    });
}

// search village
const searchVIllage = document.getElementById("formVillage");
searchVIllage.addEventListener("keyup", async function () {
    const searchVIllageValue = this.value;
    if (searchVIllageValue === null || searchVIllageValue === "") {
        $("#showDataVillage").empty();
    } else {
        BeforeSend("LoadVillage");
        try {
            const village = await getVillage(searchVIllageValue);
            updateMemberUiVillage(village);
        } catch (err) {}
        Complete("LoadVillage");
    }
});
function getVillage(searchVIllageValue) {
    if (searchVIllageValue.length >= minlength) {
        return fetch(`/api/searchvillage`, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ data: searchVIllageValue }),
        }).then((response) => {
            return response.json();
        });
    }
}
function updateMemberUiVillage(village) {
    let divHtml = "";
    village.forEach((m) => {
        divHtml += showDivHtmlVillage(m);
    });

    const divHtmlContainer = document.getElementById("showDataVillage");
    divHtmlContainer.innerHTML = divHtml;
}
function showDivHtmlVillage(m) {
    return `
                <a onclick='selectDataVillage(${m.id})' class="col-12">
                    <div class="card mt-2">
                    <div class="card-body">
                    <i class="fa fa-check"></i> ${m.view}
                    </div>
                    </div>
                    </a>
            `;
}
async function selectDataVillage(id) {
    let formVillage = $("#formVillage");
    let formVillageResult = $("#formVillageResult");
    BeforeSend("LoadVillage");
    try {
        const village = await getVillageById(id);
        formVillage.val(
            `${village.name},${village.district.name}, ${village.district.regency.name}, ${village.district.regency.province.name}`
        );
        formVillageResult.val(village.id);
        $("#showDataVillage").empty();
    } catch (err) {}
    Complete("LoadVillage");
}
function getVillageById(id) {
    return fetch(`/api/searchVillageById`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ data: id }),
    }).then((response) => {
        return response.json();
    });
}
function BeforeSend(idLoader) {
    $("#" + idLoader + "").removeClass("d-none");
}

function Complete(idLoader) {
    $("#" + idLoader + "").addClass("d-none");
}
