<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
	@if ($text)
		<p>
			{{ $text }}
		</p>
	@endif
	
	@if (count($items))
		@foreach ($items as $label => $text)
			<p>
				<strong>
					{{ $label }}:
				</strong>
				
				{{ $text }}
			</p>
		@endforeach
	@endif

</body>
</html>
