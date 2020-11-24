<?php
	include "include/header.php";
?>
<ons-navigator id="navigator">
	<ons-page>
	  
	  <div style="text-align: center; margin-top: 50px">
	  	<ons-row>
	  		<ons-col><img src="assets/images/telkom.png" width="100" align="right" style="margin-bottom:40px;"></ons-col>
	  	</ons-row>
	  	<img src="assets/images/logo.jpeg" width="150" align="center" style="margin-bottom:30px;">
	  <p>
	    <ons-input id="username" placeholder="Username" modifier="underbar"></ons-input>
	  </p>

	  <p>
	    <ons-input
	      id="password"
	      placeholder="Password"
	      type="password"
	      modifier="underbar"
	    >
	    </ons-input>
	  </p>
	  
	  <p>
	  	Login Sebagai : 
	  	<ons-select id="choose-sel">
		    <option value="basic">Sales</option>
		    <option value="material">Tek. Pasang</option>
		    <option value="underbar">Tek. Gangguan</option>
		    <option value="underbar">Collection</option>
		  </ons-select>
	  </p>
	  <p>
	  	<ons-checkbox 
	  		value="remember me"></ons-checkbox> Ingat
	  		/ <a href="#">Forgot Password</a>
	  </p>
	  <p>
	    <ons-button onclick="login()">Sign in</ons-button>
	  </p><br /><br />
	  </div>

	</ons-page>
</ons-navigator>

<script>
	if(localStorage.token != undefined){
		const navigator = document.querySelector('#navigator');
		navigator
		.pushPage('home.html')
		.then(function(){
		  //load list
		  const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
		  fetch(url,{
		  	method : "GET",
		  	headers : {
		  		"Authorization" : localStorage.token,
		  	},
		  }).then(response => response.json())
		    .then(function(response){
		    	refresh(response);
		    });
		  //load grafik
	      var ctx = document.getElementById("myChart");
		  var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		      labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		      datasets: [{
		        data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
		        lineTension: 0,
		        backgroundColor: 'transparent',
		        borderColor: '#7f8c8d',
		        borderWidth: 4,
		        pointBackgroundColor: '#95a5a6'
		      }]
		    },
		    options: {
		      scales: {
		        yAxes: [{
		          ticks: {
		            beginAtZero: false
		          }
		        }]
		      },
		      legend: {
		        display: false,
		      }
		    }
		  });
		});
	}
	const refresh = (response) =>{
		var hasil = JSON.parse(JSON.stringify(response));
    	console.log('Success:', JSON.stringify(response));
    	$("#list-pelanggan").html("");
    	//document.getElementById("result").innerHTML = hasil.data.length;
    	for (var i = 0; i < hasil.data.length; i++){
		  //document.write("<br><br>array index: " + i);
		  var obj = hasil.data[i];
		    // var nama = obj['nama'];
		    // var nohp = obj['nohp'];
		    $("#list-pelanggan").append('<ons-card onclick="edit()"><ons-row><ons-col width="40%"><input type="hidden" id="myid" value="'+ obj['id']+'"><img src="http://localhost/laravel/apigenius/public/images/upload/'+obj['photo']+'" width="85%"></ons-col><ons-col width="60%"><table><tr><td>ID Pel. </td><td>: 00'+ obj['id'] +'</td></tr><tr><td>Nama </td><td>: '+ obj['nama'] +'</td></tr><tr><td>No. HP </td><td>: '+ obj['nohp'] +'</td></tr><tr><td>No. HP Alt </td><td>: '+ obj['nohpalt'] +'</td></tr><tr><td>Tagging </td><td>: <ons-button onclick="tagging('+obj['id']+')">Lihat</ons-button></td></tr><tr><td>Status </td><td>: '+ obj['status'] +'</td></tr></table></ons-col></ons-row><ons-row><ons-col><b>Keterangan</b>: '+ obj['keterangan'] +'</ons-col></ons-row></ons-card>');
		}
	}
	const tagging = (id) =>{
		const navigators = document.querySelector('#navigator');
	    navigators
	    .pushPage('tagging.html')
	    .then(function(){
	    	const url = "http://localhost/laravel/apigenius/public/api/pelanggan/"+id;
			fetch(url,{
			  	method : "GET",
			  	headers : {
			  		"Authorization" : localStorage.token,
			  	},
			  }).then(response => response.json())
		    .then(function(response){
		    	var hasil = JSON.parse(JSON.stringify(response));
		    	var obj = hasil.data;	
		    	//document.getElementById("result").innerHTML = hasil.data.length;
		    	var infoWindow;
      
		        var directionsService = new google.maps.DirectionsService;
		        var directionsDisplay = new google.maps.DirectionsRenderer;
		        var secheltLoc = new google.maps.LatLng(-6.9790894, 110.4090187);
		        var myMapOptions = {
		           zoom: 17,
		           center: secheltLoc
		         };

		        var map = new google.maps.Map(document.getElementById('map_canvas'),myMapOptions);
		        
		        directionsDisplay.setMap(map);
				
		    		infoWindow = new google.maps.InfoWindow;
		    		var pos;
		        // Try HTML5 geolocation.
		        if (navigator.geolocation) {
		          navigator.geolocation.getCurrentPosition(function(position) {
		            pos = {
		              lat: position.coords.latitude,
		              lng: position.coords.longitude
		            };
					//var marker = new google.maps.Marker({position: pos, map: map});
		            map.setCenter(pos);
					       directionsService.route({
		                origin:pos,
		                destination: obj['lat']+","+obj['lng'],
		                travelMode: 'DRIVING'
		              }, function(response, status) {
		                if (status === 'OK') {
		                directionsDisplay.setDirections(response);
		                } else {
		                window.alert('Directions request failed due to ' + status);
		                }
		              });
		          }, function() {
		            handleLocationError(true, infoWindow, map.getCenter());
		          });

		        } else {
		          // Browser doesn't support Geolocation
		          handleLocationError(false, infoWindow, map.getCenter());
		        }
			  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		        infoWindow.setPosition(pos);
		        infoWindow.setContent(browserHasGeolocation ?
		                              'Error: The Geolocation service failed.' :
		                              'Error: Your browser doesn\'t support geolocation.');
		        infoWindow.open(map);
		      }
		    });
	    });
	}
	const logout = () =>{
		const navigator = document.querySelector('#navigator');
	    navigator
	    .pushPage('signin.html')
	    .then(function(){
	    	localStorage.clear();
	    });
	}
	const edit = () => { 
		const myid = $("#myid").val();
		const navigator = document.querySelector('#navigator');
	    navigator
	    .pushPage('edit.html')
	    .then(function(){
	    	const url = "http://localhost/laravel/apigenius/public/api/pelanggan/"+myid;
			fetch(url,{
			  	method : "GET",
			  	headers : {
			  		"Authorization" : localStorage.token,
			  	},
			  }).then(response => response.json())
		    .then(function(response){
		    	var hasil = JSON.parse(JSON.stringify(response));
		    	var obj = hasil.data;	
		    	console.log('Success:'+obj['nama']);
		    	//document.getElementById("result").innerHTML = hasil.data.length;
		    		
		    		$("#nama").val(obj['nama']);
		    		$("#nohp").val(obj['nohp']);
		    		$("#nohpalt").val(obj['nohpalt']);
		    		$("#statuss").val(obj['status']).prop("selected",true);
//		    		alert(obj['status']);
		    		$("#keterangan").val(obj['keterangan']);
		    		$("#ids").val(myid);
		    });
	    });
	}
	const input = () =>{
		const navigators = document.querySelector('#navigator');
	    navigators
	    .pushPage('input.html')
	    .then(function(){
	    		//maps script
				var marker = false;
				var secheltLoc = new google.maps.LatLng(-6.9790894, 110.4090187);
				var myMapOptions = {
				   zoom: 17,
				   center: secheltLoc
				 };
				 var theMap = new google.maps.Map(document.getElementById("map_canvas"), myMapOptions);
				 var infowindow = new google.maps.InfoWindow;

				 // Try HTML5 geolocation.
				if (navigator.geolocation) {
				  navigator.geolocation.getCurrentPosition(function(position) {
					var pos = {
					  lat: position.coords.latitude,
					  lng: position.coords.longitude
					};
					var marker = new google.maps.Marker({position: pos, map: theMap});
					theMap.setCenter(pos);
					document.getElementById('lat').value = position.coords.latitude; //latitude
					document.getElementById('lng').value = position.coords.longitude; //logitude
				  }, function() {
					handleLocationError(true, infowindow, theMap.getCenter());
				  });
				} else {
				  // Browser doesn't support Geolocation
				  handleLocationError(false, infowindow, theMap.getCenter());
				}
				function handleLocationError(browserHasGeolocation, infoWindow, pos) {
					infoWindow.setPosition(pos);
					infoWindow.setContent(browserHasGeolocation ?
										  'Error: The Geolocation service failed.' :
										  'Error: Your browser doesn\'t support geolocation.');
					infoWindow.open(theMap);
				  }	
	    });
	}
	const update = () => {
	  const nama = $('#nama').val();
	  const nohp = $('#nohp').val();
	  const nohpalt = $('#nohpalt').val();
	  const keterangan = $('#keterangan').val();
	  const status = $('#statuss').val();
		
	  var ids = $("#ids").val();

	  const url = "http://localhost/laravel/apigenius/public/api/pelanggan/"+ids+"?nama="+nama+"&nohp="+nohp+"&nohpalt="+nohpalt+"&keterangan="+keterangan+"&status="+status;
	  fetch(url,{
	  	method : "PUT",
	  	headers : {
	  		"Authorization" : localStorage.token,
	  	},
	  }).then(response => response.json())
	    .then(function(response){
	    	var hasil = JSON.parse(JSON.stringify(response));
	    	if(hasil['success'] == true){
	    		document.querySelector('ons-back-button').onClick = function() {
			   //    
				  document.querySelector('ons-navigator').popPage();
				  document.querySelector('ons-navigator').addEventListener('postpop', function() { 
				  	  const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
					  fetch(url,{
					  	method : "GET",
					  	headers : {
					  		"Authorization" : localStorage.token,
					  	},
					  }).then(response => response.json())
					    .then(function(response){
					    	//alert("data berhasil disimpan");
					    	const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
							  fetch(url,{
							  	method : "GET",
							  	headers : {
							  		"Authorization" : localStorage.token,
							  	},
							  }).then(response => response.json())
							    .then(function(response){
							    	refresh(response);
							    });
					    });
				  });
			    };
	    	}else{
	    		var showToast = function() {
				  ons.notification.toast('Data Gagal Ditambahkan', {
				    timeout: 2000
				  });
				};
	    	}
	    });
	}
	const simpan = () => {
	  const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
	  
	  const nama = document.querySelector('#nama').value;
	  const nohp = document.querySelector('#nohp').value;
	  const nohpalt = document.querySelector('#nohpalt').value;
	  const keterangan = document.querySelector('#keterangan').value;
	  const lat = document.querySelector('#lat').value;
	  const lng = document.querySelector('#lng').value;
	  const status = document.querySelector('#status').value;
	  const photo_file = document.querySelector('input[type="file"]');
	  const photo = document.querySelector('#photo').value;
		const formData = new FormData();
	  formData.append("nama",nama);
	  formData.append("nohp",nohp);
	  formData.append("nohpalt",nohpalt);
	  formData.append("keterangan",keterangan);
	  formData.append("lat",lat);
	  formData.append("lng",lng);
	  formData.append("status",status);
	  formData.append("photo_file",photo_file.files[0]);
	  formData.append("photo",photo);

	  fetch(url,{
	  	method : "POST",
	  	body : formData,
	  	headers : {
	  		"Authorization" : localStorage.token,
	  	},
	  }).then(response => response.json())
	    .then(function(response){
	    	var hasil = JSON.parse(JSON.stringify(response));
	    	if(hasil['success'] == true){
	    		document.querySelector('ons-back-button').onClick = function() {
			   //    
				  document.querySelector('ons-navigator').popPage();
				  document.querySelector('ons-navigator').addEventListener('postpop', function() { 
				  	  const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
					  fetch(url,{
					  	method : "GET",
					  	headers : {
					  		"Authorization" : localStorage.token,
					  	},
					  }).then(response => response.json())
					    .then(function(response){
					    	//alert("data berhasil disimpan");
					    	const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
							  fetch(url,{
							  	method : "GET",
							  	headers : {
							  		"Authorization" : localStorage.token,
							  	},
							  }).then(response => response.json())
							    .then(function(response){
							    	refresh(response);
							    });
					    });
				  });
			    };
	    	}else{
	    		var showToast = function() {
				  ons.notification.toast('Data Gagal Ditambahkan', {
				    timeout: 2000
				  });
				};
	    	}
	    });
	}
	function search(){
		const keyword =  $('#keyword').val();
		const by = $('#by').val();
		const url = "http://localhost/laravel/apigenius/public/api/pelanggan/cari?search="+keyword+"&by="+by;
		fetch(url,{
		  	method : "GET",
		  	headers : {
		  		"Authorization" : localStorage.token,
		  	},
		  }).then(response => response.json())
	    .then(function(response){
	    	
	    	$("#list-pelanggan").html("<p style='margin:10px;'>Hasil Pencarian untuk Kata kunci : <b>" + keyword + "</b>");
			refresh(response);
	    });
	}
	const home = () => {
		const navigator = document.querySelector('#navigator');
		navigator
		.pushPage('home.html')
		.then(function(){
		  //APi Call Javascript
		  const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
		  fetch(url,{
		  	method : "GET",
		  	headers : {
		  		"Authorization" : localStorage.token,
		  	},
		  }).then(response => response.json())
		    .then(function(response){
		    	refresh(response);
		    });

		  //Chart Javascript	
	      var ctx = document.getElementById("myChart");
		  var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		      labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		      datasets: [{
		        data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
		        lineTension: 0,
		        backgroundColor: 'transparent',
		        borderColor: '#7f8c8d',
		        borderWidth: 4,
		        pointBackgroundColor: '#95a5a6'
		      }]
		    },
		    options: {
		      scales: {
		        yAxes: [{
		          ticks: {
		            beginAtZero: false
		          }
		        }]
		      },
		      legend: {
		        display: false,
		      }
		    }
		  });
		});
	}
	const login = () => {
	  const username = document.querySelector('#username').value;
	  const password = document.querySelector('#password').value;
	  const url = "http://localhost/laravel/apigenius/public/oauth/token";
	  const formData = new FormData();
	  formData.append("username",username);
	  formData.append("password",password);
	  formData.append("grant_type","password");
	  formData.append("client_id",2);
	  formData.append("client_secret","4FEOV2c8NJEjw6tyNc7xXPBCjoOkaUCv3f1Aj5Pn");
	  fetch(url,{
	  	method : "POST",
	  	body : formData,
	  })
	    .then(response => response.json())
	    .then(function(response){
	    	var hasil = JSON.parse(JSON.stringify(response));
	    	if(hasil['token_type']=="Bearer"){
	    		localStorage.token = hasil['token_type'] + " " + hasil['access_token'];
	    		const navigator = document.querySelector('#navigator');
	    		navigator
	    		.pushPage('home.html')
	    		.then(function(){
	    		  //APi Call Javascript
	    		  const url = "http://localhost/laravel/apigenius/public/api/pelanggan";
				  fetch(url,{
				  	method : "GET",
				  	headers : {
				  		"Authorization" : localStorage.token,
				  	},
				  }).then(response => response.json())
				    .then(function(response){
				    	refresh(response);
				    });

	    		  //Chart Javascript	
			      var ctx = document.getElementById("myChart");
				  var myChart = new Chart(ctx, {
				    type: 'bar',
				    data: {
				      labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
				      datasets: [{
				        data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
				        lineTension: 0,
				        backgroundColor: 'transparent',
				        borderColor: '#7f8c8d',
				        borderWidth: 4,
				        pointBackgroundColor: '#95a5a6'
				      }]
				    },
				    options: {
				      scales: {
				        yAxes: [{
				          ticks: {
				            beginAtZero: false
				          }
				        }]
				      },
				      legend: {
				        display: false,
				      }
				    }
				  });
				});


	    	}else{
	    		ons.notification.alert('Error'+hasil['error']);
	    		//alert('Error'+JSON.stringify(response));
	    	}
	    })
		// .then(response => console.log('Success:', JSON.stringify(response)))
		// .catch(error => console.error('Error:', error));

	  // if (username === 'admin' && password === 'admin') {
	  //    // call the navigator to move to the new page
   //  	const navigator = document.querySelector('#navigator');
	  //   navigator
	  //   .pushPage('home.html')
	  //   .then(function(){
	  //     var ctx = document.getElementById("myChart");
		 //  var myChart = new Chart(ctx, {
		 //    type: 'bar',
		 //    data: {
		 //      labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
		 //      datasets: [{
		 //        data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
		 //        lineTension: 0,
		 //        backgroundColor: 'transparent',
		 //        borderColor: '#7f8c8d',
		 //        borderWidth: 4,
		 //        pointBackgroundColor: '#95a5a6'
		 //      }]
		 //    },
		 //    options: {
		 //      scales: {
		 //        yAxes: [{
		 //          ticks: {
		 //            beginAtZero: false
		 //          }
		 //        }]
		 //      },
		 //      legend: {
		 //        display: false,
		 //      }
		 //    }
		 //  });
	  //   });
	  // } else {
	  //   ons.notification.alert('Wrong username/password combination');
	  // }
	}
</script>

<?php
	include "include/footer.php";
?>