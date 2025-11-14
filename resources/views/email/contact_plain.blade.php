@if ($text)
{{ $text }}
@endif

@if (count($items))
	@foreach ($items as $label => $text)
{{ $label }}: {{ $text }}
	@endforeach
@endif
