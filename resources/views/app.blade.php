<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Maha Constructions | Premium Luxury Architectural Masterpieces</title>
    <meta name="description" content="Maha Construction is an enterprise-grade builder of bespoke luxury villas, organic residences, and iconic commercial towers designed with materials integrity." />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @if(file_exists(public_path('assets')))
      @foreach(scandir(public_path('assets')) as $file)
        @if(str_ends_with($file, '.css'))
          <link rel="stylesheet" href="{{ asset('assets/' . $file) }}">
        @endif
      @endforeach
      @foreach(scandir(public_path('assets')) as $file)
        @if(str_ends_with($file, '.js'))
          <script type="module" src="{{ asset('assets/' . $file) }}"></script>
        @endif
      @endforeach
    @endif
  </head>
  <body class="bg-[#F8F8F8] text-[#071B35]">
    <div id="root"></div>
  </body>
</html>
