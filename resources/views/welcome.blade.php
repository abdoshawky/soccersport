<!DOCTYPE html>
<html>
    <head>
        <title>Store</title>
    </head>
    <body onload="">
        <div id="display">

        </div>
        <script
              src="https://code.jquery.com/jquery-3.2.1.min.js"
              integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
              crossorigin="anonymous"></script>

        <script>
        $(document).ready(function(){
            setInterval(function(){

                $('#display').append('test');

            },1000)
        }); 
        </script>
    </body>
</html>