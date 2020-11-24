<?php
	include "include/header.php";
?>
	<ons-page="home">
	  <ons-toolbar>
		<div class="center">Tab 1</div>
	  </ons-toolbar>

	  <ons-tabbar swipeable position="bottom">
		<ons-tab page="tab1.html" label="Beranda" icon="ion-home, material:md-home" badge="7" active>
		</ons-tab>
		<ons-tab page="tab2.html" label="Pelanggan" icon="md-account-box" active-icon="md-account-box">
		</ons-tab>
		<ons-tab page="tab3.html" label="Akun" icon="md-settings" active-icon="md-settings">
		</ons-tab>
	  </ons-tabbar>
	</ons-page>

	<template id="tab1.html">
	  <ons-page id="Tab1"><br /><br />
	  	<div style="padding:10px">
		  	<ons-row >
		  		<ons-col width="60%">
					<p style="text-align: left; margin-top:50px;margin-bottom:15px;font-size:14pt;">
					  Hallo
					</p>
				
					<h2 style="margin-bottom:5px;margin-top:0;color:red">
						<b>SOFI</b>
					</h2>
					<p style="margin-top:0;">SALES</p>
				</ons-col>
				<ons-col width="40%">
					<img src="assets/images/user.png" width="100" align="right" style="margin-top:50px">
				</ons-col>
			</ons-row ><br /><br />
			<ons-row>
				<ons-col width="100%">
					<div style="background:#fff;margin:auto;padding:7px">
						<p>Sales Today : 5</p>
						<p>Sales Month : 5</p>
					</div>
				</ons-col>
			</ons-row><br />
			<center><h2><b>Sales Years</b></h2></center><br />
			<canvas class="my-4" id="myChart" width="900" height="380"></canvas>
			<br />
			<center><div  style="border:3px solid #7f8c8d;display:block;padding:5px;width:110px;border-radius:20px"><b>2019</b></div></center>
		</div>
	  </ons-page>
	</template>

	<template id="tab2.html">
	  <ons-page id="Tab2"><br /><br /><br />
	  	<div style="padding:8px;">
			 <ons-search-input placeholder="Search something" style="width:100%"></ons-search-input>
			  
		</div>
		<ons-fab position="bottom right" style="background:#e74c3c;color:#fff;">
		  <ons-icon
		    icon="md-plus">
		  </ons-icon>
		</ons-fab>
		<ons-card>
			<ons-row>
				<ons-col width="40%">
					<img src="assets/images/no-image.png" width="85%">
				</ons-col>
				<ons-col width="60%">
					<table>
						<tr><td>ID Pel. </td><td>: 001 - 812387</td></tr>
						<tr><td>Nama </td><td>: Endang Sutedi</td></tr>
						<tr><td>No. HP </td><td>: 0812123989</td></tr>
						<tr><td>No. HP Alt </td><td>: 0830192389</td></tr>
						<tr><td>Tagging </td><td>: Lihat</td></tr>
						<tr><td>Status </td><td>: Nunggak</td></tr>
					</table>
				</ons-col>
			</ons-row>
			<ons-row>
				<ons-col>
					<b>Keterangan</b>: Gang Deket SMP Kartini lurus terus lalu belok kiri lalu belok kanan lalu belok kiri lagi. pertigaan pertama belok kanan, perempatan ke 2 belok kiri. lurus, rumah di  depan masjid
				</ons-col>
			</ons-row>
		</ons-card>
	  </ons-page>
	</template>
	<template id="tab3.html">
	  <ons-page id="Tab3">
		<p style="text-align: center;">
		  testing page 3
		</p>
	  </ons-page>
	</template>
  
<?php
	include "include/footer.php";
?>