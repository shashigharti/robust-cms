<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <!-- <link rel="shortcut icon" href="%PUBLIC_URL%/favicon.ico" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <!--
      manifest.json provides metadata used when your web app is installed on a
      user's mobile device or desktop. See https://developers.google.com/web/fundamentals/web-app-manifest/
    -->
    <!-- <link rel="manifest" href="%PUBLIC_URL%/manifest.json" /> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--
      Notice the use of %PUBLIC_URL% in the tags above.
      It will be replaced with the URL of the `public` folder during the build.
      Only files inside the `public` folder can be referenced from the HTML.

      Unlike "/favicon.ico" or "favicon.ico", "%PUBLIC_URL%/favicon.ico" will
      work correctly both with client-side routing and a non-root public URL.
      Learn how to configure a non-root public URL by running `npm run build`.
    -->

    <title>LgProfile-React</title>
  </head>
  <body class="horizontal-layout page-header-light horizontal-menu 2-columns  " data-open="click" data-menu="horizontal-menu" data-col="2-columns">
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root"></div>
    {{-- Maps API --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVMGPU0xbiE-XtO-U61AltLGW05KKF0cY&libraries=places" async defer></script>
    <script src={{asset('js/app.js')}}></script>
  </body>
</html>
