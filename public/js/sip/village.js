// Data for the bar graph
const query = document.URL;
const districtId = query.substring(query.lastIndexOf("/") + 1);
function getSipDataRegency(){
	return fetch(`/api/sip/district/${districtId}`).then((response) => { 
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

async function getSipGrafikRegency(){
	try{
		
		const results = await getSipDataRegency();
		getSipGrafikRegencyUi(results)
		
	}catch(err){
		console.log(err);
	} 
}
function getSipGrafikRegencyUi(results){
	// const label = results.label;
	// const suara = results.hasilsuara; 
	// const anggota = results.anggota;
	// const peserta_kunjungan = results.peserta_kunjungan;
	let data = results

	// Get the context of the canvas element
	let ctx = document.getElementById("myChart"); 

			// Create the bar graph
	const config = {
		type: 'bar',
				data: data,
				options: {
					responsive: true,
					title: { 
					  display: true,
					  position: "top",
					  text: "Bar Graph",
					  fontSize: 18,
					  fontColor: "#111"
					},
					legend: {
					  display: true,
					  position: "bottom", 
					  labels: { 
						fontColor: "#333",
						fontSize: 16
					  }
					},
					scales: {
						x: { 
								  ticks: {
								  min: 0
								}
						   },
						y: {
							 ticks: {
							  min: 0 
							}  
							}
					}
				}
	}
	
	let myChart = new Chart(
		ctx,
		config
	)
	
	// function clickHandler(click){
		// const points = myChart.getElementsAtEventForMode(click, 'nearest',{intersect: true}, true);
		// if(points.length){
			// const firstPoint = points[0];
			 // const value = myChart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];
			// console.log(firstPoint);
			
		// }

	// }
	
	// ctx.onclick = clickHandler;
};

getSipGrafikRegency();