<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('clients.components.head')
</head>
<body>
    @include('clients.components.header')
    @include('clients.components.stickyheader')
    @include($template)
    @include('clients.components.footer')
    @include('clients.components.script')
</body>
</html>