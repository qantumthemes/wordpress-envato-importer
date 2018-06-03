<?php
		$fields = array("qwim_envatousername",
		                "qwim_apikey",
		                "qwim_pagetemplate",
		                "qwim_displayprice",
		                "qwim_displayrating",
		                "qwim_displaylink"
		                );

		$user = get_option("qwim_envatousername");
		$apikey = get_option("qwim_apikey");

		/*
		*
		*	Requests
		*
		*/

		$vitals = 'http://marketplace.envato.com/api/edge/'.$user.'/'.$apikey.'/vitals.json';
		$earnings = 'http://marketplace.envato.com/api/edge/'.$user.'/'.$apikey.'/earnings-and-sales-by-month.json';
		$statement = 'http://marketplace.envato.com/api/edge/'.$user.'/'.$apikey.'/statement.json';
		$sales = 'http://marketplace.envato.com/api/edge/'.$user.'/'.$apikey.'/recent-sales.json';

		

		if(!function_exists('qwGetEnvData')){
			function qwGetEnvData ($url){
				//echo $requestString;
				$defaults = array(
				 'method' => 'GET',
				 'timeout' => 10,
				 'redirection' => 5,
				 'httpversion' => '1.0',
				 'user-agent' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
				 'reject_unsafe_urls' => false,
				 'blocking' => true,
				 'headers' => array(),
				 'cookies' => array(),
				 'body' => null,
				 'compress' => false,
				 'decompress' => true,
				 'sslverify' => true,
				 'stream' => false,
				 'filename' => null,
				 'limit_response_size' => null,
				);

		        $response = wp_remote_get(
		            $url, 
		            $defaults
				);	        
				if ( is_wp_error( $response ) ) {
				   $error_message = $response->get_error_message();
				   return "Something went wrong: $error_message";
				} else {
				   return $response['body'];//$response ;
				}
			}
		}

?>
<h1>Your Envato Stats</h1>
<div class="qw_contentSection">
	<h2>Overview</h2>
	<?php
		$errors = '';
		if($user != '' && $apikey != ''){
			$vitals_data = qwGetEnvData ($vitals);
			$vitals_data = json_decode($vitals_data,true);
			if(isset($vitals_data['error'])){
				$errors = $vitals_data['error'];
				foreach($vitals_data as $a => $b){
					echo '<p>'.ucfirst($a).': <strong>'.$b.'</strong></p>';
				}
			} else {
				//print_r($vitals_data);

				foreach($vitals_data['vitals'] as $a => $b){
					echo '<p>'.ucfirst($a).': <strong>'.$b.'</strong></p>';
				}
			}
		}
	?>
</div>
<?php
	if($errors == ''){
?>
<a href="#" id="qwShowEarnings" data-url="<?php echo $earnings; ?>" class="button button-primary">Show Earnings and Sales</a>

<div class="qw_contentSection qw_hidden" id="qwEarningsContainer">
	<h2>Earnings</h2>
	<div class="qw_chart"  >
		<div>
		<canvas id="qwEarnings" height="400" width="800"></canvas>

		</div>
	</div>
	<div id="qwEarningsTotal">

	</div>
</div>
<div class="qw_contentSection qw_hidden" id="qwSalesContainer">
	<h2>Sales</h2>
	<div class="qw_chart"  >
		<div>
		<canvas id="qwSales" height="400" width="800"></canvas>

		</div>

	</div>
	<div id="qwSalesTotal">

	</div>
</div>


<a href="#" id="qwShowStatement" data-url="<?php echo $statement; ?>" class="button button-primary" >Show Statement</a>
<div class="qw_contentSection qw_hidden" id="qwStatement">
	<h2>Statement</h2>
	<table class="qw_table">
		<thead>
			<tr>
				<th>
					Date
				</th>
				<th>
					Description
				</th>
				<th>
					Kind
				</th>
				<th>
					Amount
				</th>
			</tr>
		</thead>
		<tbody id="qwStatementContent">

		</tbody>


	</table>
</div>








<?php
} //$errors == ''
?>








