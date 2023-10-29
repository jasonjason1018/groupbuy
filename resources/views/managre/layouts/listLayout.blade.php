<!DOCTYPE html>
<html lang="en">

<head>
    @include('managre.include.head')
</head>

<body>
    <section id="container" class="">
        @yield('content')
    </section>

    
  
</body>
<style>
    .fixed-footer {
        position: fixed;
        bottom: 0;
        width: 100%; 
        background-color: #f7f7f7; 
        padding: 10px 0; 
    }
</style>
</html>