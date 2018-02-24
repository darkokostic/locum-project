<html>
	<head>
		<style>
			body {
				max-width: 960px; 
				color: white;
			}
			.header {
				height: 60px; 
				background: #ff8f00; 
				color: #fff;
				text-align: center;
				padding: 1px;
				border-top-right-radius: 4px;
				border-top-left-radius: 4px;
			}
			.content {
				min-height: 300px; 
				background: #fff; 
				color: #90a4ae;
				padding: 10px;
				border: 2px solid #ff8f00;
				border-top: none;
				border-bottom-right-radius: 4px;
				border-bottom-left-radius: 4px;
				font-size: 14px;
			}
		</style>
	</head>
	<body>
		<div class="header">
			<h1>{{$content}}</h1>	
		</div>
		<div class="content">
			<p>{{$subject}}</p>	
		</div>
	</body>
</html>